@extends('layouts.app')

@section('content')
  <div class="max-w-md mx-auto bg-white border rounded-xl shadow p-6">
    <h1 class="text-2xl font-semibold mb-4">Masuk</h1>

    @if (session('error'))
      <div class="mb-3 rounded bg-red-100 border border-red-200 text-red-800 px-3 py-2">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
      @csrf
      <div>
        <label class="text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus
               class="mt-1 border rounded-md px-3 py-2 w-full" placeholder="email@example.com" />
        @error('email') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="text-sm font-medium">Password</label>
        <input type="password" name="password" required
               class="mt-1 border rounded-md px-3 py-2 w-full" placeholder="••••••••" />
        @error('password') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>

      <div class="flex items-center justify-between">
        <label class="inline-flex items-center gap-2 text-sm">
          <input type="checkbox" class="rounded border" disabled />
          Ingat saya (demo)
        </label>
        <span class="text-sm text-gray-500">Belum punya akun? (opsional: tambahkan register)</span>
      </div>

      <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
        Login
      </button>
    </form>

    <p class="text-xs text-gray-500 mt-4">
      Gunakan akun yang ada di tabel <code>users</code> (contoh seeder: <em>admin@example.com / secret</em>).
    </p>
  </div>
@endsection
