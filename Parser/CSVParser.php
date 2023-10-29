<?php
namespace App\Parser;

use App\Model\Model;
use App\Model\Product;
use Generator;

class CSVParser implements ParserInterface
{
    private string $file;
    private array $headers;

    public function __construct(string $file)
    {
        $this->file = $file;
    }
    public function parse(Model $model): Generator
    {
        $model->checkHeaders($this->headers());
        $file = fopen($this->file, 'r');
        // skip the headers line
        fgetcsv($file);
        // read the file line by line
        while (!feof($file)) {
            $row = fgetcsv($file);
            // create a new product
            $product = new Product($model);
            foreach ($row as $i => $cell) {
                $property = $model->getProperty($this->headers[$i]);
                if ($property->required && !$cell) {
                    throw new \Exception("Property {$property->name} is required");
                }
                // set the property of the product
                $product->{$this->headers[$i]} = $cell;
            }
            yield $product;
        }
        fclose($file);
    }

    public function outputCombination(string $fileName, array $combination)
    {
        $csvFile = fopen($fileName, 'w');
        fputcsv($csvFile, [...$this->headers(), 'count']);
        foreach ($combination as [$product, $count]) {
            $row = [];
            foreach ($this->headers() as $header) {
                $row[] = $product->{$header};
            }
            $row[] = $count;
            fputcsv($csvFile, $row);
        }
    }
    public function headers(): false|array
    {
        // check if the headers are already set
        if (isset($this->headers)) {
            return $this->headers;
        }

        // return the array of the first line of the file
        $file = fopen($this->file, 'r');
        $this->headers = fgetcsv($file);
        fclose($file);
        return $this->headers;
    }
}