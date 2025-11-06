<div>
<nav class="bg-white shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <!-- Left: Tabs -->
      <div class="flex items-center space-x-6">
        <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
        <!-- تبويب إضافي تضيفهن لاحقاً -->
      </div>

      <!-- Right: Auth button -->
      <div class="flex items-center space-x-4">
        @auth
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-700 hover:text-red-600 font-medium">Logout</button>
          </form>
        @else
          <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-semibold">Get Started</a>
        @endauth
      </div>
    </div>
  </div>
</nav>
</div>
