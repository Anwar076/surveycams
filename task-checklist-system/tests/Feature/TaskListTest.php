<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskList;
use App\Models\Task;
use App\Models\ListAssignment;
use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Seed the database with test data
    }

    public function test_admin_can_create_task_list(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/lists', [
            'title' => 'Test Cleaning List',
            'description' => 'A test cleaning checklist',
            'priority' => 'medium',
            'schedule_type' => 'daily',
            'category' => 'Cleaning',
            'is_active' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('lists', [
            'title' => 'Test Cleaning List',
            'created_by' => $admin->id,
        ]);
    }

    public function test_employee_can_view_assigned_lists(): void
    {
        $employee = User::where('role', 'employee')->first();

        $response = $this->actingAs($employee)->get('/employee/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('employee.dashboard');
    }

    public function test_employee_can_start_submission(): void
    {
        $employee = User::where('role', 'employee')->first();
        $list = TaskList::first();

        // Ensure the employee has access to this list
        ListAssignment::create([
            'list_id' => $list->id,
            'user_id' => $employee->id,
            'assigned_date' => today(),
        ]);

        $response = $this->actingAs($employee)->post("/employee/lists/{$list->id}/start");

        $response->assertRedirect();
        $this->assertDatabaseHas('submissions', [
            'user_id' => $employee->id,
            'list_id' => $list->id,
            'status' => 'in_progress',
        ]);
    }

    public function test_employee_can_complete_task(): void
    {
        $employee = User::where('role', 'employee')->first();
        $list = TaskList::first();
        $task = $list->tasks->first();

        // Create a submission
        $submission = Submission::create([
            'user_id' => $employee->id,
            'list_id' => $list->id,
            'started_at' => now(),
            'status' => 'in_progress',
        ]);

        // Create submission task
        $submissionTask = $submission->submissionTasks()->create([
            'task_id' => $task->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($employee)->post("/employee/submissions/{$submission->id}/tasks/{$task->id}", [
            'proof_text' => 'Task completed successfully',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('submission_tasks', [
            'id' => $submissionTask->id,
            'status' => 'completed',
            'proof_text' => 'Task completed successfully',
        ]);
    }

    public function test_admin_can_review_submission(): void
    {
        $admin = User::where('role', 'admin')->first();
        $employee = User::where('role', 'employee')->first();
        $list = TaskList::first();

        // Create completed submission
        $submission = Submission::create([
            'user_id' => $employee->id,
            'list_id' => $list->id,
            'started_at' => now(),
            'completed_at' => now(),
            'status' => 'completed',
        ]);

        $task = $list->tasks->first();
        $submissionTask = $submission->submissionTasks()->create([
            'task_id' => $task->id,
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        $response = $this->actingAs($admin)->post("/admin/submissions/{$submission->id}/review", [
            'task_reviews' => [
                $task->id => [
                    'status' => 'approved',
                    'comment' => 'Well done!',
                ]
            ]
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('submission_tasks', [
            'id' => $submissionTask->id,
            'status' => 'approved',
            'manager_comment' => 'Well done!',
            'reviewed_by' => $admin->id,
        ]);
    }

    public function test_api_returns_assigned_lists(): void
    {
        $employee = User::where('role', 'employee')->first();
        $token = $employee->createToken('test')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/lists');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'priority',
                    'category',
                    'tasks_count',
                ]
            ]
        ]);
    }

    public function test_unauthorized_user_cannot_access_admin_routes(): void
    {
        $employee = User::where('role', 'employee')->first();

        $response = $this->actingAs($employee)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_access_employee_routes(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/employee/dashboard');

        $response->assertStatus(403);
    }
}
