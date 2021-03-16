<?php

namespace App\Controller;

use App\Entity\UserController;
use App\Form\UserControllerType;
use App\Repository\LieuRepository;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
//    /**
//     * @Route("/", name="accueilNonConnect")
//     */
//    public function home(): Response
//    {
//        return $this->render('/accueilNonConnect.html.twig');
//    }

    /**
     * @Route("/", name="accueilNonConnect", methods={"GET"})
     * @param SortieRepository $sortieRepository
     * @param SiteRepository $siteRepository
     * @param VilleRepository $villeRepository
     * @param LieuRepository $lieuRepository
     * @return Response
     */
    public function index(SortieRepository $sortieRepository, SiteRepository $siteRepository, VilleRepository $villeRepository, LieuRepository $lieuRepository): Response
    {
        return $this->render('/accueilNonConnect.html.twig', [
            'sorties' => $sortieRepository->findAll(),
            'sites' => $siteRepository->findAll(),
            'villes' => $villeRepository->findAll(),
            'lieux' => $lieuRepository->findAll(),
        ]);
    }



}
