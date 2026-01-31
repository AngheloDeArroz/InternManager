<div class="p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 uppercase font-bold">Required Hours</p>
            <p class="text-3xl font-bold text-gray-800">{{ auth()->user()->required_hours }}h</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 uppercase font-bold">Approved Hours</p>
            <p class="text-3xl font-bold text-green-600">{{ auth()->user()->approvedHours() }}h</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 uppercase font-bold">Remaining Hours</p>
            <p class="text-3xl font-bold text-indigo-600">{{ auth()->user()->remainingHours() }}h</p>
        </div>
    </div>

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">My Assigned Tasks</h2>
        @if (session()->has('message'))
            <span class="text-green-600 text-sm font-medium">{{ session('message') }}</span>
        @endif
    </div>

    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Task Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hours</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tasks as $task)
                    <tr wire:key="task-{{ $task->id }}">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($task->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $task->hours }}h
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $task->pivot->status === 'approved' ? 'bg-green-100 text-green-800' : ($task->pivot->status === 'done' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($task->pivot->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($task->pivot->status === 'pending')
                                <button wire:click="markDone({{ $task->id }})" 
                                        class="text-indigo-600 hover:text-indigo-900 font-bold">
                                    Mark as Done
                                </button>
                            @elseif($task->pivot->status === 'done')
                                <button wire:click="unmarkDone({{ $task->id }})" 
                                        class="text-red-600 hover:text-red-900 font-bold">
                                    Unmark as Done
                                </button>
                            @else
                                <span class="text-gray-400 italic">Approved & Locked</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            No tasks assigned yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
