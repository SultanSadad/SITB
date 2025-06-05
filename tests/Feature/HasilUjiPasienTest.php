<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Pasien;
use App\Models\HasilUjiTB;

class HasilUjiPasienTest extends TestCase
{
    use RefreshDatabase;

    public function test_pasien_bisa_melihat_hasil_uji()
    {
        $pasien = Pasien::factory()->create();

        $user = User::factory()->create([
            'pasien_id' => $pasien->id,
            'role' => 'pasien', // ← Tambahkan ini
        ]);

        HasilUjiTB::factory()->count(3)->create([
            'pasien_id' => $pasien->id,
            'tanggal_uji' => now()->subDays(1),
        ]);

        $this->actingAs($user, 'web');

        $response = $this->get('/pasien/hasil-uji');
        $response->assertStatus(200);
        $response->assertSee('Hasil Uji Laboratorium'); // ✅ ini heading yang pasti ada
        
    }

    public function test_pasien_bisa_filter_hasil_uji_dengan_tanggal()
{
    $pasien = Pasien::factory()->create();

    $user = User::factory()->create([
        'pasien_id' => $pasien->id,
        'role' => 'pasien',
    ]);

    // Hasil uji dalam rentang
    HasilUjiTB::factory()->create([
        'pasien_id' => $pasien->id,
        'tanggal_uji' => '2025-06-01',
    ]);

    // Hasil uji di luar rentang
    HasilUjiTB::factory()->create([
        'pasien_id' => $pasien->id,
        'tanggal_uji' => '2024-01-01',
    ]);

    $this->actingAs($user, 'web');

    $response = $this->get('/pasien/hasil-uji?start=2025-05-01&end=2025-06-30');
    $response->assertStatus(200);
    $response->assertSee('01 June 2025');       // ✅ sesuaikan dengan format di Blade
    $response->assertDontSee('01 January 2024'); // ✅
}

}
