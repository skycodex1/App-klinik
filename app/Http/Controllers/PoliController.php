<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $poli = poli::latest()->paginate(10);
        return view('poli_index', compact('poli'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('poli_create');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $requestData = $request->validate([
        'nama' => 'required',
        'biaya' => 'required|numeric',
        
    ]);
    $poli = new \App\Models\poli(); //membuat objek kosong
    $poli->fill($requestData); //mengisi objek dengan data yang sudah divalidasi requestData
    $poli->save();
    return back()->with('pesan', 'Data sudah disimpan');
}


    /**
     * Display the specified resource.
     */
    public function show(Poli $poli)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['poli'] = \App\Models\poli::findOrFail($id);
        return view('poli_edit', $data);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poli $poli)
    {
        $requestData = $request->validate([
            'nama'          => 'required|min:2',
            'biaya'          => 'required|numeric',
        ]);
        $poli->nama = $requestData['nama'];
        $poli->biaya = $requestData['biaya'];
        $poli->save();
        return redirect('/poli')->with('pesan', 'Data sudah diubah');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $poli = \App\Models\poli::findOrFail($id);
    $poli->delete();
    return back()->with('pesan', 'Data sudah dihapus');
}

}

//By Pratama Putra A.
