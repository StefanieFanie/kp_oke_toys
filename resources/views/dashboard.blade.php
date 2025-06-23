@extends('layout')

@section('title', 'Oke Toys')

@section('content')
<style>
    .card-info {
        padding: 60px;
    }
    .card-style {
        box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
        border-radius: 15px;
        border : 1px solid #8EABFF;
        background: #E4EBFF;
    }
 
    .chart-card {
        height: calc(100vh - 375px); 
        min-height: 300px; 
    }
    .chart-card .card-body {
        display: flex;
        flex-direction: column;
    }
    .chart-card .chart-container {
        flex: 1;
    }
    
    @media (max-width: 767px) {
        .weekly-chart-container {
            margin-bottom: 30px;
        }
    }
</style>
<div>
    <h3 class="mb-4"><b>Oke Toys - Dashboard</b></h3>
    <div class="row">
        <div class="col-sm-4 mb-3 mb-sm-5">
          <div class="card card-style">
            <div class="card-body card-info">
              <h5 class="card-title text-center"><b>Penjualan hari ini</b></h5>
              <h3 class="card-text text-center"><b>Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</b></h3>
            </div>
          </div>
        </div>
        <div class="col-sm-4 mb-3 mb-sm-5">
          <div class="card card-style">
            <div class="card-body card-info">
              <h5 class="card-title text-center"><b>Jumlah transaksi hari ini</b></h5>
              <h3 class="card-text text-center"><b>{{ $transaksiHariIni }}</b></h3>
            </div>
          </div>
        </div>
        <div class="col-sm-4 mb-sm-5">
            <div class="card card-style">
              <div class="card-body card-info">
                <h5 class="card-title text-center"><b>Untung bersih hari ini</b></h5>
                <h3 class="card-text text-center"><b>Rp {{ number_format($untungHariIni, 0, ',', '.') }}</b></h3>
              </div>
            </div>
          </div>
      </div>    
      <div class="row">
        <div class="col-sm-6 weekly-chart-container">
          <div class="card card-style chart-card">
            <div class="card-body">
              <h5 class="card-title text-center"><b>Penjualan minggu ini</b></h5>
              <div class="chart-container">
                <canvas id="weeklyChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card card-style chart-card">
            <div class="card-body">
              <h5 class="card-title text-center"><b>Penjualan bulan ini</b></h5>
              <div class="chart-container">
                <canvas id="monthlyChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    //chart.js
  document.addEventListener('DOMContentLoaded', function() {
    const weeklyChartCtx = document.getElementById('weeklyChart').getContext('2d');
    const weeklyChart = new Chart(weeklyChartCtx, {
      type: 'bar',
      data: {
        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        datasets: [{
          label: 'Penjualan (Rp)',
          data: @json($penjualanMingguIni),
          backgroundColor: '#B1C4FF',
          borderColor: '#8EABFF',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              display: false
            },
            ticks: {
              font: {
                size: 14
              }
            }
          },
          x: {
            grid: {
              display: false
            },
            ticks: {
              font: {
                size: 14
              }
            }
          }
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            titleFont: {
              size: 16
            },
            bodyFont: {
              size: 14
            },
            callbacks: {
              label: function(context) {
                let value = context.parsed.y;
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        },
        layout: {
          padding: {
            top: 20,
            bottom: 20
          }
        }
      }
    });

    const monthlyChartCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyChartCtx, {
      type: 'bar',
      data: {
        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
        datasets: [{
          label: 'Penjualan (Rp)',
          data: @json($penjualanBulanIni),
          backgroundColor: '#5D7BC4',
          borderColor: '#4A63A0',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              display: false
            },
            ticks: {
              font: {
                size: 14
              }
            }
          },
          x: {
            grid: {
              display: false
            },
            ticks: {
              font: {
                size: 14
              }
            }
          }
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            titleFont: {
              size: 16
            },
            bodyFont: {
              size: 14
            },
            callbacks: {
              label: function(context) {
                let value = context.parsed.y;
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        },
        layout: {
          padding: {
            top: 20,
            bottom: 20
          }
        }
      }
    });
  });
</script>
@endsection