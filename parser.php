<?php

use App\Model\Model;
use App\Model\ModelProperty;

require __DIR__.'/Core/autoload.php';

$options = [];
$values = [];
for ($i = 1; $i < count($argv); $i++) {
    if (str_starts_with($argv[$i], '--')) {
        $option = substr($argv[$i], 2);
        $option = explode('=', $option);
        if (count($option) == 1) {
            $option[1] = true;
        }
        $options[$option[0]] = $option[1];
    }
    else {
        $values[] = $argv[$i];
    }
}

$file = $options['file'];

if (!$file){
    throw new \Exception("File is required");
}

//check if the file exists
if (!file_exists($file)) {
    throw new \Exception("File does not exist");
}

// check if the file is readable
if (!is_readable($file)) {
    throw new \Exception("File is not readable");
}


$combination = [];
$keys = [];
$ext = pathinfo($file, PATHINFO_EXTENSION);
$parserClass = 'App\\Parser\\'.strtoupper($ext).'Parser';
if (!class_exists($parserClass)) {
    throw new \Exception("Unsupported file type");
}
$parser = new $parserClass($file);

// specify the properties of the product
// TODO: make this configurable from the command line
$productProperties = [
    new ModelProperty('brand_name', true),
    new ModelProperty('model_name', true),
    new ModelProperty('condition_name'),
    new ModelProperty('grade_name'),
    new ModelProperty('gb_spec_name'),
    new ModelProperty('colour_name'),
    new ModelProperty('network_name'),
];
$productModel = new Model($productProperties);

foreach ($parser->parse($productModel) as $i => $product) {
    echo $i . PHP_EOL . $product . PHP_EOL;
    $combination[$product->getIdentifier()] = isset($combination[$product->getIdentifier()]) ?
        [$product, $combination[$product->getIdentifier()][1] + 1 ]: [$product, 1];
}

$output = $options['unique-combinations'] ?? 'output.csv';

// write to a csv file
$parser->outputCombination($output, $combination);
echo "\033[32m" . "$output has been created" . "\033[0m" . PHP_EOL;