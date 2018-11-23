<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return array(
            new TwigFunction('instanceOf', array($this, 'isInstanceOf')),
        );
    }

    public function isInstanceOf($var, $instance)
    {
        return $var instanceof $instance;
    }
}