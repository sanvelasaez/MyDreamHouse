<?php

namespace App\Controller;
use App\Entity\Casa;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CasaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $casa = new Casa();
        $form = $this->createForm(CasaType::class, $casa);
        $form->handleRequest($request);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
        ]);
    }
}
