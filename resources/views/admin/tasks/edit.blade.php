<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200">
                <form action="{{ route('admin.tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Task Title</label>
                        <input type="text" name="title" value="{{ old('title', $task->title) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Task Hours</label>
                        <input type="number" name="hours" value="{{ old('hours', $task->hours) }}" min="1" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Assign to Interns</label>
                        <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border p-3 rounded bg-gray-50">
                            @php $assignedIds = $task->users->pluck('id')->toArray(); @endphp
                            @foreach(\App\Models\User::where('role', 'intern')->get() as $intern)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="intern_ids[]" value="{{ $intern->id }}" 
                                        {{ in_array($intern->id, $assignedIds) ? 'checked' : '' }}
                                        class="rounded text-indigo-600 border-gray-300 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">{{ $intern->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('admin.tasks') }}" class="text-gray-500 text-sm">Cancel</a>
                        <x-primary-button>
                            {{ __('Update Task') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
