<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App - Get Organized</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900">TodoApp</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Organize Your Life with
                <span class="text-blue-600">TodoApp</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Manage your tasks, take notes, and boost productivity with our Pomodoro timer.
                Everything you need to stay organized in one simple app.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-50 transition">
                        Sign In
                    </a>
                @endauth
            </div>

            <!-- Features -->
            <div class="grid md:grid-cols-3 gap-8 mt-16">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Todo Management</h3>
                    <p class="text-gray-600">Create, organize, and track your tasks with ease. Never forget what needs to be done.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Smart Notes</h3>
                    <p class="text-gray-600">Capture your thoughts and ideas instantly. Organize your notes with titles and rich content.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pomodoro Timer</h3>
                    <p class="text-gray-600">Boost your productivity with focused work sessions and regular breaks using the Pomodoro technique.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; 2025 TodoApp. Built with TALL-Stack</p>
            </div>
        </div>
    </footer>
</body>
</html>
