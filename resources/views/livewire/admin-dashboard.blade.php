<div class="min-h-screen bg-gray-50">
    <x-flash-message />

    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Admin Panel</h1>
                    <p class="text-gray-600">System overview and user management</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">Back to Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                        <p class="text-xs text-gray-500">+{{ $stats['users_today'] }} today</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Notes</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_notes'] }}</p>
                        <p class="text-xs text-gray-500">+{{ $stats['notes_today'] }} today</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Todos</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_todos'] }}</p>
                        <p class="text-xs text-gray-500">{{ $stats['completed_todos'] }} completed</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pomodoro Sessions</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_pomodoro_sessions'] }}</p>
                        <p class="text-xs text-gray-500">All time</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Users Management -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Users Management</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->notes_count }} notes, {{ $user->todos_count }} todos
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <button
                                            wire:click="viewUser({{ $user->id }})"
                                            class="text-blue-600 hover:text-blue-900">View</button>
                                        <button
                                            wire:click="toggleUserRole({{ $user->id }})"
                                            class="text-yellow-600 hover:text-yellow-900">Toggle Role</button>
                                        @if($user->id !== auth()->id())
                                            <button
                                                wire:click="deleteUser({{ $user->id }})"
                                                wire:confirm="Are you sure?"
                                                class="text-red-600 hover:text-red-900">Delete</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($recentActivity as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    @if($activity['type'] === 'note')
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        <span class="font-medium">{{ $activity['user'] }}</span>
                                        created a {{ $activity['type'] }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">{{ $activity['title'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $activity['created_at']->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Details Modal -->
    @if($showUserModal && $selectedUser)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">User Details: {{ $selectedUser->name }}</h3>
                    <button wire:click="closeUserModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <p><strong>Email:</strong> {{ $selectedUser->email }}</p>
                        <p><strong>Role:</strong> {{ ucfirst($selectedUser->role) }}</p>
                        <p><strong>Joined:</strong> {{ $selectedUser->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="bg-gray-50 p-3 rounded">
                            <div class="text-2xl font-bold text-blue-600">{{ $selectedUser->notes->count() }}</div>
                            <div class="text-sm text-gray-600">Notes</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <div class="text-2xl font-bold text-green-600">{{ $selectedUser->todos->count() }}</div>
                            <div class="text-sm text-gray-600">Todos</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <div class="text-2xl font-bold text-red-600">{{ $selectedUser->pomodoroSessions->sum('completed_sessions') }}</div>
                            <div class="text-sm text-gray-600">Pomodoro Sessions</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
