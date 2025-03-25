<?php

namespace Deg540\StringCalculatorPHP;

class StringCalculator
{
    public function __construct()
    {
    }

    // TODO: String Calculator Kata
    public function Add(string $numbers): int
    {
        if ($this->isEmpty($numbers)) {
            return 0;
        }

        if ($this->isDelimeterDeclared($numbers[0])) {
            return $this->delimeterCleanedArray($numbers);
        }

        $numbersArray = $this->cleanArray($numbers, ",");

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
     * @param string $delimiter
     * @return string[]
     */
    public function cleanArray(string $numbers, string $delimiter): array
    {
        // Reemplazamos los saltos de línea por el delimitador correcto
        $numbers = str_replace("\n", $delimiter, $numbers);
        // Ahora explotamos usando el delimitador proporcionado (puede ser coma o el delimitador especial)
        $numbersArray = explode($delimiter, $numbers);
        return $numbersArray;
    }

    /**
     * @param string $input
     * @return array
     */
    public function obtainDelimeter(string $input): array
    {
        // Dividimos la cadena de entrada en líneas
        $lines = explode("\n", $input);

        // Extraemos el delimitador de la primera línea, después de "//"
        $delimiter = substr($lines[0], 2, 1);  // Extrae el delimitador de "//[delimitador]"
        // El segundo valor será la línea con los números
        $numbers = implode("\n", array_slice($lines, 1));

        return [$delimiter, $numbers];
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
        list($delimiter, $numbers) = $this->obtainDelimeter($numbers);

        $numbersArray = $this->cleanArray($numbers, $delimiter);
        return $this->getSum($numbersArray);
    }
}
