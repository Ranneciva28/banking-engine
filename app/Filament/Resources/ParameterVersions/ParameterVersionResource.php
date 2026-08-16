<?php
namespace App\Filament\Resources\ParameterVersions;
use App\Filament\Resources\ParameterVersions\Pages\ManageParameterVersions;
use App\Models\ParameterVersion;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class ParameterVersionResource extends Resource
{
    protected static ?string $model = ParameterVersion::class;
    public static function form(Schema $schema): Schema { return $schema->components([
        Select::make('parameter_id')->relationship('parameter','name')->searchable()->preload()->required(),
        KeyValue::make('value')->required()->columnSpanFull()->helperText('Masukkan value terstruktur. Untuk scalar sederhana gunakan key value, misalnya value = 20.'),
        DatePicker::make('effective_from')->required(), DatePicker::make('effective_to'),
        Select::make('status')->options(['draft'=>'Draft','approved'=>'Approved','published'=>'Published','archived'=>'Archived'])->default('draft')->required(),
        Textarea::make('source_note')->columnSpanFull(),
    ]); }
    public static function table(Table $table): Table { return $table->columns([
        TextColumn::make('parameter.name')->label('Parameter')->searchable(), TextColumn::make('status')->badge(), TextColumn::make('effective_from')->date()->sortable(), TextColumn::make('effective_to')->date(), TextColumn::make('source_note')->limit(45)->wrap(),
    ])->recordActions([EditAction::make(),DeleteAction::make()]); }
    public static function getPages(): array { return ['index'=>ManageParameterVersions::route('/')]; }
}
