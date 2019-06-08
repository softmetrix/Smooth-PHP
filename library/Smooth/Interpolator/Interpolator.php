<?php

namespace softmetrix\Smooth\Interpolator;

use softmetrix\Smooth\ClipHelper\ClipHelperFactory;

abstract class Interpolator
{
    const CLIP_CLAMP = 'clamp';
    const CLIP_ZERO = 'zero';
    const CLIP_PERIODIC = 'periodic';
    const CLIP_MIRROR = 'mirror';

    private $clip;
    private $inputArray = [];
    /**
     * @var ClipHelper
     */
    private $clipHelper;

    public function __construct($inputArray, $clip = self::CLIP_CLAMP)
    {
        $this->inputArray = $inputArray;
        $clipHelperFactory = new ClipHelperFactory();
        $this->clipHelper = $clipHelperFactory->create($clip, $inputArray);
    }

    public function setClipMethod($clip)
    {
        $this->clip = $clip;
    }

    protected function getClippedInput($i)
    {
        if ($i >= 0 && $i < count($this->inputArray)) {
            return $this->inputArray[$i];
        }

        return $this->clipHelper->clip($i);
    }

    abstract public function interpolate($i);
}
