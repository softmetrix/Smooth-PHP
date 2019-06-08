<?php

namespace softmetrix\Smooth\ClipHelper;

class ClipHelperClamp extends ClipHelper
{
    private function clipClamp($i, $n)
    {
        return max(0, min($i, $n - 1));
    }

    public function clip($i)
    {
        return $this->array[$this->clipClamp($i, count($this->array))];
    }
}
