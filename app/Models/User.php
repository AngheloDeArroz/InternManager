<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Task;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',           // admin or intern
        'required_hours', // total internship hours
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: tasks assigned to the user (intern)
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class)
                    ->withPivot('status', 'approved_by', 'completed_at', 'approved_at')
                    ->withTimestamps();
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is intern
     */
    public function isIntern(): bool
    {
        return $this->role === 'intern';
    }

    /**
     * Calculate total hours from approved tasks
     */
    public function approvedHours(): int
    {
        return $this->tasks()->wherePivot('status', 'approved')->sum('hours');
    }

    /**
     * Calculate remaining hours for internship
     */
    public function remainingHours(): int
    {
        return $this->required_hours - $this->approvedHours();
    }
}
