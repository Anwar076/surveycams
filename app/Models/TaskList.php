<?php
/**
 * @property int $id
 */

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
        'weekday',
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

    public function scopeMainLists($query)
    {
        return $query->whereNull('parent_list_id');
    }

    public function scopeDailySubLists($query)
    {
        return $query->whereNotNull('parent_list_id')->whereNotNull('weekday');
    }

    public function scopeForWeekday($query, $weekday)
    {
        return $query->where('weekday', strtolower($weekday));
    }

    public function scopeForToday($query)
    {
        $today = strtolower(now()->format('l')); // 'monday', 'tuesday', etc.
        return $query->where('weekday', $today);
    }

    // Helper methods
    public function isMainList()
    {
        return is_null($this->parent_list_id);
    }

    public function isDailySubList()
    {
        return !is_null($this->parent_list_id) && !is_null($this->weekday);
    }

    public function getTodaySubList()
    {
        if (!$this->isMainList()) {
            return null;
        }

        $today = strtolower(now()->format('l'));
        return $this->subLists()->where('weekday', $today)->first();
    }

    public function createDailySubLists()
    {
        $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        
        foreach ($weekdays as $weekday) {
            $existingSubList = $this->subLists()->where('weekday', $weekday)->first();
            
            if (!$existingSubList) {
                $this->subLists()->create([
                    'title' => $this->title . ' – ' . ucfirst($weekday),
                    'description' => $this->description,
                    'weekday' => $weekday,
                    'schedule_type' => 'daily',
                    'priority' => $this->priority,
                    'category' => $this->category,
                    'requires_signature' => $this->requires_signature,
                    'is_active' => true,
                    'created_by' => $this->created_by,
                ]);
            }
        }
    }
}
