<?php

namespace App\Controller;

use App\Entity\UserController;
use App\Form\UserControllerType;
use App\Repository\UserControllerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/controller")
 */
class UserControllerController extends AbstractController
{
    /**
     * @Route("/", name="user_controller_index", methods={"GET"})
     */
    public function index(UserControllerRepository $userControllerRepository): Response
    {
        return $this->render('user_controller/home.html.twig', [
            'user_controllers' => $userControllerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_controller_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userController = new UserController();
        $form = $this->createForm(UserControllerType::class, $userController);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userController);
            $entityManager->flush();

            return $this->redirectToRoute('user_controller_index');
        }

        return $this->render('user_controller/new.html.twig', [
            'user_controller' => $userController,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_controller_show", methods={"GET"})
     */
    public function show(UserController $userController): Response
    {
        return $this->render('user_controller/show.html.twig', [
            'user_controller' => $userController,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_controller_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserController $userController): Response
    {
        $form = $this->createForm(UserControllerType::class, $userController);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_controller_index');
        }

        return $this->render('user_controller/edit.html.twig', [
            'user_controller' => $userController,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_controller_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserController $userController): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userController->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userController);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_controller_index');
    }
}
