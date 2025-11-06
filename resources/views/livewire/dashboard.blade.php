<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
                </div>
                <div class="flex items-center space-x-4">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Admin Panel
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-lg shadow-sm">
            <!-- Tab Headers -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6">
                    <button 
                        wire:click="setActiveTab('todos')"
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'todos' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <span>Todos</span>
                        </div>
                    </button>

                    <button 
                        wire:click="setActiveTab('notes')"
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'notes' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Notes</span>
                        </div>
                    </button>

                    <button 
                        wire:click="setActiveTab('pomodoro')"
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'pomodoro' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Pomodoro</span>
                        </div>
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                @if($activeTab === 'todos')
                    <livewire:todos-manager />
                @elseif($activeTab === 'notes')
                    <livewire:notes-manager />
                @elseif($activeTab === 'pomodoro')
                    <livewire:pomodoro-timer />
                @endif
            </div>
        </div>
    </div>
</div>