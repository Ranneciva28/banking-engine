<?php
namespace App\Filament\Resources\Sops;
use App\Filament\Resources\Sops\Pages\ManageSops;
use App\Models\Sop;
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
class SopResource extends Resource
{
    protected static ?string $model = Sop::class;
    protected static ?string $recordTitleAttribute = 'title';
    public static function form(Schema $schema): Schema { return $schema->components([
        TextInput::make('sop_code')->label('SOP Code')->required(), TextInput::make('title')->required(), TextInput::make('organization'),
        Select::make('classification')->options(['internal'=>'Internal','confidential'=>'Confidential','public'=>'Public'])->default('internal')->required(),
        Select::make('status')->options(['draft'=>'Draft','active'=>'Active','superseded'=>'Superseded','archived'=>'Archived'])->default('draft')->required(),
        DatePicker::make('effective_from'), DatePicker::make('effective_to'), TextInput::make('document_path')->label('Document Path / URL')->columnSpanFull(), Textarea::make('summary_md')->label('Summary')->columnSpanFull(),
    ]); }
    public static function table(Table $table): Table { return $table->columns([
        TextColumn::make('sop_code')->label('SOP')->searchable()->copyable(), TextColumn::make('title')->searchable()->wrap(), TextColumn::make('organization')->toggleable(), TextColumn::make('classification')->badge(), TextColumn::make('status')->badge(), TextColumn::make('effective_from')->date()->sortable(),
    ])->recordActions([EditAction::make(),DeleteAction::make()]); }
    public static function getPages(): array { return ['index'=>ManageSops::route('/')]; }
}
