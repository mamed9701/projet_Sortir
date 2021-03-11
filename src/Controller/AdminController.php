<?php

namespace App\Controller;

use App\Entity\UserController;
use App\Form\UserControllerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function home(): Response
    {
        return $this->render('admin/home.html.twig');
    }




}
