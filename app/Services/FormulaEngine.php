<?php
namespace App\Services;

use App\Models\CalculatorFormula;
use App\Models\CalculatorVersion;
use InvalidArgumentException;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class FormulaEngine
{
    public function __construct(private readonly ExpressionLanguage $engine = new ExpressionLanguage()) {}

    public function calculate(CalculatorVersion $version, array $inputs): array
    {
        $context = $this->normalizeInputs($inputs);
        $results = [];
        foreach ($version->formulas()->orderBy('sort_order')->get() as $formula) {
            $expression = $this->normalizeExpression($formula->expression);
            if ($formula->formula_key === 'monthly_payment' && (($context['monthly_rate'] ?? null) === 0.0)) {
                $value = ($context['principal'] ?? 0) / max(1, ($context['months'] ?? 1));
            } else {
                $value = $this->engine->evaluate($expression, $context);
            }
            if (! is_numeric($value)) throw new InvalidArgumentException("Formula {$formula->formula_key} tidak menghasilkan angka.");
            $value = (float) $value;
            $precision = $formula->precision_digits ?? 8;
            $value = round($value, $precision);
            $context[$formula->formula_key] = $value;
            $results[] = ['key'=>$formula->formula_key,'label'=>$formula->label,'value'=>$value,'type'=>$formula->output_type,'unit'=>$formula->unit,'explanation'=>$formula->explanation_md];
        }
        return $results;
    }

    public function validateExpression(string $expression, array $allowedVariables): void
    {
        $expression = $this->normalizeExpression($expression);
        $names = $this->engine->parse($expression, $allowedVariables)->getNodes()->getAttribute('names');
        foreach ((array) $names as $name) if (!in_array($name, $allowedVariables, true)) throw new InvalidArgumentException("Variable {$name} tidak diizinkan.");
    }

    private function normalizeInputs(array $inputs): array
    {
        return collect($inputs)->map(fn($value) => is_numeric($value) ? (float) $value : $value)->all();
    }

    private function normalizeExpression(string $expression): string
    {
        // Existing prototype formulas use ^ for exponent. Symfony uses **.
        return str_replace('^', '**', $expression);
    }
}
