<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];


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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public static $user_types = [
        1 => [
            'name' => 'Admin',
            'key'  => 'admin'
        ],
        2 => [
            'name' => 'Researcher',
            'key'  => 'researcher'
        ],
        3 => [
            'name' => 'Volunteer',
            'key'  => 'volunteer'
        ],
        4 => [
            'name' => 'N/A',
            'key'  => 'N/A'
        ],
        5 => [
            'name' => 'Assignee',
            'key'  => 'assignee'
        ],
        6 => [
            'name' => 'Freelancers',
            'key'  => 'freelancers'
        ],
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getRoleNameAttribute()
    {
        return self::$user_types[$this->user_role]['name'] ?? 'Unknown';
    }
    public function project() {
        return $this->hasOne(Project::class, 'researcher_id', 'id');
    }

     public function projectNew() {
        return $this->hasOne(Project::class, 'researcher_id', 'id');
    }

    // 2. A Volunteer has MANY collaborations (applications)
    public function collaborations() {
        return $this->hasMany(ProjectCollaboration::class, 'volunteer_id', 'id');
    }
}
