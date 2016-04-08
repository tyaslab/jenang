<?php

namespace Jenang\Util;

use Plasticbrain\FlashMessages\FlashMessages as PlasticBrainFlashMessages;

class FlashMessages extends PlasticBrainFlashMessages {
    public function hasMessages($type=null) {
        $messages = parent::hasMessages($type);

        if ($messages) {
            $this->clear();
        }

        return $messages;
    }
}