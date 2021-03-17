<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\UserController;
use App\Entity\Ville;
use App\Form\SortieType;
use App\Repository\LieuRepository;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;

/**
 * @Route("/sortie")
 */
class SortieController extends AbstractController
{

    /**
     * @Route("/", name="sortie_index", methods={"GET"})
     * @param SortieRepository $sortieRepository
     * @param SiteRepository $siteRepository
     * @param VilleRepository $villeRepository
     * @param LieuRepository $lieuRepository
     * @return Response
     */
    public function index(SortieRepository $sortieRepository, SiteRepository $siteRepository, VilleRepository $villeRepository, LieuRepository $lieuRepository): Response
    {
        return $this->render('sortie/index.html.twig', [
            'sorties' => $sortieRepository->findAll(),
            'sites' => $siteRepository->findAll(),
            'villes' => $villeRepository->findAll(),
            'lieux' => $lieuRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sortie_new", methods={"GET","POST"})
     * @param Request $request
     * @param SortieRepository $repo
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, SortieRepository $repo, EntityManagerInterface $em): Response
    {
        //Repo User
        $repoUser = $em->getRepository(UserController::class);
        $villes = $em->getRepository(Ville::class)->findAll();
        // Récupère instance de l'utilsiateur connecté
        $user = $repoUser->find($this->getUser());

        //dump($user->getSite()->getNom());

        $sortie = new Sortie();
        $sortie->setSiteOrganisateur($user->getSite());

        $form = $this->createForm(SortieType::class, $sortie);

//        $repo = $em->getRepository(Sortie::class);
        dump($request);

        $form->handleRequest($request);
        dump($sortie);
//        $sortie->setSiteOrganisateur($repo->findVille());
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($sortie);
            $em->flush();

            return $this->redirectToRoute('sortie_index');
        }

        return $this->render('sortie/new.html.twig', [
            'sortie' => $sortie,
            'villes' => $villes,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_show", methods={"GET"})
     */
    public function show(Sortie $sortie, SortieRepository $sortieRepo): Response
    {
      // $users=$sortie->getId();
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
            //'users' => $sortieRepo->findPseudosSortie($users),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sortie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sortie $sortie): Response
    {
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sortie_index');
        }

        return $this->render('sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sortie $sortie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sortie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sortie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sortie_index');
    }
}
