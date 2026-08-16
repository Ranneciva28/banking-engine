<?php
namespace App\Filament\Resources\CalculatorCategories;
use App\Filament\Resources\CalculatorCategories\Pages\ManageCalculatorCategories;
use App\Models\CalculatorCategory;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class CalculatorCategoryResource extends Resource
{
    protected static ?string $model = CalculatorCategory::class;
    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Schema $schema): Schema { return $schema->components([
        Select::make('segment_id')->relationship('segment','name')->searchable()->preload()->required(),
        TextInput::make('name')->required(), TextInput::make('slug')->required(),
        Textarea::make('description')->columnSpanFull(), TextInput::make('sort_order')->integer()->default(0), Toggle::make('is_active')->default(true),
    ]); }
    public static function table(Table $table): Table { return $table->columns([
        TextColumn::make('name')->searchable()->sortable(), TextColumn::make('segment.name')->label('Segment')->sortable(), TextColumn::make('slug')->searchable(), IconColumn::make('is_active')->boolean()->label('Active'),
    ])->recordActions([EditAction::make(),DeleteAction::make()]); }
    public static function getPages(): array { return ['index'=>ManageCalculatorCategories::route('/')]; }
}
