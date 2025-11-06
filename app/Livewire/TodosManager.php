<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;
use Livewire\Attributes\Validate;

class TodosManager extends Component
{
    #[Validate('required|min:3')]
    public $title = '';
    
    #[Validate('nullable|date|after_or_equal:today')]
    public $dueDate = '';
    
    public $description = '';
    public $editingId = null;
    public $viewingId = null;
    public $showTrashed = false;
    public $filter = 'all'; // all, completed, pending
    public $search = '';

    public function createTodo()
    {
        $this->validate();
        
        auth()->user()->todos()->create([
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->dueDate ?: null,
        ]);
        
        $this->reset(['title', 'description', 'dueDate']);
        session()->flash('message', 'Todo created successfully!');
    }

    public function editTodo($id)
    {
        $todo = auth()->user()->todos()->findOrFail($id);
        $this->editingId = $id;
        $this->title = $todo->title;
        $this->description = $todo->description;
        $this->dueDate = $todo->due_date ? $todo->due_date->format('Y-m-d') : '';
    }

    public function updateTodo()
    {
        $this->validate();
        
        $todo = auth()->user()->todos()->findOrFail($this->editingId);
        $todo->update([
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->dueDate ?: null,
        ]);
        
        $this->reset(['title', 'description', 'dueDate', 'editingId']);
        session()->flash('message', 'Todo updated successfully!');
    }

    public function toggleComplete($id)
    {
        $todo = auth()->user()->todos()->findOrFail($id);
        $todo->update(['completed' => !$todo->completed]);
    }

    public function deleteTodo($id)
    {
        auth()->user()->todos()->findOrFail($id)->delete();
        session()->flash('message', 'Todo moved to trash!');
    }

    public function restoreTodo($id)
    {
        auth()->user()->todos()->withTrashed()->findOrFail($id)->restore();
        session()->flash('message', 'Todo restored!');
    }

    public function forceDeleteTodo($id)
    {
        auth()->user()->todos()->withTrashed()->findOrFail($id)->forceDelete();
        session()->flash('message', 'Todo permanently deleted!');
    }

    public function viewTodo($id)
    {
        $this->viewingId = $id;
    }

    public function closeView()
    {
        $this->viewingId = null;
    }

    public function cancelEdit()
    {
        $this->reset(['title', 'description', 'dueDate', 'editingId']);
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function toggleTrashed()
    {
        $this->showTrashed = !$this->showTrashed;
    }

    public function render()
    {
        $query = auth()->user()->todos();
        
        if ($this->showTrashed) {
            $query = $query->onlyTrashed();
        } else {
            if ($this->filter === 'completed') {
                $query = $query->where('completed', true);
            } elseif ($this->filter === 'pending') {
                $query = $query->where('completed', false);
            }
        }
        
        if ($this->search) {
            $query = $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        $todos = $query->latest()->get();
        
        return view('livewire.todos-manager', compact('todos'));
    }
}
