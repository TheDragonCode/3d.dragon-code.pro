<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }

    public function machines(): Relation
    {
        return $this->belongsToMany(Machine::class, 'user_machine')
            ->using(UserMachine::class)
            ->withTimestamps();
    }

    public function filaments(): Relation
    {
        return $this->belongsToMany(Filament::class, 'user_filament')
            ->using(UserFilament::class)
            ->withTimestamps();
    }

    public function userFilaments(): Relation
    {
        return $this->hasMany(UserFilament::class, 'user_id', 'id');
    }
}
