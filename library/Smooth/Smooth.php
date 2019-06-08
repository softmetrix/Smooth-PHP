<?php

namespace softmetrix\Smooth;

use softmetrix\Smooth\Interpolator\InterpolatorFactory;
use softmetrix\Smooth\Interpolator\Interpolator;

class Smooth
{
    const METHOD_NEAREST = 'nearest';
    const METHOD_LINEAR = 'linear';
    const METHOD_CUBIC = 'cubic';

    private $method;
    private $inputArray = [];
    private $interpolator;

    public function __construct(array $inputArray, $method = self::METHOD_CUBIC)
    {
        $this->inputArray = $inputArray;
        $this->validateInputArray();
        $this->method = $method;
        $interpolatorFactory = new InterpolatorFactory();
        $this->interpolator = $interpolatorFactory->create($method, $inputArray, Interpolator::CLIP_CLAMP);
    }

    private function validateInputArray()
    {
        if (!$this->validateCount()) {
            throw new \Exception('Input array count must be >= 2');
        }
        if (!$this->validateIsNumeric()) {
            throw new \Exception('All elements of input array must be numeric');
        }
    }

    private function validateIsNumeric()
    {
        return count($this->inputArray) === count(array_filter($this->inputArray, 'is_numeric'));
    }

    private function validateCount()
    {
        return count($this->inputArray) >= 2;
    }

    public function val($i)
    {
        return $this->interpolator->interpolate($i);
    }
}
