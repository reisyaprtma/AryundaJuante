@extends('layouts.user_type.auth')


@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Detail Pekerjaan</h6>
                        <a href="{{ route('dashboard') }}" class="btn bg-gradient-dark btn-sm mb-0">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <h6>Informasi Pekerjaan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <div class="mb-3">
                                            <span class="text-xs text-secondary">Nama Pekerjaan:</span>
                                            <p class="text-sm mb-0">{{ $pekerjaan->nama }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-xs text-secondary">Kategori:</span>
                                            <p class="text-sm mb-0">{{ $pekerjaan->kategori }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-xs text-secondary">Status:</span>
                                            <span class="badge badge-sm bg-gradient-{{
                                                $pekerjaan->status == 'Selesai' ? 'success' :
                                                ($pekerjaan->status == 'IH' ? 'info' :
                                                ($pekerjaan->status == 'BA' ? 'warning' :
                                                ($pekerjaan->status == 'Barang' ? 'danger' : 'primary')))
                                            }}">
                                                {{ ucfirst($pekerjaan->status) }}
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-xs text-secondary">Deadline:</span>
                                            <p class="text-sm mb-0">{{ \Carbon\Carbon::parse($pekerjaan->deadline)->format('d-m-Y') }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-xs text- secondary">Deskripsi:</span>
                                            <p class="text-sm mb-0">{{  $pekerjaan->deskripsi }}</p>
                                        </div>
                                     </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <h6>Informasi Client</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <div class="mb-3">
                                            <span class="text-xs text-secondary">Nama Client:</span>
                                            <p class="text-sm mb-0">{{ $pekerjaan->client }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-xs text-secondary">Nomor Kontak:</span>
                                            <p class="text-sm mb-0">{{ $pekerjaan->no_kontak }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-xs text-secondary">Total Biaya:</span>
                                            <p class="text-sm mb-0">Rp. {{ number_format($pekerjaan->total, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-xs text-secondary">Tanggal Tagihan:</span>
                                            <p class="text-sm mb-0">{{ \Carbon\Carbon::parse($pekerjaan->tanggal_tagihan)->format('d-m-Y') }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-xs text-secondary">Dokumen:</span>
                                            @if($pekerjaan->url_dokumen)
                                                <a href="{{ Storage::url($pekerjaan->url_dokumen) }}" target="_blank" class="btn btn-sm bg-gradient-primary mb-0">
                                                    <i class="fas fa-file me-2"></i>Lihat Dokumen
                                                </a>
                                            @else
                                                <p class="text-sm mb-0">Tidak ada dokumen</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Update Status</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('pekerjaan.updateStatus', $pekerjaan->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="Mulai" {{ $pekerjaan->status == 'Mulai' ? 'selected' : '' }}>Mulai</option>
                                                        <option value="Barang" {{ $pekerjaan->status == 'Barang' ? 'selected' : '' }}>Barang</option>
                                                        <option value="BA" {{ $pekerjaan->status == 'BA' ? 'selected' : '' }}>BA</option>
                                                        <option value="IH" {{ $pekerjaan->status == 'IH' ? 'selected' : '' }}>IH</option>
                                                        <option value="Selesai" {{ $pekerjaan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 d-flex align-items-end">
                                                <button type="submit" class="btn bg-gradient-primary w-100">Update Status</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
