<?php
namespace App\Filament\Resources\Calculators\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
class CalculatorForm { public static function configure(Schema $schema):Schema{return $schema->components([Select::make('category_id')->relationship('category','name')->searchable()->required(),TextInput::make('name')->required(),TextInput::make('slug')->required(),Select::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])->required(),Select::make('calculation_type')->options(['calculator'=>'Calculator','assessment'=>'Assessment','hybrid'=>'Hybrid'])->required(),Textarea::make('short_description')->columnSpanFull(),Textarea::make('long_description')->columnSpanFull(),TextInput::make('sort_order')->integer()->default(0)]);} }
