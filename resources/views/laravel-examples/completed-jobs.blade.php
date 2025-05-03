@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">History Pekerjaan Selesai</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No Kontak
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Deadline
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tanggal Selesai
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Ditangani oleh
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="pekerjaanTableBody">
                                @foreach($pekerjaans->take(10) as $p)
                                <tr>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <p class="text-xs font-weight-bold mb-0 text-truncate" style="max-width: 150px;">{{ $p->nama }}</p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $p->no_kontak }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $p->deadline }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $p->updated_at->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $p->ditanganiUser->name ?? 'Belum Ditentukan' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.job-detail', $p->id) }}" class="btn btn-sm bg-gradient-info">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @if($pekerjaans->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada pekerjaan yang selesai</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($pekerjaans->count() > 10)
                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-sm bg-gradient-warning" id="showAllBtn">
                        <i class="ni ni-bold-down"></i> Tampilkan Semuanya
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('dashboard')
<script>
    window.onload = function() {
        const showAllBtn = document.getElementById('showAllBtn');
        if (showAllBtn) {
            showAllBtn.addEventListener('click', function() {
                const tableBody = document.getElementById('pekerjaanTableBody');
                const pekerjaans = @json($pekerjaans);

                // Clear existing rows
                tableBody.innerHTML = '';

                // Add all rows
                pekerjaans.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <p class="text-xs font-weight-bold mb-0 text-truncate" style="max-width: 150px;">${item.nama}</p>
                            </div>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">${item.no_kontak}</p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">${item.deadline}</p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">${new Date(item.updated_at).toLocaleDateString('id-ID')}</p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">${item.ditangani_user ? item.ditangani_user.name : 'Belum Ditentukan'}</p>
                        </td>
                        <td class="text-center">
                            <a href="/admin/detail/${item.id}" class="btn btn-sm bg-gradient-info">
                                <i class="fas fa-info-circle"></i> Detail
                            </a>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                // Hide the button after showing all
                showAllBtn.style.display = 'none';
            });
        }
    }
</script>
@endpush
