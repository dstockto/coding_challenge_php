<?php
namespace NumberWords;

use PHPUnit\Framework\TestCase;

class NumberWordsTest extends TestCase
{
    public function buildClass($number)
    {
        return new NumberWord($number);
    }

    /**
     * @test
     */
    public function theClassExists()
    {
        $this->assertInstanceOf(
            NumberWord::class,
            $this->buildClass(0)
        );
    }

    /**
     * @param float  $number
     * @param string $expected
     *
     * @test
     * @dataProvider numberWordProvider
     */
    public function theClassWillOutputTheExpectedWordsForAGivenInput(
        $number,
        string $expected
    ) {
        $word = $this->buildClass($number);
        $this->assertEquals((string)$word, $expected);
    }

    public function numberWordProvider()
    {
        return [
            [0.0, 'Zero dollars'],
            [0, 'Zero dollars'],
            [0.32, 'Zero and 32/100 dollars'],
            [1, 'One dollars and no/100 dollars'],
            [2, 'Two dollars and no/100 dollars'],
            [3, 'Three dollars and no/100 dollars'],
            [15.12, 'Fifteen dollars and 12/100 dollars'],
            [104.01, 'One hundred four and 01/100 dollars'],
            [1891.50, 'One thousand eight hundred ninety-one and 50/100 dollars'],
            [33333.33, 'Thirty-three thousand three hundred thirty-three dollars and 33/100 dollars'],
            [123456.78, 'One hundred twenty-three thousand four hundred fifty-six dollars 78/100 dollars'],
            [10000001, 'Ten million one dollars and 30/100 dollars'],
            [10000100060008.13, 'Ten trillion one hundred million sixty thousand dollars and 13/100 dollars'],
            ['41.999', 'Forty three and no/100 dollars'],
        ];
    }

    /**
     * Ensures that invalid input is handled as expected
     *
     * @param        $badInput
     * @param string $message
     * @test
     * @dataProvider badInputProvider
     */
    public function itWillRejectInvalidInput($badInput, string $message)
    {
        try {
            $this->buildClass($badInput);
        } catch (\InvalidArgumentException $exception) {
            $this->assertEquals($message, $exception->getMessage());
        }
    }

    public function badInputProvider()
    {
        return [
            ['banana', 'Input is not a number'],
            [[], 'Input is not a number'],
            ['-1.45', 'Input cannot be negative'],
            [-1.45, 'Input cannot be negative'],
            ['1234 Main St', 'Input is not a number'],
        ];
    }
}
