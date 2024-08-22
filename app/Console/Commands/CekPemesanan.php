<?php

namespace App\Console\Commands;

use App\Models\Pemesanan;
use App\Models\User;
use App\Notifications\PemesananNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CekPemesanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:pemesanan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek Pemesanan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pemesanan = DB::table("detail_pemesanan")
            ->leftJoin("pemesanan", function ($join) {
                $join->on("pemesanan.id_pemesanan", "=", "detail_pemesanan.pemesanan_id");
            })
            ->leftJoin("jadwal", function ($join) {
                $join->on("jadwal.id_jadwal", "=", "detail_pemesanan.jadwal_id");
            })
            ->leftJoin("lapangan", function ($join) {
                $join->on("lapangan.id_lapangan", "=", "jadwal.lapangan_id");
            })
            ->leftJoin("jam", function ($join) {
                $join->on(
                    "jam.id_jam",
                    "=",
                    "jadwal.jam_id"
                );
            })
            ->leftJoin("users", function ($join) {
                $join->on("users.id_user", "=", "pemesanan.user_id");
            })
            ->select("detail_pemesanan.id_detail_pemesanan", "pemesanan.id_pemesanan", "pemesanan.tgl_pemesanan", "pemesanan.status", "users.name", "lapangan.nama_lapangan", "jadwal.id_jadwal", "jam.id_jam", "jam.jam_awal", "jam.jam_akhir")
            ->where("pemesanan.tgl_pemesanan", "=", date('Y-m-d'))
            ->where("pemesanan.status", "=", 'booked')
            ->get();
        // return $pemesanan;
        // return $pemesanan;
        // foreach ($pemesanan as $pm) {
        //     $pemesananNotifikasi = [
        //         'id' => $pm['id'],
        //         'costumer' => $pm['costumer'],
        //         'lapangan' => $pm['lapangan'],
        //         'tgl_pesan' => $pm['tgl_pesan'],
        //         'status' => 'selesai'
        //     ];
        //     foreach ($pm['detail'] as $pmd) {
        //         if ($pmd['jam_akhir'] <= date('H:i:s')) {
        //             DB::beginTransaction();
        //             try {
        //                 $pm->update(['status' => 'done']);
        //                 Log::info('done success' . date('Y-m-d H:i:s'));
        //                 User::find(1)->notify(new PemesananNotification($pemesananNotifikasi));
        //                 DB::commit();
        //             } catch (\Exception $ex) {
        //                 //throw $th;
        //                 DB::rollBack();
        //                 Log::info('done error ' . date('Y-m-d H:i:s') . ' ' . $ex);
        //             }
        //         }
        //     }
        // }
        foreach ($pemesanan as $pm) {
            $pemesananNotifikasi = [
                'id' => $pm->id_pemesanan,
                'costumer' => $pm->name,
                'lapangan' => $pm->nama_lapangan,
                'tgl_pesan' => $pm->tgl_pemesanan,
                'status' => 'selesai'
            ];
            if ($pm->jam_akhir <= date('H:i:s')) {
                DB::beginTransaction(); // active to on going
                try {
                    Pemesanan::where('id_pemesanan', $pm->id_pemesanan)->update(['status' => 'done']);
                    Log::info('done success ' . date('Y-m-d H:i:s'));
                    User::find(1)->notify(new PemesananNotification($pemesananNotifikasi));
                    DB::commit();
                } catch (\Exception $th) {
                    Log::info('done error ' . date('Y-m-d H:i:s') . ' ' . $th);
                    DB::rollBack();
                }
            }
        }
        Log::info("Cron job Berhasil di jalankan " . date('Y-m-d H:i:s'));
    }
}
