<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $table = "tasks";

    protected $fillable = [
        'title',
        'description',
        'priority',
        'due_date',
        'is_completed',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_completed' => 'boolean',
    ];

    /**
     * categories
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_task');
    }

    public function scopeCategory($query, ?int $categoryId)
    {
        if (is_null($categoryId)) {
            return $query;
        }

        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    public function scopePriority($query, ?string $priority)
    {
        if (is_null($priority)) {
            return $query;
        }
        return $query->where('priority', $priority);
    }

    public function scopeIsCompleted($query, ?bool $isCompleted)
    {
        if (is_null($isCompleted)) {
            return $query;
        }
        return $query->where('is_completed', filter_var($isCompleted, FILTER_VALIDATE_BOOLEAN));
    }
}
