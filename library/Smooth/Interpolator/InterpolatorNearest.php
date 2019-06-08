<?php

namespace softmetrix\Smooth\Interpolator;

class InterpolatorNearest extends Interpolator
{
    public function interpolate($i)
    {
        return $this->getClippedInput(round($i));
    }
}
