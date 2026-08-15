<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CalculatorField extends BaseUuidModel
{
    protected $table = 'public.calculator_fields';
    protected $casts = ['default_value'=>'array','options'=>'array','validation'=>'array','is_required'=>'boolean'];
    public function version(): BelongsTo { return $this->belongsTo(CalculatorVersion::class, 'calculator_version_id'); }
}
