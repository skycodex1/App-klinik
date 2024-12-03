@extends('layouts.app_modern', ['title' => 'Edit Data Pendaftaran Pasien'])
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Edit Data <b>{{ $daftar->nama }}</b></h5>
                    <div class="card-body">
                        <form action="{{ url('/daftar/' . $daftar->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group mt-1 mb-3">
                                <label for="no_pasien">No. Pasien</label>
                                <input type="text" 
                                    class="form-control @error('no_pasien') is-invalid @enderror"
                                    id="no_pasien" name="no_pasien"
                                    value="{{ old('no_pasien', $daftar->no_pasien) }}">
                                @error('no_pasien')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-1 mb-3">
                                <label for="nama">Nama Pasien</label>
                                <input type="text" 
                                    class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama"
                                    value="{{ old('nama', $daftar->nama) }}">
                                @error('nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-1 mb-3">
                                <label for="tanggal_daftar">Tanggal Daftar</label>
                                <input type="date" name="tanggal_daftar" class="form-control"
                                    value="{{ old('tanggal_daftar', $daftar->tanggal_daftar) }}">
                                @error('tanggal_daftar')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-1 mb-3">
                                <label for="poli_id">Poli</label>
                                <select name="poli_id" class="form-control">
                                    <option value="">-- Pilih Poli --</option>
                                    @foreach ($listPoli as $item)
                                        <option value="{{ $item->id }}" 
                                            {{ old('poli_id', $daftar->poli_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('poli_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-1 mb-3">
                                <label for="keluhan">Keluhan</label>
                                <textarea name="keluhan" rows="2" class="form-control">{{ old('keluhan', $daftar->keluhan) }}</textarea>
                                @error('keluhan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
