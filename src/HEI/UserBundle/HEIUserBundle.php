<?php

namespace HEI\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HEIUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
