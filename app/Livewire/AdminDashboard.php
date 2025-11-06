<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Note;
use App\Models\Todo;
use App\Models\PomodoroSession;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    public $selectedUser = null;
    public $showUserModal = false;

    public function viewUser($userId)
    {
        $this->selectedUser = User::with(['notes', 'todos', 'pomodoroSessions'])->find($userId);
        $this->showUserModal = true;
    }

    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->selectedUser = null;
    }

    public function deleteUser($userId)
    {
        User::find($userId)->delete();
        session()->flash('message', 'User deleted successfully!');
    }

    public function toggleUserRole($userId)
    {
        $user = User::find($userId);
        $user->update([
            'role' => $user->role === 'admin' ? 'user' : 'admin'
        ]);
        session()->flash('message', 'User role updated!');
    }

    public function render()
    {
        $stats = [
            'total_users' => User::count(),
            'total_notes' => Note::count(),
            'total_todos' => Todo::count(),
            'completed_todos' => Todo::where('completed', true)->count(),
            'total_pomodoro_sessions' => PomodoroSession::sum('completed_sessions'),
            'users_today' => User::whereDate('created_at', Carbon::today())->count(),
            'notes_today' => Note::whereDate('created_at', Carbon::today())->count(),
            'todos_today' => Todo::whereDate('created_at', Carbon::today())->count(),
        ];

        $users = User::withCount(['notes', 'todos'])
            ->with('pomodoroSessions')
            ->latest()
            ->get();

        $recentActivity = collect()
            ->merge(Note::with('user')->latest()->take(5)->get()->map(function($note) {
                return [
                    'type' => 'note',
                    'user' => $note->user->name,
                    'title' => $note->title,
                    'created_at' => $note->created_at,
                ];
            }))
            ->merge(Todo::with('user')->latest()->take(5)->get()->map(function($todo) {
                return [
                    'type' => 'todo',
                    'user' => $todo->user->name,
                    'title' => $todo->title,
                    'created_at' => $todo->created_at,
                ];
            }))
            ->sortByDesc('created_at')
            ->take(10);

        return view('livewire.admin-dashboard', compact('stats', 'users', 'recentActivity'))
            ->layout('layouts.dashboard');
    }
}
