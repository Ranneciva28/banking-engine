<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ParameterVersion extends BaseUuidModel
{
    protected $table = 'public.parameter_versions';
    protected $casts = ['value'=>'array','effective_from'=>'date','effective_to'=>'date'];
    public function parameter(): BelongsTo { return $this->belongsTo(Parameter::class); }
}
