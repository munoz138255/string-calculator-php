<?php

declare(strict_types=1);

namespace Deg540\StringCalculatorPHP\Test;

use Deg540\StringCalculatorPHP\StringCalculator;
use PHPUnit\Framework\TestCase;

final class StringCalculatorTest extends TestCase
{

    private StringCalculator $stringCalculator;
    // TODO: String Calculator Kata Tests


    protected function setUp(): void{
        parent::setUp();

        $this->stringCalculator = new StringCalculator();
    }
    /**
     * @test
     */
    public function ifInputIsNullReturnZero(): void{
        $result = $this->stringCalculator->add("");

        $this->assertEquals(0, $result);
    }
    /**
     * @test
     */
    public function ifInputIsOneNumberReturnThatIntNumber(): void{
        $result = $this->stringCalculator->add("1");

        $this->assertEquals(1, $result);
    }
    /**
     * @test
     */
    public function ifInputAreTwoNumbersReturnItsSum(): void{
        $result = $this->stringCalculator->add("1,2");

        $this->assertEquals(3, $result);
    }
    /**
     * @test
     */
    public function givenMultipleNumbersReturnItsSum(): void{
        $result = $this->stringCalculator->add("1,2,3,4,5,6,7,8,9");

        $this->assertEquals(45, $result);
    }

    /**
     * @test
     */
    public function givenLineBreakReturnItsSum(): void{
        $result = $this->stringCalculator->add("1\n2,3,4,5,6\n7,8,9");

        $this->assertEquals(45, $result);
    }

    /**
     * @test
     */
    public function givenDelimiterReturnItsSum(): void{
        $result = $this->stringCalculator->add("//:\n1\n2:3:4:5\n6\n7:8:9");

        $this->assertEquals(45, $result);
    }

    /**
     * @test
     */
    public function givenNegativeNumbersThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Negativos no soportados: -2, -3");

        $this->stringCalculator->add("1,-2,-3,4");
    }

    /**
     * @test
     */
    public function givenNumbersGreaterThan1000IgnoreThoseNumbers(): void
    {
        $result = $this->stringCalculator->add("//:\n1\n2:3000:9:4000");

        $this->assertEquals(12, $result);
    }
    /**
     * @test
     */
    public function givenCustomDelimiterBiggerThanOneCharacterReturnsSumOfNumbers(): void
    {
        $result = $this->stringCalculator->add("//[***]\n1***2***3");

        $this->assertEquals(6, $result);
    }
    /**
     * @test
     */
    public function givenMultipleCustomDelimitersReturnsSumOfNumbers(): void
    {
        $result = $this->stringCalculator->add("//[***][;][-]\n1***2;3-4-6\n7");

        $this->assertEquals(23, $result);
    }





}