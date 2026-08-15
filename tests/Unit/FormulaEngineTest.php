<?php
namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
class FormulaEngineTest extends TestCase
{
    public function test_deposit_formula_matches_expected_math(): void
    {
        $e = new ExpressionLanguage();
        $result = $e->evaluate('principal * (annual_rate / 100) * days / 365', ['principal'=>100000000,'annual_rate'=>6,'days'=>30]);
        $this->assertEqualsWithDelta(493150.6849, $result, 0.01);
    }
}
