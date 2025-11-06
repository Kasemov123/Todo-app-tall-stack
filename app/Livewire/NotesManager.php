<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;
use Livewire\Attributes\Validate;

class NotesManager extends Component
{
    #[Validate('required|min:3')]
    public $title = '';
    
    #[Validate('required|min:10')]
    public $content = '';
    
    public $editingId = null;
    public $viewingId = null;
    public $showTrashed = false;
    public $search = '';

    public function createNote()
    {
        $this->validate();
        
        auth()->user()->notes()->create([
            'title' => $this->title,
            'content' => $this->content,
        ]);
        
        $this->reset(['title', 'content']);
        session()->flash('message', 'Note created successfully!');
    }

    public function editNote($id)
    {
        $note = auth()->user()->notes()->findOrFail($id);
        $this->editingId = $id;
        $this->title = $note->title;
        $this->content = $note->content;
    }

    public function updateNote()
    {
        $this->validate();
        
        $note = auth()->user()->notes()->findOrFail($this->editingId);
        $note->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);
        
        $this->reset(['title', 'content', 'editingId']);
        session()->flash('message', 'Note updated successfully!');
    }

    public function deleteNote($id)
    {
        auth()->user()->notes()->findOrFail($id)->delete();
        session()->flash('message', 'Note moved to trash!');
    }

    public function restoreNote($id)
    {
        auth()->user()->notes()->withTrashed()->findOrFail($id)->restore();
        session()->flash('message', 'Note restored!');
    }

    public function forceDeleteNote($id)
    {
        auth()->user()->notes()->withTrashed()->findOrFail($id)->forceDelete();
        session()->flash('message', 'Note permanently deleted!');
    }

    public function viewNote($id)
    {
        $this->viewingId = $id;
    }

    public function closeView()
    {
        $this->viewingId = null;
    }

    public function cancelEdit()
    {
        $this->reset(['title', 'content', 'editingId']);
    }

    public function toggleTrashed()
    {
        $this->showTrashed = !$this->showTrashed;
    }

    public function render()
    {
        $query = auth()->user()->notes();
        
        if ($this->showTrashed) {
            $query = $query->onlyTrashed();
        }
        
        if ($this->search) {
            $query = $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }
        
        $notes = $query->latest()->get();
        
        return view('livewire.notes-manager', compact('notes'));
    }
}
