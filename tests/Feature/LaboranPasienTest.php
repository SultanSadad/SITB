<?php

namespace Tests\Feature;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaboranPasienTest extends TestCase
{
    use RefreshDatabase;

    protected function loginAsLaboran()
    {
        $user = User::factory()->create([
            'role' => 'staf',
        ]);

        $this->actingAs($user);
    }

    public function test_tambah_pasien_valid()
    {
        $this->loginAsLaboran();

        $response = $this->post(route('laboran.data-pasien.store'), [
            'nama' => 'Pasien Uji',
            'nik' => '3219876543210001',
            'no_erm' => 'ERM2001',
            'no_whatsapp' => '081234567891',
            'tanggal_lahir' => '2001-01-01',
        ]);

        $response->assertRedirect(route('laboran.data-pasien'));
        $this->assertDatabaseHas('pasiens', [
            'nama' => 'Pasien Uji',
            'no_erm' => 'ERM2001',
        ]);
    }
    public function test_edit_pasien_valid()
    {
        $this->loginAsLaboran();

        $pasien = Pasien::factory()->create([
            'nama' => 'Awal Nama',
            'nik' => '1234567890123456',
            'no_erm' => 'ERM0001',
            'no_whatsapp' => '081234567890',
        ]);

        $response = $this->put(route('laboran.data-pasien.update', $pasien), [
            'nama' => 'Nama Baru',
            'nik' => '1234567890123456',
            'no_erm' => 'ERM0001',
            'no_whatsapp' => '081234567890',
            'tanggal_lahir' => '2000-12-31',
        ]);

        $response->assertRedirect(route('laboran.data-pasien'));
        $this->assertDatabaseHas('pasiens', [
            'id' => $pasien->id,
            'nama' => 'Nama Baru',
        ]);
    }
    public function test_hapus_pasien_berhasil()
{
    $this->loginAsLaboran();

    $pasien = Pasien::factory()->create([
        'nama' => 'Pasien Hapus',
        'no_erm' => 'ERM9999',
    ]);

    $response = $this->delete(route('laboran.data-pasien.destroy', $pasien));

    $response->assertRedirect(route('laboran.data-pasien'));
    $this->assertDatabaseMissing('pasiens', [
        'id' => $pasien->id,
        'nama' => 'Pasien Hapus',
    ]);
}



}
