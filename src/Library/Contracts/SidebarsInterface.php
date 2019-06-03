<?php

namespace AceLords\Core\Library\Contracts;

interface SidebarsInterface
{
    /**
     * return sidebar entries
     *
     * @return mixed
     */
    public function data() : array;
    
}
