<?php
namespace App\Http\Controllers;

use App\Models\Calculator;
use App\Models\Segment;
use App\Services\FormulaEngine;
use App\Services\VersionResolver;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalculatorController
{
    public function index(): View
    {
        $segments = Segment::query()->where('is_active',true)->with(['categories'=>fn($q)=>$q->where('is_active',true)->with(['calculators'=>fn($q)=>$q->where('status','published')])])->orderBy('sort_order')->get();
        return view('calculators.index', compact('segments'));
    }

    public function show(string $slug, VersionResolver $versions): View
    {
        $calculator = Calculator::where('slug',$slug)->where('status','published')->firstOrFail();
        $version = $versions->published($calculator)->load(['fields','formulas']);
        return view('calculators.show', compact('calculator','version'));
    }

    public function calculate(Request $request, string $slug, VersionResolver $versions, FormulaEngine $engine)
    {
        $calculator = Calculator::where('slug',$slug)->where('status','published')->firstOrFail();
        $version = $versions->published($calculator)->load(['fields','formulas']);
        $rules = [];
        foreach ($version->fields as $field) {
            $rule = [$field->is_required ? 'required' : 'nullable'];
            if (in_array($field->field_type,['number','currency','percentage','integer'],true)) $rule[]='numeric';
            if (($field->validation['min'] ?? null) !== null) $rule[]='min:'.$field->validation['min'];
            if (($field->validation['max'] ?? null) !== null) $rule[]='max:'.$field->validation['max'];
            $rules[$field->field_key]=$rule;
        }
        $inputs = $request->validate($rules);
        return back()->withInput()->with('calculation_results', $engine->calculate($version,$inputs));
    }
}
