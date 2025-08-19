<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserSecondary extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $connection = 'mysql2';
    protected $table = 'users';
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

    public static $user_types = [
        1 => [
            'name' => 'Admin',
            'key'  => 'admin'
        ],
        2 => [
            'name' => 'Trainer',
            'key'  => 'trainer'
        ],
        3 => [
            'name' => 'Members',
            'key'  => 'members'
        ],
        4 => [
            'name' => 'RHM Club',
            'key'  => 'rhm-club'
        ],
        5 => [
            'name' => 'Nomad Community',
            'key'  => 'nomad-community'
        ],
        6 => [
            'name' => 'Freelancers',
            'key'  => 'freelancers'
        ],
    ];
    /**
     * Get the attributes that should be cast.
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

    public function getRoleNameAttribute()
{
    return self::$user_types[$this->user_role]['name'] ?? 'Unknown';
}
    public function project()
    {
        return $this->hasOne(Project::class, 'researcher_id', 'id');
    }

    public function projectNew()
    {
        return $this->hasOne(Project::class, 'researcher_id', 'id');
    }

    // 2. A Volunteer has MANY collaborations (applications)
    public function collaborations()
    {
        return $this->hasMany(ProjectCollaboration::class, 'volunteer_id', 'id');
    }

    public function moduleInstances()
    {
        return $this->hasMany(ModuleInstance::class);
    }

    // A User can be assigned to many modules via module_instances
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_instances', 'user_id', 'module_id')
            ->withTimestamps();
    }

    public function literatures()
    {
        // A user has many literatures through module instances
        return $this->hasManyThrough(Literature::class, ModuleInstance::class, 'user_id', 'module_instance_id', 'id', 'id');
    }


    // public function literatures()
    // {
    //     return $this->hasManyThrough(
    //         Literature::class,      // Final related model
    //         ModuleInstance::class,  // Intermediate model
    //         'user_id',              // Foreign key on module_instances table pointing to users.id
    //         'module_instance_id',   // Foreign key on literatures table pointing to module_instances.id
    //         'id',                   // Local key on users table
    //         'id'                    // Local key on module_instances table
    //     );
    // }
}
