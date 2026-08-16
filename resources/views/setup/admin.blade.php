<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Setup Super Admin · Banking Engine</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 grid place-items-center px-6">
    <div class="w-full max-w-md rounded-3xl border border-white/10 bg-white/[.04] p-8 shadow-2xl">
        <p class="text-sm font-semibold text-sky-400">Banking Engine</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight">Buat Super Admin</h1>
        <p class="mt-3 text-sm leading-6 text-slate-400">Halaman ini hanya aktif jika belum ada super admin aktif. Setelah akun dibuat, halaman setup otomatis tidak bisa dibuka lagi.</p>

        @if ($errors->any())
            <div class="mt-5 rounded-xl border border-rose-400/20 bg-rose-400/10 p-4 text-sm text-rose-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('setup.store') }}" class="mt-7 space-y-5">
            @csrf
            <label class="block">
                <span class="text-sm text-slate-300">Nama</span>
                <input name="name" value="{{ old('name', 'Banking Engine Admin') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 outline-none focus:border-sky-500">
            </label>
            <label class="block">
                <span class="text-sm text-slate-300">Email</span>
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 outline-none focus:border-sky-500">
            </label>
            <label class="block">
                <span class="text-sm text-slate-300">Password baru</span>
                <input type="password" name="password" required minlength="12" class="mt-2 w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 outline-none focus:border-sky-500">
                <span class="mt-1 block text-xs text-slate-500">Minimal 12 karakter.</span>
            </label>
            <label class="block">
                <span class="text-sm text-slate-300">Ulangi password</span>
                <input type="password" name="password_confirmation" required minlength="12" class="mt-2 w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 outline-none focus:border-sky-500">
            </label>
            <button class="w-full rounded-xl bg-sky-400 py-3 font-bold text-slate-950 transition hover:bg-sky-300">Buat Super Admin</button>
        </form>
    </div>
</body>
</html>
