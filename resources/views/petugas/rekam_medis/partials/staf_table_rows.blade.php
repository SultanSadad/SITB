@forelse ($stafs as $staf)
  <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
    <td class="px-6 py-4 font-medium text-gray-900">{{ $staf->nama }}</td>
    <td class="px-6 py-4">{{ $staf->nip }}</td>
    <td class="px-6 py-4">{{ $staf->email }}</td>
    <td class="px-6 py-4 whitespace-nowrap">
    @if (!empty($staf->no_whatsapp))
    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $staf->no_whatsapp) }}" target="_blank"
      class="text-green-600 hover:underline">{{ $staf->no_whatsapp }}</a>
    @else
    <span class="text-gray-500">Belum diisi</span>
    @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
    @if ($staf->peran === 'laboran')
    <span class="bg-orange-200 text-orange-800 text-xs font-medium px-2.5 py-1 rounded-full">Laboran</span>
    @elseif ($staf->peran === 'rekam_medis')
    <span class="bg-purple-200 text-purple-800 text-xs font-medium px-2.5 py-1 rounded-full">Rekam Medis</span>
    @else
    <span
      class="bg-gray-200 text-gray-800 text-xs font-medium px-2.5 py-1 rounded-full">{{ ucfirst($staf->peran) }}</span>
    @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex items-center space-x-2">
      <button type="button" data-modal-target="edit-modal" data-modal-toggle="edit-modal" data-id="{{ $staf->id }}"
      data-nama="{{ $staf->nama }}" data-nip="{{ $staf->nip }}" data-email="{{ $staf->email }}"
      data-wa="{{ $staf->no_whatsapp }}" data-peran="{{ $staf->peran }}"
      class="edit-btn inline-flex items-center justify-center text-xs font-bold w-12 h-6 px-1 py-0.5 rounded bg-blue-500 hover:bg-blue-600 text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
      Edit
      </button>
      <button type="button" data-modal-target="delete-modal" data-modal-toggle="delete-modal"
      data-url="{{ route('rekam-medis.staf.destroy', $staf->id) }}"
      class="btn-delete inline-flex items-center justify-center text-xs font-bold w-12 h-6 px-1 py-0.5 rounded bg-red-600 hover:bg-red-700 text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-red-600">
      Hapus
      </button>
    </div>
    </td>
  </tr>
@empty
  <tr>
    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data staf yang ditemukan.</td>
  </tr>
@endforelse