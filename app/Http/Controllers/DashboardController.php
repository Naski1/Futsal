<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Lapangan;
use App\Models\Pemesanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // $data['lapangan'] = Lapangan::where('status', 'y')->get();
        $costumer = User::where('role', 'costumer')->get();
        $pemesananDone = Pemesanan::where('status', 'done')->get();
        $pemesananBooked = Pemesanan::where('status', 'booked')->get();
        // $tgl = '2024-04-14';
        $tgl = '';
        if ($request->has('q')) {
            $tgl = request()->q;
        } else {
            $tgl = Carbon::now()->format('Y-m-d');
        }
        $lapangan = Lapangan::where('status', 'y')->get();
        $hasil = array();
        foreach ($lapangan as $lap) {
            $hasilAwal = array();
            $hasilAwal['id_lapangan'] = $lap->id_lapangan;
            $hasilAwal['nama_lapangan'] = $lap->nama_lapangan;
            $hasilAwal['status'] = $lap->status;
            $jadwal = Jadwal::where([['status', 'y'], ['lapangan_id', $lap->id_lapangan]])
                ->select('id_jadwal', 'lapangan_id', 'jam_id', 'status')
                ->get();;
            $pemesanan = DB::table('pemesanan')
                ->select('pemesanan.id_pemesanan', 'pemesanan.user_id', 'pemesanan.tgl_pemesanan', 'detail_pemesanan.jadwal_id', 'jadwal.lapangan_id')
                ->leftJoin('detail_pemesanan', 'detail_pemesanan.pemesanan_id', '=', 'pemesanan.id_pemesanan')
                ->leftJoin('jadwal', 'jadwal.id_jadwal', '=', 'detail_pemesanan.jadwal_id')
                ->where('tgl_pemesanan', '=', $tgl)
                ->where('lapangan_id', '=', $lap->id_lapangan)
                ->get();
            $hasilAwal['jadwal'] = array();
            foreach ($jadwal as &$jad) {
                $found = false;

                // Check if schedule_id exists in array2
                foreach ($pemesanan as $item2) {
                    if (isset($jad->id_jadwal) && isset($item2->jadwal_id) && $jad->id_jadwal === $item2->jadwal_id) {
                        $jad->status = 'booked';
                        $found = true;
                        break;
                    }
                }

                // If not found in array2, set status to 'free'
                if (!$found) {
                    $jad->status = 'free';
                }

                $hasilDua = array();
                $hasilDua['id_jadwal'] = $jad->id_jadwal;
                $hasilDua['lapangan_id'] = $jad->lapangan_id;
                $hasilDua['jam_id'] = $jad->jam_id;
                $hasilDua['nama_jam'] = $jad->jam->nama_jam;
                $hasilDua['durasi'] = $jad->jam->durasi;
                $hasilDua['status'] = $jad->status;
                array_push($hasilAwal['jadwal'], $hasilDua);
            }

            // unset the reference for foreach
            unset($item);

            array_push($hasil, $hasilAwal);
        }
        return view('dashboard', compact('hasil', 'tgl', 'lapangan', 'costumer', 'pemesananDone', 'pemesananBooked'));
        // $pemesanan = Pemesanan::where([['tgl_pemesanan', date('Y-m-d')], ['status', 'booked']])
        //     ->with(['pemesananDetail' => function ($d) {
        //         $d->select('id_detail_pemesanan', 'pemesanan_id', 'jadwal_id')
        //             ->with(['jadwal' => function ($j) {
        //                 $j->select('id_jadwal', 'jam_id', 'lapangan_id')
        //                     ->with(['jam' => function ($jm) {
        //                         $jm->select('id_jam', 'jam_awal', 'jam_akhir');
        //                     }])
        //                     ->with(['lapangan' => function ($l) {
        //                         $l->select('id_lapangan', 'nama_lapangan');
        //                     }]);
        //             }]);
        //     }])
        //     ->get()
        //     ->map(function ($m) {
        //         return [
        //             'id' => $m->id_pemesanan,
        //             'costumer' => $m->user->name,
        //             'lapangan' => $m->pemesananDetail[0]->jadwal->lapangan->nama_lapangan,
        //             'tgl_pesan' => $m->tgl_pemesanan,
        //             'status' => 'selesai',
        //             'detail' => $m->pemesananDetail->map(function ($details) {
        //                 return [
        //                     'id_detail_pemesanan' => $details->id_detail_pemesanan,
        //                     'jam_awal' => $details->jadwal->jam->jam_awal,
        //                     'jam_akhir' => $details->jadwal->jam->jam_akhir
        //                 ];
        //             }),
        //         ];
        //     });
        // $pemesanan = DB::table("detail_pemesanan")
        //     ->leftJoin("pemesanan", function ($join) {
        //         $join->on("pemesanan.id_pemesanan", "=", "detail_pemesanan.pemesanan_id");
        //     })
        //     ->leftJoin("jadwal", function ($join) {
        //         $join->on("jadwal.id_jadwal", "=", "detail_pemesanan.jadwal_id");
        //     })
        //     ->leftJoin("lapangan", function ($join) {
        //         $join->on("lapangan.id_lapangan", "=", "jadwal.lapangan_id");
        //     })
        //     ->leftJoin("jam", function ($join) {
        //         $join->on(
        //             "jam.id_jam",
        //             "=",
        //             "jadwal.jam_id"
        //         );
        //     })
        //     ->leftJoin("users", function ($join) {
        //         $join->on("users.id_user", "=", "pemesanan.user_id");
        //     })
        //     ->select("detail_pemesanan.id_detail_pemesanan", "pemesanan.id_pemesanan", "pemesanan.tgl_pemesanan", "pemesanan.status", "users.name", "lapangan.nama_lapangan", "jadwal.id_jadwal", "jam.id_jam", "jam.jam_awal", "jam.jam_akhir")
        //     ->where("pemesanan.tgl_pemesanan", "=", date('Y-m-d'))
        //     ->where("pemesanan.status", "=", 'booked')
        //     ->get();
        // return $pemesanan;
    }
}
