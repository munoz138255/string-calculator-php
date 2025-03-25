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
     * @return int|mixed
     */
    public function getSum(array $numbersArray): int
    {
        $sum = 0;
        $negativeNumbers = [];

        foreach ($numbersArray as $number) {
            $currentNumber = (int)$number;

            if ($currentNumber < 0) {
                $negativeNumbers[] = $currentNumber; // Agregamos al array
            }
            if($currentNumber < 1000){
                $sum += $currentNumber;
            }
        }

        if (!empty($negativeNumbers)) {
            throw new \InvalidArgumentException("negativos no soportados: " . implode(", ", $negativeNumbers));
        }

        return $sum;
    }
    /**
     * @param string $numbers
     * @param string $delimiters
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


    /**
     * @param $numbers
     * @return bool
     */
    public function isDelimeterDeclared($numbers): bool
    {
        return $numbers === "/";
    }

    /**
     * @param string $numbers
     * @return int|mixed
     */
    public function delimeterCleanedArray(string $numbers): mixed
    {
        list($delimiters, $numbers) = $this->obtainDelimiter($numbers);

        $numbersArray = $this->cleanArray($numbers, $delimiters);
        return $this->getSum($numbersArray);
    }
}
