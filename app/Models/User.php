<?php 

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Add this line
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail // Implement this interface
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'profile_picture',
        'date_of_birth',
        'account_type',
        'account_status',
        'password', // Make sure to keep password for authentication
    ];

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function kycDocuments()
    {
        return $this->hasMany(KycDocument::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
    public function kycVerificationStage()
    {
        return $this->hasOne(KycVerificationStage::class, 'user_id');
    }

}