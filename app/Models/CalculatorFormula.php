<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CalculatorFormula extends BaseUuidModel
{
    protected $table = 'public.calculator_formulas';
    protected $casts = ['is_visible'=>'boolean'];
    public function version(): BelongsTo { return $this->belongsTo(CalculatorVersion::class, 'calculator_version_id'); }
}
