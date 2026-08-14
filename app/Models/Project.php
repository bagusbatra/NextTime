<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'tag',
        'category',
        'status',
        'mockup_type',
        'icon',
        'summary',
        'overview',
        'features',
        'featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'featured' => 'boolean',
        ];
    }

    /**
     * Gunakan slug (bukan id) pada URL: /projects/{project}.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
