<?php

namespace PB\TransportBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PBTransportBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
