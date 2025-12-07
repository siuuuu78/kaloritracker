<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        "name",
        "email",
        "password",
        "height",
        "start_weight",
        "target_weight",
        "calorie_target",
        "mode",
    ];

    public function weightLogs()
    {
        return $this->hasMany(WeightLog::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function foodLogs()
    {
        return $this->hasMany(FoodLog::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }
}
