<?php
namespace softmetrix\Smooth\Interpolator;

class InterpolatorLinear extends Interpolator 
{
    public function interpolate($i)
    {
        $k = floor($i);
        $r = $i - $k;
        return (1 - $r) * $this->getClippedInput($k) + $r * $this->getClippedInput($k + 1);
    }
}