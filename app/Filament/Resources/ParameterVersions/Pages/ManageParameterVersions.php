<?php
namespace App\Filament\Resources\ParameterVersions\Pages;
use App\Filament\Resources\ParameterVersions\ParameterVersionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
class ManageParameterVersions extends ManageRecords
{
    protected static string $resource = ParameterVersionResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
