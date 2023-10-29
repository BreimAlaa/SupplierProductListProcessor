<?php

namespace App\Model;

class Product
{
    private Model $model;
    private array $values;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function getIdentifier(): string
    {
        $identifier = '';
        foreach ($this->values as $key => $value) {
            if ($this->model->getProperty($key)->identifier) {
                $identifier .= $value . PHP_EOL;
            }
        }
        return $identifier = substr($identifier, 0, -1);
    }
    public function __toString()
    {
        $str = '';
        foreach ($this->values as $key => $value) {
            $str .= $key . ': ' . $value . PHP_EOL;
        }
        return $str;
    }
    public function __set($name, $value)
    {
        $property = $this->model->getProperty($name);
        $this->values[$property->name] = $value;
    }
    public function __get($name)
    {
        if (isset($this->values[$name])){
            return $this->values[$name];
        }
        throw new \Exception("Property $name does not exist");
    }
}