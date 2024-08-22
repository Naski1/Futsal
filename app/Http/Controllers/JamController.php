<?php

namespace App\Http\Controllers;

use App\Models\Jam;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class JamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['jam'] = Jam::select('id_jam', 'nama_jam', 'durasi', 'biaya', 'status')->get();
        return view('admin.jam.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jam.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_jam' => 'required|min:5|max:100',
            'jam_awal' => 'required|date_format:H:i|before:jam_akhir',
            'jam_akhir' => 'required|date_format:H:i|after:jam_awal',
            // 'durasi' => 'required|numeric|digits_between:1,2|max:3',
            'biaya' => 'required|numeric|digits_between:4,6',
            'status' => 'required|in:y,t',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $jamAwal = Carbon::parse($request->jam_awal);
        $jamAkhir = Carbon::parse($request->jam_akhir);
        $data = [
            'nama_jam' => $request->nama_jam,
            'jam_awal' => $request->jam_awal,
            'jam_akhir' => $request->jam_akhir,
            'durasi' => $jamAkhir->diffInHours($jamAwal),
            'biaya' => $request->biaya,
            'status' => $request->status
        ];

        $store = Jam::create($data);
        if ($store) {
            return redirect()->route('jam.index')->with('success', 'Simpan Jam Berhasil');
        } else {
            return redirect()->route('jam.index')->with('fail', 'Simpan Jam Gagal');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jam $jam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jam $jam)
    {
        $find = Jam::findOrFail($jam->id_jam);

        return view('admin.jam.edit', [
            'jam' => $find
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jam $jam)
    {
        $rules = [
            'nama_jam' => 'required|min:5|max:100',
            'jam_awal' => 'required|date_format:H:i|before:jam_akhir',
            'jam_akhir' => 'required|date_format:H:i|after:jam_awal',
            // 'durasi' => 'required|numeric|digits_between:1,2|max:3',
            'biaya' => 'required|numeric|digits_between:4,6',
            'status' => 'required|in:y,t',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $jamAwal = Carbon::parse($request->jam_awal);
        $jamAkhir = Carbon::parse($request->jam_akhir);
        $data = [
            'nama_jam' => $request->nama_jam,
            'jam_awal' => $request->jam_awal,
            'jam_akhir' => $request->jam_akhir,
            'durasi' => $jamAkhir->diffInHours($jamAwal),
            'biaya' => $request->biaya,
            'status' => $request->status
        ];

        $update = $jam->update($data);
        if ($update) {
            return redirect()->route('jam.index')->with('success', 'Edit Jam Berhasil');
        } else {
            return redirect()->route('jam.index')->with('fail', 'Edit Jam Gagal');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jam $jam)
    {
        //
    }
}
