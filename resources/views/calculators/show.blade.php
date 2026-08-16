<x-layouts.app :title="$calculator->name">
@php
    $category = $calculator->category;
    $segment = $category?->segment;
    $results = session('calculation_results');
@endphp

<section class="mx-auto max-w-[1440px] px-5 pb-20 pt-8 sm:px-8 lg:px-10">
    <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
        <a href="{{ route('home') }}" class="transition hover:text-sky-300">Banking Engine</a>
        <span>/</span>
        @if($segment)<span>{{ $segment->name }}</span><span>/</span>@endif
        @if($category)<span>{{ $category->name }}</span><span>/</span>@endif
        <span class="text-slate-300">{{ $calculator->name }}</span>
    </div>

    <div class="mt-7 grid gap-8 xl:grid-cols-[minmax(0,1.05fr)_minmax(360px,.72fr)] xl:items-start">
        <div class="min-w-0">
            <div class="rounded-[28px] border border-white/[.075] bg-white/[.028] p-6 sm:p-8">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                    <div class="max-w-3xl">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full border border-sky-400/15 bg-sky-400/[.07] px-2.5 py-1 text-[11px] font-bold uppercase tracking-[.14em] text-sky-300">{{ $category?->name ?? 'Calculator' }}</span>
                            <span class="rounded-full border border-white/[.07] bg-white/[.035] px-2.5 py-1 text-[11px] font-semibold text-slate-500">Version {{ $version->version_no }}</span>
                            @if($version->effective_from)<span class="rounded-full border border-white/[.07] bg-white/[.035] px-2.5 py-1 text-[11px] font-semibold text-slate-500">Efektif {{ \Carbon\Carbon::parse($version->effective_from)->format('d M Y') }}</span>@endif
                        </div>
                        <h1 class="mt-5 text-3xl font-bold tracking-[-.03em] text-white sm:text-4xl lg:text-5xl">{{ $calculator->name }}</h1>
                        <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-400 sm:text-base">{{ $calculator->long_description ?: $calculator->short_description }}</p>
                    </div>
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl border border-sky-400/10 bg-sky-400/[.08] text-sky-300">
                        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-none stroke-current" stroke-width="1.8"><rect x="4" y="3" width="16" height="18" rx="3"/><path d="M8 7h8M8 11h2m3 0h3M8 15h2m3 0h3"/></svg>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('calculator.calculate', $calculator->slug) }}" class="mt-5 overflow-hidden rounded-[28px] border border-white/[.075] bg-[#0b1728]/80 shadow-2xl shadow-black/10">
                @csrf
                <div class="flex items-center justify-between border-b border-white/[.07] px-6 py-5 sm:px-8">
                    <div>
                        <p class="text-sm font-bold text-white">Input perhitungan</p>
                        <p class="mt-1 text-xs text-slate-500">Masukkan parameter sesuai periode dan basis data yang sama.</p>
                    </div>
                    <span class="hidden text-[11px] font-semibold uppercase tracking-[.14em] text-slate-600 sm:block">{{ $version->fields->count() }} parameters</span>
                </div>

                <div class="grid gap-5 p-6 sm:p-8 md:grid-cols-2">
                    @foreach($version->fields as $field)
                        <label class="block {{ $version->fields->count() <= 2 ? 'md:col-span-1' : '' }}">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-sm font-semibold text-slate-300">{{ $field->label }}</span>
                                @if(!$field->is_required)<span class="text-[10px] uppercase tracking-wider text-slate-600">Optional</span>@endif
                            </div>
                            @if($field->description)<p class="mt-1 min-h-8 text-[11px] leading-4 text-slate-600">{{ $field->description }}</p>@else<p class="mt-1 min-h-8 text-[11px] leading-4 text-transparent">.</p>@endif
                            <div class="relative mt-2">
                                @if($field->unit)
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 rounded-md bg-white/[.045] px-2 py-1 text-[11px] font-semibold text-slate-500">{{ $field->unit }}</span>
                                @endif
                                <input
                                    name="{{ $field->field_key }}"
                                    value="{{ old($field->field_key, is_array($field->default_value) ? ($field->default_value[0] ?? null) : $field->default_value) }}"
                                    type="{{ in_array($field->field_type, ['number','currency','percentage','integer']) ? 'number' : 'text' }}"
                                    step="{{ $field->field_type === 'integer' ? '1' : 'any' }}"
                                    @if(($field->validation['min'] ?? null) !== null) min="{{ $field->validation['min'] }}" @endif
                                    @if(($field->validation['max'] ?? null) !== null) max="{{ $field->validation['max'] }}" @endif
                                    placeholder="{{ $field->placeholder ?: 'Masukkan '.$field->label }}"
                                    class="w-full rounded-2xl border border-white/[.08] bg-white/[.035] px-4 py-3.5 text-sm font-medium text-white outline-none transition placeholder:text-slate-700 focus:border-sky-400/40 focus:bg-white/[.055] {{ $field->unit ? 'pr-20' : '' }}"
                                >
                            </div>
                            @error($field->field_key)<span class="mt-1.5 block text-xs font-medium text-rose-400">{{ $message }}</span>@enderror
                        </label>
                    @endforeach
                </div>

                <div class="border-t border-white/[.07] bg-white/[.018] px-6 py-5 sm:px-8">
                    <button class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-sky-400 to-blue-500 px-5 py-3.5 text-sm font-bold text-slate-950 shadow-lg shadow-sky-500/15 transition hover:from-sky-300 hover:to-blue-400 sm:w-auto sm:min-w-48">
                        Hitung sekarang
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-none stroke-current" stroke-width="2"><path d="M5 12h14m-5-5 5 5-5 5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </form>

            <div class="mt-5 grid gap-4 lg:grid-cols-2">
                <div class="rounded-2xl border border-white/[.07] bg-white/[.025] p-5">
                    <div class="flex items-center gap-2"><svg viewBox="0 0 24 24" class="h-4 w-4 fill-none stroke-sky-300" stroke-width="2"><path d="M12 3 4 7v5c0 4.5 3 7.5 8 9 5-1.5 8-4.5 8-9V7l-8-4Z"/></svg><p class="text-sm font-bold text-white">Governance note</p></div>
                    <p class="mt-3 text-xs leading-6 text-slate-500">{{ $version->explanation_md ?: 'Formula berasal dari versi kalkulator aktif. Threshold keputusan, pricing final, dan ketentuan produk harus mengikuti regulasi/SOP yang berlaku.' }}</p>
                </div>
                <div class="rounded-2xl border border-white/[.07] bg-white/[.025] p-5">
                    <div class="flex items-center gap-2"><svg viewBox="0 0 24 24" class="h-4 w-4 fill-none stroke-sky-300" stroke-width="2"><path d="M8 6h8M8 10h8M8 14h5M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/></svg><p class="text-sm font-bold text-white">Formula transparency</p></div>
                    <div class="mt-3 space-y-2">
                        @foreach($version->formulas->where('is_visible', true)->take(3) as $formula)
                            <div class="rounded-xl bg-black/15 px-3 py-2"><p class="text-[11px] font-semibold text-slate-400">{{ $formula->label }}</p><code class="mt-1 block overflow-hidden text-ellipsis whitespace-nowrap text-[10px] text-slate-600">{{ $formula->expression }}</code></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <aside class="xl:sticky xl:top-24">
            @if($results)
                <div class="overflow-hidden rounded-[28px] border border-sky-400/15 bg-gradient-to-br from-sky-400/[.13] via-[#0d1b2d] to-[#0a1626] shadow-2xl shadow-sky-950/30">
                    <div class="border-b border-white/[.08] p-6 sm:p-7">
                        <div class="flex items-center justify-between gap-4">
                            <div><p class="text-[11px] font-bold uppercase tracking-[.17em] text-sky-300">Calculation result</p><h2 class="mt-1 text-xl font-bold text-white">Hasil perhitungan</h2></div>
                            <div class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-400/10 text-emerald-300"><svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current" stroke-width="2"><path d="m5 12 4 4L19 6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                        </div>
                    </div>
                    <div class="divide-y divide-white/[.07]">
                        @foreach($results as $result)
                            <div class="p-6 sm:px-7">
                                <p class="text-xs font-semibold text-slate-500">{{ $result['label'] }}</p>
                                <p class="mt-1 break-words text-2xl font-bold tracking-tight text-white sm:text-3xl">
                                    @if($result['type'] === 'currency')
                                        <span class="mr-1 text-base font-semibold text-slate-500">Rp</span>{{ number_format($result['value'], 0, ',', '.') }}
                                    @elseif($result['type'] === 'percentage')
                                        {{ number_format($result['value'], 2, ',', '.') }}<span class="ml-1 text-base font-semibold text-slate-500">%</span>
                                    @else
                                        {{ number_format($result['value'], $result['type'] === 'integer' ? 0 : 2, ',', '.') }}@if(!empty($result['unit']) && $result['unit'] !== 'decimal')<span class="ml-1.5 text-base font-semibold text-slate-500">{{ $result['unit'] }}</span>@endif
                                    @endif
                                </p>
                                @if($result['explanation'])<p class="mt-2 text-xs leading-5 text-slate-500">{{ $result['explanation'] }}</p>@endif
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-white/[.08] bg-black/10 px-6 py-4 text-[10px] leading-4 text-slate-600 sm:px-7">Hasil bersifat kalkulatif berdasarkan input dan formula versi aktif; bukan keputusan kredit, quotation transaksi, atau pengganti kebijakan bank.</div>
                </div>
            @else
                <div class="rounded-[28px] border border-white/[.075] bg-white/[.025] p-7">
                    <div class="grid h-12 w-12 place-items-center rounded-2xl border border-dashed border-sky-400/25 bg-sky-400/[.06] text-sky-300">
                        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-none stroke-current" stroke-width="1.7"><path d="M4 19V8m5 11V4m5 15v-7m5 7V9" stroke-linecap="round"/></svg>
                    </div>
                    <h2 class="mt-5 text-xl font-bold text-white">Hasil akan muncul di sini</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Isi parameter di workspace lalu tekan <span class="font-semibold text-slate-300">Hitung sekarang</span>. Engine akan menjalankan formula versi aktif secara berurutan.</p>
                    <div class="mt-6 space-y-3 border-t border-white/[.07] pt-5 text-xs text-slate-600">
                        <div class="flex items-center justify-between"><span>Version</span><span class="font-semibold text-slate-400">{{ $version->version_no }}</span></div>
                        <div class="flex items-center justify-between"><span>Input</span><span class="font-semibold text-slate-400">{{ $version->fields->count() }} parameter</span></div>
                        <div class="flex items-center justify-between"><span>Output formula</span><span class="font-semibold text-slate-400">{{ $version->formulas->count() }}</span></div>
                    </div>
                </div>
            @endif
        </aside>
    </div>
</section>
</x-layouts.app>
