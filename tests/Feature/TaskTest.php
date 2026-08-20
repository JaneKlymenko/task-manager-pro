<?php

use App\Models\Task;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('dashboard shows only the current user tasks', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    $ownTask = $user->tasks()->create(['title' => 'My task']);
    $other->tasks()->create(['title' => 'Other task']);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Dashboard')
            ->has('tasks', 1)
            ->where('tasks.0.id', $ownTask->id)
            ->where('tasks.0.title', 'My task')
        );
});

test('tasks index shows only the current user tasks', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    $ownTask = $user->tasks()->create(['title' => 'My task']);
    $other->tasks()->create(['title' => 'Other task']);

    $this->actingAs($user)
        ->get(route('tasks.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('tasks/Index')
            ->has('tasks', 1)
            ->where('tasks.0.id', $ownTask->id)
        );
});

test('user can open create task page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('tasks.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('tasks/Create'));
});

test('user can create a task', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('tasks.store'), ['title' => 'New task'])
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'title' => 'New task',
        'is_done' => false,
    ]);
});

test('user can create a task with full details', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('tasks.store'), [
            'title' => 'Full task',
            'description' => 'Detailed notes',
            'status' => 'in_progress',
            'priority' => 2,
            'due_date' => '2030-01-15',
            'time_estimate' => 45,
        ])
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'title' => 'Full task',
        'description' => 'Detailed notes',
        'status' => 'in_progress',
        'priority' => 2,
        'time_estimate' => 45,
        'is_done' => false,
    ]);

    $task = $user->tasks()->where('title', 'Full task')->first();
    expect($task->due_date->toDateString())->toBe('2030-01-15');
});

test('creating a completed task marks is_done true', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('tasks.store'), [
            'title' => 'Already done',
            'status' => 'completed',
        ])
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'title' => 'Already done',
        'status' => 'completed',
        'is_done' => true,
    ]);
});

test('user can toggle own task', function () {
    $user = User::factory()->create();
    $task = $user->tasks()->create(['title' => 'Toggle me']);

    $this->actingAs($user)
        ->patch(route('tasks.update', $task), ['is_done' => true])
        ->assertRedirect();

    expect($task->fresh()->is_done)->toBeTrue();
});

test('user cannot update another users task', function () {
    $user = User::factory()->create();
    $otherTask = User::factory()->create()->tasks()->create(['title' => 'Secret']);

    $this->actingAs($user)
        ->patch(route('tasks.update', $otherTask), ['is_done' => true])
        ->assertForbidden();
});

test('user can delete own task', function () {
    $user = User::factory()->create();
    $task = $user->tasks()->create(['title' => 'Delete me']);

    $this->actingAs($user)
        ->delete(route('tasks.destroy', $task))
        ->assertRedirect();

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});

test('user cannot delete another users task', function () {
    $user = User::factory()->create();
    $otherTask = User::factory()->create()->tasks()->create(['title' => 'Secret']);

    $this->actingAs($user)
        ->delete(route('tasks.destroy', $otherTask))
        ->assertForbidden();
});
