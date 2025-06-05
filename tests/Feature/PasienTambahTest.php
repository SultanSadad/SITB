<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Staf;
use App\Models\Pasien;

class PasienTambahTest extends TestCase
{
    use RefreshDatabase;

    public function test_tambah_pasien_berhasil_dengan_data_valid()
    {
        // Setup login user (staf)
        $staf = Staf::factory()->create();
        $user = User::factory()->create([
            'role' => 'staf',
            'staf_id' => $staf->id,
        ]);

        $this->actingAs($user);

        // Kirim request POST ke route store
        $response = $this->post('/pasiens', [
            'no_erm' => 'ERM123456',
            'nama_pasien' => 'Budi Prasetyo',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '2000-01-01',
            'no_whatsapp' => '081234567890',
        ]);

        $response->assertRedirect(route('pasiens.index'));
        $this->assertDatabaseHas('pasiens', [
            'no_erm' => 'ERM123456',
            'nama' => 'Budi Prasetyo',
        ]);

        $this->assertDatabaseHas('users', [
            'role' => 'pasien',
            'name' => 'Budi Prasetyo',
        ]);
    }
    public function test_tambah_pasien_gagal_jika_nama_kosong()
{
    $staf = Staf::factory()->create();
    $user = User::factory()->create([
        'role' => 'staf',
        'staf_id' => $staf->id,
    ]);
    $this->actingAs($user);

    $response = $this->post('/pasiens', [
        'no_erm' => 'ERM001',
        'nama_pasien' => '', // kosong
        'nik' => '1234567890123456',
        'tanggal_lahir' => '2000-01-01',
        'no_whatsapp' => '081234567890',
    ]);

    $response->assertSessionHasErrors(['nama_pasien']);
    $this->assertDatabaseMissing('pasiens', ['no_erm' => 'ERM001']);
}

public function test_tambah_pasien_gagal_jika_no_erm_duplicate()
{
    $staf = Staf::factory()->create();
    $user = User::factory()->create([
        'role' => 'staf',
        'staf_id' => $staf->id,
    ]);
    $this->actingAs($user);

    Pasien::factory()->create([
        'no_erm' => 'DUPLICATE01',
    ]);

    $response = $this->post('/pasiens', [
        'no_erm' => 'DUPLICATE01', // sudah ada
        'nama_pasien' => 'Ani',
        'nik' => '3213213213213210',
        'tanggal_lahir' => '1999-09-09',
        'no_whatsapp' => '081999999999',
    ]);

    $response->assertSessionHasErrors(['no_erm']);
}

public function test_tambah_pasien_gagal_jika_nik_duplicate()
{
    $staf = Staf::factory()->create();
    $user = User::factory()->create([
        'role' => 'staf',
        'staf_id' => $staf->id,
    ]);
    $this->actingAs($user);

    Pasien::factory()->create([
        'nik' => '9998887776665554',
    ]);

    $response = $this->post('/pasiens', [
        'no_erm' => 'NEWERM002',
        'nama_pasien' => 'Sinta',
        'nik' => '9998887776665554', // duplikat
        'tanggal_lahir' => '1998-08-08',
        'no_whatsapp' => '081888888888',
    ]);

    $response->assertSessionHasErrors(['nik']);
}

}
