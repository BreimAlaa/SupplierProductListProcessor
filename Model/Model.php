<?php

namespace App\Model;

class Model
{
    private array $properties = [];
    public function __construct(array $modelProperties)
    {
        // check if there are duplicate properties
        foreach ($modelProperties as $property) {
            if (in_array($property->name, $this->properties)) {
                throw new \Exception("Duplicate property $property->name");
            }
            $this->properties[] = $property;
        }
    }

    /**
     * check that all the required properties are present in the headers
     * @param $headers
     * @return bool
     * @throws \Exception if a required property is missing from the headers
     */
    public function checkHeaders($headers): bool
    {
        foreach ($this->properties as $property) {
            if ($property->required && !in_array($property->name, $headers)) {
                throw new \Exception("Property $property->name is required");
            }
        }
        return true;
    }

    /**
     * get the property by name
     * @param  string  $name
     * @return ModelProperty
     * @throws \Exception if the property does not exist
     */
    public function getProperty(string $name): ModelProperty
    {
        foreach ($this->properties as $property) {
            if ($property->name == $name) {
                return $property;
            }
        }
        throw new \Exception("Property $name does not exist");
    }
}