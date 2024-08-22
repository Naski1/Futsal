<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['costumer'] = User::select('id_user', 'name', 'email', 'no_tlpn', 'foto_profil')->where('role', 'costumer')->get();
        return view('admin.costumer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.costumer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required|string|min:3|max:255',
            'email' => 'required|email:rfc,dns',
            'no_tlpn' => 'required|string|min:11|max:12',
            'alamat' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'name' => $request->nama,
            'email' => $request->email,
            'no_tlpn' => $request->no_tlpn,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->no_tlpn),
            'email_verified_at' => Carbon::now(),
            'role' => 'costumer'
        ];

        $store = User::create($data);
        if ($store) {
            return redirect()->route('user.index')->with('success', 'Simpan Berhasil');
        } else {
            return redirect()->route('user.index')->with('fail', 'Simpan Gagal');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $find = User::findOrFail($id);

        // return $find;
        return view('admin.costumer.edit', [
            'user' => $find
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'nama' => 'required|string|min:3|max:255',
            'email' => 'required|email:rfc,dns',
            'no_tlpn' => 'required|string|min:11|max:12',
            'alamat' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'name' => $request->nama,
            'email' => $request->email,
            'no_tlpn' => $request->no_tlpn,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->no_tlpn),
            // 'email_verified_at' => Carbon::now(),
            // 'role' => 'costumer'
        ];

        $update = User::where('id_user', $id)->update($data);
        if ($update) {
            if (Auth::user()->role == 'costumer') {

                return redirect()->back()->with('success', 'Edit Berhasil');
            }
            return redirect()->route('user.index')->with('success', 'Edit Berhasil');
        } else {
            if (Auth::user()->role == 'costumer') {

                return redirect()->back()->with('fail', 'Edit Gagal');
            }
            return redirect()->route('user.index')->with('fail', 'Edit Gagal');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
