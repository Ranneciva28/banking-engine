<x-layouts.app title="Banking Engine">
@php
    $calculatorCount = $segments->sum(fn($segment) => $segment->categories->sum(fn($category) => $category->calculators->count()));
    $categoryCount = $segments->sum(fn($segment) => $segment->categories->count());
    $segmentMeta = [
        'funding' => ['Dana', 'Simpanan, deposito & funding cost'],
        'lending' => ['Kredit', 'Angsuran, pricing & pembiayaan'],
        'micro-sme' => ['UMKM', 'Kelayakan usaha & cash flow'],
        'corporate' => ['Korporasi', 'Working capital & structured finance'],
        'trade-finance' => ['Trade', 'LC, guarantee & trade fee'],
        'treasury' => ['Treasury', 'FX, forward & money market'],
        'risk' => ['Risk', 'Credit risk & collateral metrics'],
        'financial-analysis' => ['Analisis', 'Rasio & financial diagnostics'],
        'bank-profitability' => ['Profit', 'Margin & bank profitability'],
        'payments' => ['Payments', 'Merchant, fee & settlement'],
    ];
@endphp

<section class="mx-auto max-w-[1440px] px-5 pb-20 pt-10 sm:px-8 lg:px-10 lg:pt-14">
    <div class="grid items-center gap-10 lg:grid-cols-[1.15fr_.85fr] lg:gap-16">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-sky-400/15 bg-sky-400/[.07] px-3 py-1.5 text-xs font-semibold text-sky-300">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_14px_rgba(52,211,153,.8)]"></span>
                Dynamic banking calculation engine
            </div>
            <h1 class="mt-6 max-w-4xl text-4xl font-bold tracking-[-.04em] text-white sm:text-5xl lg:text-[4.2rem] lg:leading-[1.03]">
                Satu workspace untuk <span class="bg-gradient-to-r from-sky-300 to-blue-400 bg-clip-text text-transparent">kalkulasi banking.</span>
            </h1>
            <p class="mt-6 max-w-2xl text-base leading-7 text-slate-400 sm:text-lg">
                Hitung rasio, pricing, bunga, fee, dan analisis perbankan tanpa bongkar spreadsheet atau menghafal rumus. Semua formula dan versi dibaca langsung dari database.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#calculators" class="inline-flex items-center gap-2 rounded-xl bg-sky-400 px-5 py-3 text-sm font-bold text-slate-950 shadow-lg shadow-sky-500/20 transition hover:bg-sky-300">
                    Jelajahi kalkulator
                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-none stroke-current" stroke-width="2"><path d="M5 12h14m-5-5 5 5-5 5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <a href="/admin" class="rounded-xl border border-white/10 bg-white/[.04] px-5 py-3 text-sm font-semibold text-slate-300 transition hover:bg-white/[.08] hover:text-white">Kelola konten</a>
            </div>
        </div>

        <div class="relative">
            <div class="absolute inset-10 rounded-full bg-sky-500/20 blur-3xl"></div>
            <div class="glass soft-ring relative overflow-hidden rounded-[28px] p-5 shadow-glow sm:p-6">
                <div class="flex items-center justify-between border-b border-white/[.07] pb-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[.16em] text-slate-500">Engine overview</p>
                        <p class="mt-1 text-lg font-bold text-white">Live calculation library</p>
                    </div>
                    <span class="rounded-lg bg-emerald-400/10 px-2.5 py-1 text-[11px] font-bold text-emerald-300">ONLINE</span>
                </div>
                <div class="grid grid-cols-3 gap-3 py-5">
                    <div class="rounded-2xl bg-white/[.045] p-4"><p class="text-2xl font-bold text-white">{{ $segments->count() }}</p><p class="mt-1 text-xs text-slate-500">Segmen</p></div>
                    <div class="rounded-2xl bg-white/[.045] p-4"><p class="text-2xl font-bold text-white">{{ $categoryCount }}</p><p class="mt-1 text-xs text-slate-500">Kategori</p></div>
                    <div class="rounded-2xl bg-white/[.045] p-4"><p class="text-2xl font-bold text-sky-300">{{ $calculatorCount }}</p><p class="mt-1 text-xs text-slate-500">Kalkulator</p></div>
                </div>
                <div class="space-y-3 border-t border-white/[.07] pt-5">
                    @foreach($segments->take(4) as $segment)
                        @php $count = $segment->categories->sum(fn($category) => $category->calculators->count()); @endphp
                        <div class="flex items-center gap-3">
                            <div class="grid h-8 w-8 place-items-center rounded-lg bg-sky-400/10 text-xs font-bold text-sky-300">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                            <div class="min-w-0 flex-1"><p class="truncate text-sm font-semibold text-slate-200">{{ $segment->name }}</p><div class="mt-1 h-1 rounded-full bg-white/[.06]"><div class="h-1 rounded-full bg-gradient-to-r from-sky-400 to-blue-500" style="width: {{ min(100, max(12, $count * 28)) }}%"></div></div></div>
                            <span class="text-xs font-medium text-slate-500">{{ $count }} tools</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="calculators" class="mt-20 scroll-mt-24">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[.2em] text-sky-400">Calculation Library</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl">Pilih area banking</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">Cari kalkulator berdasarkan produk, rasio, atau kebutuhan analisis.</p>
            </div>
            <label class="relative block w-full lg:w-[420px]">
                <svg viewBox="0 0 24 24" class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 fill-none stroke-slate-500" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5" stroke-linecap="round"/></svg>
                <input id="calculatorSearch" type="search" placeholder="Cari: deposito, DSCR, LTV, NIM..." class="w-full rounded-2xl border border-white/10 bg-white/[.045] py-3.5 pl-11 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-sky-400/40 focus:bg-white/[.065]">
            </label>
        </div>

        <div id="segmentGrid" class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($segments as $segment)
                @php
                    $count = $segment->categories->sum(fn($category) => $category->calculators->count());
                    [$shortName, $descriptor] = $segmentMeta[$segment->slug] ?? [$segment->name, $segment->description ?: 'Banking calculation tools'];
                @endphp
                <article data-search-card data-search-text="{{ strtolower($segment->name.' '.$shortName.' '.$descriptor.' '.$segment->categories->pluck('name')->implode(' ').' '.$segment->categories->flatMap->calculators->pluck('name')->implode(' ')) }}" class="group overflow-hidden rounded-[24px] border border-white/[.075] bg-white/[.035] transition duration-300 hover:-translate-y-1 hover:border-sky-400/25 hover:bg-white/[.055] hover:shadow-2xl hover:shadow-sky-950/30">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="grid h-11 w-11 place-items-center rounded-2xl border border-sky-400/10 bg-gradient-to-br from-sky-400/15 to-blue-500/5 text-sky-300">
                                @switch($segment->slug)
                                    @case('funding') <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current" stroke-width="1.8"><path d="M3 9 12 4l9 5-9 5-9-5Z"/><path d="M5 12v5m4-3v5m6-5v5m4-7v5M3 20h18"/></svg> @break
                                    @case('lending') <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current" stroke-width="1.8"><path d="M4 7h12m-8-4-4 4 4 4M20 17H8m8-4 4 4-4 4"/></svg> @break
                                    @case('treasury') <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current" stroke-width="1.8"><path d="m4 16 5-5 4 4 7-8"/><path d="M15 7h5v5"/></svg> @break
                                    @case('risk') <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current" stroke-width="1.8"><path d="M12 3 5 6v5c0 4.6 2.9 8 7 10 4.1-2 7-5.4 7-10V6l-7-3Z"/><path d="m9 12 2 2 4-5"/></svg> @break
                                    @default <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current" stroke-width="1.8"><rect x="4" y="4" width="16" height="16" rx="3"/><path d="M8 9h8M8 13h3m3 0h2M8 17h2m3 0h3"/></svg>
                                @endswitch
                            </div>
                            <span class="rounded-full border border-white/[.07] bg-white/[.04] px-2.5 py-1 text-[11px] font-semibold text-slate-500">{{ $count }} kalkulator</span>
                        </div>
                        <h3 class="mt-5 text-xl font-bold tracking-tight text-white">{{ $segment->name }}</h3>
                        <p class="mt-1.5 min-h-10 text-sm leading-5 text-slate-500">{{ $descriptor }}</p>

                        <div class="mt-5 space-y-2">
                            @forelse($segment->categories as $category)
                                @foreach($category->calculators as $calculator)
                                    <a href="{{ route('calculator.show', $calculator->slug) }}" class="flex items-center gap-3 rounded-xl border border-transparent bg-white/[.025] px-3.5 py-3 transition hover:border-sky-400/15 hover:bg-sky-400/[.06]">
                                        <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-white/[.05] text-slate-400 transition group-hover:text-sky-300">
                                            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 fill-none stroke-current" stroke-width="2"><path d="M7 3h10a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/><path d="M8 7h8M8 11h2m3 0h3M8 15h2m3 0h3"/></svg>
                                        </span>
                                        <span class="min-w-0 flex-1"><span class="block truncate text-sm font-semibold text-slate-300">{{ $calculator->name }}</span><span class="block truncate text-[11px] text-slate-600">{{ $category->name }}</span></span>
                                        <svg viewBox="0 0 24 24" class="h-4 w-4 shrink-0 fill-none stroke-slate-600 transition group-hover:translate-x-0.5 group-hover:stroke-sky-300" stroke-width="2"><path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </a>
                                @endforeach
                            @empty
                                <div class="rounded-xl border border-dashed border-white/10 px-4 py-4 text-xs text-slate-600">Belum ada kalkulator aktif.</div>
                            @endforelse
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <div id="emptySearch" class="mt-8 hidden rounded-2xl border border-dashed border-white/10 bg-white/[.02] px-6 py-10 text-center text-sm text-slate-500">Tidak ada kalkulator yang cocok dengan pencarian.</div>
    </div>

    <div class="mt-16 grid gap-4 lg:grid-cols-3">
        <div class="rounded-2xl border border-white/[.07] bg-white/[.025] p-5"><p class="text-sm font-bold text-white">Version controlled</p><p class="mt-2 text-sm leading-6 text-slate-500">Setiap formula dapat punya versi efektif, sehingga perubahan tidak perlu menimpa histori kalkulasi.</p></div>
        <div class="rounded-2xl border border-white/[.07] bg-white/[.025] p-5"><p class="text-sm font-bold text-white">Database driven</p><p class="mt-2 text-sm leading-6 text-slate-500">Field input, formula, parameter, dan konten kalkulator dibaca dari database—bukan ditanam di halaman.</p></div>
        <div class="rounded-2xl border border-white/[.07] bg-white/[.025] p-5"><p class="text-sm font-bold text-white">Governance ready</p><p class="mt-2 text-sm leading-6 text-slate-500">Arsitektur siap mengaitkan kalkulator dengan regulasi, SOP, approval, dan audit trail melalui admin workspace.</p></div>
    </div>
</section>

<script>
    (() => {
        const input = document.getElementById('calculatorSearch');
        const cards = [...document.querySelectorAll('[data-search-card]')];
        const empty = document.getElementById('emptySearch');
        if (!input) return;
        input.addEventListener('input', () => {
            const q = input.value.toLowerCase().trim();
            let visible = 0;
            cards.forEach(card => {
                const show = !q || card.dataset.searchText.includes(q);
                card.dataset.searchHidden = show ? 'false' : 'true';
                if (show) visible++;
            });
            empty.classList.toggle('hidden', visible !== 0);
        });
    })();
</script>
</x-layouts.app>
