<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CalculatorVersion extends BaseUuidModel
{
    protected $table = 'public.calculator_versions';
    protected $casts = ['effective_from'=>'date','effective_to'=>'date','published_at'=>'datetime'];
    public function calculator(): BelongsTo { return $this->belongsTo(Calculator::class); }
    public function fields(): HasMany { return $this->hasMany(CalculatorField::class)->orderBy('sort_order'); }
    public function formulas(): HasMany { return $this->hasMany(CalculatorFormula::class)->orderBy('sort_order'); }
}
