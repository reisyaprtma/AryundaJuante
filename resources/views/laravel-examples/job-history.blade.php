@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Riwayat Status Pekerjaan</h5>
                            <p class="text-sm mb-0">{{ $pekerjaan->nama }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.job-detail', $pekerjaan->id) }}" class="btn bg-gradient-primary btn-sm mb-0">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Diubah Oleh</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($histories as $history)
                                <tr>
                                    <td class="text-sm">
                                        <div class="px-3">
                                            {{ \Carbon\Carbon::parse($history->created_at)->format('d M Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="text-sm">
                                        <div class="px-3">
                                            {{ $history->user_name }}
                                        </div>
                                    </td>
                                    <td class="text-sm">
                                        <div class="px-3">
                                            {{ ucfirst($history->status) }}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada riwayat perubahan status</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
