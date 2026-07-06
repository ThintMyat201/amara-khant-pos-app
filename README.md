# 🛒 Amara Khant POS & Store Management System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Database-MySQL%20%7C%20SQLite-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL & SQLite">
  <img src="https://img.shields.io/badge/Frontend-Bootstrap%204%20%7C%20DataTables-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap & DataTables">
  <img src="https://img.shields.io/badge/Architecture-PSR--4%20Compliant-00C7B7?style=for-the-badge" alt="PSR-4 Compliant">
  <img src="https://img.shields.io/badge/Tests-Passing-4c1?style=for-the-badge" alt="Tests Passing">
</p>

---

## 🌟 Overview

**Amara Khant POS** is a modern, high-performance Point of Sale and Store Management web application built on **Laravel 12**. Designed for retail stores, boutiques, and fast-paced checkout environments, it provides an intuitive cashier interface, real-time inventory tracking, comprehensive sales reporting, and a robust administrative dashboard.

With our latest engineering optimizations, the application features **zero N+1 query bottlenecks**, **100% route cacheability**, **database-agnostic analytics queries**, and a strict **PSR-4 compliant model architecture** guaranteed to run seamlessly across local development, Docker containers, and Linux production servers.

---

## ✨ Key Features

### 💻 Point of Sale (POS) Terminal & Checkout
- **Instant Cart Management**: Rapidly add products to cart with real-time stock validation.
- **Smart Inventory Safeguards**: Automatic checkout disabling for out-of-stock items and dynamic low-stock warning badges (`Stock <= 3`).
- **Seamless Transaction Processing**: Immutable sales record generation with instant receipt calculation and store session tracking.

### 📊 Real-Time Administrative Dashboard
- **Aggregated Financial Analytics**: Daily revenue tracking, monthly earnings breakdowns, and annual projections powered by high-speed single-query SQL aggregations.
- **Interactive Visualizations**: Clean graphical representations of sales performance using integrated chart components.
- **User & Store Statistics**: Immediate visibility into active customer registrations, cashier activities, and inventory alerts.

### 📦 Product & Category Management
- **Full Inventory Control**: Create, update, view, and delete products and categories with structured form validation.
- **Image Preview & Scaling**: Automatic thumbnail generation and responsive image container scaling with `object-fit: contain/cover` styling.
- **Advanced Filtering**: Rapidly filter products by category, stock status, or custom low-stock thresholds.

### 👥 User Registration & Approval Workflow
- **Multi-Tier Role Access**: Clean segregation between administrative controllers (`Admin`) and store operators (`User`).
- **Interactive Request Management**: Dedicated registration request review workflow with modal-based approvals, rejection justifications, and admin notes.
- **SweetAlert2 Integrations**: Smooth modal transitions, confirmation dialogs for critical actions, and intuitive user feedback.

### ⚡ Enterprise Performance & DevOps Ready
- **Route & View Caching**: Fully controller-routed architecture enabling 0-error execution of `php artisan route:cache` and `php artisan view:cache`.
- **Driver-Agnostic SQL**: High-performance dashboard queries compatible with both MySQL (Production) and SQLite (In-Memory Automated Testing).
- **Automated Feature Suite**: Integrated PHPUnit test suite validating authentication flows, dashboard analytics, and core transaction logic.

---

## 🏗️ System Architecture & Tech Stack

| Layer | Technologies Used |
| :--- | :--- |
| **Backend Framework** | Laravel 12.x, PHP 8.2+, Eloquent ORM |
| **Frontend UI** | Bootstrap 4, Customized Theme (`amara-khant-theme.css`), FontAwesome 6 |
| **Interactive JS** | jQuery, DataTables (with custom empty table DOM styling), SweetAlert2, Chart.js |
| **Database Support** | MySQL / MariaDB (Production), SQLite (Testing & Local Dev) |
| **Testing & CI** | PHPUnit, Laravel Feature & Unit Test Suites |

---

