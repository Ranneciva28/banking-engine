<?php
namespace App\Filament\Resources\AuditLogs;
use App\Filament\Resources\AuditLogs\Pages\ListAuditLogs;
use App\Models\AuditLog;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;
    protected static ?string $recordTitleAttribute = 'entity_type';
    public static function form(Schema $schema): Schema { return $schema->components([]); }
    public static function table(Table $table): Table { return $table->columns([
        TextColumn::make('created_at')->dateTime()->sortable(), TextColumn::make('entity_type')->label('Entity')->badge()->searchable(), TextColumn::make('action')->badge(), TextColumn::make('entity_id')->label('Entity ID')->copyable()->limit(24), TextColumn::make('actor_user_id')->label('Actor')->copyable()->toggleable(), TextColumn::make('reason')->limit(50)->wrap(),
    ])->recordActions([]); }
    public static function canCreate(): bool { return false; }
    public static function canEdit($record): bool { return false; }
    public static function canDelete($record): bool { return false; }
    public static function getPages(): array { return ['index'=>ListAuditLogs::route('/')]; }
}
