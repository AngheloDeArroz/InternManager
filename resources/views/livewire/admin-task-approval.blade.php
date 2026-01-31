<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Task Approval Workflow</h2>
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Intern</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Task</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hours</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tasks as $task)
                    @foreach($task->users as $user)
                        <tr wire:key="row-{{ $task->id }}-{{ $user->id }}-{{ $user->pivot->status }}">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $task->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $task->hours }}h</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->pivot->status === 'approved' ? 'bg-green-100 text-green-800' : ($user->pivot->status === 'done' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($user->pivot->status) }}
                                </span>
                            </td>
                             <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div wire:loading.class="opacity-50">
                                    @if($user->pivot->status === 'done')
                                        <button wire:click="approve({{ $task->id }}, {{ $user->id }})" 
                                                wire:loading.attr="disabled"
                                                wire:key="btn-approve-{{ $task->id }}-{{ $user->id }}"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-sm transition transition-colors shadow-sm disabled:opacity-50">
                                            Approve
                                        </button>
                                    @elseif($user->pivot->status === 'approved')
                                        <button wire:click="unapprove({{ $task->id }}, {{ $user->id }})" 
                                                wire:loading.attr="disabled"
                                                wire:key="btn-unapprove-{{ $task->id }}-{{ $user->id }}"
                                                class="bg-red-100 text-red-700 hover:bg-red-200 font-bold py-1 px-3 rounded text-sm transition transition-colors border border-red-200 disabled:opacity-50">
                                            Unapprove
                                        </button>
                                    @else
                                        <span class="text-gray-400 italic">Awaiting Intern Completion</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
