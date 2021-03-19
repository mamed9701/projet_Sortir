<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\UserController;
use App\Entity\Ville;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use App\Repository\UserControllerRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/sortie")
 */
class SortieController extends AbstractController
{

    /**
     * @Route("/", name="sortie_index", methods={"GET","POST"})
     * @param SortieRepository $sortieRepository
     * @param SiteRepository $siteRepository
     * @param VilleRepository $villeRepository
     * @param LieuRepository $lieuRepository
     * @return Response
     */
    public function index(SortieRepository $sortieRepository, SiteRepository $siteRepository, VilleRepository $villeRepository, LieuRepository $lieuRepository, Request $request, EntityManagerInterface $em, UserInterface $user): Response
    {
//        Etat archivé sur les sorties terminées si +30 jours
//        foreach ($sortiesTerminees as $laSortieTerminee) {
//            $interval = date_diff($laSortieTerminee->getDateHeureDebut(), $localDate);
//
//            if($interval->format('%R%a') >= '+30'){
//                $laSortieTerminee->setEtat($etatArchive);
//                $emi->persist($laSortieTerminee);
//                $emi->flush();
//            }
//        }

        //------------ Filtre de l'accueil --------------------
        $result = [];
        $organisateur = $this->getUser()->getId();
        //vérification de tous les champs : si aucun n'est coché affichage de toutes les sorties
        if (
            !$request->request->get('siteNom') &&
            !$request->request->get('sortieSearch') &&
            !$request->request->get('sortieDate1') &&
            !$request->request->get('sortieDate2') &&
            !$request->request->get('organisateur') &&
            !$request->request->get('inscrit') &&
            !$request->request->get('nonInscrit') &&
            !$request->request->get('sortieEtatPassee')
        ) {
            $result = $sortieRepository->findAll();
        } //si un ou plusieurs champ de recherche sélectionnés
        else {
var_dump( $request->request->get('inscrit'));

            $result = $sortieRepository->findByParameters(
                $request->request->get('siteNom'),
                $request->request->get('sortieSearch'),
                $request->request->get('sortieDate1'),
                $request->request->get('sortieDate2'),
                $request->request->get('organisateur') ? $this->getUser()->getId() : "",
                $request->request->get('inscrit') ? $this->getUser()->getId() : "",
                $request->request->get('sortieEtatPassee')
            );
var_dump($this->getUser()->getId());
var_dump($request->request->get('inscrit') ? $this->getUser()->getId() : "");

//            // test du filtre organisateur : si coché alors
//            if ($request->request->get('organisateur')) {
//                $tempResult = $sortieRepository->findBy(['organisateur' => $user->getId()]);
//                // insertion de chaque élément de tempResult vers result
//                for ($i = 0; $i < count($tempResult); $i++) {
//                    //ajout du résultat vers le tableau de sortie en précisant son id
//                    $result[$tempResult[$i]->getId()] = $tempResult[$i];
//                }
//            }

//            $etat = $request->request->get('sortieEtatPassee');
//            // test du filtre état sortie : si coché alors
//            if ($request->request->get('sortieEtatPassee')) {
//                $tempResult = $sortieRepository->findByEtat($etat);
//                // insertion de chaque élément de tempResult vers result
//                for ($i = 0; $i < count($tempResult); $i++) {
//                    //ajout du résultat vers le tableau de sortie en précisant son id
//                    $result[$tempResult[$i]->getId()] = $tempResult[$i];
//                }
//            }
        }

        //Inscrit
        $userId = $this->getUser()->getId();

        return $this->render('sortie/index.html.twig', [
            'sorties' => $result,
            'sites' => $siteRepository->findAll(),
            'villes' => $villeRepository->findAll(),
            'lieux' => $lieuRepository->findAll(),
            'inscrits' => $sortieRepository->findInscriptions($userId),
        ]);
    }






    /**
     * @Route("/new", name="sortie_new", methods={"GET","POST"})
     * @param Request $request
     * @param LieuRepository $lieuRepository
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, LieuRepository $lieuRepository, EntityManagerInterface $em): Response
    {
        //Repo User
        $repoUser = $em->getRepository(UserController::class);
        $villes = $em->getRepository(Ville::class)->findAll();

//        $repoLieu = $em->getRepository(Lieu::class);
//        $lieu = $repoLieu->findRueByVille();


        // Récupère instance de l'utilsiateur connecté

        $user = $repoUser->find($this->getUser());


        $sortie = new Sortie();
//        $etatRepo = $em->getRepository(Etat::class);
//        $etat = $etatRepo->find(1);
//        $sortie->setEtatsNoEtat($etat);
        $sortie->setSiteOrganisateur($user->getSite());
        $sortie->setOrganisateur($user);

        $form = $this->createForm(SortieType::class, $sortie);

//        $repo = $em->getRepository(Sortie::class);
//        dump($request);

        $form->handleRequest($request);
//        dump($sortie);
//        $sortie->setSiteOrganisateur($repo->findVille());
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($sortie);
            $em->flush();

            return $this->redirectToRoute('sortie_index');
        }

        return $this->render('sortie/new.html.twig', [
            'sortie' => $sortie,
            'villes' => $villes,
//            'lieux' => $lieuRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_show", methods={"GET"})
     */
    public function show(Sortie $sortie, SortieRepository $sortieRepo): Response
    {
        $users = $sortie->getId();
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
            'users' => $sortieRepo->findPseudosSortie($users),

        ]);
    }

    /**
     * @Route("/{id}/edit", name="sortie_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Sortie $sortie
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request, Sortie $sortie, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);
        $villes = $em->getRepository(Ville::class)->findAll();
        $lieux = $em->getRepository(Lieu::class)->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sortie_index');
        }

        return $this->render('sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView(),
            'villes' => $villes,
            'lieux' => $lieux,

        ]);
    }

    /**
     * @Route("/{id}", name="sortie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sortie $sortie): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sortie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sortie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sortie_index');
    }

    /**
     * @Route("/sortie/inscrire/{id}", name="sinscrire", requirements={"id": "\d+"}, methods={"GET","POST"})
     */
    public function sinscrire(EntityManagerInterface $em, Request $request, Sortie $sortie)
    {
        $user = $em->getRepository(UserController::class)->find($this->getUser()->getId());
        $inscription = new UserController();

        //$inscription->
        $inscription->setSortie($sortie);
        $inscription->setUserController($user);

        $em->persist($inscription);
        $em->flush();
        $this->addFlash('success', 'L\'inscription a été faite !');
        return $this->redirectToRoute('sortie_index');
    }


    /**
     * @Route("/sortie/desister/{id}", name="desister", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function desister(int $id)
    {
        $sortieRepository = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

        // supprime l'utilisateur de la liste des participants
        $sortie->removeUserControllerSortie($this->getId());
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        //return $this->redirectToRoute('sortie_index');
        return $this->render('sortie/sortie_index.html.twig', [
            'sortie' => $sortie,
        ]);
    }

}
