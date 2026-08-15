<?php
namespace App\Services;
use App\Models\Parameter;
use Carbon\CarbonInterface;

class ParameterResolver
{
    public function value(string $key, ?CarbonInterface $date = null): mixed
    {
        $date ??= now();
        $parameter = Parameter::where('parameter_key',$key)->firstOrFail();
        $version = $parameter->versions()->where('status','published')
            ->where('effective_from','<=',$date->toDateString())
            ->where(fn($q)=>$q->whereNull('effective_to')->orWhere('effective_to','>=',$date->toDateString()))
            ->orderByDesc('effective_from')->firstOrFail();
        return $version->value;
    }
}
