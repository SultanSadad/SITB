<div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-6">
  <div class="flex justify-between items-center mb-3">
    <h3 class="font-semibold text-base text-gray-800">Hasil Uji Hari Ini</h3>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-600">
      <thead class="text-xs text-gray-500 uppercase bg-gray-50 rounded-t-lg">
        <tr>
          <th class="px-4 py-2.5 font-medium">No</th>
          <th class="px-4 py-2.5 font-medium">Nama Pasien</th>
          <th class="px-4 py-2.5 font-medium">NIK</th>
          <th class="px-4 py-2.5 font-medium">Jam Upload</th>
          <th class="px-4 py-2.5 font-medium">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse ($todayResults as $result)
      <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-700">{{ $loop->iteration }}</td>
        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-700">{{ $result->pasien->nama }}</td>
        <td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $result->pasien->nik }}</td>
        <td class="px-4 py-3 whitespace-nowrap text-gray-600">
        {{ \Carbon\Carbon::parse($result->created_at)->setTimezone('Asia/Jakarta')->format('H:i') }} WIB
        </td>
        <td class="px-4 py-3 whitespace-nowrap">
        <a href="{{ asset('storage/' . $result->file) }}" target="_blank"
          class="inline-flex items-center justify-center px-2.5 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700">
          Lihat
        </a>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
        Tidak ada hasil uji yang diupload hari ini
        </td>
      </tr>
    @endforelse
      </tbody>
    </table>
  </div>

  @if ($todayResults->hasPages())
    <div class="flex justify-center mt-6">
    {{ $todayResults->links() }}
    </div>
  @endif
</div>