## 🚀 Quick Start & Installation

### 1. Prerequisites
Ensure your development environment meets the following requirements:
- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM**
- **MySQL** / **MariaDB** (or SQLite)

### 2. Clone & Install Dependencies
```bash
# Clone the repository
git clone https://github.com/ThintMyat201/amara-khant-pos-app.git
cd amara-khant-pos-app

# Install PHP composer dependencies
composer install

# Install frontend NPM packages & compile assets
npm install
npm run build
```

### 3. Environment Setup & Configuration
```bash
# Copy the example environment file
cp .env.example .env

# Generate application encryption key
php artisan key:generate
```

Configure your database credentials in the `.env` file:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=amara_khant_pos
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Database Migrations & Seeding
```bash
# Run database migrations and seed default administrative user / initial data
php artisan migrate --seed
```

### 5. Launch the Application
You can start the server manually or use our built-in utility scripts:
```bash
# Start via standard Laravel development server
php artisan serve

# Or use our automated POS launch script
./scripts/start-pos.sh
```
Access the application in your browser at: `http://localhost:8000`

---

## 🧪 Running Automated Tests

The application includes an automated test suite verifying core business logic and dashboard aggregation performance:
```bash
# Run the complete test suite (uses in-memory SQLite database automatically)
php artisan test

# Run specifically targeted feature tests
php artisan test --filter=DashboardTest
```

---

## 📁 Clean Directory Structure

```text
amara-khant-pos-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── admin/          # Admin domain controllers (Dashboard, Product, Category, Sale, Report)
│   │   │   └── Auth/           # Breeze authentication & registration controllers
│   │   └── Middleware/         # AdminMiddleware & role verification
│   └── Models/                 # PSR-4 PascalCase models (Cart, Category, Product, Sale, StoreSession)
├── docs/                       # Comprehensive technical guides & deployment documentation
├── public/
│   ├── assets/                 # Cleaned static CSS/JS themes & vendor libraries
│   └── images/                 # Product inventory images & upload storage
├── resources/
│   └── views/
│       ├── admin/              # Blade templates (Dashboard, Product lists, POS sale terminal, User management)
│       └── layouts/            # Master layout wrappers & navigation headers
├── scripts/                    # Shell utilities for automated server checks & deployment
└── tests/
    ├── Feature/                # Automated feature tests (DashboardTest, Authentication, Registration)
    └── Unit/                   # Unit test assertions
```

---

## 📚 Documentation & DevOps Scripts

For advanced server readiness, deployment procedures, and testing workflows, refer to our dedicated guides in the `docs/` directory:
- [📖 Quick Start & Deployment Guide](docs/QUICK_START_DEPLOYMENT.md)
- [📖 Production Deployment Guide](docs/DEPLOYMENT_GUIDE.md)
- [📖 Registration System Guide](docs/REGISTRATION_SYSTEM_GUIDE.md)
- [📖 Server Readiness & Option B Deployment](docs/SERVER_READINESS_AND_OPTION_B.md)

Our utility scripts in `scripts/` automate routine operations:
- `./scripts/check-status.sh`: Verifies server health, database connectivity, and configuration caching.
- `./scripts/deploy.sh`: Production deployment pipeline with route/view optimization.
- `./scripts/start-pos.sh`: One-click local development startup.

---

## 🔒 Security & Performance Best Practices

- **Route & View Caching**: In production, execute `php artisan optimize` to cache all routes, configuration files, and compiled Blade views for maximum responsiveness.
- **CSRF & SQL Injection Protection**: All form submissions are secured via Laravel `@csrf` tokens, and all database interactions utilize Eloquent ORM parameter binding.
- **Timezone Standardization**: Application time is globally synchronized to `Asia/Yangon` in `config/app.php`, eliminating runtime timestamp discrepancies across financial transactions.

---

## 📄 License

This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).

<p align="center">
  Made with ❤️ by the <b>Amara Khant Development Team</b>
</p>
