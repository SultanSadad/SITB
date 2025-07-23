<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pasien;
use App\Models\Staf;
use App\Models\HasilUjiTB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SystemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pasien_can_login_and_view_dashboard()
    {
        $pasien = Pasien::create([
            'nik' => '1234567891234567',
            'no_erm' => 'ERM001',
            'nama' => 'Pasien Test',
            'tanggal_lahir' => '2000-01-01',
            'no_whatsapp' => '081234567890',
            'verifikasi' => true,
        ]);

        $response = $this->post('/pasien/login', [
            'nik' => $pasien->nik,
            'no_erm' => $pasien->no_erm,
        ]);

        $response->assertRedirect('/pasien/dashboard');
    }

    /** @test */
    public function laboran_can_login_and_upload_hasil_uji()
    {
        Storage::fake('public');

        $staf = Staf::create([
            'nama' => 'Laboran Uji',
            'email' => 'laboran@example.com',
            'password' => bcrypt('password123'),
            'peran' => 'laboran',
        ]);

        $this->actingAs($staf, 'staf'); // login sebagai laboran (guard: staf)

        $pasien = Pasien::factory()->create();

        $file = UploadedFile::fake()->create('hasil_uji.pdf', 500, 'application/pdf');

        $response = $this->post("/laboran/hasil-uji/{$pasien->id}", [
            'tanggal_uji' => now()->toDateString(),
            'tanggal_upload' => now()->toDateString(),
            'file' => $file,
        ]);


        $response->assertRedirect(); // sukses simpan
        Storage::disk('public')->assertExists('hasil-uji/' . $file->hashName());
    }


    /** @test */
    public function pasien_can_see_uploaded_hasil_uji()
    {
        $pasien = Pasien::create([
            'nik' => '1234567891234567',
            'no_erm' => 'ERM001',
            'nama' => 'Pasien Test',
            'tanggal_lahir' => '2000-01-01',
            'no_whatsapp' => '081234567890',
            'verifikasi' => true,
        ]);

        $hasil = HasilUjiTB::create([
            'pasien_id' => $pasien->id,
            'tanggal_uji' => now()->toDateString(),
            'file' => 'hasil-uji/test.pdf',
        ]);

        $this->post('/pasien/login', [
            'nik' => $pasien->nik,
            'no_erm' => $pasien->no_erm,        ]);

        $response = $this->get('/pasien/hasil-uji');

        $response->assertStatus(200)
            ->assertSee('test.pdf'); // Pastikan file terlihat di HTML
    }
}
