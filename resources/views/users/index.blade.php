<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('User Management') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <div class="overflow-x-auto">
            <table id="users-table"
              class="table w-full border border-gray-300 dark:border-gray-700 text-left text-sm sm:text-base">
              <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                <tr>
                  <th class="border px-6 py-3">Name</th>
                  <th class="border px-6 py-3">Email</th>
                  <th class="border px-6 py-3">Role</th>
                  <th class="border px-6 py-3">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
          <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="border px-6 py-4">{{ $user->name }}</td>
            <td class="border px-6 py-4">{{ $user->email }}</td>
            <td class="border px-6 py-4 capitalize">{{ $user->getRoleNames()->first() ?? '-' }}</td>
            <td class="border px-6 py-4">
            <div class="flex space-x-2">
              <form action="{{ route('users.edit', $user->id) }}" method="GET">
              <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                Edit
              </button>
              </form>

              <form action="{{ route('users.destroy', $user->id) }}" method="POST"
              onsubmit="return confirm('Are you sure?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                Delete
              </button>
              </form>
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