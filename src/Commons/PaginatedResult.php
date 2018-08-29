<?php

namespace Eidosmedia\Cobalt\Commons;

class PaginatedResult {

    private $result;
    private $count;
    private $offset;
    private $limit;

    public function __construct($result, $count, $offset, $limit) {
        $this->result = $result;
        $this->count = $count;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function getResult() {
        return $this->result;
    }

}