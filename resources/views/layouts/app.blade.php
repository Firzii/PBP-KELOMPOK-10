<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'UMKM Mini' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
  {{-- NAVBAR --}}
  <header class="bg-white/90 backdrop-blur shadow-sm sticky top-0 z-30">
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex items-center justify-between py-3">
        <a href="{{ route('home') }}" class="font-extrabold text-lg tracking-tight">
          UMKM<span class="text-blue-600">Mini</span>
        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm text-gray-700">
          <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
          <a href="/cart" class="hover:text-blue-600">Keranjang</a>
          <a href="/orders" class="hover:text-blue-600">Pesanan</a>
        </nav>

        <div class="flex items-center gap-3">
          @if (session('logged_in'))
            <span class="hidden sm:inline text-sm text-gray-700">Hi, {{ session('user_name') }}</span>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="text-sm bg-gray-200 hover:bg-gray-300 px-3 py-1.5 rounded-md">
                Logout
              </button>
            </form>
          @else
            <a href="{{ route('login') }}"
               class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md">
              Login
            </a>
          @endif
        </div>
      </div>
    </div>
  </header>

  {{-- FLASH MESSAGES --}}
  <main class="max-w-6xl mx-auto px-4 py-6">
    @if (session('success'))
      <div class="mb-4 rounded-lg bg-green-100 border border-green-200 text-green-800 px-4 py-3">
        {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="mb-4 rounded-lg bg-red-100 border border-red-200 text-red-800 px-4 py-3">
        {{ session('error') }}
      </div>
    @endif

    @yield('content')
  </main>

  {{-- FOOTER --}}
  <footer class="border-t bg-white">
    <div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 sm:grid-cols-3 gap-6 text-sm">
      <div>
        <div class="font-extrabold text-lg mb-2">
          UMKM<span class="text-blue-600">Mini</span>
        </div>
        <p class="text-gray-600">
          Platform sederhana untuk memajukan produk UMKM. Belanja mudah, aman, dan langsung dari sumbernya.
        </p>
      </div>
      <div>
        <div class="font-semibold mb-2">Navigasi</div>
        <ul class="space-y-1 text-gray-600">
          <li><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a></li>
          <li><a href="/cart" class="hover:text-blue-600">Keranjang</a></li>
          <li><a href="/orders" class="hover:text-blue-600">Pesanan</a></li>
        </ul>
      </div>
      <div>
        <div class="font-semibold mb-2">Newsletter</div>
        <form class="flex gap-2">
          <input class="border rounded-md px-3 py-2 w-full" placeholder="Email kamu (dummy)" />
          <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            Kirim
          </button>
        </form>
      </div>
    </div>
    <div class="border-t text-center text-xs text-gray-500 py-4">
      © {{ date('Y') }} UMKM Mini — All rights reserved.
    </div>
  </footer>
</body>
</html>
