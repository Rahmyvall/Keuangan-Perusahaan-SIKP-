<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Depresiasi;
use App\Models\Aset;
use App\Models\AsetTetap;
use Carbon\Carbon;

class GenerateDepresiasiBulanan extends Command
{
    protected $signature = 'depresiasi:generate-bulanan';
    protected $description = 'Auto generate depresiasi setiap bulan';

    public function handle()
    {
        $periode = Carbon::now()->format('Y-m');

        // Cegah duplikat
        $exists = Depresiasi::where('periode_depresiasi', $periode)->exists();

        if ($exists) {
            $this->info("Depresiasi $periode sudah ada.");
            return;
        }

        $asetList = AsetTetap::all();

        foreach ($asetList as $aset) {

            $nilaiPerolehan = $aset->nilai_perolehan;
            $nilaiSisa = $aset->nilai_sisa;
            $masaManfaat = $aset->masa_manfaat * 12; // bulan

            $depresiasiBulanan =
                ($nilaiPerolehan - $nilaiSisa) / max($masaManfaat, 1);

            Depresiasi::create([
                'id_aset' => $aset->id_aset,
                'periode_depresiasi' => $periode,
                'nilai_perolehan' => $nilaiPerolehan,
                'nilai_sisa' => $nilaiSisa,
                'masa_manfaat' => $aset->masa_manfaat,
                'nilai_depresiasi' => $depresiasiBulanan,
                'akumulasi_depresiasi' => 0, // nanti bisa dihitung lagi
                'nilai_buku' => $nilaiPerolehan - $depresiasiBulanan,
            ]);
        }

        $this->info("Depresiasi bulan $periode berhasil digenerate.");
    }
}