# Registration Request System - Setup Guide

## Overview
A complete user registration request system where users must request account creation and wait for admin approval. Includes notifications for admins when new requests are submitted.

## Features Implemented

### User Features:
1. **Registration Request Form** - Users can submit account creation requests
2. **Status Check** - Users can check the status of their registration request
3. **Email Validation** - Prevents duplicate registrations

### Admin Features:
1. **Registration Requests Dashboard** - View all pending/approved/rejected requests
2. **Approve/Reject Actions** - Admin can approve or reject requests with notes
3. **Notifications System** - Real-time notifications for new registration requests
4. **Notification Bell** - Top navbar shows unread notification count
5. **Dashboard Widget** - Shows pending requests count on admin dashboard

## Files Created

### Database Migrations:
- `/database/migrations/2026_02_19_000000_create_registration_requests_table.php`
- `/database/migrations/2026_02_19_000001_create_admin_notifications_table.php`

### Models:
- `/app/Models/RegistrationRequest.php`
- `/app/Models/AdminNotification.php`

### Controllers:
- `/app/Http/Controllers/admin/RegistrationRequestController.php`
- `/app/Http/Controllers/admin/NotificationController.php`
- `/app/Http/Controllers/Auth/RegisterRequestController.php`

### Views:
- `/resources/views/auth/register-request.blade.php` - User registration request form
- `/resources/views/auth/request-status.blade.php` - Check request status
- `/resources/views/admin/registration/index.blade.php` - Admin requests list
- `/resources/views/admin/registration/show.blade.php` - Request details
- `/resources/views/admin/notifications/index.blade.php` - Notifications page

### Routes Modified:
- `/routes/auth.php` - Added registration request routes
- `/routes/admin.php` - Added admin management routes

### Views Modified:
- `/resources/views/layouts/master.blade.php` - Added notification bell and navigation
- `/resources/views/auth/login.blade.php` - Updated links
- `/resources/views/admin/home/dashboard.blade.php` - Added pending requests card

## Installation Steps

### 1. Run Database Migrations
```bash
cd /root/POS_PROJECT
php artisan migrate
```

### 2. Clear Cache (Optional but recommended)
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 3. Test the System

#### For Users:
1. Visit: `/register-request` - Submit a new registration request
2. Visit: `/register-request-status` - Check status of your request
3. After approval, login at `/login` with your credentials

#### For Admins:
1. Login as admin
2. Check the notification bell icon (top right) for new requests
3. Visit "Registration Requests" in the sidebar
4. Click on a pending request to approve or reject
5. View all notifications at `/admin/notifications`

## Routes Available

### Public Routes (Guest):
- `GET /register-request` - Show registration request form
- `POST /register-request` - Submit registration request
- `GET /register-request-status` - Show status check form
- `POST /register-request-status` - Check request status

### Admin Routes (Authenticated Admin):
- `GET /admin/registration/requests` - List all requests (with status filter)
- `GET /admin/registration/requests/{id}` - View request details
- `POST /admin/registration/requests/{id}/approve` - Approve request
- `POST /admin/registration/requests/{id}/reject` - Reject request
- `DELETE /admin/registration/requests/{id}` - Delete request
- `GET /admin/notifications` - View all notifications
- `POST /admin/notifications/{id}/read` - Mark notification as read
- `POST /admin/notifications/read-all` - Mark all as read
- `GET /admin/notifications/unread-count` - Get unread count (AJAX)

## Database Tables

### registration_requests
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email address
- `password` - Hashed password
- `phone` - Optional phone number
- `address` - Optional address
- `status` - enum('pending', 'approved', 'rejected')
- `admin_id` - Foreign key to users table (who processed)
- `admin_note` - Optional admin note/reason
- `approved_at` - Timestamp when processed
- `created_at` & `updated_at`

### admin_notifications
- `id` - Primary key
- `type` - Notification type (e.g., 'registration_request')
- `message` - Notification message
- `user_id` - Optional foreign key to users
- `registration_request_id` - Foreign key to registration_requests
- `is_read` - Boolean flag
- `created_at` & `updated_at`

## Usage Flow

### User Registration Flow:
1. User visits login page
2. Clicks "Request Account Registration"
3. Fills in registration form (name, email, password, phone, address)
4. Submits request
5. System creates a pending registration request
6. System creates admin notification
7. User can check status anytime using their email

### Admin Approval Flow:
1. Admin logs in
2. Sees notification bell with unread count
3. Clicks on "Registration Requests" in sidebar
4. Views pending requests
5. Clicks on a request to see details
6. Approves or rejects with optional note
7. If approved: User account is created automatically
8. Notification is marked as read

## Customization Options

### Change Request Fields:
Edit migration file and add fields to:
- `RegistrationRequest` model's `$fillable` array
- Registration request form view
- Request details view

### Modify Notification Types:
Add new notification types in:
- `AdminNotification` model
- Notification creation logic in controllers

### Customize Email Templates (Future):
You can add Laravel mail notifications to email users when:
- Their request is approved
- Their request is rejected
- Admin when new request arrives

## Security Considerations

1. **Password Hashing** - Passwords are automatically hashed before storage
2. **Email Uniqueness** - Validates against both users and registration_requests tables
3. **Admin Middleware** - All admin routes protected by authentication and role check
4. **CSRF Protection** - All forms include CSRF tokens
5. **SQL Injection** - Using Eloquent ORM prevents SQL injection

## Troubleshooting

### Migration Errors:
If you get foreign key constraint errors:
```bash
php artisan migrate:fresh
```
**Warning**: This will delete all data!

### Route Not Found:
```bash
php artisan route:clear
php artisan route:cache
```

### Views Not Updating:
```bash
php artisan view:clear
```

### Permission Issues:
```bash
chmod -R 775 storage bootstrap/cache
```

## Next Steps (Optional Enhancements)

1. **Email Notifications** - Add Laravel mail to notify users
2. **Auto-rejection** - Reject old pending requests after X days
3. **Request Limits** - Limit requests per email per day
4. **Enhanced Validation** - Add email verification before approval
5. **Admin Dashboard** - Add charts for registration statistics
6. **Bulk Actions** - Approve/reject multiple requests at once
7. **Search & Filter** - Advanced filtering in requests list
8. **Export** - Export requests to CSV/Excel

## Support

For issues or questions:
- Check Laravel logs: `/storage/logs/laravel.log`
- Enable debug mode: Set `APP_DEBUG=true` in `.env`
- Check browser console for JavaScript errors

---

**Created**: February 19, 2026
**Version**: 1.0
**Laravel Version**: 11.x
