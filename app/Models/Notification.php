<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'json',
            'read_at' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helper methods
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function isRead()
    {
        return !is_null($this->read_at);
    }

    // Static methods for creating notifications
    public static function createTaskRejected($userId, $taskTitle, $reason, $submissionId)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'task_rejected',
            'title' => 'Task Rejected',
            'message' => "Your task '{$taskTitle}' was rejected. Reason: {$reason}",
            'data' => [
                'submission_id' => $submissionId,
                'task_title' => $taskTitle,
                'reason' => $reason,
            ],
        ]);
    }

    public static function createRedoRequested($userId, $taskTitle, $submissionId)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'task_redo_requested',
            'title' => 'Redo Requested',
            'message' => "Please redo the task '{$taskTitle}'",
            'data' => [
                'submission_id' => $submissionId,
                'task_title' => $taskTitle,
            ],
        ]);
    }
}
