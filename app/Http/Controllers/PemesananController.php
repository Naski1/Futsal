<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Lapangan;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\User;
use App\Notifications\PemesananNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

class PemesananController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            Auth::user()->unreadNotifications->markAsRead();
        }
        $data['pemesanan'] = Pemesanan::select(
            'id_pemesanan',
            'user_id',
            'kode_pemesanan',
            'tgl_pemesanan',
            'total_durasi',
            'total_biaya',
            'status'
        )
            ->when(Auth::user()->role == 'costumer', function ($q) {
                $q->where('user_id', Auth::user()->id_user);
            })
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($p) {
                return [
                    'id_pemesanan' => $p->id_pemesanan,
                    'kode_pemesanan' => $p->kode_pemesanan,
                    'tgl_pemesanan' => $p->tgl_pemesanan,
                    'nama_pemesan' => $p->user->name,
                    'total_durasi' => $p->total_durasi,
                    'total_biaya' => $p->total_biaya,
                    'status' => $p->status
                ];
            });
        // return $data;

        return view('admin.pemesanan.index', $data);
    }


    public function search(Request $request)
    {
        $data['costumer'] = User::select('id_user', 'name')->where('role', 'costumer')->get();
        $data['lapangan'] = Lapangan::where('status', 'y')->get();
        return view('admin.pemesanan.search', $data);
    }

    public function create(Request $request)
    {
        if (Auth::user()->role == 'costumer') {
            $rules = [
                'tgl' => 'required',
                'lpng' => 'required',
            ];
        } else {
            $rules = [
                'cs' => 'required',
                'tgl' => 'required',
                'lpng' => 'required',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $cs = $request->query('cs');
        $tgl = $request->query('tgl');
        $lpng = $request->query('lpng');

        $data['costumer'] = User::select('id_user', 'name')->where('role', 'costumer')->get();
        $data['lapangan'] = Lapangan::where('status', 'y')->get();
        $jadwal = Jadwal::where([['status', 'y'], ['lapangan_id', $lpng]])
            ->select('id_jadwal', 'lapangan_id', 'jam_id')
            ->get();
        $pemesanan = DB::table('pemesanan')
            ->select('pemesanan.id_pemesanan', 'pemesanan.user_id', 'pemesanan.tgl_pemesanan', 'detail_pemesanan.jadwal_id', 'jadwal.lapangan_id')
            ->leftJoin('detail_pemesanan', 'detail_pemesanan.pemesanan_id', '=', 'pemesanan.id_pemesanan')
            ->leftJoin('jadwal', 'jadwal.id_jadwal', '=', 'detail_pemesanan.jadwal_id')
            ->where('tgl_pemesanan', '=', $tgl)
            ->where('lapangan_id', '=', $lpng)
            ->get();
        // $jadwal = $jadwal->toArray();
        // $pemesanan = $pemesanan->toArray();

        // $combinedArray = array_merge($jadwal, $pemesanan);

        // // Menambahkan kunci 'status' berdasarkan kondisi
        // foreach ($combinedArray as &$item) {
        //     // if (isset($item->id_jadwal) && isset($item->jadwal_id)) {
        //     // $item['status'] = 'free';
        //     // }
        //     // return $item;
        // }

        // // Filter hanya hasil dari array pertama
        // $resultArray = array_filter($combinedArray, function ($item) use ($jadwal) {
        //     return in_array($item, $jadwal);
        // });


        // return $pemesanan;
        // Loop through each item in array1
        foreach ($jadwal as &$item) {
            $found = false;

            // Check if schedule_id exists in array2
            foreach ($pemesanan as $item2) {
                if (isset($item->id_jadwal) && isset($item2->jadwal_id) && $item->id_jadwal === $item2->jadwal_id) {
                    $item->status = 'booked';
                    $found = true;
                    break;
                }
            }

            // If not found in array2, set status to 'free'
            if (!$found) {
                $item->status = 'free';
            }
        }

        // unset the reference for foreach
        unset($item);

        $data['jadwal'] = $jadwal;

        // return $data;
        return view('admin.pemesanan.create', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'jam' => 'required|min:1',
            'jam.*' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        // dd($request->all());
        $costumer = User::select('name')->where('id_user', $request->cs)->first();
        $lapangan = Lapangan::select('nama_lapangan')->where('id_lapangan', $request->lap)->first();

        DB::beginTransaction();
        try {
            $pemesanan = [
                'user_id' => $request->cs,
                'kode_pemesanan' => Str::upper(Str::random(10)),
                'tgl_pemesanan' => $request->tgl_pemesanan,
                'status' => 'booked'
            ];

            $createPemesanan = Pemesanan::create($pemesanan);
            if ($createPemesanan) {
                $totalBiaya = 0;
                $totalDurasi = 0;
                foreach ($request->jam as $key => $value) {
                    if ($request->jam[$key] != null) {
                        $detailPemesanan = [
                            'pemesanan_id' => $createPemesanan->id_pemesanan,
                            'jadwal_id' => $request->jam[$key],
                            'durasi' => $request->durasi[$key],
                            'biaya' => $request->biaya[$key],
                            'status' => 'done'
                        ];
                        $totalBiaya +=  $request->biaya[$key];
                        $totalDurasi +=  $request->durasi[$key];
                        $createDetailPemesanan = PemesananDetail::create($detailPemesanan);
                    }
                }
                $updatePemesanan = Pemesanan::where('id_pemesanan', $createPemesanan->id_pemesanan)->update(['total_durasi' => $totalDurasi, 'total_biaya' => $totalBiaya]);
            } else {
                return redirect()->route('pemesanan.index')->with('fail', 'Pemesanan Gagal Dibuat');
            }

            $pemesananNotifikasi = [
                'id' => $createPemesanan->id_pemesanan,
                'costumer' => $costumer->name,
                'lapangan' => $lapangan->nama_lapangan,
                'tgl_pesan' => $request->tgl_pemesanan,
                'status' => 'baru'
            ];
            User::find(1)->notify(new PemesananNotification($pemesananNotifikasi));
            DB::commit();
            return redirect()->route('pemesanan.index')->with('success', 'Pemesanan Behasil Dibuat');
        } catch (\Exception $ex) {
            //throw $th;
            DB::rollBack();
            return $pemesananNotifikasi;
            return $ex;
            return redirect()->route('pemesanan.index')->with('fail', 'Pemesanan Gagal Dibuat');
        }
    }

    public function detail($id)
    {
        if (Auth::user()->role == 'admin') {
            Auth::user()->unreadNotifications->markAsRead();
        }

        $data['pemesanan'] = Pemesanan::select(
            'id_pemesanan',
            'user_id',
            'kode_pemesanan',
            'tgl_pemesanan',
            'total_durasi',
            'total_biaya',
            'status'
        )->with('user', function ($qu) {
            $qu->select('id_user', 'name', 'email', 'no_tlpn', 'alamat');
        })
            ->where('id_pemesanan', $id)->first();
        $data['detail_pemesanan'] = PemesananDetail::select(
            'id_detail_pemesanan',
            'pemesanan_id',
            'jadwal_id',
            'durasi',
            'biaya',
            'status',
        )->where('pemesanan_id', $data['pemesanan']->id_pemesanan)->get()
            ->map(function ($dp) {
                return [
                    'nama_lapangan' => $dp->jadwal->lapangan->nama_lapangan,
                    'nama_jam' => $dp->jadwal->jam->nama_jam,
                    'durasi' => $dp->jadwal->jam->durasi,
                    'biaya' => $dp->biaya
                ];
            });
        // return $data;

        return view('admin.pemesanan.detail', $data);
    }

    public function pemesananByTanggal(Request $request)
    {
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

        // return $hasil;
        return view('admin.pemesanan.harian', compact('hasil', 'tgl'));
    }
}
