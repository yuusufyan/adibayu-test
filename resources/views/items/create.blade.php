<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Tambah Item') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="mb-4">
            <x-input-label for="kode" :value="'Kode Item'" />
            <x-text-input id="kode" name="kode" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('kode')" class="mt-2" />
          </div>

          <div class="mb-4">
            <x-input-label for="nama" :value="'Nama Item'" />
            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
          </div>

          <div class="mb-4">
            <x-input-label for="harga" :value="'Harga'" />
            <x-text-input id="harga" name="harga" type="number" class="mt-1 block w-full" required step="0.01" />
            <x-input-error :messages="$errors->get('harga')" class="mt-2" />
          </div>

          <div class="mb-4">
            <x-input-label for="image" :value="'Gambar (opsional)'" />
            <input type="file" name="image" id="image"
              class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300" accept="image/*">
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
          </div>

          <div class="flex justify-end">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>