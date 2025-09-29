@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-semibold mb-4">Katalog Produk</h1>

  {{-- Filter & Search --}}
  <form method="GET" action="{{ route('home') }}" class="mb-6 flex flex-col gap-3 md:flex-row md:items-end">
    <div>
      <label class="text-sm font-medium">Kategori</label>
      <select name="category_id" class="mt-1 border rounded-md px-3 py-2 w-56">
        <option value="">— Semua —</option>
        @foreach ($categories as $cat)
          <option value="{{ $cat->id }}" {{ ($activeCategoryId == $cat->id) ? 'selected' : '' }}>
            {{ $cat->name }} ({{ $cat->products_count }})
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="text-sm font-medium">Cari</label>
      <input type="text" name="q" value="{{ $q }}" placeholder="Nama produk..."
             class="mt-1 border rounded-md px-3 py-2 w-64" />
    </div>

    <div>
      <button class="mt-6 md:mt-0 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
        Terapkan
      </button>
      <a href="{{ route('home') }}" class="mt-6 md:mt-0 ml-2 inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
        Reset
      </a>
    </div>
  </form>

  {{-- Grid Produk --}}
  @if ($products->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach ($products as $p)
        <div class="bg-white rounded-xl shadow border p-4 flex flex-col">
          <div class="text-xs text-gray-500 mb-1">{{ $p->category_name }}</div>
          <h2 class="font-semibold mb-1">{{ $p->name }}</h2>
          <div class="text-lg font-bold mb-1">Rp {{ number_format($p->price,0,',','.') }}</div>
          <div class="text-sm text-gray-600 mb-4">Stok: {{ $p->stock }}</div>

          <form method="POST" action="{{ route('cart.items.store') }}" class="mt-auto">
            @csrf
            <input type="hidden" name="product_id" value="{{ $p->id }}">
            <label class="text-sm">Qty</label>
            <input type="number" name="qty" value="1" min="1" max="{{ $p->stock }}"
                   class="border rounded-md px-2 py-1 w-20 ml-2" />
            <button class="ml-3 inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-md text-sm">
              + Keranjang
            </button>
          </form>
        </div>
      @endforeach
    </div>

    <div class="mt-6">
      {{ $products->links('pagination::tailwind') }}
    </div>
  @else
    <div class="text-gray-600">Tidak ada produk yang cocok.</div>
  @endif
@endsection
