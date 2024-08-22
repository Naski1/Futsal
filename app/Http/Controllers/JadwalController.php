<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Jam;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['jadwal'] = Jadwal::with('lapangan', 'jam')->get()
            ->map(function ($jdw) {
                return [
                    'id_jadwal' => $jdw->id_jadwal,
                    'nama_lapangan' => $jdw->lapangan->nama_lapangan,
                    'nama_jam' => $jdw->jam->nama_jam,
                    'status' => $jdw->status
                ];
            });
        // $data['jadwal'] =
        //     DB::table("jadwal")
        //     ->leftJoin("lapangan", function ($join) {
        //         $join->on("lapangan.id_lapangan", "=", "jadwal.lapangan_id");
        //     })
        //     ->select(DB::raw('jadwal.lapangan_id, lapangan.nama_lapangan, COUNT(jadwal.lapangan_id) as jad'))
        //     ->groupBy("lapangan_id")
        //     ->get();
        // return $data;
        return view('admin.jadwal.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['jadwal'] = Jadwal::where('status', 'y')->get();
        $data['lapangan'] = Lapangan::where('status', 'y')->get();
        $data['jam'] = Jam::where('status', 'y')->get();
        return view('admin.jadwal.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'id_lapangan' => 'required',
            'id_jam' => 'required',
            // 'status' => 'required|in:y,t',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $data = [
            'lapangan_id' => $request->id_lapangan,
            'jam_id' => $request->id_jam,
        ];

        $findExistData = Jadwal::where([['lapangan_id', $request->id_lapangan], ['jam_id', $request->id_jam]])->first();

        if ($findExistData) {
            return redirect()->route('jadwal.index')->with('fail', 'Jadwal Sudah Ada');
        }

        $store = Jadwal::create($data);
        if ($store) {
            return redirect()->route('jadwal.index')->with('success', 'Simpan Jadwal Berhasil');
        } else {
            return redirect()->route('jadwal.index')->with('fail', 'Simpan Jadwal Gagal');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        $data['lapangan'] = Lapangan::where('status', 'y')->get();
        $data['jam'] = Jam::where('status', 'y')->get();
        $data['jadwal'] = Jadwal::findOrFail($jadwal->id_jadwal);

        return view('admin.jadwal.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $rules = [
            'id_lapangan' => 'required',
            'id_jam' => 'required',
            // 'status' => 'required|in:y,t',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $data = [
            'lapangan_id' => $request->id_lapangan,
            'jam_id' => $request->id_jam,
        ];

        $findExistData = Jadwal::where([['lapangan_id', $request->id_lapangan], ['jam_id', $request->id_jam]])->first();

        if ($findExistData) {
            return redirect()->route('jadwal.index')->with('fail', 'Jadwal Sudah Ada');
        }

        $update = $jadwal->update($data);
        if ($update) {
            return redirect()->route('jadwal.index')->with('success', 'Edit Jadwal Berhasil');
        } else {
            return redirect()->route('jadwal.index')->with('fail', 'Edit Jadwal Gagal');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        //
    }
}
