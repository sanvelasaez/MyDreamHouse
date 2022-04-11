<?php

namespace App\Controller;

use App\Entity\Ciudad;
use App\Entity\Casa;
use App\Form\CiudadType;
use App\Repository\CiudadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ciudad")
 */
class CiudadController extends AbstractController
{
    /**
     * @Route("/", name="ciudad_index", methods={"GET"})
     */
    public function index(CiudadRepository $ciudadRepository): Response
    {
        return $this->render('ciudad/index.html.twig', [
            'ciudads' => $ciudadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ciudad_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ciudad = new Ciudad();
        $form = $this->createForm(CiudadType::class, $ciudad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ciudad);
            $entityManager->flush();

            return $this->redirectToRoute('ciudad_index');
        }

        return $this->render('ciudad/new.html.twig', [
            'ciudad' => $ciudad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="ciudad_show", methods={"GET"})
     */
    public function show(Ciudad $ciudad): Response
    {
        return $this->render('ciudad/show.html.twig', [
            'ciudad' => $ciudad,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="ciudad_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ciudad $ciudad): Response
    {
        $form = $this->createForm(CiudadType::class, $ciudad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ciudad_index');
        }

        return $this->render('ciudad/edit.html.twig', [
            'ciudad' => $ciudad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="ciudad_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ciudad $ciudad): Response
    {
        $casa = new Casa;
        $q = true;

        foreach ($casa as $c) {
            if ($c->getIdCiu() == $ciudad->getId()) {
                $q = false;
            }
        }

        if (!$q) {
            if ($this->isCsrfTokenValid('delete' . $ciudad->getId(), $request->request->get('_token')) && $q) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($ciudad);
                $entityManager->flush();
            }
        } else echo '<script>alert("No se ha podido eliminar la ciudad\nPuede que haya alguna casa que pertenece a la ciudad escogida");</script>';

        return $this->redirectToRoute('ciudad_index');
    }
}
