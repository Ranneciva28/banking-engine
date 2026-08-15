<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Parameter extends BaseUuidModel
{
    protected $table = 'public.parameters';
    public function versions(): HasMany { return $this->hasMany(ParameterVersion::class); }
}
