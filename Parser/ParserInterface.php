<?php
namespace App\Parser;
use App\Model\Model;

interface ParserInterface
{
    public function parse(Model $model): \Generator;
    public function outputCombination(string $fileName, array $combination);
}
