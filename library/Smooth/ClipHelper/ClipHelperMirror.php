<?php
namespace softmetrix\Smooth\ClipHelper;

class ClipHelperMirror extends ClipHelperPeriodic
{
    private function clipMirror($i, $n) {
        $period = 2 * ($n - 1);
        $result = parent::clipPeriodic($i, $period);
        if($result > $n - 1) {
            $result = $period - 1;
        }
        return $result;
    }

    public function clip($i) {
        return $this->array[$this->clipMirror($i, count($this->array))];
    }
}