<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use Illuminate\Support\Facades\Storage;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasien = Pasien::latest()->paginate(10);
        return view('pasien_index', compact('pasien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pasien_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'no_pasien'     => 'required|unique:pasiens,no_pasien',
            'nama'          => 'required',
            'umur'          => 'required|numeric',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat'        => 'nullable',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $pasien = new \App\Models\Pasien();
        $pasien->no_pasien = $requestData['no_pasien'];
        $pasien->nama = $requestData['nama'];
        $pasien->umur = $requestData['umur'];
        $pasien->jenis_kelamin = $requestData['jenis_kelamin'];
        $pasien->alamat = $requestData['alamat'];
        if ($request->hasFile('foto')) {
            $fotoName = time().'.'.$request->foto->extension();
            $request->file('foto')->storeAs('public/images', $fotoName);
            $pasien->foto = $fotoName;
        }
        $pasien->save();
        return redirect('/pasien')->with('pesan', 'Data sudah disimpan');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien_edit', compact('pasien'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $requestData = $request->validate([
            'no_pasien'     => 'required|unique:pasiens,no_pasien,' . $id,
            'nama'          => 'required|min:2',
            'umur'          => 'required|numeric',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat'        => 'nullable',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $pasien = \App\Models\Pasien::findOrFail($id);
        $pasien->no_pasien = $requestData['no_pasien'];
        $pasien->nama = $requestData['nama'];
        $pasien->umur = $requestData['umur'];
        $pasien->jenis_kelamin = $requestData['jenis_kelamin'];
        $pasien->alamat = $requestData['alamat'];
        if ($request->hasFile('foto')) {
            $fotoName = time().'.'.$request->foto->extension();
            $request->file('foto')->storeAs('public/images', $fotoName);
            $Image = str_replace('/storage', '', $pasien->foto);
            if(Storage::exists('public/images/' . $Image)){
                Storage::delete('/public/images/' . $Image);
            }
            $pasien->foto = $fotoName;
        }
        $pasien->save();
        return redirect('/pasien')->with('pesan', 'Data sudah diubah');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        if ($pasien->foto) {
            Storage::delete('public/images/' . $pasien->foto);
        }
        $pasien->delete();

        return back()->with('pesan', 'Data sudah dihapus');
    }
}
//By Pratama Putra A