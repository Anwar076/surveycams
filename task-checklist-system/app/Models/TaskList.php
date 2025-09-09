<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskList extends Model
{
    use HasFactory;

    protected $table = 'lists';

    protected $fillable = [
        'title',
        'description',
        'created_by',
        'parent_list_id',
        'schedule_type',
        'schedule_config',
        'priority',
        'due_date',
        'tags',
        'category',
        'requires_signature',
        'is_template',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'schedule_config' => 'json',
            'tags' => 'json',
            'due_date' => 'datetime',
            'requires_signature' => 'boolean',
            'is_template' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parentList()
    {
        return $this->belongsTo(TaskList::class, 'parent_list_id');
    }

    public function subLists()
    {
        return $this->hasMany(TaskList::class, 'parent_list_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'list_id')->orderBy('order_index');
    }

    public function assignments()
    {
        return $this->hasMany(ListAssignment::class, 'list_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'list_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTemplates($query)
    {
        return $query->where('is_template', true);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }
}
