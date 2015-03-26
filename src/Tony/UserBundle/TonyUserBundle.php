<?php

namespace Tony\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TonyUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
