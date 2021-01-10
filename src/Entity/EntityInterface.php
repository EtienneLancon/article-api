<?php

namespace App\Entity;

interface EntityInterface
{
    //must return entity attributes excepted other entities relations
    public function getOwnParams(): array;
}