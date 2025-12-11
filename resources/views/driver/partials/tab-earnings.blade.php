<div class="space-y-6">
    <h2 class="text-xl font-bold text-white">Pendapatan & Statistik</h2>

    <!-- RINGKASAN TOTAL BULAN INI -->
    <div class="bg-gradient-to-br from-brand-green to-emerald-600 rounded-3xl p-6 shadow-lg shadow-brand-green/20 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
        <p class="text-black/70 font-bold text-xs uppercase tracking-wider mb-1">Pendapatan Bulan Ini</p>
        <h3 class="text-4xl font-black text-black">Rp {{ number_format($monthEarnings, 0, ',', '.') }}</h3>
        <div class="mt-4 flex gap-4">
            <div class="bg-black/10 px-3 py-1.5 rounded-lg">
                <p class="text-[10px] font-bold text-black/60">Total Order</p>
                <p class="text-black font-bold">{{ $historyOrders->where('status', 'completed')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- GRAFIK GARIS (LINE CHART) -->
    <div class="glass-panel p-5 rounded-2xl relative">
        <div class="flex justify-between items-center mb-2">
            <h3 class="font-bold text-white text-sm">Grafik 7 Hari Terakhir</h3>
            <span class="text-[10px] text-brand-green bg-brand-green/10 px-2 py-1 rounded-full animate-pulse">Live Data</span>
        </div>
        
        <!-- Container Chart -->
        <div id="incomeChart" class="w-full h-40"></div>
    </div>

    <!-- LIST PENDAPATAN HARIAN -->
    <div>
        <h3 class="font-bold text-white mb-3 text-sm">Rincian Harian</h3>
        <div class="space-y-3">
            @forelse($dailyLog as $log)
            <div class="flex justify-between items-center border-b border-gray-800 pb-3 hover:bg-white/5 p-2 rounded-lg transition">
                <div>
                    <p class="text-white font-bold text-sm">
                        {{ \Carbon\Carbon::parse($log->date)->isoFormat('dddd, D MMMM') }}
                    </p>
                    <p class="text-xs text-gray-500">{{ $log->count }} Order Selesai</p>
                </div>
                <p class="text-brand-green font-bold">Rp {{ number_format($log->total, 0, ',', '.') }}</p>
            </div>
            @empty
            <div class="text-center py-4 text-gray-500 text-xs">
                Belum ada data pendapatan.
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- SCRIPT UNTUK RENDER CHART (FIXED: URUTAN HARI) -->
<script>
    document.addEventListener('alpine:init', () => {
        // Ambil data dari Controller
        // HAPUS .reverse() agar urutannya benar (Kiri: Lalu -> Kanan: Hari Ini)
        const chartData = @json($chartData); 

        const options = {
            series: [{
                name: 'Pendapatan',
                data: chartData.map(item => item.total) // Nominal uang
            }],
            chart: {
                type: 'area', 
                height: 180,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Inter, sans-serif',
                background: 'transparent'
            },
            colors: ['#00E073'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                categories: chartData.map(item => item.day_name), // Mon, Tue...
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: '#94a3b8', fontSize: '10px' }
                }
            },
            yaxis: { show: false },
            grid: {
                show: true,
                borderColor: '#334155',
                strokeDashArray: 4,
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            theme: { mode: 'dark' },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                    }
                }
            }
        };

        // Render ulang jika chart sudah ada sebelumnya (untuk menghindari duplikasi)
        if(document.querySelector("#incomeChart").innerHTML === "") {
            const chart = new ApexCharts(document.querySelector("#incomeChart"), options);
            chart.render();
        }
    });
</script>