<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmailCustom;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'university_id',
        'phone',
        'photo_url',
        'user_title',
        'user_type',
        'status',
        'terms_accepted_at',
        'photo_public_id',
        'role_id',
        'cpf',
        'abacate_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
        ];
    }

    public function university(): BelongsTo {
        return $this->belongsTo(University::class);
    }

    public function driverProfile(): HasOne {
        return $this->hasOne(DriverProfile::class);
    }

    public function rideRequests(): HasMany {
        return $this->hasMany(RideRequest::class);
    }

    public function rated(): HasMany {
        return $this->hasMany(Rating::class, 'rated_id');
    }

    public function rater(): HasMany {
        return $this->hasMany(Rating::class, 'rater_id');
    }

    public function payer(): HasMany {
        return $this->hasMany(Payment::class, 'payer_id');
    }

    public function receiver(): HasMany {
        return $this->hasMany(Payment::class, 'receiver_id');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailCustom);
    }
}
