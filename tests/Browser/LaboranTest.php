<?php

namespace Tests\Browser;

use App\Models\Staf;
use App\Models\Pasien;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LaboranTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function testLaboranCanLoginAndUploadHasilUji(): void
    {
        $staf = Staf::create([
            'nama' => 'laboran',
            'email' => 'laboran@example.com',
            'password' => bcrypt('password'),
            'peran' => 'laboran',
        ]);

        $pasien = Pasien::create([
            'nik' => '1234567891234567',
            'no_erm' => 'ERM001',
            'nama' => 'Pasien Uji',
            'tanggal_lahir' => '2000-01-01',
            'no_whatsapp' => '081234567890',
            'verifikasi' => true,
        ]);

        Storage::disk('public')->put('hasil-uji/test.pdf', 'dummy content');

        $this->browse(function (Browser $browser) use ($staf, $pasien) {
            $browser->visit('/staf/login')
                ->type('email', $staf->email)
                ->type('password', 'password')
                ->press('Login')
                ->pause(1000)
                ->visit('/laboran/hasil-uji/create')
                ->select('pasien_id', $pasien->id) // pastikan name="pasien_id"
                ->type('tanggal_uji', now()->toDateString())
                ->attach('file', storage_path('app/public/hasil-uji/test.pdf'))
                ->press('Simpan')
                ->pause(2000)
                ->assertPathIs('/laboran/hasil-uji')
                ->assertSee('Berhasil'); // pastikan ada flash message sukses
        });
    }
}
