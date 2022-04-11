<?php

namespace App\Controller;

use App\Entity\Casa;
use App\Entity\Fotos;
use App\Form\CasaType;
use App\Repository\CasaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

//use function App\acceso;

/**
 * @Route("/casa")
 */
class CasaController extends AbstractController
{
    /**
     * @Route("/{page}", name="casa_index", methods={"GET","POST"}, requirements={"page"="\d+"})
     */
    public function index(CasaRepository $casaRepository, Request $request, $page = 1): Response
    {
        $usu = $this->getUser();
        $limit = 10;

        $tipo_venta = '';
        $tipo_casa = '';
        $id_ciu = '';
        $m2min = '';
        $m2max = '';
        $preciomin = '';
        $preciomax = '';
        $h = [];
        $b = [];

        if ($request->getMethod() == "POST") {

            $h = $request->request->get('h');
            $b = $request->request->get('b');

            $tipo_venta = ($request->request->get('casa')['tipo_venta']) ? $request->request->get('casa')['tipo_venta'] : '';
            $tipo_casa = ($request->request->get('casa')['tipo_casa']) ? $request->request->get('casa')['tipo_casa'] : '';
            $id_ciu = ($request->request->get('casa')['id_ciu']) ? $request->request->get('casa')['id_ciu'] : '';

            $m2min = ($request->request->get('m2min')) ? $request->request->get('m2min') : '';
            $m2max = ($request->request->get('m2max')) ? $request->request->get('m2max') : '';
            $preciomin = ($request->request->get('preciomin')) ? $request->request->get('preciomin') : '';
            $preciomax = ($request->request->get('preciomax')) ? $request->request->get('preciomax') : '';

            if ($request->request->get('h') != null) {
                $h = $request->request->get('h');
                for ($i = 0; $i < 5; $i++) if (!array_key_exists($i, $h)) $h[$i] = '';
            }
            if ($request->request->get('b') != null) {
                $b = $request->request->get('b');
                for ($i = 0; $i < 5; $i++) if (!array_key_exists($i, $b)) $b[$i] = '';
            }


            $casas = $casaRepository->getCasasFiltrado($page, $limit, $request->request);
        } else $casas = $casaRepository->getAllCasas($page, $limit);

        $casasPaginadas = $casas['paginator'];
        $casasCompleto =  $casas['query'];
        $maxPages = ceil($casas['paginator']->count() / $limit);

        $casa = new Casa();
        $form = $this->createForm(CasaType::class, $casa);
        $form->handleRequest($request);

        if ($usu == null) {

            return $this->render('casa/user/indexuser.html.twig', [
                'casas' => $casasPaginadas,
                'maxPages' => $maxPages,
                'thisPage' => $page,
                'all_items' => $casasCompleto,
                'form' => $form->createView(),
                'request' => $request,
                'method' => $request->getMethod(),
                'tipo_venta' => $tipo_venta,
                'tipo_casa' => $tipo_casa,
                'id_ciu' => $id_ciu,
                'm2min' => $m2min,
                'm2max' => $m2max,
                'preciomin' => $preciomin,
                'preciomax' => $preciomax,
                'h' => $h,
                'b' => $b,
            ]);
        } else {

            if ($casaRepository->acceso($usu->getRoles()) == 'admin') {

                return $this->render('casa/index.html.twig', [
                    'casas' => $casasPaginadas,
                    'maxPages' => $maxPages,
                    'thisPage' => $page,
                    'all_items' => $casasCompleto,
                    'form' => $form->createView(),
                    'request' => $request,
                    'method' => $request->getMethod(),
                    'tipo_venta' => $tipo_venta,
                    'tipo_casa' => $tipo_casa,
                    'id_ciu' => $id_ciu,
                    'm2min' => $m2min,
                    'm2max' => $m2max,
                    'preciomin' => $preciomin,
                    'preciomax' => $preciomax,
                    'h' => $h,
                    'b' => $b,
                ]);
            } else {

                return $this->render('casa/user/indexuser.html.twig', [
                    'casas' => $casasPaginadas,
                    'maxPages' => $maxPages,
                    'thisPage' => $page,
                    'all_items' => $casasCompleto,
                    'form' => $form->createView(),
                    'request' => $request,
                    'method' => $request->getMethod(),
                    'tipo_venta' => $tipo_venta,
                    'tipo_casa' => $tipo_casa,
                    'id_ciu' => $id_ciu,
                    'm2min' => $m2min,
                    'm2max' => $m2max,
                    'preciomin' => $preciomin,
                    'preciomax' => $preciomax,
                    'h' => $h,
                    'b' => $b,
                ]);
            }
        }
    }

