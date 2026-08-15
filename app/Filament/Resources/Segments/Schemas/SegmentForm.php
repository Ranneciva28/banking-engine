<?php
namespace App\Filament\Resources\Segments\Schemas;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
class SegmentForm { public static function configure(Schema $schema): Schema { return $schema->components([TextInput::make('name')->required()->maxLength(255),TextInput::make('slug')->required()->maxLength(255),Textarea::make('description')->columnSpanFull(),TextInput::make('sort_order')->integer()->default(0),Toggle::make('is_active')->default(true)]); } }
