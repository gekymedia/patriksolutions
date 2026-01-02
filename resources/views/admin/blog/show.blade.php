<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task Bone Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <h3 class="font-semibold text-xl">{{ $taskBone->title }}</h3>
                </div>

                <div class="mb-4">
                    <p><strong>Start Time:</strong> {{ $taskBone->start_time }}</p>
                </div>

                <div class="mb-4">
                    <p><strong>End Time:</strong> {{ $taskBone->end_time }}</p>
                </div>

                <div class="mb-4">
                    <p><strong>Assigned To:</strong> {{ $taskBone->assignedTo ? $taskBone->assignedTo->name : 'Unassigned' }}</p>
                </div>

                <div class="mb-4">
                    <p><strong>Description:</strong></p>
                    <p>{{ $taskBone->description }}</p>
                </div>

                <div class="flex">
                    <a href="{{ route('admin.task_bones.edit', $taskBone) }}" class="btn btn-warning mr-2">Edit</a>
                    <form action="{{ route('admin.task_bones.destroy', $taskBone) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
