<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\Config\Paths;
use Cloudinary\Cloudinary;

class ReceiptService
{
    private Cloudinary $cloudinary;
    
    public function __construct(private Database $db) {
        // Initialize Cloudinary with URL (contains all credentials)
        $cloudinaryUrl = $_ENV['CLOUDINARY_URL'] ?? '';
        if ($cloudinaryUrl && str_starts_with($cloudinaryUrl, 'cloudinary://')) {
            $this->cloudinary = new Cloudinary($cloudinaryUrl);
        } else {
            // Fallback to individual credentials
            $this->cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'] ?? '',
                    'api_key' => $_ENV['CLOUDINARY_API_KEY'] ?? '',
                    'api_secret' => $_ENV['CLOUDINARY_API_SECRET'] ?? '',
                ]
            ]);
        }
    }

    public function validateFile(?array $file) {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException([
                'receipt' => 'Failed to upload file'
            ]);
        }

        $maxFileSizeMB = 3 * 1024 * 1024;

        if ($file['size'] > $maxFileSizeMB) {
            throw new ValidationException([
                'receipt' => 'File upload is too large'
            ]);
        }

        $originalFilename = $file['name'];

        if (!preg_match('/^[a-zA-Z0-9\s._-]+$/', $originalFilename)) {
            throw new ValidationException([
                'receipt' => ['Invalid filename']
            ]);
        }

        $clientMimeType = $file['type'];
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf'];

        if (!in_array($clientMimeType, $allowedMimeTypes)) {
            throw new ValidationException([
                'receipt' => ['Invalid file type']
            ]);
        }
    }

    public function upload(array $file, int $transaction) {
        try {
            // Upload to Cloudinary
            $result = $this->cloudinary->uploadApi()->upload($file['tmp_name'], [
                'folder' => 'phpiggy/receipts',
                'public_id' => 'receipt_' . $transaction . '_' . bin2hex(random_bytes(8)),
                'resource_type' => 'auto' // auto-detect file type
            ]);

            // Save to database with Cloudinary URL
            $this->db->query(
                "INSERT INTO receipts (transaction_id, original_filename, storage_filename, media_type)
                VALUES (:transaction_id, :original_filename, :storage_filename, :media_type)",
                [
                    'transaction_id' => $transaction,
                    'original_filename' => $file['name'],
                    'storage_filename' => $result['secure_url'], // Cloudinary URL
                    'media_type' => $file['type']
                ]
            );
        } catch (\Exception $e) {
            throw new ValidationException([
                'receipt' => ['Failed to upload file: ' . $e->getMessage()]
            ]);
        }

    }

    public function getReceipt(string $id) {
        $receipt = $this->db->query(
            "SELECT * FROM receipts WHERE id = :id",
            [
                'id' => $id
            ]
        )->find();

        return $receipt;
    }

    public function read(array $receipt) {
        // Check if it's a Cloudinary URL (starts with https://)
        if (str_starts_with($receipt['storage_filename'], 'https://')) {
            // Redirect to Cloudinary URL directly
            header('Location: ' . $receipt['storage_filename']);
            exit;
        } else {
            // Legacy local file handling
            $filePath = Paths::STORAGE_UPLOADS . '/' . $receipt['storage_filename'];

            if (!file_exists($filePath)) {
                $_SESSION['flash'] = 'Receipt file is no longer available.';
                redirectTo("/");
            }
            
            header('Content-Disposition: inline;filename=' . $receipt["original_filename"]);
            header('Content-Type: ' . $receipt["media_type"]);

            readfile($filePath);
        }
    }

    public function delete(array $receipt) {
        // Check if it's a Cloudinary URL
        if (str_starts_with($receipt['storage_filename'], 'https://')) {
            try {
                // Extract public_id from Cloudinary URL for deletion
                $urlParts = parse_url($receipt['storage_filename']);
                $pathParts = explode('/', $urlParts['path']);
                // Find public_id (usually after version number)
                $publicId = null;
                for ($i = 0; $i < count($pathParts); $i++) {
                    if (str_starts_with($pathParts[$i], 'v') && is_numeric(substr($pathParts[$i], 1))) {
                        $publicId = implode('/', array_slice($pathParts, $i + 1));
                        $publicId = pathinfo($publicId, PATHINFO_FILENAME); // Remove extension
                        break;
                    }
                }
                
                if ($publicId) {
                    $this->cloudinary->uploadApi()->destroy($publicId);
                }
            } catch (\Exception $e) {
                // Log error but continue with database deletion
                error_log("Failed to delete from Cloudinary: " . $e->getMessage());
            }
        } else {
            // Legacy local file deletion
            $filePath = Paths::STORAGE_UPLOADS . '/' . $receipt['storage_filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->db->query(
            "DELETE FROM receipts WHERE id = :id",
            [
                'id' => $receipt['id']
            ]
        );
    }
}