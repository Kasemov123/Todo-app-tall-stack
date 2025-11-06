<div>
    <x-flash-message />

    <!-- Header with Filters and Search -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-4">
            <h2 class="text-xl font-semibold text-gray-900">
                {{ $showTrashed ? 'Deleted Todos' : 'My Todos' }}
            </h2>
            
            @if(!$showTrashed)
                <div class="flex space-x-2">
                    <button 
                        wire:click="setFilter('all')"
                        class="px-3 py-1 text-sm rounded {{ $filter === 'all' ? 'bg-blue-100 text-blue-800' : 'text-gray-600 hover:text-gray-900' }}">
                        All
                    </button>
                    <button 
                        wire:click="setFilter('pending')"
                        class="px-3 py-1 text-sm rounded {{ $filter === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'text-gray-600 hover:text-gray-900' }}">
                        Pending
                    </button>
                    <button 
                        wire:click="setFilter('completed')"
                        class="px-3 py-1 text-sm rounded {{ $filter === 'completed' ? 'bg-green-100 text-green-800' : 'text-gray-600 hover:text-gray-900' }}">
                        Completed
                    </button>
                </div>
            @endif
            
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
                placeholder="Search todos..."
                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>

    <!-- Create/Edit Form -->
    @if(!$showTrashed)
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-medium mb-4">{{ $editingId ? 'Edit Todo' : 'Create New Todo' }}</h3>
            
            <div class="space-y-4">
                <div>
                    <input 
                        wire:model="title"
                        type="text" 
                        placeholder="Todo title..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <textarea 
                        wire:model="description"
                        rows="2" 
                        placeholder="Description (optional)..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div>
                    <input 
                        wire:model="dueDate"
                        type="date" 
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <label class="text-sm text-gray-600">Due date (optional)</label>
                    @error('dueDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex space-x-3">
                    @if($editingId)
                        <button 
                            wire:click="updateTodo"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Update Todo
                        </button>
                        <button 
                            wire:click="cancelEdit"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            Cancel
                        </button>
                    @else
                        <button 
                            wire:click="createTodo"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Create Todo
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Todos List -->
    @if($todos->count() > 0)
        <div class="space-y-3">
            @foreach($todos as $todo)
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow">
                    <div class="flex items-start space-x-3">
                        @if(!$showTrashed)
                            <button 
                                wire:click="toggleComplete({{ $todo->id }})"
                                class="mt-1 flex-shrink-0">
                                @if($todo->completed)
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <div class="w-5 h-5 border-2 border-gray-300 rounded-full"></div>
                                @endif
                            </button>
                        @endif
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="font-medium text-gray-900 break-words {{ $todo->completed ? 'line-through text-gray-500' : '' }}">
                                {{ $todo->title }}
                            </h3>
                            @if($todo->description)
                                <p class="text-sm text-gray-600 mt-1 break-words {{ $todo->completed ? 'line-through' : '' }}">
                                    {{ $todo->description }}
                                </p>
                            @endif
                            <div class="text-xs text-gray-500 mt-2">
                                {{ $todo->created_at->diffForHumans() }}
                                @if($todo->due_date)
                                    <span class="ml-2 px-2 py-1 {{ $todo->due_date->isPast() && !$todo->completed ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }} rounded-full text-xs">
                                        Due: {{ $todo->due_date->format('M d') }}
                                    </span>
                                @endif
                                @if($todo->completed)
                                    <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex space-x-1">
                            @if($showTrashed)
                                <button 
                                    wire:click="restoreTodo({{ $todo->id }})"
                                    class="text-green-600 hover:text-green-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </button>
                                <button 
                                    wire:click="forceDeleteTodo({{ $todo->id }})"
                                    wire:confirm="Are you sure? This cannot be undone!"
                                    class="text-red-600 hover:text-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            @else
                                <button 
                                    wire:click="viewTodo({{ $todo->id }})"
                                    class="text-gray-600 hover:text-gray-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button 
                                    wire:click="editTodo({{ $todo->id }})"
                                    class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button 
                                    wire:click="deleteTodo({{ $todo->id }})"
                                    class="text-red-600 hover:text-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">
                {{ $showTrashed ? 'No deleted todos' : 'No todos yet' }}
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                {{ $showTrashed ? 'You haven\'t deleted any todos.' : 'Get started by creating your first todo.' }}
            </p>
        </div>
    @endif

    <!-- View Todo Modal -->
    @if($viewingId)
        @php $viewTodo = auth()->user()->todos()->find($viewingId); @endphp
        @if($viewTodo)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Todo Details</h3>
                        <button wire:click="closeView" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $viewTodo->title }}</h4>
                            @if($viewTodo->description)
                                <p class="text-gray-600 mt-2">{{ $viewTodo->description }}</p>
                            @endif
                        </div>
                        
                        <div class="text-sm text-gray-500">
                            <p>Created: {{ $viewTodo->created_at->format('M d, Y h:i A') }}</p>
                            @if($viewTodo->due_date)
                                <p>Due: {{ $viewTodo->due_date->format('M d, Y') }}</p>
                            @endif
                            <p>Status: {{ $viewTodo->completed ? 'Completed' : 'Pending' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>