<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Modal toggle -->
                    <button data-modal-target="create-task" data-modal-toggle="create-task" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        Create Task
                    </button>

                    <!-- Main modal -->
                    <div id="create-task" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Create New Task
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="create-task">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form action="{{ route('todo.store') }}" method="POST" class="p-4 md:p-5">
                                    @csrf
                                    <div class="grid gap-4 mb-4 grid-cols-1">
                                        <div class="col-span-1">
                                            <label for="task" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Task Name</label>
                                            <input type="text" name="task" id="task" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter task name" required>
                                        </div>
                                        <div class="col-span-1 flex items-center gap-2">
                                            <input type="checkbox" name="is_completed" id="is_completed" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="is_completed" class="text-sm font-medium text-gray-900 dark:text-white">Mark as Completed</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Add New Task
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel To-Do List -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-white uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center">Task</th>
                                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($todolists as $todo)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-center">{{ $todo->task }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($todo->is_completed)
                                            <span class="text-green-500">Completed</span>
                                        @else
                                            <span class="text-yellow-500">Pending</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-center">
                                        <!-- Tombol Edit -->
                                        <button data-modal-target="edit-task-{{ $todo->id }}" data-modal-toggle="edit-task-{{ $todo->id }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            ✏️ Edit
                                        </button>

                                        <!-- Modal Edit -->
                                        <div id="edit-task-{{ $todo->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative p-4 w-full max-w-md max-h-full">
                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                                    <!-- Modal header -->
                                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                            Edit Task
                                                        </h3>
                                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit-task-{{ $todo->id }}">
                                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <form action="{{ route('todo.update', $todo->id) }}" method="POST" class="p-4 md:p-5">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="grid gap-4 mb-4 grid-cols-1">
                                                            <div class="col-span-1">
                                                                <label for="task-{{ $todo->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left">Task Name</label>
                                                                <input type="text" name="task" id="task-{{ $todo->id }}" value="{{ $todo->task }}" required
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                            </div>
                                                            <div class="col-span-1 flex items-center gap-2">
                                                                <input type="checkbox" name="is_completed" id="is_completed-{{ $todo->id }}" value="1"
                                                                    {{ $todo->is_completed ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                                                <label for="is_completed-{{ $todo->id }}" class="text-sm font-medium text-gray-900 dark:text-white">Mark as Completed</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            Update Task
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
