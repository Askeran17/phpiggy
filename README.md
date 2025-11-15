# PHPiggy - Expense Tracking Application

A modern PHP application for tracking personal expenses and managing your budget effectively. Built with a custom MVC framework and deployed on cloud infrastructure with persistent file storage.

🔗 **[Live Demo](https://phpiggy-o6o6.onrender.com/)** - Try it yourself!

![PHPiggy Homepage](public/assets/screen.png)

## Features

- **💰 Expense Tracking**: Add, view, edit, and delete your daily expenses
- **📱 Mobile Responsive**: Optimized UI for both desktop and mobile devices
- **📄 Receipt Management**: Upload and manage receipt files (images/PDFs)
- **☁️ Cloud Storage**: Persistent file storage using Cloudinary CDN
- **🗄️ Multi-Database Support**: Works with MySQL (local) and PostgreSQL (production)
- **🐳 Docker Ready**: Containerized for easy deployment
- **🔐 User Authentication**: Secure login and session management
- **🎨 Modern UI**: Clean interface with CSS utility classes
- **🚀 Cloud Deployment**: Production-ready deployment on Render

## Tech Stack

- **Backend**: PHP 8.2+ with custom MVC framework
- **Database**: MySQL (development) / PostgreSQL (production via Neon)
- **File Storage**: Cloudinary CDN for persistent receipt storage
- **Frontend**: Custom CSS with utility classes for responsive design
- **Deployment**: Docker + Render cloud hosting
- **Development**: Composer, PSR-4 autoloading, Custom CSS

## Requirements

### Local Development
- **PHP 8.2+** with extensions: pdo, pdo_mysql, pdo_pgsql
- **Composer** for dependency management
- **MySQL** database server
- **Web Server** (Apache/Nginx) or PHP built-in server

### Production
- **Docker** support
- **PostgreSQL** database (Neon)
- **Cloudinary** account for file storage

## Installation

### Local Development Setup

1. **Clone the Repository**
```bash
git clone https://github.com/Askeran17/phpiggy.git
cd phpiggy
```

2. **Install Dependencies**
```bash
composer install
```

3. **Configure Environment**
```bash
# Copy environment template
cp .env.example .env

# Edit .env with your database credentials
# For local development with MySQL:
DB_DRIVER=mysql
DB_HOST=localhost
DB_PORT=3306
DB_NAME=phpiggy
DB_USER=your_username
DB_PASSWORD=your_password
```

4. **Setup Database**
```bash
# Import the database schema
mysql -u your_username -p phpiggy < database-mysql.sql
```

5. **Start Development Server**
```bash
php -S localhost:8000 -t public
```

6. **Open in Browser**
Navigate to `http://localhost:8000`

### Production Deployment (Render)

The application is configured for automatic deployment on Render cloud platform:

1. **Fork this repository**
2. **Connect to Render** and create new Web Service
3. **Set Environment Variables**:
   ```
   DB_DRIVER=pgsql
   DB_HOST=your-host
   DB_PORT=5432
   DB_NAME=
   DB_USER=
   DB_PASSWORD=your-password
   CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name
   ```

4. **Deploy** - Render will automatically build using Docker

## Project Structure

```
phpiggy/
├── public/                 # Web-accessible files
├── src/
│   ├── App/
│   │   ├── Config/         # Configuration files
│   │   ├── Controllers/    # Request handlers
│   │   ├── Services/       # Business logic
│   │   ├── Middleware/     # Request middleware
│   │   └── views/          # HTML templates
│   └── Framework/          # Custom MVC framework
├── storage/
│   └── uploads/           # Local file storage (dev only)
├── Dockerfile             # Docker configuration
├── composer.json          # PHP dependencies
└── database-*.sql         # Database schemas
```

## Architecture

PHPiggy is built using a custom MVC framework with the following components:

### Core Framework
- **🔀 Router**: RESTful routing with HTTP method support
- **🎮 Controllers**: Handle HTTP requests and responses
- **🗃️ Database Layer**: PDO-based with multi-driver support
- **🛡️ Middleware**: Authentication, CSRF protection, validation
- **📝 Template Engine**: Custom view rendering system
- **⚡ PSR-4 Autoloading**: Modern PHP class loading

### Services Layer
- **👤 UserService**: User authentication and management
- **💳 TransactionService**: Expense tracking and management
- **📎 ReceiptService**: File upload and cloud storage integration
- **🔐 ValidatorService**: Input validation and sanitization

### Database Design
- **Multi-Database Support**: MySQL for development, PostgreSQL for production
- **Database-Agnostic Queries**: Compatible SQL across different engines
- **Migration Scripts**: Separate schema files for each database type

### Cloud Integration
- **☁️ Cloudinary**: CDN-based file storage for receipts
- **🐘 Neon PostgreSQL**: Managed database service
- **🚀 Render**: Cloud hosting platform
- **🐳 Docker**: Containerized deployment

## Features in Detail

### Expense Management
- ➕ **Add Transactions**: Record income and expenses with categories
- 📊 **View Dashboard**: Overview of financial activity
- ✏️ **Edit/Delete**: Modify existing transactions
- 📄 **Receipt Uploads**: Attach images/PDFs to transactions

### Mobile Responsiveness
- 📱 **Adaptive Layout**: Optimized for mobile devices
- 🔘 **Mobile Actions**: Vertical button layout on small screens
- 📐 **Responsive Tables**: Touch-friendly data display

### File Management
- ☁️ **Cloud Storage**: Files stored in Cloudinary CDN
- 🔄 **Auto-Migration**: Seamless transition from local to cloud storage
- 🗂️ **Multiple Formats**: Support for JPEG, PNG, PDF files
- 🔒 **Secure URLs**: Protected file access

## Development

### Local Development
```bash
# Install dependencies
composer install

# Start development server
php -S localhost:8000 -t public

# Watch for file changes (if using Docker)
docker-compose up --build
```

### Adding New Features

1. **Controllers**: Add new controllers in `src/App/Controllers/`
2. **Routes**: Register routes in `src/App/Config/Routes.php`
3. **Views**: Create templates in `src/App/views/`
4. **Services**: Add business logic in `src/App/Services/`

### Database Migrations
```bash
# MySQL (local)
mysql -u username -p database_name < database-mysql.sql

# PostgreSQL (production)
psql -h hostname -U username -d database_name < database-postgresql.sql
```

## Deployment

### Docker Build
```bash
# Build image
docker build -t phpiggy .

# Run container
docker run -p 8000:80 phpiggy
```

## Course Information

This project was developed as part of a comprehensive PHP course on Udemy, taught by **Luis Ramirez**. The course provided hands-on experience in building modern PHP applications with custom MVC frameworks, database management, and cloud deployment.

**📜 [View Certificate](https://www.udemy.com/certificate/UC-9666a43e-c817-4405-8edd-abd95ab69bb4/)**

## License

This project is open source.