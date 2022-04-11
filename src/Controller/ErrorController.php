<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/error")
 */
class ErrorController extends AbstractController
{
    /**
     * @Route("/error403", name="error403")
     */
    public function error403()
    {
        return $this->render('error/error403.html.twig', [
            'controller_name' => 'ErrorController',
        ]);
    }

    /**
     * @Route("/error404", name="error404")
     */
    public function error404()
    {
        return $this->render('error/error404.html.twig', [
            'controller_name' => 'ErrorController',
        ]);
    }

    /**
     * @Route("/error500", name="error500")
     */
    public function error500()
    {
        return $this->render('error/error500.html.twig', [
            'controller_name' => 'ErrorController',
        ]);
    }
}
