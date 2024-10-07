<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function testRedirecttoTasksWhenVisitTheHomePage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function testTasksPage()
    {

        $response = $this->get('/tasks');

        $response->assertSeeText('The list of tasks');
    }

    public function testNoTasksWhenNothingInDatabase()
    {

        $response = $this->get('/tasks');

        $response->assertSeeText('There are no tasks!');
    }

    public function testSeeOneTaskWhenThereIsOneTask()
    {
        // Arrange
        $task = $this->createDummyTask();

        // Act 
        $response = $this->get('/tasks');

        // Assert 

        $response->assertSeeText('New Task');

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task'
        ]);
    }

    public function testStoreValidTask()
    {
        $params = [
            'title' => 'Valid task',
            'description' => 'Valid task description',
            'long_description' => 'Valid task long description'
        ];

        $this->post('/tasks', $params)
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertEquals(session('success'), 'Task created successfully!');
    }

    public function testStoreInvalidTask()
    {
        $params = [
            'title' => 'Invalid taskInvalid taskInvalid taskInvalid 
            taskInvalid taskInvalid taskInvalid 
            taskInvalid taskInvalid taskInvalid 
            taskInvalid taskInvalid taskInvalid 
            taskInvalid taskInvalid taskInvalid taskInvalid task 
            taskInvalid taskInvalid taskInvalid 
            taskInvalid taskInvalid taskInvalid 
            taskInvalid taskInvalid taskInvalid 
            taskInvalid taskInvalid taskInvalid taskInvalid task',
            'description' => '',
            'long_description' => ''
        ];

        $this->post('/tasks', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title field must not be greater than 255 characters.');
        $this->assertEquals($messages['description'][0], 'The description field is required.');
        $this->assertEquals($messages['long_description'][0], 'The long description field is required.');
    }

    public function testUpdateTask()
    {
        $task = $this->createDummyTask();

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task'
        ]);

        $params = [
            'title' => 'Updated title',
            'description' => 'Updated description',
            'long_description' => 'Updated long description',
        ];

        $response = $this->put("/tasks/{$task->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('success', 'Task updated successfully!');

        $this->assertDatabaseMissing('tasks', $task->toArray());
        $this->assertDatabaseHas('tasks',  $params);
    
    }


    public function testDeleteTask()
    {
        $task = $this->createDummyTask();

        $this->assertDatabaseHas('tasks',[
            'title' => 'New Task',
            'description' => 'Task Description',
            'long_description' => 'Task Long Description'
        ]);

        $this->delete("/tasks/{$task->id}")
            ->assertStatus(302)
            ->assertSessionHas('success');

            $this->assertEquals(session('success'),'Task deleted successfully!');
            $this->assertDatabaseMissing('tasks', $task->toArray());
    }

    public function testShowSingleTask(){
        $task = $this->createDummyTask();

        $this->assertDatabaseHas('tasks',[
            'title' => 'New Task',
            'description' => 'Task Description',
            'long_description' => 'Task Long Description'
        ]);

        $response = $this->get("/tasks/{$task->id}");

        $response->assertSeeText('New Task');
        
    }

    private function createDummyTask(): Task
    {
        $task = new Task();

        $task->title = 'New Task';
        $task->description = 'Task Description';
        $task->long_description = 'Task Long Description';
        $task->save();

        return $task;
    }


}
