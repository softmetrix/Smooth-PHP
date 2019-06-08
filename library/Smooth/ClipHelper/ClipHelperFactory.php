<?php
namespace softmetrix\Smooth\ClipHelper;

class ClipHelperFactory {
    public function create($type, $inputArray) {
        $className = 'softmetrix\Smooth\ClipHelper\ClipHelper' . ucfirst($type);
        return new $className($inputArray);
    }
}