# 🚀 POS Project - Complete Setup & Run Guide

## 📋 Prerequisites (Already Installed ✅)

-   ✅ PHP 8.4.5
-   ✅ Composer 2.8.10
-   ✅ Node.js v23.3.0
-   ✅ MySQL (running)
-   ✅ Gmail SMTP configured

## 🛠️ Step-by-Step Setup

### **Step 1: Navigate to Project Directory**

```bash
cd /Users/pyaephonenaing/Documents/POS_PROJECT
```

### **Step 2: Install PHP Dependencies**

```bash
composer install
```

### **Step 3: Install Node.js Dependencies**

```bash
npm install
```

### **Step 4: Environment Configuration**

Your `.env` file should already be configured with:

-   Database settings
-   Gmail SMTP settings
-   App key

### **Step 5: Database Setup**

```bash
# Create database (if not exists)
mysql -u root -e "CREATE DATABASE IF NOT EXISTS pos_project;"

# Run migrations
php artisan migrate

# Run seeders (optional - database already has admin user)
php artisan db:seed
```

### **Step 6: Clear All Caches**

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### **Step 7: Start Development Servers**

**Terminal 1 - Laravel Server:**

```bash
php artisan serve
```

_Server will run on: http://localhost:8000_

**Terminal 2 - Vite Development Server:**

```bash
npm run dev
```

_Vite will run on: http://localhost:5173_

## 🎯 Access Your Application

### **Main Application URL:**

**http://localhost:8000**

### **Login Credentials:**

**Admin User:**

-   Email: `admin123@gmail.com`
-   Password: `admin123!@#`
-   Access: Dashboard, User Management, Product Management, Reports

**Regular User:**

-   Email: `paolo@gmail.com`
-   Password: (check what you set during registration)
-   Access: Sales Interface, Cart Management

## 🔧 Key Features Available

### **Admin Features:**

-   📊 Dashboard with sales analytics
-   👥 User Management
-   📦 Product & Category Management
-   📈 Sales Reports
-   🏪 Store Session Management

### **User Features:**

-   🛒 Sales Interface
-   📋 Cart Management
-   💰 Checkout Process
-   📱 Profile Management

### **Authentication:**

-   🔐 Login/Register
-   📧 Forgot Password (Gmail SMTP configured)
-   🔒 Role-based Access Control

## 🚨 Troubleshooting

### **If you get errors:**

1. **Database Connection Error:**

    ```bash
    # Check MySQL is running
    brew services start mysql

    # Test connection
    mysql -u root -p
    ```

2. **Port Already in Use:**

    ```bash
    # Kill processes on port 8000
    lsof -ti:8000 | xargs kill -9

    # Kill processes on port 5173
    lsof -ti:5173 | xargs kill -9
    ```

3. **Permission Errors:**

    ```bash
    # Fix storage permissions
    chmod -R 775 storage bootstrap/cache
    ```

4. **Cache Issues:**
    ```bash
    php artisan cache:clear
    php artisan config:clear
    ```

## 📱 Quick Start Commands

**One-liner to start everything:**

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

**Check if everything is running:**

```bash
# Check Laravel server
curl -s -o /dev/null -w "%{http_code}" http://localhost:8000

# Check Vite server
curl -s -o /dev/null -w "%{http_code}" http://localhost:5173
```

## 🎉 Success Indicators

✅ **Laravel Server**: `http://localhost:8000` returns 200  
✅ **Vite Server**: `http://localhost:5173` returns 404 (normal for dev server)  
✅ **Login Page**: `http://localhost:8000/login` loads correctly  
✅ **Admin Login**: Can access dashboard with admin credentials  
✅ **Email System**: Forgot password sends real emails via Gmail

## 🔗 Important URLs

-   **Main App**: http://localhost:8000
-   **Login**: http://localhost:8000/login
-   **Register**: http://localhost:8000/register
-   **Forgot Password**: http://localhost:8000/forgot-password
-   **Admin Dashboard**: http://localhost:8000/dashboard (after login)
-   **Sales Interface**: http://localhost:8000/saleproduct (after login)

## 📞 Need Help?

If you encounter any issues:

1. Check the terminal output for error messages
2. Verify all prerequisites are installed
3. Ensure MySQL is running
4. Clear caches if needed
5. Check `.env` file configuration

---

**🎊 Your POS System is ready to use!** 🎊
