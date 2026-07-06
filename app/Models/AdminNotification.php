<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'message',
        'user_id',
        'registration_request_id',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Get the user associated with this notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the registration request associated with this notification
     */
    public function registrationRequest()
    {
        return $this->belongsTo(RegistrationRequest::class);
    }

    /**
     * Get unread notifications count
     */
    public static function getUnreadCount()
    {
        return self::where('is_read', false)->count();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}
