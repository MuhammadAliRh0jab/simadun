@extends('layouts.dosen.app')
@section('title', 'Dashboard Dosen')

@section('styles')
  <style>

  </style>
@endsection

@section('content')
  <div class="col-lg-12 mb-4">
    {{-- welcome --}}
    <div class="my-5">
      <div class="text-start">
        <h3 class="">Selamat Datang, {{ Auth::guard('dosen')->user()->nama }}
          <span class="hand-icon">
            👋
          </span>
        </h3>
        <p class="text-muted col-12 col-md-6">Selamat data di dashboard dosen, Anda dapat melihat progress mahasiswa anda
          dalam tahapan
          ujian disertasi.</p>
      </div>
      @if( UserHelper::isKaprodi() || UserHelper::isDosen())
      <div class="row mt-5">
        <div class="col-12 col-md-6">
          <div class="card">
            <div class="card-header header-elements">
              <div class="ps-0 ps-sm-2 d-flex flex-column mb-sm-0">
                <h5 class="card-title mb-0">Pendaftar Ujian Disertasi (dalam proses)</h5>
                <small>Chart ini menggambarkan pendaftaran ujian disertasi yang sedang dalam proses</small>
              </div>
            </div>
            <div class="card-body">
              <canvas id="doughnutChart" class="chartjs" data-height="200"></canvas>
              <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 mt-4 pt-1">

              </ul>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 mt-3 mt-md-0">
          <div class="card">
            <div class="card-header header-elements">
              <div class="ps-0 ps-sm-2 d-flex flex-column mb-sm-0">
                <h5 class="card-title mb-0">Pengguna SIMADUN
                </h5>
                 <small>Grafik ini menggambarkan jumlah pengguna aplikasi ini</small>
              </div>
              <div class="card-action-element ms-auto py-0">

              </div>
            </div>
            <div class="card-body">
              <canvas id="horizontalBarChart" class="chartjs" data-height="200"></canvas>
            </div>
          </div>
        </div>
      </div>
      @endif
      <div class="row mt-3">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Jadwal Ujian Disertasi</h5>
              <div id="calendar" class="w-full" style="height: 300px !important;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection

  @section('scripts')
    <script src="assets/vendor/libs/chartjs/chartjs.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
      // Color Variables
      let cardColor, headingColor, labelColor, borderColor, legendColor;

      if (isDarkStyle) {
        cardColor = config.colors_dark.cardColor;
        headingColor = config.colors_dark.headingColor;
        labelColor = config.colors_dark.textMuted;
        legendColor = config.colors_dark.bodyColor;
        borderColor = config.colors_dark.borderColor;
      } else {
        cardColor = config.colors.cardColor;
        headingColor = config.colors.headingColor;
        labelColor = config.colors.textMuted;
        legendColor = config.colors.bodyColor;
        borderColor = config.colors.borderColor;
      }

      const horizontalBarChart = document.getElementById('horizontalBarChart');
      const dataUser = [
        {{ $statistic->dosen }}, {{ $statistic->eks }}, {{ $statistic->kaprodi }}, {{ $statistic->mahasiswa }},
      ]
      if (horizontalBarChart) {
        const horizontalBarChartVar = new Chart(horizontalBarChart, {
          type: 'bar',
          data: {
            labels: ['Dosen', 'Penguji Eksternal', 'Kaprodi', 'Mahasiswa'],
            datasets: [{
              data: dataUser,
              backgroundColor: config.colors.info,
              borderColor: 'transparent',
              maxBarThickness: 15
            }]
          },
          options: {
            indexAxis: 'y',
            aspectRatio: 1.8,
            responsive: true,
            animation: {
              duration: 500
            },
            elements: {
              bar: {
                borderRadius: {
                  topRight: 15,
                  bottomRight: 15
                }
              }
            },
            plugins: {
              tooltip: {
                rtl: isRtl,
                backgroundColor: cardColor,
                titleColor: headingColor,
                bodyColor: legendColor,
                borderWidth: 1,
                borderColor: borderColor
              },
              legend: {
                display: false
              }
            },
            scales: {
              x: {
                min: 0,
                grid: {
                  color: borderColor,
                  borderColor: borderColor
                },
                ticks: {
                  color: labelColor,
                  stepSize: 1
                }
              },
              y: {
                grid: {
                  borderColor: borderColor,
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  color: labelColor
                }
              }
            }
          }
        });
      }
    </script>
    <script>
      // Color Variables
      const cyanColor = '#28dac6',
        orangeLightColor = '#FDAC34',
        greenColor = '#28c76f',
        redColor = '#ea5455',
        blueColor = '#1e90ff';


      if (isDarkStyle) {
        cardColor = config.colors_dark.cardColor;
        headingColor = config.colors_dark.headingColor;
        labelColor = config.colors_dark.textMuted;
        legendColor = config.colors_dark.bodyColor;
        borderColor = config.colors_dark.borderColor;
      } else {
        cardColor = config.colors.cardColor;
        headingColor = config.colors.headingColor;
        labelColor = config.colors.textMuted;
        legendColor = config.colors.bodyColor;
        borderColor = config.colors.borderColor;
      }

      const data = [
        {{ $statistic->proposal }},
        {{ $statistic->semhas }},
        {{ $statistic->publikasi }},
        {{ $statistic->tertutup }},

      ]
      const doughnutChart = document.getElementById('doughnutChart');
      if (doughnutChart) {
        const doughnutChartVar = new Chart(doughnutChart, {
          type: 'doughnut',
          data: {

            labels: ['Proposal', 'Seminar Hasil', 'Kelayakan', 'Disertasi Tertutup'],
            datasets: [{
              data: data,
              backgroundColor: [cyanColor, orangeLightColor, config.colors.primary, greenColor, redColor],
              borderWidth: 2,
              pointStyle: 'rectRounded'
            }]
          },

          options: {
            aspectRatio: 2,
            responsive: true,
            animation: {
              duration: 500
            },
            cutout: '68%',

            plugins: {

              legend: {
                display: true,
                position: 'left',
              },

              tooltip: {
                callbacks: {
                  label: function(context) {
                    const label = context.labels || '',
                      value = context.parsed;
                    const output = ' ' + label + ' : ' + value + ' Pendaftar';
                    return output;
                  }
                },
                // Updated default tooltip UI
                rtl: isRtl,
                backgroundColor: cardColor,
                titleColor: headingColor,
                bodyColor: legendColor,
                borderWidth: 1,
                borderColor: borderColor,
              }
            }
          },
          // add text to the center of the chart
          // plugins: [{
          //   afterDraw: function(chart) {
          //     if (chart.data.datasets.length === 0) {
          //       // No data is present
          //       return;
          //     }
          //     var ctx = chart.ctx;
          //     var totalValue = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
          //     ctx.save();
          //     ctx.textAlign = 'center';
          //     ctx.textBaseline = 'middle';
          //     ctx.font = "1em sans-serif";
          //     ctx.fillText('Total: ' + totalValue, chart.width / 1.45, chart.height / 2);
          //     ctx.restore();
          //   }
          // }]
        });
      }
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        @if ($jadwal_ujians)
          var jadwal_ujians = @json($jadwal_ujians);
          var events = jadwal_ujians.map(function(jadwal_ujian) {
            var truncatedDate = (jadwal_ujian.tanggal).split(' ')[0];
            var hour = jadwal_ujian.jam;
            var startDateTime = new Date(truncatedDate + 'T' + hour);
            var endDateTime = new Date(truncatedDate + 'T' + hour);
            endDateTime.setHours(endDateTime.getHours() + 2);
            return {
              title: ('Ujian ' + jadwal_ujian.jenis_ujian.charAt(0).toUpperCase() + jadwal_ujian.jenis_ujian.slice(
                1)) + ' - ' + jadwal_ujian.nama,

              start: startDateTime,
              end: endDateTime,
              color: '#28c76f',
              textColor: 'white',
              borderColor: '#28c76f',
              display: 'list-item',
              description: jadwal_ujian.jenis_ujian + ' - ' + jadwal_ujian.nama + ' - ' + jadwal_ujian.nim,
              description: 'test',
            };
          });

          console.log(events);
          var calendarEl = document.getElementById('calendar');
          var calendar = new FullCalendar.Calendar(calendarEl, {
            timezone: 'Asia/Jakarta',
            initialView: 'timeGridWeek',
            views: {
              timeGridWeek: {
                slotMinTime: '07:00:00',
                slotMaxTime: '17:00:00',
                titleFormat: {
                  year: 'numeric',
                  month: 'long',
                  day: 'numeric'
                },
                slotLabelFormat: {
                  hour: 'numeric',
                  minute: '2-digit',
                  omitZeroMinute: false,
                  meridiem: 'short'
                },
                dayHeaderFormat: {
                  weekday: 'long'
                },
                dayMaxEventRows: 3,
                dayHeaderContent: function(arg) {
                  return arg.view.calendar.formatDate(arg.date, {
                    weekday: 'long'
                  });
                },
                slotLabelContent: function(arg) {
                  return arg.view.calendar.formatDate(arg.date, {
                    hour: 'numeric',
                    minute: '2-digit',
                    omitZeroMinute: false,
                    meridiem: 'short'
                  });
                },
              }
            },
          });

          calendar.setOption('locale', 'id');
          calendar.setOption('height', 600);
          calendar.addEventSource(events);
          calendar.render();
        @endif
      });
    </script>
    <script>
      $(document).ready(function() {
        // init
      });
    </script>
  @endsection
