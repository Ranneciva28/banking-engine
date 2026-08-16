<?php
namespace App\Filament\Resources\CalculatorVersions;
use App\Filament\Resources\CalculatorVersions\Pages\ManageCalculatorVersions;
use App\Models\CalculatorVersion;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class CalculatorVersionResource extends Resource
{
    protected static ?string $model = CalculatorVersion::class;
    protected static ?string $recordTitleAttribute = 'version_no';
    public static function form(Schema $schema): Schema { return $schema->components([
        Select::make('calculator_id')->relationship('calculator','name')->searchable()->preload()->required(),
        TextInput::make('version_no')->label('Version')->required(),
        Select::make('status')->options(['draft'=>'Draft','review'=>'Review','approved'=>'Approved','published'=>'Published','archived'=>'Archived'])->default('draft')->required(),
        DatePicker::make('effective_from'), DatePicker::make('effective_to'),
        Textarea::make('change_notes')->columnSpanFull(), Textarea::make('explanation_md')->label('Explanation')->columnSpanFull(),
    ]); }
    public static function table(Table $table): Table { return $table->columns([
        TextColumn::make('calculator.name')->label('Calculator')->searchable()->sortable(), TextColumn::make('version_no')->badge(), TextColumn::make('status')->badge(), TextColumn::make('effective_from')->date(), TextColumn::make('published_at')->dateTime()->toggleable(),
    ])->recordActions([EditAction::make(),DeleteAction::make()]); }
    public static function getPages(): array { return ['index'=>ManageCalculatorVersions::route('/')]; }
}
