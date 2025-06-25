<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_task_page_is_empty_when_no_tasks_in_database(): void
    {
        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertSeeText('There are no tasks!');
    }

    public function test_the_tasks_page_displays_tasks_correctly(): void
    {
        Task::factory()->create(['title' => 'First Task']);
        Task::factory()->create(['title' => 'Second Task']);

        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertSeeText('First Task')
            ->assertSeeText('Second Task');
    }

    public function test_the_tasks_are_displayed_with_pagination(): void
    {
        Task::factory(15)->create();

        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertSeeText(Task::first()->title)
            ->assertSee('pagination');
    }

    public function test_it_returns_a_404_when_showing_a_non_existent_task(): void
    {
        $this->get(route('tasks.show', 999))
            ->assertNotFound();
    }

    public function test_the_create_page_is_accessible(): void
    {
        $this->get(route('tasks.create'))
            ->assertOk();
    }

    public function test_the_edit_page_is_accessible(): void
    {
        $task = Task::factory()->create();
        $this->get(route('tasks.edit', $task))
            ->assertOk();
    }
}
