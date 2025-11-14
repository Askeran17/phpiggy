<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService 
{
    public function __construct(private Database $db) {
        
    }

    public function create(array $formData) 
    {
        $formattedDate = "{$formData['date']} 00:00:00";

        $this->db->query(
            "INSERT INTO transactions (user_id, description, amount, date) 
            VALUES (:user_id, :description, :amount, :date)",
            [
                'user_id' => $_SESSION['user_id'],
                'description' => $formData['description'],
                'amount' => $formData['amount'],
                'date' => $formattedDate 
            ]
        );
    }

    public function getUserTransactions(int $length, int $offset)
    {
        $searchTerm = $_GET['s'] ?? '';
        // Escape special characters for LIKE query
        $searchTerm = str_replace(['%', '_'], ['\%', '\_'], $searchTerm);
        $params = [
                'user_id' => $_SESSION['user_id'],
                'description' => "%{$searchTerm}%"
        ];
        

        $transactions = $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date
            FROM transactions 
            WHERE user_id = :user_id
            AND description LIKE :description
            LIMIT {$length} OFFSET {$offset}",
            $params
        )->findAll();

        $transactions = array_map(function($transaction) {
            $transaction['receipt'] = $this->db->query(
                "SELECT * FROM receipts WHERE transaction_id = :transaction_id",
                [
                    'transaction_id' => $transaction['id']
                ]
            )->findAll();
            
            return $transaction;
        }, $transactions);

        $transactionCount = $this->db->query(
            "SELECT COUNT(*)
            FROM transactions 
            WHERE user_id = :user_id
            AND description LIKE :description",
            $params
        ) ->count();

        return [$transactions, $transactionCount];
    }

    public function getUserTransaction(int $id)
    {
        return $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date
            FROM transactions 
            WHERE id = :id
            AND user_id = :user_id",
            [
                'id' => $id,
                'user_id' => $_SESSION['user_id']
            ]
        )->find();
    }

    public function update(array $formData, int $id) 
    {
        $formattedDate = "{$formData['date']} 00:00:00";

        $this->db->query(
            "UPDATE transactions 
            SET description = :description, amount = :amount, date = :date
            WHERE id = :id
            AND user_id = :user_id",
            [
                'description' => $formData['description'],
                'amount' => $formData['amount'],
                'date' => $formattedDate,
                'id' => $id,
                'user_id' => $_SESSION['user_id']
                
            ]
        );
    }

    public function delete(int $id) 
    {
        $this->db->query(
            "DELETE FROM transactions 
            WHERE id = :id
            AND user_id = :user_id",
            [
                'id' => $id,
                'user_id' => $_SESSION['user_id']
            ]
        );
    }

}