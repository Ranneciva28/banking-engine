<?php
namespace App\Filament\Resources\CalculatorFields\Pages;
use App\Filament\Resources\CalculatorFields\CalculatorFieldResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
class ManageCalculatorFields extends ManageRecords
{
    protected static string $resource = CalculatorFieldResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
