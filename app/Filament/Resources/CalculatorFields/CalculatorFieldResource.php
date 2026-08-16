<?php
namespace App\Filament\Resources\CalculatorFields;
use App\Filament\Resources\CalculatorFields\Pages\ManageCalculatorFields;
use App\Models\CalculatorField;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class CalculatorFieldResource extends Resource
{
    protected static ?string $model = CalculatorField::class;
    protected static ?string $recordTitleAttribute = 'label';
    public static function form(Schema $schema): Schema { return $schema->components([
        Select::make('calculator_version_id')->relationship('version','version_no')->searchable()->preload()->required(),
        TextInput::make('field_key')->required()->helperText('Gunakan snake_case, contoh: principal_amount'),
        TextInput::make('label')->required(),
        Select::make('field_type')->options(['number'=>'Number','currency'=>'Currency','percentage'=>'Percentage','integer'=>'Integer','text'=>'Text','select'=>'Select','boolean'=>'Boolean','date'=>'Date'])->required(),
        TextInput::make('unit'), TextInput::make('placeholder'),
        Textarea::make('description')->columnSpanFull(),
        KeyValue::make('validation')->keyLabel('Rule')->valueLabel('Value')->columnSpanFull(),
        Toggle::make('is_required')->default(true), TextInput::make('sort_order')->integer()->default(0),
    ]); }
    public static function table(Table $table): Table { return $table->columns([
        TextColumn::make('version.calculator.name')->label('Calculator')->searchable(), TextColumn::make('version.version_no')->label('Version')->badge(), TextColumn::make('label')->searchable(), TextColumn::make('field_key')->copyable(), TextColumn::make('field_type')->badge(), IconColumn::make('is_required')->boolean()->label('Required'),
    ])->recordActions([EditAction::make(),DeleteAction::make()]); }
    public static function getPages(): array { return ['index'=>ManageCalculatorFields::route('/')]; }
}
