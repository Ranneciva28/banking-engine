<?php
namespace App\Filament\Widgets;
use App\Models\Calculator;
use App\Models\CalculatorVersion;
use App\Models\Regulation;
use App\Models\Segment;
use App\Models\Sop;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
class EngineOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Segments', Segment::query()->where('is_active', true)->count())->description('Active business domains'),
            Stat::make('Calculators', Calculator::query()->count())->description(Calculator::query()->where('status','published')->count().' published'),
            Stat::make('Versions', CalculatorVersion::query()->count())->description(CalculatorVersion::query()->where('status','published')->count().' published'),
            Stat::make('Governance Sources', Regulation::query()->count() + Sop::query()->count())->description(Regulation::query()->count().' regulations · '.Sop::query()->count().' SOPs'),
            Stat::make('Admin Users', User::query()->where('is_active', true)->count())->description('Active panel accounts'),
        ];
    }
}
