<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LuckyController extends Controller
{
    public function numberAction()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>AppBundle lucky number: '.$number.'</body></html>'
        );
    }
}
