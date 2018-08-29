<?php

namespace Eidosmedia\Cobalt\Commons\Exceptions;

class HttpClientException extends Exception {

    public function __construct($message) {
        parent::__construct($message);
    }

}