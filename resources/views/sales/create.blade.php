<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('sales.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-200">Item Penjualan</label>

                        <table class="w-full text-sm text-left mt-2" id="items-table">
                            <thead>
                                <tr class="text-gray-300 uppercase">
                                    <th class="px-3 py-2">Item</th>
                                    <th class="px-3 py-2">Qty</th>
                                    <th class="px-3 py-2">Harga Satuan</th>
                                    <th class="px-3 py-2">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="item-rows">
                                <tr>
                                    <td class="px-3 py-2">
                                        <select name="items[0][item_id]" class="form-select w-full item-select"
                                            required>
                                            <option value="">Pilih Item</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">
                                                    {{ $item->nama }}</option>
                                            @endforeach
                                        </select>

                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="number" name="items[0][qty]" class="form-input w-full qty" min="1"
                                            required>
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="number" name="items[0][harga_satuan]"
                                            class="form-input w-full harga" min="0" required>
                                    </td>
                                    <td class="px-3 py-2 text-gray-300 total">0</td>
                                    <td class="px-3 py-2 text-center">
                                        <button type="button" class="text-red-500 remove-row">✕</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="button" class="mt-3 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
                            id="add-row">
                            + Tambah Item
                        </button>
                    </div>

                    <div class="mt-4 text-right">
                        <strong class="text-gray-200">Grand Total: </strong>
                        <span id="grand-total" class="text-white">0</span>
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let rowIndex = 1;

            function updateTotal() {
                let grandTotal = 0;
                document.querySelectorAll('#item-rows tr').forEach((row) => {
                    const qty = parseFloat(row.querySelector('.qty')?.value || 0);
                    const harga = parseFloat(row.querySelector('.harga')?.value || 0);
                    const total = qty * harga;
                    row.querySelector('.total').innerText = total.toLocaleString();
                    grandTotal += total;
                });
                document.getElementById('grand-total').innerText = grandTotal.toLocaleString();
            }

            document.getElementById('add-row').addEventListener('click', () => {
                const tbody = document.getElementById('item-rows');
                const newRow = document.createElement('tr');

                newRow.innerHTML = `
                <td class="px-3 py-2">
                  <select name="items[${rowIndex}][item_id]" class="form-select w-full" required>
                    <option value="">Pilih Item</option>
                    @foreach ($items as $item)
                          <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                  </select>
                </td>
                <td class="px-3 py-2">
                  <input type="number" name="items[${rowIndex}][qty]" class="form-input w-full qty" min="1" required>
                </td>
                <td class="px-3 py-2">
                  <input type="number" name="items[${rowIndex}][harga_satuan]" class="form-input w-full harga" min="0" required>
                </td>
                <td class="px-3 py-2 text-gray-300 total">0</td>
                <td class="px-3 py-2 text-center">
                  <button type="button" class="text-red-500 remove-row">✕</button>
                </td>
              `;

                tbody.appendChild(newRow);
                rowIndex++;
            });

            document.addEventListener('input', (e) => {
                if (e.target.classList.contains('qty') || e.target.classList.contains('harga')) {
                    updateTotal();
                }
            });

            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                    updateTotal();
                }
            });

            document.addEventListener('change', (e) => {
                if (e.target.classList.contains('item-select')) {
                    const harga = e.target.selectedOptions[0].getAttribute('data-harga');
                    const row = e.target.closest('tr');
                    row.querySelector('.harga').value = harga;
                    updateTotal();
                }
            });
        </script>
    @endpush
</x-app-layout>