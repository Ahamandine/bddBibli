<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestDbController extends AbstractController
{
    #[Route('/test/db', name: 'app_test_db')]
    public function index(): Response
    {
        return $this->render('test_db/index.html.twig', [
            'controller_name' => 'TestDbController',
        ]);
    }
}
