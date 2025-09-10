<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'list_id',
        'title',
        'description',
        'instructions',
        'required_proof_type',
        'is_required',
        'order_index',
        'attachments',
        'validation_rules',
        'requires_signature',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'attachments' => 'json',
            'validation_rules' => 'json',
            'requires_signature' => 'boolean',
        ];
    }

    // Relationships
    public function taskList()
    {
        return $this->belongsTo(TaskList::class, 'list_id');
    }

    public function submissionTasks()
    {
        return $this->hasMany(SubmissionTask::class);
    }

    public function assignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_assignments')->withPivot('assigned_at', 'due_at', 'is_active')->withTimestamps();
    }

    // Scopes
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    public function scopeByProofType($query, $type)
    {
        return $query->where('required_proof_type', $type);
    }
}
