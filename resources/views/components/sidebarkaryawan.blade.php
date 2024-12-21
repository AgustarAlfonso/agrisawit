<div class="w-full h-full flex flex-col justify-between px-6 py-8 bg-green-100">
    <div class="flex flex-col flex-grow">
        <h1 class="text-xl font-bold text-black-400 ">Hello {{ Auth::user()->name }} 👋</h1>
        <p class="text-black-400 font-bold text-l">Selamat datang!</p>
        <ul class="mt-8 space-y-4 flex-grow">
            <li>
                <a href="{{ route('dashboard.karyawan.index') }}"
                    class="flex items-center font-semibold px-3 py-2 rounded-lg 
                    {{ request()->routeIs('dashboard.karyawan.index') ? 'bg-green-400 text-white' : 'text-gray-400 hover:text-white' }}">
                    <img src="{{ request()->routeIs('dashboard.karyawan.index') ? asset('images/icon-dashboard-active.png') : asset('images/icon-dashboard.png') }}" 
                         alt="Dashboard Icon" class="w-6 h-6 mr-3">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.karyawan.jadwal') }}"
                    class="flex items-center px-3 py-2 rounded-lg 
                    {{ request()->routeIs('dashboard.karyawan.jadwal', 'dashboard.karyawan.jadwal.tambah', 'dashboard.karyawan.jadwal.ubah') ? 'bg-green-400 text-white' : 'text-gray-400 hover:text-white' }}">
                    <img src="{{ request()->routeIs('dashboard.karyawan.jadwal', 'dashboard.karyawan.jadwal.tambah', 'dashboard.karyawan.jadwal.ubah') ? asset('images/icon-jadwal-active.png') : asset('images/icon-jadwal.png') }}" 
                         alt="Schedule Icon" class="w-6 h-6 mr-3">
                     Jadwal
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.karyawan.panen') }}"
                    class="flex items-center px-3 py-2 rounded-lg 
                    {{ request()->routeIs('dashboard.karyawan.panen','dashboard.karyawan.panen.tambah','dashboard.karyawan.panen.ubah') ? 'bg-green-400 text-white' : 'text-gray-400 hover:text-white' }}">
                    <img src="{{ request()->routeIs('dashboard.karyawan.panen','dashboard.karyawan.panen.tambah','dashboard.karyawan.panen.ubah') ? asset('images/icon-panen-active.png') : asset('images/icon-panen.png') }}" 
                         alt="Harvest Icon" class="w-6 h-6 mr-3">
                    Data Panen
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.karyawan.penjualan') }}"
                    class="flex items-center px-3 py-2 rounded-lg 
                    {{ request()->routeIs('dashboard.karyawan.penjualan', 'dashboard.karyawan.penjualan.tambah', 'dashboard.karyawan.penjualan.ubah') ? 'bg-green-400 text-white' : 'text-gray-400 hover:text-white' }}">
                    <img src="{{ request()->routeIs('dashboard.karyawan.penjualan', 'dashboard.karyawan.penjualan.tambah', 'dashboard.karyawan.penjualan.ubah') ? asset('images/icon-penjualan-active.png') : asset('images/icon-penjualan.png') }}" 
                         alt="Sales Icon" class="w-6 h-6 mr-3">
                    Mengelola Penjualan
                </a>
            </li>


            <li>
                <a href="{{ route('dashboard.karyawan.laporan') }}"
                    class="flex items-center px-3 py-2 rounded-lg 
                    {{ request()->routeIs('dashboard.karyawan.laporan') ? 'bg-green-400 text-white' : 'text-gray-400 hover:text-white' }}">
                    <img src="{{ request()->routeIs('dashboard.karyawan.laporan') ? asset('images/icon-laporan-active.png') : asset('images/icon-laporan.png') }}" 
                         alt="Report Icon" class="w-6 h-6 mr-3">
                    Laporan
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.karyawan.stok') }}"
                    class="flex items-center px-3 py-2 rounded-lg 
                    {{ request()->routeIs('dashboard.karyawan.stok') ? 'bg-green-400 text-white' : 'text-gray-400 hover:text-white' }}">
                    <img src="{{ request()->routeIs('dashboard.karyawan.stok') ? asset('images/icon-stok-active.png') : asset('images/icon-stok.png') }}" 
                         alt="Stock Icon" class="w-6 h-6 mr-3">
                    Laporan Stok
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                    class="flex items-center px-3 py-2 ml-1 rounded-lg text-gray-400 hover:text-red-600">
                    <img src="{{ asset('images/icon-logout.png') }}" alt="Logout Icon" class="w-6 h-6 mr-3">
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <div class="mt-8 flex flex-col items-center justify-center flex-shrink-0">
        <img src="{{ asset('images/icon.png') }}" alt="Logo" class="w-12 h-12 mb-2">
        <span class="text-gray-400 font-semibold">Agrisawit</span>
    </div>
</div>
