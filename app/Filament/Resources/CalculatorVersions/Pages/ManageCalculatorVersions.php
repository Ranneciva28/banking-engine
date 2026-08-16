<?php
namespace App\Filament\Resources\CalculatorVersions\Pages;
use App\Filament\Resources\CalculatorVersions\CalculatorVersionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
class ManageCalculatorVersions extends ManageRecords
{
    protected static string $resource = CalculatorVersionResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
