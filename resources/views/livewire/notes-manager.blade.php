<div>
    <x-flash-message />

    <!-- Header with Search and Actions -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-4">
            <h2 class="text-xl font-semibold text-gray-900">
                {{ $showTrashed ? 'Deleted Notes' : 'My Notes' }}
            </h2>
            <button 
                wire:click="toggleTrashed"
                class="text-sm text-gray-600 hover:text-gray-900">
                {{ $showTrashed ? 'Show Active' : 'Show Deleted' }}
            </button>
        </div>
        
        <div class="flex items-center space-x-3">
            <input 
                wire:model.live="search"
                type="text" 
                placeholder="Search notes..."
                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>

    <!-- Create/Edit Form -->
    @if(!$showTrashed)
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-medium mb-4">{{ $editingId ? 'Edit Note' : 'Create New Note' }}</h3>
            
            <div class="space-y-4">
                <div>
                    <input 
                        wire:model="title"
                        type="text" 
                        placeholder="Note title..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <textarea 
                        wire:model="content"
                        rows="4" 
                        placeholder="Write your note content here..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex space-x-3">
                    @if($editingId)
                        <button 
                            wire:click="updateNote"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Update Note
                        </button>
                        <button 
                            wire:click="cancelEdit"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            Cancel
                        </button>
                    @else
                        <button 
                            wire:click="createNote"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Create Note
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Notes List -->
    @if($notes->count() > 0)
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($notes as $note)
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-semibold text-gray-900 truncate">{{ $note->title }}</h3>
                        <div class="flex space-x-1 ml-2">
                            @if($showTrashed)
                                <button 
                                    wire:click="restoreNote({{ $note->id }})"
                                    class="text-green-600 hover:text-green-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </button>
                                <button 
                                    wire:click="forceDeleteNote({{ $note->id }})"
                                    wire:confirm="Are you sure? This cannot be undone!"
                                    class="text-red-600 hover:text-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            @else
                                <button 
                                    wire:click="viewNote({{ $note->id }})"
                                    class="text-gray-600 hover:text-gray-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button 
                                    wire:click="editNote({{ $note->id }})"
                                    class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button 
                                    wire:click="deleteNote({{ $note->id }})"
                                    class="text-red-600 hover:text-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{ $note->excerpt }}</p>
                    
                    <div class="text-xs text-gray-500">
                        {{ $note->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">
                {{ $showTrashed ? 'No deleted notes' : 'No notes yet' }}
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                {{ $showTrashed ? 'You haven\'t deleted any notes.' : 'Get started by creating your first note.' }}
            </p>
        </div>
    @endif

    <!-- View Note Modal -->
    @if($viewingId)
        @php $viewNote = auth()->user()->notes()->find($viewingId); @endphp
        @if($viewNote)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 shadow-lg rounded-md bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Note Details</h3>
                        <button wire:click="closeView" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-xl font-semibold text-gray-900 mb-3">{{ $viewNote->title }}</h4>
                            <div class="text-gray-600 whitespace-pre-wrap">{{ $viewNote->content }}</div>
                        </div>
                        
                        <div class="text-sm text-gray-500 border-t pt-3">
                            <p>Created: {{ $viewNote->created_at->format('M d, Y h:i A') }}</p>
                            @if($viewNote->updated_at != $viewNote->created_at)
                                <p>Last updated: {{ $viewNote->updated_at->format('M d, Y h:i A') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>