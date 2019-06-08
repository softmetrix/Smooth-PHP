<?php

namespace softmetrix\Smooth\Interpolator;

class InterpolatorCubic extends Interpolator
{
    private $tangentFactor;

    public function __construct($inputArray, $clip = self::CLIP_CLAMP)
    {
        parent::__construct($inputArray, $clip);
        $this->tangentFactor = 1 - max(0, min(1, $this->cubicTension));
    }

    private function getTangent($k)
    {
        return $this->tangentFactor * ($this->getClippedInput($k + 1) - $this->getClippedInput($k - 1)) / 2;
    }

    public function interpolate($i)
    {
        $k = floor($i);
        $m = [$this->getTangent($k), $this->getTangent($k + 1)];
        $p = [$this->getClippedInput($k), $this->getClippedInput($k + 1)];
        $r = $i - $k;
        $t2 = $r * $r;
        $t3 = $r * $t2;

        return (2 * $t3 - 3 * $t2 + 1) * $p[0]
            + ($t3 - 2 * $t2 + $r) * $m[0]
            + (-2 * $t3 + 3 * $t2) * $p[1]
            + ($t3 - $t2) * $m[1];
    }
}
