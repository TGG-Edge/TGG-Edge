<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'settings';
    protected $guarded = ['id'];

    protected $casts = [
        'value' => 'array',     // JSON auto-cast
        'is_editable' => 'boolean',
    ];

    /**
     * Scope: filter by group
     */
    public function scopeGroup($query, $group)
    {
        return $query->where('group', $group)->orderBy('order');
    }

    /**
     * Get setting value by group & key
     */
    public static function getValue(string $group, string $key, $default = null)
    {
        return self::where('group', $group)
            ->where('key', $key)
            ->value('value') ?? $default;
    }
}
