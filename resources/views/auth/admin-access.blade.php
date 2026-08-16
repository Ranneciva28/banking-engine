<!doctype html>
<html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Access · Banking Engine</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="min-h-screen bg-slate-950 text-slate-100 grid place-items-center px-6">
<div class="w-full max-w-md rounded-3xl border border-white/10 bg-white/[.04] p-7 shadow-2xl">
    <div class="mb-6"><p class="text-sm font-semibold text-sky-400">Banking Engine</p><h1 class="mt-2 text-2xl font-bold">Admin Access Check</h1><p class="mt-2 text-sm text-slate-400">Masukkan email dan password yang lu buat saat setup. Halaman ini akan kasih tahu titik gagalnya secara spesifik.</p></div>
    @if($errors->any())<div class="mb-5 rounded-2xl border border-rose-400/20 bg-rose-400/10 p-4 text-sm text-rose-200"><ul class="space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('admin-access.store') }}" class="space-y-4">@csrf
        <label class="block"><span class="text-sm text-slate-300">Email</span><input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 outline-none focus:border-sky-500"></label>
        <label class="block"><span class="text-sm text-slate-300">Password</span><input type="password" name="password" required class="mt-2 w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 outline-none focus:border-sky-500"></label>
        <button class="w-full rounded-xl bg-sky-500 py-3 font-semibold text-slate-950 hover:bg-sky-400">Cek & Masuk Admin</button>
    </form>
</div>
</body></html>
