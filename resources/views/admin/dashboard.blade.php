@extends('layouts.user_type.auth')

@section('content')



@php
use Illuminate\Support\Facades\DB;

function formatRupiah($number) {
    if ($number >= 1000000000) {
        return 'Rp. ' . number_format($number / 1000000000, 1) . ' M';
    } else if ($number >= 1000000) {
        return 'Rp. ' . number_format($number / 1000000, 1) . ' Jt';
    } else if ($number >= 1000) {
        return 'Rp. ' . number_format($number / 1000, 1) . ' Rb';
    } else {
        return 'Rp. ' . number_format($number);
    }
}
$pekerja = DB::table('users')
    ->where('role', 'pekerja')
    ->count();

$notifikasi = DB::table('notifikasi')
    ->leftJoin('users', 'notifikasi.user_id', '=', 'users.id')
    ->leftJoin('pekerjaan', 'notifikasi.job_id', '=', 'pekerjaan.id')
    ->select('notifikasi.*', 'users.name as user_name', 'pekerjaan.nama as pekerjaan_nama')
    ->orderBy('notifikasi.created_at', 'desc')
    ->limit(10)
    ->get();

// Ambil data pekerjaan per bulan tahun ini
$year = now()->year;

$jobsPerMonth = DB::table('pekerjaan')
    ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    ->whereYear('created_at', $year)
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('count', 'month')
    ->toArray();
$jobsDonePerMonth = DB::table('pekerjaan')
    ->where('status','selesai')
    ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    ->whereYear('created_at', $year)
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('count', 'month')
    ->toArray();
$jobsCount = DB::table('pekerjaan')->count();

// Bikin array 12 bulan penuh

