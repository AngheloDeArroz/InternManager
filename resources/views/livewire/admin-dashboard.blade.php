<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Admin Dashboard Overview</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Interns Stats -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
            <h3 class="text-lg font-semibold mb-2">Internal Users</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $interns->count() }}</p>
            <p class="text-gray-500">Total interns registered</p>
        </div>

        <!-- Tasks Stats -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
            <h3 class="text-lg font-semibold mb-2">Tasks</h3>
            <p class="text-3xl font-bold text-green-600">{{ $tasks->count() }}</p>
            <p class="text-gray-500">Total tasks created</p>
        </div>
    </div>
</div>
