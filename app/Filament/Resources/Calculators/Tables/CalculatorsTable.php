<?php
namespace App\Filament\Resources\Calculators\Tables;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class CalculatorsTable { public static function configure(Table $table):Table{return $table->columns([TextColumn::make('name')->searchable()->sortable(),TextColumn::make('category.segment.name')->label('Segment'),TextColumn::make('category.name')->label('Category'),TextColumn::make('status')->badge(),TextColumn::make('calculation_type')->badge()])->recordActions([EditAction::make()]);} }
