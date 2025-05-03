@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Edit Pekerjaan</h5>
                        </div>
                        <a href="{{ route('admin.job-detail', $pekerjaan->id) }}" class="btn bg-gradient-primary btn-sm mb-0">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.job-update', $pekerjaan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="form-control-label">Nama Pekerjaan</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $pekerjaan->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_kontak" class="form-control-label">No Kontak</label>
                                    <input type="text" class="form-control @error('no_kontak') is-invalid @enderror" id="no_kontak" name="no_kontak" value="{{ old('no_kontak', $pekerjaan->no_kontak) }}" required>
                                    @error('no_kontak')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deadline" class="form-control-label">Deadline</label>
                                    <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline', $pekerjaan->deadline) }}" required>
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="kategori" class="form-control-label">Kategori</label>
                                    <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori', $pekerjaan->kategori) }}" required>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="client" class="form-control-label">Client</label>
                                    <input type="text" class="form-control @error('client') is-invalid @enderror" id="client" name="client" value="{{ old('client', $pekerjaan->client) }}" required>
                                    @error('client')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ditangani_oleh" class="form-control-label">Ditangani oleh</label>
                                    <select class="form-control @error('ditangani_oleh') is-invalid @enderror" id="ditangani_oleh" name="ditangani_oleh">
                                        <option value="">Pilih Pekerja</option>
                                        @foreach($pekerjas as $pekerja)
                                            <option value="{{ $pekerja->id }}" {{ old('ditangani_oleh', $pekerjaan->ditangani_oleh) == $pekerja->id ? 'selected' : '' }}>
                                                {{ $pekerja->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ditangani_oleh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="total" class="form-control-label">Total</label>
                                    <input type="number" class="form-control @error('total') is-invalid @enderror" id="total" name="total" value="{{ old('total', $pekerjaan->total) }}" required>
                                    @error('total')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_tagihan" class="form-control-label">Tanggal Tagihan</label>
                                    <input type="date" class="form-control @error('tanggal_tagihan') is-invalid @enderror" id="tanggal_tagihan" name="tanggal_tagihan" value="{{ old('tanggal_tagihan', $pekerjaan->tanggal_tagihan) }}" required>
                                    @error('tanggal_tagihan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="url_dokumen" class="form-control-label">Dokumen</label>
                                    <input type="file" class="form-control @error('url_dokumen') is-invalid @enderror" id="url_dokumen" name="url_dokumen">
                                    @error('url_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($pekerjaan->url_dokumen)
                                        <small class="form-text text-muted">Dokumen saat ini: {{ $pekerjaan->url_dokumen }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="deskripsi" class="form-control-label">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $pekerjaan->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
