<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CalculatorCategory extends BaseUuidModel
{
    protected $table = 'public.calculator_categories';
    protected $casts = ['is_active' => 'boolean'];
    public function segment(): BelongsTo { return $this->belongsTo(Segment::class); }
    public function calculators(): HasMany { return $this->hasMany(Calculator::class, 'category_id'); }
}
