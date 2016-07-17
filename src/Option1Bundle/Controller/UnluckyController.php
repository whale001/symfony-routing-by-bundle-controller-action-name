<?php

namespace Option1Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UnluckyController extends Controller
{
    public function numberAction()
    {
        $number = mt_rand(0, 0);

        return new Response(
            '<html><body>Option1Bundle, unlucky number: '.$number.'</body></html>'
        );
    }
}
