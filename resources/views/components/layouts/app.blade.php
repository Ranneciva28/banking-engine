<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-color" content="#07111f">
    <title>{{ $title ?? 'Banking Engine' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                    boxShadow: { glow: '0 24px 80px rgba(14,165,233,.14)' }
                }
            }
        }
    </script>
    <style>
        body{background:#07111f}
        .grid-noise{background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);background-size:42px 42px}
        .glass{background:rgba(15,28,47,.72);backdrop-filter:blur(18px)}
        .soft-ring{box-shadow:inset 0 0 0 1px rgba(255,255,255,.08)}
        [data-search-hidden="true"]{display:none!important}
    </style>
</head>
<body class="min-h-screen text-slate-100 antialiased selection:bg-sky-300 selection:text-slate-950">
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -top-40 left-1/4 h-[36rem] w-[36rem] rounded-full bg-sky-500/10 blur-3xl"></div>
        <div class="absolute top-1/3 -right-40 h-[30rem] w-[30rem] rounded-full bg-blue-600/10 blur-3xl"></div>
        <div class="absolute inset-0 grid-noise opacity-70"></div>
    </div>

    <div class="relative min-h-screen">
        <header class="sticky top-0 z-50 border-b border-white/[.07] bg-[#07111f]/85 backdrop-blur-xl">
            <div class="mx-auto flex h-16 max-w-[1440px] items-center justify-between px-5 sm:px-8 lg:px-10">
                <a href="{{ route('home') }}" class="group flex items-center gap-3">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-sky-400 to-blue-600 shadow-lg shadow-sky-500/20">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-white" stroke-width="2"><path d="M4 18V9m5 9V5m5 13v-7m5 7V3" stroke-linecap="round"/><path d="M3 21h18" stroke-linecap="round"/></svg>
                    </span>
                    <span>
                        <span class="block text-[15px] font-bold tracking-tight text-white">Banking Engine</span>
                        <span class="hidden text-[10px] font-medium uppercase tracking-[.18em] text-slate-500 sm:block">Calculation & Decision Workspace</span>
                    </span>
                </a>
                <nav class="flex items-center gap-2">
                    <a href="{{ route('home') }}#calculators" class="hidden rounded-lg px-3 py-2 text-sm font-medium text-slate-400 transition hover:bg-white/5 hover:text-white md:block">Kalkulator</a>
                    <a href="/admin" class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/[.055] px-3.5 py-2 text-sm font-semibold text-slate-200 transition hover:border-sky-400/30 hover:bg-sky-400/10 hover:text-white">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-none stroke-current" stroke-width="1.8"><path d="M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z"/><path d="M4.5 21a7.5 7.5 0 0 1 15 0"/></svg>
                        Admin
                    </a>
                </nav>
            </div>
        </header>

        <main>{{ $slot }}</main>

        <footer class="border-t border-white/[.06] py-8">
            <div class="mx-auto flex max-w-[1440px] flex-col gap-2 px-5 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-8 lg:px-10">
                <p>Banking Engine · dynamic calculation platform</p>
                <p>Formula, parameter, versi, dan governance dikelola dari database.</p>
            </div>
        </footer>
    </div>
</body>
</html>
