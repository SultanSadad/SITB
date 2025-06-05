<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Staf;

class PasienHapusTest extends TestCase
{
    use RefreshDatabase;

    public function test_hapus_pasien_berhasil_dan_user_terkait_ikut_terhapus()
    {
        $staf = Staf::factory()->create();
        $user = User::factory()->create([
            'role' => 'staf',
            'staf_id' => $staf->id,
        ]);
        $this->actingAs($user);

        $pasien = Pasien::factory()->create([
            'nama' => 'Agus Wijaya',
        ]);

        $userPasien = User::factory()->create([
            'role' => 'pasien',
            'pasien_id' => $pasien->id,
            'name' => 'Agus Wijaya',
        ]);

        $response = $this->delete("/pasiens/{$pasien->id}");

        $response->assertRedirect(route('pasiens.index'));

        $this->assertDatabaseMissing('pasiens', ['id' => $pasien->id]);
        $this->assertDatabaseMissing('users', ['id' => $userPasien->id]);
    }
}
