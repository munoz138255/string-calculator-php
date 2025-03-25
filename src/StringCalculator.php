<?php

namespace Deg540\StringCalculatorPHP;

class StringCalculator
{
    public function __construct()
    {
    }

    // TODO: String Calculator Kata
    public function add(string $numbers): int
    {
        if ($this->isEmpty($numbers)) {
            return 0;
        }

        $numbersArray = $this->cleanArray($numbers);

        if ($this->isOnlyOneNumber($numbersArray)) {
            return (int)$numbersArray[0];
        }

        $numbersArray = $this->validateNumbers($numbersArray);
        return $this->getSum($numbersArray);
    }

    /**
     * @param string $numbers
     * @return bool
     */
    public function isEmpty(string $numbers): bool
    {
        return empty($numbers);
    }

    /**
     * @param array $numbersArray
     * @return bool
     */
    public function isOnlyOneNumber(array $numbersArray): bool
    {
        return count($numbersArray) === 1;
    }

    /**
     * @param array $numbersArray
     * @return array
     */
    function validateNumbers(array $numbersArray): array
    {
        $negativeNumbers = array_filter($numbersArray, fn($num) => (int)$num < 0);

        if (!empty($negativeNumbers)) {
            throw new \InvalidArgumentException("Negativos no soportados: " . implode(", ", $negativeNumbers));
        }
        return array_filter($numbersArray, fn($num) => (int)$num < 1000);
    }

    /**
     * @param array $numbersArray
     * @return int
     */
    public function getSum(array $numbersArray): int
    {
       return array_sum($numbersArray);
    }

    /**
     * @param string $numbers
     * @return string[]
     */
    public function cleanArray(string $numbers): array
    {
        list($delimiters, $numbers) = $this->obtainDelimiter($numbers);

        $delimitersPattern = '/' . implode('|', array_map('preg_quote', $delimiters)) . '/';

        $numbers = preg_replace($delimitersPattern, ",", $numbers);

        $numbers = preg_replace('/,{2,}/', ",", trim($numbers, ","));

        return array_filter(explode(",", $numbers), fn($value) => $value !== "");
    }
    /**
     * @param string $input
     * @return array
     */
    public function obtainDelimiter(string $input): array
    {
        if (!str_starts_with($input, "//")) {
            return [[",", "\n"], $input];
        }

        $endOfDelimiters = strpos($input, "\n");
        $delimiterPart = substr($input, 2, $endOfDelimiters - 2);
        $numbers = substr($input, $endOfDelimiters + 1);

        preg_match_all('/\[(.*?)\]/', $delimiterPart, $matches);

        $delimiters = !empty($matches[1]) ? $matches[1] : [$delimiterPart];

        $delimiters[] = "\n";

        return [$delimiters, $numbers];
    }
}
