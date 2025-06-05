<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Staf;
use App\Models\Pasien;

class HasilUjiLaboranTest extends TestCase
{
    use RefreshDatabase;

    public function test_upload_hasil_uji_berhasil()
{
    Storage::fake('public');

    // Simulasikan login staf
    $staf = \App\Models\Staf::factory()->create();
    $this->actingAs($staf, 'web'); // Sesuaikan guard jika perlu

    // Buat pasien dummy
    $pasien = \App\Models\Pasien::factory()->create();

    // Buat file palsu hanya sekali
    $file = \Illuminate\Http\UploadedFile::fake()->create('hasil.pdf', 500, 'application/pdf');

    $response = $this->post("/laboran/hasil-uji/{$pasien->id}", [
        'tanggal_uji' => now()->toDateString(),
        'tanggal_upload' => now()->toDateString(),
        'file' => $file,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Hasil uji berhasil ditambahkan');

    // Pastikan file disimpan di folder 'hasil-uji/'
    Storage::disk('public')->assertExists("hasil-uji/{$file->hashName()}");
}

public function test_hapus_hasil_uji_berhasil()
{
    Storage::fake('public');

    $staf = \App\Models\Staf::factory()->create();
    $this->actingAs($staf, 'web');

    $pasien = \App\Models\Pasien::factory()->create();

    $file = UploadedFile::fake()->create('hapus.pdf', 500, 'application/pdf');
    $path = $file->store('hasil-uji', 'public');

    $hasil = \App\Models\HasilUjiTB::create([
        'pasien_id' => $pasien->id,
        'staf_id' => $staf->id,
        'tanggal_uji' => now()->toDateString(),
        'tanggal_upload' => now()->toDateString(),
        'file' => $path,
    ]);

    $response = $this->delete("/laboran/hasil-uji/{$hasil->id}");
    $response->assertRedirect();
    $response->assertSessionHas('success', 'Hasil uji berhasil dihapus');

    // Pastikan file juga terhapus dari storage
    Storage::disk('public')->assertMissing($path);
    $this->assertDatabaseMissing('hasil_uji_tb', ['id' => $hasil->id]);

}


}
