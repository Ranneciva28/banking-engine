<?php
namespace App\Filament\Resources\CalculatorFormulas\Pages;
use App\Filament\Resources\CalculatorFormulas\CalculatorFormulaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
class ManageCalculatorFormulas extends ManageRecords
{
    protected static string $resource = CalculatorFormulaResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
