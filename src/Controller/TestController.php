<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test-route', name: 'admin_test_route')]
    public function specificRoute(): Response
    {
        return $this->render('pages/test.html.twig');
    }
}
