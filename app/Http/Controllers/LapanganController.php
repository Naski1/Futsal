<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['lapangan'] = Lapangan::select('id_lapangan', 'nama_lapangan', 'deskripsi', 'status')->get();
        return view('admin.lapangan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lapangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_lapangan' => 'required|min:3|max:150',
            'status' => 'required|in:y,t',
            'deskripsi' => 'nullable'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'nama_lapangan' => $request->nama_lapangan,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi
        ];

        $store = Lapangan::create($data);
        if ($store) {
            return redirect()->route('lapangan.index')->with('success', 'Simpan Lapangan Berhasil');
        } else {
            return redirect()->route('lapangan.index')->with('fail', 'Simpan Lapangan Gagal');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lapangan $lapangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lapangan $lapangan)
    {
        $find = Lapangan::findOrFail($lapangan->id_lapangan);

        return view('admin.lapangan.edit', [
            'lapangan' => $find
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lapangan $lapangan)
    {
        $rules = [
            'nama_lapangan' => 'required|min:3|max:150',
            'status' => 'required|in:y,t',
            'deskripsi' => 'nullable'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'nama_lapangan' => $request->nama_lapangan,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi
        ];

        $update = $lapangan->update($data);
        if ($update) {
            return redirect()->route('lapangan.index')->with('success', 'Edit Lapangan Berhasil');
        } else {
            return redirect()->route('lapangan.index')->with('fail', 'Edit Lapangan Gagal');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lapangan $lapangan)
    {
        //
    }
}
