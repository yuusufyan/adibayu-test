<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Manajemen Item') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        @if (session('success'))
        <div class="mb-4 text-green-600 dark:text-green-400 font-semibold">
        {{ session('success') }}
        </div>
    @endif

        <div class="flex justify-end mb-4">
          <a href="{{ route('items.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow text-sm font-medium">
            + Tambah Item
          </a>
        </div>

        <div class="overflow-x-auto">
          <table id="items-table"
            class="table-auto w-full border border-gray-300 dark:border-gray-700 text-left text-sm sm:text-base">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase tracking-wider">
              <tr>
                <th class="border px-4 py-2">Kode</th>
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Harga</th>
                <th class="border px-4 py-2">Gambar</th>
                <th class="border px-4 py-2">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($items as $item)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
              <td class="border px-4 py-2">{{ $item->kode }}</td>
              <td class="border px-4 py-2">{{ $item->nama }}</td>
              <td class="border px-4 py-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
              <td class="border px-4 py-2">
              @if ($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" class="w-12 h-12 object-cover rounded" alt="img">
          @else
            <span class="text-gray-400 italic">No image</span>
          @endif
              </td>
              <td class="border px-4 py-2 space-x-2">
              <a href="{{ route('items.edit', $item->id) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold">
                Edit
              </a>
              <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline-block"
                onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">
                Hapus
                </button>
              </form>
              </td>
            </tr>
        @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- DataTables --}}
  @push('scripts')
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
    $('#items-table').DataTable();
    });
  </script>
  @endpush

  @push('styles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  @endpush
</x-app-layout>
