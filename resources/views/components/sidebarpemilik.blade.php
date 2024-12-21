<div class="w-full h-full flex flex-col justify-between px-6 py-8 bg-green-100">
    <div class="flex flex-col flex-grow">
        <h1 class="text-xl font-bold text-black-">Hello {{ Auth::user()->name }} 👋</h1>
        <p class="text-black-600 font-bold text-l">Selamat datang!</p>
        <ul class="mt-8 space-y-4 flex-grow">
            <li>
                <a href="{{ route('dashboard.pemilik.index') }}"
                    class="flex items-center font-semibold px-3 py-2 rounded-lg 
                    {{ request()->routeIs('dashboard.pemilik.index') ? 'bg-green-400 text-white' : 'text-green-600' }}">
                    <img src="{{ request()->routeIs('dashboard.pemilik.index') ? asset('images/icon-dashboard-active.png') : asset('images/icon-dashboard.png') }}" 
                         alt="Dashboard Icon" class="w-6 h-6 mr-3">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.pemilik.akun') }}"
                    class="flex items-center px-3 py-2 rounded-lg 
                    {{ request()->routeIs('dashboard.pemilik.akun','dashboard.pemilik.akun.tambah', 'dashboard.pemilik.akun.ubah') ? 'bg-green-400 text-white' : 'text-gray-600 hover:text-green-600' }}">
                    <img src="{{ request()->routeIs('dashboard.pemilik.akun','dashboard.pemilik.akun.tambah', 'dashboard.pemilik.akun.ubah') ? asset('images/icon-akun-active.png') : asset('images/icon-akun.png') }}" 
                         alt="Account Icon" 
                         class="{{ request()->routeIs('dashboard.pemilik.akun','dashboard.pemilik.akun.tambah', 'dashboard.pemilik.akun.ubah') ? 'w-6 h-6' : 'w-6 h-6' }} mr-3">
                    Kelola Akun
                </a>
            </li>
            
            <li>
                <a href="{{ route('dashboard.pemilik.laporan') }}"
                    class="flex items-center px-3 py-2 rounded-lg 
                    {{ request()->routeIs('dashboard.pemilik.laporan') ? 'bg-green-400 text-white' : 'text-gray-600 hover:text-green-600' }}">
                    <img src="{{ request()->routeIs('dashboard.pemilik.laporan') ? asset('images/icon-laporan-active.png') : asset('images/icon-laporan.png') }}" 
                         alt="Report Icon" class="w-6 h-6 mr-3">
                    Melihat Laporan
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                    class="flex items-center px-3 py-2 rounded-lg hover:text-red-600">
                    <img src="{{ asset('images/icon-logout.png') }}" alt="Logout Icon" class="w-6 h-6 mr-3 ml-1">
                    Log out
                </a>
            </li>
        </ul>
    </div>
    <div class="mt-8 flex flex-col items-center justify-center flex-shrink-0">
        <img src="{{ asset('images/icon.png') }}" alt="Logo Agrisawit" class="w-12 h-12 mb-2">
        <span class="text-gray-600 font-semibold">Agrisawit</span>
    </div>
</div>
