<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Intern Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Hours Summary -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="font-bold text-lg mb-4">Internship Progress</h3>

            <p><strong>Required Hours:</strong> {{ auth()->user()->required_hours }}</p>
            <p><strong>Approved Hours:</strong> {{ auth()->user()->approvedHours() }}</p>
            <p><strong>Remaining Hours:</strong> {{ auth()->user()->remainingHours() }}</p>
        </div>

        <!-- Tasks List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="font-bold text-lg mb-4">Assigned Tasks</h3>

            @livewire('intern-task-list')
        </div>
    </div>
</x-app-layout>
