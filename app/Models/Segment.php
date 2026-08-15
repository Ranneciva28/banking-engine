<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Segment extends BaseUuidModel
{
    protected $table = 'public.segments';
    protected $casts = ['is_active' => 'boolean'];
    public function categories(): HasMany { return $this->hasMany(CalculatorCategory::class); }
}
