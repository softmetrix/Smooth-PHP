<?php

namespace softmetrix\Smooth\ClipHelper;

abstract class ClipHelper
{
    protected $array = [];

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    abstract public function clip($i);
}
