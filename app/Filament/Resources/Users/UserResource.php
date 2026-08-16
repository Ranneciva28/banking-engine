<?php
namespace App\Filament\Resources\Users;
use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Schema $schema): Schema { return $schema->components([
        TextInput::make('name')->required()->maxLength(120),
        TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
        TextInput::make('password')->password()->revealable()->required(fn (string $operation): bool => $operation === 'create')->dehydrated(fn ($state): bool => filled($state))->helperText('Kosongkan saat edit kalau password tidak ingin diubah.'),
        Select::make('role')->options(['super_admin'=>'Super Admin','admin'=>'Admin','maker'=>'Maker','checker'=>'Checker','approver'=>'Approver','viewer'=>'Viewer'])->required()->default('viewer'),
        Toggle::make('is_active')->default(true),
    ]); }
    public static function table(Table $table): Table { return $table->columns([
        TextColumn::make('name')->searchable()->sortable(), TextColumn::make('email')->searchable()->copyable(), TextColumn::make('role')->badge(), IconColumn::make('is_active')->boolean()->label('Active'), TextColumn::make('created_at')->dateTime()->sortable(),
    ])->recordActions([EditAction::make(),DeleteAction::make()]); }
    public static function getPages(): array { return ['index'=>ManageUsers::route('/')]; }
}
