<?php

namespace Tests\Browser;

use App\Models\Pasien;
use App\Models\HasilUjiTB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PasienTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function test_pasien_can_view_uploaded_hasil_uji()
    {
        $pasien = Pasien::create([
            'nik' => '1234567891234567',
            'no_erm' => 'ERM001',
            'nama' => 'Pasien Uji',
            'tanggal_lahir' => '2000-01-01',
            'no_whatsapp' => '081234567890',
            'verifikasi' => true,
        ]);

        HasilUjiTB::create([
            'pasien_id' => $pasien->id,
            'nama_pemeriksaan' => 'Tes TB',
            'hasil' => 'Negatif',
            'tanggal_uji' => now()->toDateString(),
            'file' => 'hasil-uji/test.pdf',
        ]);

        Storage::disk('public')->put('hasil-uji/test.pdf', 'dummy content');

        $this->browse(function (Browser $browser) use ($pasien) {
            $browser->visit('/pasien/login')
                ->type('nik', $pasien->nik)
                ->type('no_erm', $pasien->no_erm)
                ->press('Login')
                ->pause(1000)
                ->visit('/pasien/hasil-uji')
                ->pause(2000)
                ->screenshot('hasil-uji-debug') // Cek ini jika masih gagal
                ->assertSee('Unduh PDF Hasil');
        });
    }
}