    /**
     * @Route("/new", name="casa_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $q = true;

        $casa = new Casa();
        $form = $this->createForm(CasaType::class, $casa);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('fotos')->getData();

            $i = 0;
            foreach ($brochureFile as $file) {
                $ext = $file->guessExtension();
                if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                    $q = false;
                    return $this->render('casa/new.html.twig', [
                        'casa' => $casa,
                        'form' => $form->createView(),
                        'q' => $q
                    ]);
                }

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($file && $q) {

                    $foto[$i] = new Fotos;
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    $newFilename = $safeFilename . '_' . uniqid() . '.' . $file->guessExtension();

                    /* $ext = $file->guessExtension();
                    if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') throw new FileException("Formato inválido"); */

                    // Move the file to the directory where brochures are stored
                    try {
                        $file->move(
                            $this->getParameter('img_casa'),
                            $newFilename
                        );

                        $foto[$i]->setRuta($newFilename);
                        $foto[$i]->setPrincipal($i == 0 ? 1 : 0);
                        $casa->addFoto($foto[$i]);
                        $entityManager->persist($foto[$i]);
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // actualiza la propiedad 'brochureFilename' para guardar el nombre archivo
                    $i++;
                }
            }

            $entityManager->persist($casa);
            $entityManager->flush();

            return $this->redirectToRoute('casa_index');
        }

        return $this->render('casa/new.html.twig', [
            'casa' => $casa,
            'form' => $form->createView(),
            'q' => $q
        ]);
    }

    /**
     * @Route("/show/{id}", name="casa_show", methods={"GET"})
     */
    public function show(Casa $casa, CasaRepository $casaRepository): Response
    {
        $usu = $this->getUser();

        if ($usu == null) {

            return $this->render('casa/user/showuser.html.twig', [
                'casa' => $casa,
            ]);
        } else {

            if ($casaRepository->acceso($usu->getRoles()) == 'admin') {

                return $this->render('casa/show.html.twig', [
                    'casa' => $casa,
                ]);
            } else {

                return $this->render('casa/user/showuser.html.twig', [
                    'casa' => $casa,
                ]);
            }
        }
    }

    /**
     * @Route("/edit/{id}", name="casa_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Casa $casa): Response
    {
        $q = true;
        
        $form = $this->createForm(CasaType::class, $casa);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('fotos')->getData();

            $i = 0;
            foreach ($brochureFile as $file) {
                $ext = $file->guessExtension();
                if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                    $q = false;
                    return $this->render('casa/new.html.twig', [
                        'casa' => $casa,
                        'form' => $form->createView(),
                        'q' => $q
                    ]);
                }

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($file && $q) {

                    $foto[$i] = new Fotos;
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    $newFilename = $safeFilename . '_' . uniqid() . '.' . $file->guessExtension();

                    /* $ext = $file->guessExtension();
                    if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') throw new FileException("Formato inválido"); */

                    // Move the file to the directory where brochures are stored
                    try {
                        $file->move(
                            $this->getParameter('img_casa'),
                            $newFilename
                        );

                        $foto[$i]->setRuta($newFilename);
                        $foto[$i]->setPrincipal($i == 0 ? 1 : 0);
                        $casa->addFoto($foto[$i]);
                        $entityManager->persist($foto[$i]);
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // actualiza la propiedad 'brochureFilename' para guardar el nombre archivo
                    $i++;
                }
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('casa_index');
        }

        return $this->render('casa/edit.html.twig', [
            'casa' => $casa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="casa_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Casa $casa): Response
    {
        if ($this->isCsrfTokenValid('delete' . $casa->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($casa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('casa_index');
    }
}
