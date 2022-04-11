<?php

namespace App\Controller;

use App\Entity\Fotos;
use App\Form\FotosType;
use App\Repository\FotosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fotos")
 */
class FotosController extends AbstractController
{
    /**
     * @Route("/", name="fotos_index", methods={"GET"})
     */
    public function index(FotosRepository $fotosRepository): Response
    {
        return $this->render('fotos/index.html.twig', [
            'fotos' => $fotosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fotos_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $foto = new Fotos();
        $form = $this->createForm(FotosType::class, $foto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($foto);
            $entityManager->flush();

            return $this->redirectToRoute('fotos_index');
        }

        return $this->render('fotos/new.html.twig', [
            'foto' => $foto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="fotos_show", methods={"GET"})
     */
    public function show(Fotos $foto): Response
    {
        return $this->render('fotos/show.html.twig', [
            'foto' => $foto,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="fotos_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fotos $foto): Response
    {
        $form = $this->createForm(FotosType::class, $foto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fotos_index');
        }

        return $this->render('fotos/edit.html.twig', [
            'foto' => $foto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="fotos_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fotos $foto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$foto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($foto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fotos_index');
    }
}
