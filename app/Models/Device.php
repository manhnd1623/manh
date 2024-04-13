<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'serial',
        'model',
        'img',
        'is_active',
        'describe'
    ];

    /**
     * Get the user that owns the Device
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
