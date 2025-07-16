@forelse($stafs as $staf)
    <tr class="bg-white border-b">
        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $staf->nama }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $staf->nip }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $staf->email }}</td>
        <td class="px-6 py-4 text-green-600 font-sm whitespace-nowrap">
            @if (!empty($staf->no_whatsapp))
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $staf->no_whatsapp) }}"
                    target="_blank" class="hover:underline">
                    {{ $staf->no_whatsapp }}
                </a>
            @else
                <span class="text-red-500">Belum diisi</span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            @if ($staf->peran === 'laboran')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-orange-800 bg-orange-200">
                    Laboran
                </span>
            @elseif ($staf->peran === 'rekam_medis')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-purple-800 bg-purple-200">
                    Rekam Medis
                </span>
            @else
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white bg-gray-600">
                    {{ ucfirst($staf->peran) }}
                </span>
            @endif
        </td>
        <td class="px-6 py-4 flex space-x-2 whitespace-nowrap">
            <button data-id="{{ $staf->id }}"
                class="edit-btn bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold transition duration-200">
                Edit
            </button>
            <button type="button"
                onclick="confirmDelete('{{ route('rekam-medis.staf.destroy', $staf->id) }}')"
                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition duration-200">
                Hapus
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data staf yang
            ditemukan.</td>
    </tr>
@endforelse