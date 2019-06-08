<?php

namespace softmetrix\Smooth\Interpolator;

class InterpolatorFactory
{
    public function create($type, $inputArray, $clip = Interpolator::CLIP_CLAMP)
    {
        $className = 'softmetrix\Smooth\Interpolator\Interpolator'.ucfirst($type);

        return new $className($inputArray, $clip);
    }
}
