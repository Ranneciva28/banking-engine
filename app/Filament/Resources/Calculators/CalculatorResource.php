<?php
namespace App\Filament\Resources\Calculators;
use App\Filament\Resources\Calculators\Pages\CreateCalculator;
use App\Filament\Resources\Calculators\Pages\EditCalculator;
use App\Filament\Resources\Calculators\Pages\ListCalculators;
use App\Filament\Resources\Calculators\Schemas\CalculatorForm;
use App\Filament\Resources\Calculators\Tables\CalculatorsTable;
use App\Models\Calculator;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
class CalculatorResource extends Resource { protected static ?string $model=Calculator::class; protected static ?string $recordTitleAttribute='name'; public static function form(Schema $schema): Schema{return CalculatorForm::configure($schema);} public static function table(Table $table):Table{return CalculatorsTable::configure($table);} public static function getPages():array{return ['index'=>ListCalculators::route('/'),'create'=>CreateCalculator::route('/create'),'edit'=>EditCalculator::route('/{record}/edit')];} }
