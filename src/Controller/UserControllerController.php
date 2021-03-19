<?php

namespace App\Controller;

use App\Entity\UserController;
use App\Form\UserControllerType;
use App\Repository\UserControllerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

//use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/user/controller")
 */
class UserControllerController extends AbstractController
{
//    /**
//     * @Route("/", name="user_controller_index", methods={"GET"})
//     * @param UserControllerRepository $userControllerRepository
//     * @return Response
//     */
//    public function index(UserControllerRepository $userControllerRepository): Response
//    {
//        return $this->render('user_controller/index.html.twig', [
//            'user_controllers' => $userControllerRepository->findAll(),
//        ]);
//    }

    /**
     * @Route("/index/{id}", name="user_controller_index", methods={"GET","POST"})
     * @param UserControllerRepository $userControllerRepository
     * @return Response
     */
    public function index(UserControllerRepository $userControllerRepository, UserController $id, UserController $userController): Response
    {
        $infos = $userControllerRepository->findOneById($id);
//        var_dump($infos);
        return $this->render('user_controller/index.html.twig', [
            'infos' => $infos
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
     * @Route("/{id}", name="user_controller_show", methods={"GET","POST"})
     * @param UserController $userController
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Request $request
     * @return Response
     */
    public function show(TokenStorageInterface $tokenStorage, UserController $userController, UserPasswordEncoderInterface $passwordEncoder, Request $request): Response
    {
        $form = $this->createForm(UserControllerType::class, $userController);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                // encodage du nouveau password
                $userController->setPassword(
                    $passwordEncoder->encodePassword(
                        $userController,
                        $form->get('password')->getData()
                    )
                );
                // envoie des données modifiées dans la BDD
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('sortie_index');
            } else {
                // Si le formulaire n'est pas valide : rafraichi la page permettant de sortir de la soumission du formulaire
                $this->getDoctrine()->getManager()->refresh($userController);
            }
        }

        return $this->render('user_controller/show.html.twig', [
//            'user_controller' => $userController,
            'form' => $form->createView(),
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
        if ($this->isCsrfTokenValid('delete' . $userController->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userController);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_controller_index');
    }
}
