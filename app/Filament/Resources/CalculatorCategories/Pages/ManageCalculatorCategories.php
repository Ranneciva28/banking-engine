<?php
namespace App\Filament\Resources\CalculatorCategories\Pages;
use App\Filament\Resources\CalculatorCategories\CalculatorCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
class ManageCalculatorCategories extends ManageRecords
{
    protected static string $resource = CalculatorCategoryResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
