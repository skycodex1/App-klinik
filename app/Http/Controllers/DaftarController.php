<?php

namespace App\Http\Controllers;

use App\Models\Daftar;
use Illuminate\Http\Request;

class DaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $daftar = \App\Models\Daftar::query();

        if (request()->has('q')) {
            $daftar = $daftar->search(request('q'));
        }

        $daftar = $daftar->with('pasien')->latest()->paginate(20);

        $data['daftar'] = $daftar;

        return view('daftar_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['listPasien'] = \App\Models\Pasien::orderBy('nama', 'asc')->get();
        $data['listPoli'] = \App\Models\Poli::orderBy('nama', 'asc')->get();
        return view('daftar_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'tanggal_daftar' => 'required',
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'keluhan' => 'required',
        ]);

        try {
            $daftar = new \App\Models\Daftar();
            if ($daftar === null) {
                throw new \Exception('Daftar model tidak dapat dibuat');
            }

            $daftar->fill($requestData);

            if (!$daftar->save()) {
                throw new \Exception('Terjadi kesalahan saat menyimpan data');
            }

            return redirect('/daftar')->with('pesan', 'Data sudah disimpan');
        } catch (\Exception $e) {
            return redirect('/daftar')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $daftar = \App\Models\Daftar::findOrFail($id);
            $data['listPasien'] = \App\Models\Pasien::orderBy('nama', 'asc')->get();
            $data['listPoli'] = \App\Models\Poli::orderBy('nama', 'asc')->get();
            $data['daftar'] = $daftar;
            return view('daftar_show', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect('/daftar')->with('pesan', 'Data tidak ditemukan');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $daftar = \App\Models\Daftar::findOrFail($id);
            $data['listPasien'] = \App\Models\Pasien::orderBy('nama', 'asc')->get();
            $data['listPoli'] = \App\Models\Poli::orderBy('nama', 'asc')->get();
            $data['daftar'] = $daftar;
            return view('daftar_edit', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect('/daftar')->with('pesan', 'Data tidak ditemukan');
        }   
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->validate([
            'tanggal_daftar' => 'required',
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'keluhan' => 'required',
        ]);

        try {
            $daftar = \App\Models\Daftar::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect('/daftar')->with('error', 'Data tidak ditemukan');
        }

        $daftar->fill($requestData);

        try {
            if (!$daftar->save()) {
                throw new \Exception('Terjadi kesalahan saat menyimpan data');
            }
        } catch (\Exception $e) {
            return redirect('/daftar')->with('error', $e->getMessage());
        }

        return redirect('/daftar')->with('pesan', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daftar $daftar)
    {
        $daftar->delete();
        return redirect('/daftar')->with('pesan', 'Data sudah dihapus');
    }
}