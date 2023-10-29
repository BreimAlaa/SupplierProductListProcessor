<?php

namespace App\Model;

class ModelProperty{
    public string $name;
    public bool $required;
    public bool $identifier;

    public function __construct(string $name, bool $required = false, bool $identifier = true)
    {
        $this->name = $name;
        $this->required = $required;
        $this->identifier = $identifier;
    }
}