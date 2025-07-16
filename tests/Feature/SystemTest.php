<?php

namespace Tests\Feature;

use App\Models\Pasien;
use App\Models\Staf;
use App\Models\HasilUjiTB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SystemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function laboran_can_login_and_upload_test_result()
    {
        $staf = Staf::factory()->create([
            'email' => 'laboran@example.com',
            'password' => bcrypt('password123'),
            'peran' => 'laboran',
        ]);

        // Login sebagai staf
        $response = $this->post('/staf/login', [
            'email' => 'laboran@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/laboran/dashboard');

        // Simulasikan file upload hasil uji
        $pasien = Pasien::factory()->create();
        Storage::fake('public');

        $file = UploadedFile::fake()->create('hasil.pdf', 500, 'application/pdf');

        $response = $this->actingAs($staf, 'staf')->post("/laboran/hasil-uji/{$pasien->id}", [
            'tanggal_uji' => now()->toDateString(),
            'tanggal_upload' => now()->toDateString(),
            'file' => $file,
        ]);

        $response->assertRedirect(); // bisa lebih spesifik ke route hasil-uji.index
        Storage::disk('public')->assertExists("hasil-uji/{$file->hashName()}");
    }


    /** @test */
    public function test_pasien_can_login_and_see_their_test_results()
    {
        $pasien = Pasien::factory()->create([
            'nik' => '1234567890123456',
            'no_erm' => 'ERM00123',
            'verifikasi' => true,
        ]);

        $this->actingAs($pasien, 'pasien');

        Storage::fake('public');

        $file = UploadedFile::fake()->create('hasil.pdf', 500, 'application/pdf');
        Storage::disk('public')->putFileAs('', $file, $file->hashName());

        $hasil = \App\Models\HasilUjiTB::factory()->create([
            'pasien_id' => $pasien->id,
            'file' => $file->hashName(),
        ]);

        $this->get('/pasien/hasil-uji')
            ->assertStatus(200)
            ->assertSee($hasil->id);

        $this->get("/pasien/hasil-uji/{$hasil->id}")
            ->assertStatus(200);
    }


}
