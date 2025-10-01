# PHPiggy - Expense Tracking Application

A modern PHP application for tracking personal expenses and managing your budget effectively.

## Features

- **Expense Tracking**: Add, view, and manage your daily expenses
- **Custom PHP Framework**: Built with a custom MVC framework
- **Clean Architecture**: Well-structured codebase following PSR-4 standards
- **Template Engine**: Custom template engine for dynamic views
- **Routing System**: Clean URL routing with custom router
- **Modern PHP**: Built with PHP 8.4+ features

## Requirements

- **PHP 8.4+**
- **Composer** (for dependency management)
- **Web Server** (Apache/Nginx) or PHP built-in server

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/Askeran17/phpiggy.git
cd phpiggy
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Start Development Server

```bash
php -S localhost:8000 -t public
```

### 4. Open in Browser

Navigate to `http://localhost:8000` in your web browser.

## Architecture

PHPiggy is built using a custom MVC (Model-View-Controller) framework that includes:

- **Router**: Handles URL routing and HTTP methods
- **Controllers**: Process requests and return responses
- **Template Engine**: Renders views with data
- **PSR-4 Autoloading**: Modern PHP class autoloading

## Usage

### Adding Routes

Routes are defined in `src/App/Config/Routes.php`:

```php
function registerRoutes(App $app)
{
    $app->get('/', [HomeController::class, 'home']);
    $app->get('/about', [AboutController::class, 'about']);
    // Add more routes here
}
```


### Creating Views

Views are stored in `src/App/views/` and use the custom template engine.

## Development

### Running Tests

```bash
# Add your test commands here when implemented
composer test
```

### Code Style

This project follows PSR-4 autoloading standards and modern PHP practices.
