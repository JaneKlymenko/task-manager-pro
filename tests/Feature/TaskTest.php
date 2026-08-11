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

test('user can create a task', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('tasks.store'), ['title' => 'New task'])
        ->assertRedirect();

    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'title' => 'New task',
        'is_done' => false,
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
