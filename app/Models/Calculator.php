<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Calculator extends BaseUuidModel
{
    protected $table = 'public.calculators';
    public function category(): BelongsTo { return $this->belongsTo(CalculatorCategory::class, 'category_id'); }
    public function versions(): HasMany { return $this->hasMany(CalculatorVersion::class); }
}
