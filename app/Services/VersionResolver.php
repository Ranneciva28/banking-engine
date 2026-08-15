<?php
namespace App\Services;
use App\Models\Calculator;
use App\Models\CalculatorVersion;
use Carbon\CarbonInterface;

class VersionResolver
{
    public function published(Calculator $calculator, ?CarbonInterface $date = null): CalculatorVersion
    {
        $date ??= now();
        return $calculator->versions()
            ->where('status', 'published')
            ->where(fn($q) => $q->whereNull('effective_from')->orWhere('effective_from','<=',$date->toDateString()))
            ->where(fn($q) => $q->whereNull('effective_to')->orWhere('effective_to','>=',$date->toDateString()))
            ->orderByDesc('effective_from')
            ->firstOrFail();
    }
}
