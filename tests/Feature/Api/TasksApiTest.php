<?php

namespace Tests\Feature\Api;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_task_can_be_created_via_api(): void
    {
        $taskData = [
            'title' => 'New API Task',
            'description' => 'A new task to be tested via API.',
            'long_description' => 'A more detailed description of the new task.',
        ];

        $this->postJson(route('tasks.store'), $taskData)
            ->assertCreated()
            ->assertJsonFragment($taskData);

        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_a_task_cannot_be_created_with_invalid_data_via_api(): void
    {
        $this->postJson(route('tasks.store'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'description', 'long_description']);
    }

    public function test_a_task_can_be_updated_via_api(): void
    {
        $task = Task::factory()->create();
        $updatedData = [
            'title' => 'Updated Task Title',
            'description' => 'Updated task description.',
            'long_description' => 'Updated long description of the task.',
        ];

        $this->putJson(route('tasks.update', $task), $updatedData)
            ->assertOk()
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('tasks', $updatedData);
    }

    public function test_a_task_cannot_be_updated_with_invalid_data_via_api(): void
    {
        $task = Task::factory()->create();

        $this->putJson(route('tasks.update', $task), ['title' => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_a_task_can_be_deleted_via_api(): void
    {
        $task = Task::factory()->create();

        $this->deleteJson(route('tasks.destroy', $task))
            ->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_a_task_can_be_marked_as_completed_via_api(): void
    {
        $task = Task::factory()->create(['completed' => false]);

        $this->putJson(route('tasks.toggle-complete', $task))
            ->assertOk()
            ->assertJson(['completed' => true]);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'completed' => true]);
    }

    public function test_a_task_can_be_marked_as_not_completed_via_api(): void
    {
        $task = Task::factory()->create(['completed' => true]);

        $this->putJson(route('tasks.toggle-complete', $task))
            ->assertOk()
            ->assertJson(['completed' => false]);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'completed' => false]);
    }
}
