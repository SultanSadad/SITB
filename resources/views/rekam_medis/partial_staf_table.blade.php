@foreach ($stafs as $staf)
    <tr class="bg-white border-b">
        <td class="px-6 py-4 font-medium text-gray-900">{{ $staf->nama }}</td>
        <td class="px-6 py-4">{{ $staf->nip }}</td>
        <td class="px-6 py-4">{{ $staf->email }}</td>
        <td class="px-6 py-4 text-green-600 font-semibold">{{ $staf->no_whatsapp }}</td>
        <td class="px-6 py-4 flex space-x-2">
            <button data-modal-toggle="edit-modal"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold">Edit</button>
            <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">Hapus</button>
            </form>
        </td>
    </tr>
@endforeach
