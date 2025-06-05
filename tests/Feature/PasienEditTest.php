<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Staf;

class PasienEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_pasien_berhasil()
    {
        $staf = Staf::factory()->create();
        $user = User::factory()->create([
            'role' => 'staf',
            'staf_id' => $staf->id,
        ]);
        $this->actingAs($user);

        $pasien = Pasien::factory()->create([
            'nama' => 'Sari Lama',
            'nik' => '1234567890123456',
            'no_whatsapp' => '081234567890',
        ]);

        User::factory()->create([
            'name' => 'Sari Lama',
            'role' => 'pasien',
            'pasien_id' => $pasien->id,
        ]);

        $response = $this->put("/pasiens/{$pasien->id}", [
            'no_erm' => $pasien->no_erm,
            'nama' => 'Sari Baru',
            'nik' => '1234567890123456',
            'tanggal_lahir' => $pasien->tanggal_lahir,
            'no_whatsapp' => '081234567890',
        ]);

        $response->assertRedirect(route('pasiens.index'));

        $this->assertDatabaseHas('pasiens', ['nama' => 'Sari Baru']);
        $this->assertDatabaseHas('users', ['name' => 'Sari Baru']);
    }

    public function test_edit_pasien_gagal_jika_nik_duplicate()
    {
        $staf = Staf::factory()->create();
        $user = User::factory()->create([
            'role' => 'staf',
            'staf_id' => $staf->id,
        ]);
        $this->actingAs($user);

        $pasien1 = Pasien::factory()->create(['nik' => '9991111111111111']);
        $pasien2 = Pasien::factory()->create();

        $response = $this->put("/pasiens/{$pasien2->id}", [
            'no_erm' => $pasien2->no_erm,
            'nama' => $pasien2->nama,
            'nik' => '9991111111111111', // duplikat
            'tanggal_lahir' => $pasien2->tanggal_lahir,
            'no_whatsapp' => $pasien2->no_whatsapp,
        ]);

        $response->assertSessionHasErrors(['nik']);
    }

    public function test_edit_pasien_gagal_jika_no_whatsapp_duplicate()
    {
        $staf = Staf::factory()->create();
        $user = User::factory()->create([
            'role' => 'staf',
            'staf_id' => $staf->id,
        ]);
        $this->actingAs($user);

        $pasien1 = Pasien::factory()->create(['no_whatsapp' => '081999999999']);
        $pasien2 = Pasien::factory()->create();

        $response = $this->put("/pasiens/{$pasien2->id}", [
            'no_erm' => $pasien2->no_erm,
            'nama' => $pasien2->nama,
            'nik' => $pasien2->nik,
            'tanggal_lahir' => $pasien2->tanggal_lahir,
            'no_whatsapp' => '081999999999', // duplikat
        ]);

        $response->assertSessionHasErrors(['no_whatsapp']);
    }
}
