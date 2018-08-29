<?php

namespace Eidosmedia\Cobalt\Commons\Exceptions;

class Exception extends \RuntimeException {

    public function __construct($message) {
        parent::__construct($message);
    }

}
