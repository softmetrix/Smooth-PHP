<?php
namespace softmetrix\Smooth\ClipHelper;

class ClipHelperPeriodic extends ClipHelper
{
    protected function clipPeriodic($i, $n) {
        $result = $i % $n;
        if($result < 0) {
            $result += $n;
        }
        return $result;
    }

    public function clip($i) {
        return $this->array[$this->clipPeriodic($i, count($this->array))];
    }
}