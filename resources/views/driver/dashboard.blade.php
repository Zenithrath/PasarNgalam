<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Panel - PasarNgalam</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> 
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#00E073',
                        'brand-dark': '#0F172A',
                        'brand-card': '#1E293B',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: {
                        'ping-slow': 'ping 3s cubic-bezier(0, 0, 0.2, 1) infinite',
                        'pulse-glow': 'pulse-glow 2s infinite',
                    },
                    keyframes: {
                        'pulse-glow': {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(0, 224, 115, 0.2)' },
                            '50%': { boxShadow: '0 0 40px rgba(0, 224, 115, 0.6)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-panel { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); }
        [x-cloak] { display: none !important; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-brand-dark text-white min-h-screen relative overflow-x-hidden selection:bg-brand-green selection:text-black" 
      x-data="{ 
          sidebarOpen: false,
          currentTab: 'dashboard', // dashboard, history, earnings
          showProfileModal: false,
          isOnline: @json((bool) $user->is_online), 
          EchoInstance: null,
          startRealtime() {
              try {
                  this.EchoInstance = new Echo({
                      broadcaster: 'reverb',
                      key: '{{ env('REVERB_APP_KEY') }}',
                      wsHost: '{{ env('REVERB_HOST', request()->getHost()) }}',
                      wsPort: {{ env('REVERB_PORT', 443) }},
                      wssPort: {{ env('REVERB_PORT', 443) }},
                      forceTLS: true,
                      enabledTransports: ['ws', 'wss'],
                  });
                  this.EchoInstance.channel('driver.{{ $user->id }}')
                      .listen('.order.updated', () => {
                          window.location.reload();
                      });
              } catch (e) {
                  // ignore
              }
          },
          toggleStatus() {
              this.isOnline = !this.isOnline;
              fetch('{{ route('driver.toggle') }}', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                  body: JSON.stringify({ status: this.isOnline })
              }).then(() => {
                  if(this.isOnline) updateDriverLocation(); 
              });
          }
      }">

    <!-- Background Decoration -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-brand-green/5 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-blue-500/5 rounded-full blur-[120px]"></div>
    </div>

    <!-- SIDEBAR -->
    @include('driver.partials.sidebar')

    <!-- NAVBAR -->
    @include('driver.partials.navbar')

    <!-- MAIN CONTENT AREA -->
    <main class="max-w-3xl mx-auto px-4 mt-6 pb-24 relative z-10 transition-all duration-300">
        
        <!-- TAB: DASHBOARD -->
        <div x-show="currentTab === 'dashboard'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-5" x-transition:enter-end="opacity-100 translate-y-0">
            @include('driver.partials.tab-dashboard')
        </div>

        <!-- TAB: RIWAYAT -->
        <div x-show="currentTab === 'history'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-5" x-transition:enter-end="opacity-100 translate-y-0">
            @include('driver.partials.tab-history')
        </div>

        <!-- TAB: PENDAPATAN -->
        <div x-show="currentTab === 'earnings'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-5" x-transition:enter-end="opacity-100 translate-y-0">
            @include('driver.partials.tab-earnings')
        </div>

    </main>

    <!-- MODAL PROFIL -->
    @include('driver.partials.profile-modal')

    <!-- NOTIFIKASI -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
         class="fixed top-24 right-4 z-[60] bg-brand-green text-black px-6 py-3 rounded-xl font-bold shadow-lg flex items-center gap-3 animate-pulse">
        <span>✅</span> {{ session('success') }}
    </div>
    @endif

    <script>
        function updateDriverLocation() {
            const isOnline = document.querySelector('[x-data]').__x.$data.isOnline;
            if (!isOnline) return;
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    fetch('/driver/update-location', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ latitude: position.coords.latitude, longitude: position.coords.longitude })
                    });
                });
            }
        }
        setInterval(updateDriverLocation, 10000);
        document.addEventListener('DOMContentLoaded', function() {
            const root = document.querySelector('[x-data]');
            if (root && root.__x) {
                root.__x.$data.startRealtime();
            }
        });

        function previewDriverProfile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) { document.getElementById('driver-profile-pic-preview').src = e.target.result; }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
