<?php
namespace App\Filament\Resources\CalculatorFormulas;
use App\Filament\Resources\CalculatorFormulas\Pages\ManageCalculatorFormulas;
use App\Models\CalculatorFormula;
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
class CalculatorFormulaResource extends Resource
{
    protected static ?string $model = CalculatorFormula::class;
    protected static ?string $recordTitleAttribute = 'label';
    public static function form(Schema $schema): Schema { return $schema->components([
        Select::make('calculator_version_id')->relationship('version','version_no')->searchable()->preload()->required(),
        TextInput::make('formula_key')->required()->helperText('Snake case, contoh: monthly_payment'),
        TextInput::make('label')->required(),
        Textarea::make('expression')->required()->rows(4)->helperText('Gunakan field_key dan formula_key sebagai variabel. Contoh: principal * annual_rate / 100')->columnSpanFull(),
        Select::make('output_type')->options(['number'=>'Number','currency'=>'Currency','percentage'=>'Percentage'])->default('number')->required(),
        TextInput::make('unit'), TextInput::make('precision_digits')->integer()->default(2), TextInput::make('sort_order')->integer()->default(0), Toggle::make('is_visible')->default(true),
        Textarea::make('explanation_md')->label('Explanation')->columnSpanFull(),
    ]); }
    public static function table(Table $table): Table { return $table->columns([
        TextColumn::make('version.calculator.name')->label('Calculator')->searchable(), TextColumn::make('version.version_no')->label('Version')->badge(), TextColumn::make('label')->searchable(), TextColumn::make('formula_key')->copyable(), TextColumn::make('output_type')->badge(), IconColumn::make('is_visible')->boolean()->label('Visible'),
    ])->recordActions([EditAction::make(),DeleteAction::make()]); }
    public static function getPages(): array { return ['index'=>ManageCalculatorFormulas::route('/')]; }
}