$jobCounts = [];
for ($i = 1; $i <= 12; $i++) {
    $jobCounts[] = $jobsPerMonth[$i] ?? 0;
}
$jobsdonecount = [];
for ($i = 1; $i <= 12; $i++) {
    $jobsdonecount[] = $jobsDonePerMonth[$i] ?? 0;
}
$biayaPerMonth = DB::table('pekerjaan')
        ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
        ->whereYear('created_at', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
        ->toArray();

$biayaTotal = DB::table('pekerjaan')
    ->whereYear('created_at', $year)
    ->sum('total');


$biayaCounts = [];
for ($i = 1; $i <= 12; $i++) {
    $biayaCounts[] = $biayaPerMonth[$i] ?? 0;
}
@endphp

  <div class="row mt-4">
    <div class="col-lg-6 mb-lg-0 mb-4">
        <div class="card z-index-2">
          <div class="card-body p-3">
            <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
              <div class="chart">
                <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
              </div>
            </div>
            <h6 class="ms-2 mt-4 mb-0"> Diagram Pemasukan </h6>
            <p class="text-sm ms-2"> Tahun <span class="font-weight-bolder">2025</span>  </p>
            <div class="container border-radius-lg">
              <div class="row">
                <div class="col-4 py-3 ps-0">
                  <div class="d-flex mb-2">
                    <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-primary text-center me-2 d-flex align-items-center justify-content-center">
                      <svg width="10px" height="10px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>Jumlah Pekerja</title>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                              <g transform="translate(154.000000, 300.000000)">
                                <path class="color-background" d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z" opacity="0.603585379"></path>
                                <path class="color-background" d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z"></path>
                              </g>
                            </g>
                          </g>
                        </g>
                      </svg>
                    </div>
                    <p class="text-xs mt-1 mb-0 font-weight-bold">Jumlah Pekerja</p>
                  </div>
                  <h4 class="font-weight-bolder">{{ $pekerja }}</h4>

                </div>

                <div class="col-7 py-3 ps-0">
                  <div class="d-flex mb-2">
                    <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-warning text-center me-2 d-flex align-items-center justify-content-center">
                      <svg width="10px" height="10px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>Pemasukan Total (Tahun {{ $year }})</title>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                              <g transform="translate(453.000000, 454.000000)">
                                <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                              </g>
                            </g>
                          </g>
                        </g>
                      </svg>
                    </div>
                    <p class="text-xs mt-1 mb-0 font-weight-bold">Pemasukan Total (Tahun {{ $year }})</p>
                  </div>
                  <h4 class="font-weight-bolder">{{ formatRupiah($biayaTotal) }}</h4>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    <div class="col-lg-6">
        <div class="card z-index-2">
          <div class="card-header pb-0">
            <h6>Diagram Jumlah Pekerjaan</h6>
            <p class="text-sm">
              Tahun <span class="font-weight-bold">{{ $year }}</span>
            </p>
          </div>
          <div class="card-body p-3">
            <div class="chart">
              <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
            </div>
          </div>
        </div>
      </div>


  <div class="row my-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6>Pekerjaan Berlangsung</h6>
              <p class="text-sm mb-0">
                <i class="fa fa-check text-info" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">Total: {{ $jobsCount }}</span>
              </p>
            </div>
            <div class="col-lg-6 col-5 my-auto text-end">
              <div class="dropdown float-lg-end pe-4">
                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-ellipsis-v text-secondary"></i>
                </a>
                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                  <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                  <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a></li>
                  <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else here</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-2" >
          <div class="table-responsive" >
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deadline</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progres</th>
                </tr>
              </thead>
              <tbody id="pekerjaanTableBody">
                @foreach ($pekerjaans->take(5) as $p)
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm text-truncate" style="max-width: 200px;">{{ $p->nama }}</h6>
                      </div>
                    </div>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> {{ $p->deadline }} </span>
                  </td>
                  <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                      <div class="progress-info">
                        <div class="progress-percentage">
                          <span class="text-xs font-weight-bold">{{ $p->status }}</span>
                        </div>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-gradient-{{ $p->colour }}" role="progressbar" style="width: {{ $p->progress }}%" aria-valuenow="{{ $p->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-between align-items-center mt-3 px-3">
            <div class="text-sm text-secondary" id="paginationInfo">
              Menampilkan {{ $pekerjaans->count() > 0 ? 1 : 0 }} - {{ min(5, $pekerjaans->count()) }} dari {{ $pekerjaans->count() }} pekerjaan
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-sm bg-gradient-warning-secondary" id="prevPage" disabled>
                <i class="ni ni-bold-left"></i> Sebelumnya
              </button>
              <button class="btn btn-sm btn bg-gradient-warning" id="nextPage" {{ $pekerjaans->count() <= 5 ? 'disabled' : '' }}>
                Selanjutnya <i class="ni ni-bold-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-header pb-0">
              <h6>Notifikasi</h6>
            </div>
            <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">
              <div class="timeline timeline-one-side">
                @forelse ($notifikasi as $notif)
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="ni ni-bell-55 text-success text-gradient"></i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $notif->message }}</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</p>
                    </div>
                  </div>
                @empty
                  <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Belum ada notifikasi.</p>
                @endforelse
              </div>
            </div>
          </div>

    </div>
  </div>

@endsection
@push('dashboard')
  <script>
    window.onload = function() {
        // Function to format number to Indonesian Rupiah with abbreviations
        function formatRupiah(number) {
            if (number >= 1000000000) {
                return 'Rp. ' + (number / 1000000000).toFixed(1) + 'M';
            } else if (number >= 1000000) {
                return 'Rp. ' + (number / 1000000).toFixed(1) + 'Jt';
            } else if (number >= 1000) {
                return 'Rp. ' + (number / 1000).toFixed(1) + 'Rb';
            } else {
                return 'Rp. ' + number;
            }
        }

        var ctx = document.getElementById("chart-bars").getContext("2d");

      new Chart(ctx, {
        type: "line",
        data: {
          labels: ["Jan","Feb","Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Pemasukan",
            tension: 0.4,
            borderWidth: 2,
            pointRadius: 4,
            pointBackgroundColor: "#fff",
            borderColor: "#fff",
            backgroundColor: "rgba(255, 255, 255, 0.1)",
            data: @json($biayaCounts),
            fill: true
          }, ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return formatRupiah(context.raw);
                }
              }
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: true,
                display: true,
                drawOnChartArea: true,
                drawTicks: true,
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#fff',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
                callback: function(value) {
                  return formatRupiah(value);
                }
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#fff',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              },
            },
          },
        },
      });



      var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: "Pekerjaan Selesai",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: @json($jobsdonecount),
              maxBarThickness: 6
            },
            {
              label: "Jumlah Pekerjaan",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#3A416F",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: @json($jobCounts),
              maxBarThickness: 6
            }
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });

      // Pagination functionality
      let currentPage = 1;
      const itemsPerPage = 5;
      const pekerjaans = @json($pekerjaans);
      const totalItems = pekerjaans.length;
      const totalPages = Math.ceil(totalItems / itemsPerPage);

      function updateTable() {
        const start = (currentPage - 1) * itemsPerPage;
        const end = Math.min(start + itemsPerPage, totalItems);
        const currentItems = pekerjaans.slice(start, end);

        const tableBody = document.getElementById('pekerjaanTableBody');
        tableBody.innerHTML = '';

        currentItems.forEach(item => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>
              <div class="d-flex px-2 py-1">
                <div class="d-flex flex-column justify-content-center">
                  <h6 class="mb-0 text-sm text-truncate" style="max-width: 200px;">${item.nama}</h6>
                </div>
              </div>
            </td>
            <td class="align-middle text-center text-sm">
              <span class="text-xs font-weight-bold">${item.deadline}</span>
            </td>
            <td class="align-middle">
              <div class="progress-wrapper w-75 mx-auto">
                <div class="progress-info">
                  <div class="progress-percentage">
                    <span class="text-xs font-weight-bold">${item.status}</span>
                  </div>
                </div>
                <div class="progress">
                  <div class="progress-bar bg-gradient-${item.colour}" role="progressbar" style="width: ${item.progress}%" aria-valuenow="${item.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </td>
          `;
          tableBody.appendChild(row);
        });
      }

      function updatePagination() {
        const start = (currentPage - 1) * itemsPerPage + 1;
        const end = Math.min(currentPage * itemsPerPage, totalItems);
        document.getElementById('paginationInfo').textContent =
          `Menampilkan ${start} - ${end} dari ${totalItems} pekerjaan`;

        document.getElementById('prevPage').disabled = currentPage === 1;
        document.getElementById('nextPage').disabled = currentPage === totalPages;
      }

      document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
          currentPage--;
          updateTable();
          updatePagination();
        }
      });

      document.getElementById('nextPage').addEventListener('click', () => {
        if (currentPage < totalPages) {
          currentPage++;
          updateTable();
          updatePagination();
        }
      });

      updatePagination();
    }
  </script>
@endpush

