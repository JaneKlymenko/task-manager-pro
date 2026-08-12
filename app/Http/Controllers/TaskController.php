<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function dashboard(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'tasks' => $this->tasksForUser($request),
        ]);
    }

    public function index(Request $request): Response
    {
        return Inertia::render('tasks/Index', [
            'tasks' => $this->tasksForUser($request),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('tasks/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:pending,in_progress,done'],
            'priority' => ['nullable', 'integer', 'min:0', 'max:3'],
            'due_date' => ['nullable', 'date'],
            'time_estimate' => ['nullable', 'integer', 'min:1'],
        ]);

        $validated['is_done'] = ($validated['status'] ?? null) === 'done';

        $request->user()->tasks()->create($validated);

        return redirect()->route('tasks.index');
    }

    public function show(Task $task): Response
    {
        $this->authorize('view', $task);

        return Inertia::render('tasks/Show', [
            'task' => $task,
        ]);
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'is_done' => ['required', 'boolean'],
        ]);

        $task->update($validated);

        return back();
    }

    public function destroy(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return back();
    }

    private function tasksForUser(Request $request)
    {
        return $request->user()
            ->tasks()
            ->latest()
            ->get(['id', 'title', 'is_done', 'created_at', 'status', 'priority', 'due_date']);
    }
}
