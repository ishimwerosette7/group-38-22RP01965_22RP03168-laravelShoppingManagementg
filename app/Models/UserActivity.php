<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'ip_address',
        'login_time',
        'details',
    ];

    const ACTIVITY_TYPES = [
        'login' => 'User Login',
        'logout' => 'User Logout',
        'product_view' => 'Product Viewed',
        'product_purchase' => 'Product Purchased',
        'order_placed' => 'Order Placed',
        'order_cancelled' => 'Order Cancelled',
        'profile_updated' => 'Profile Updated',
        'password_changed' => 'Password Changed',
    ];

    protected $casts = [
        'login_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
