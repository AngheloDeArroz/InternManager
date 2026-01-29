<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Task & Assign') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200">
                <form action="{{ route('admin.tasks.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Task Title</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Task Hours</label>
                        <input type="number" name="hours" min="1" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Assign to Interns</label>
                        <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border p-3 rounded bg-gray-50">
                            @foreach(\App\Models\User::where('role', 'intern')->get() as $intern)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="intern_ids[]" value="{{ $intern->id }}" 
                                        {{ (isset($preselectedInternId) && $preselectedInternId == $intern->id) ? 'checked' : '' }}
                                        class="rounded text-indigo-600 border-gray-300 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">{{ $intern->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <x-primary-button>
                            {{ __('Create Task') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
