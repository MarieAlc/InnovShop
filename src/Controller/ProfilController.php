<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdatePasswordForm;
use App\Form\ProfilTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(): Response
    {
        if (!$this->isGranted('ROLE_USER') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }
        return $this->render('profil/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    #[Route('/profil/edit', name:'profil_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        $form = $this->createForm(ProfilTypeForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès.');
            return $this->redirectToRoute('profil');
        }
        return $this->render('profil/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    #[Route('profil/password', name: 'change_password')]
    public function changePassword(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        $form = $this->createForm(UpdatePasswordForm::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $form->get('currentPassword')->getData();

            if (!$hasher->isPasswordValid($user, $oldPassword)) {

                $form->get('currentPassword')->addError(new FormError('Le mot de passe actuel est incorrect.'));
            } else {

                $newPassword = $form->get('newPassword')->getData();
                $hashedPassword = $hasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);

                $em->flush();
                $this->addFlash('success', 'Mot de passe modifier avec succès.');

                return $this->redirectToRoute('profil');
            }

        }
        return $this->render('profil/change_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/profil/delete', name:'delete_profil')]

    public function deleteAccount(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, Request $request): Response
    {

        /** @var User $user */

        $user = $this->getUser();
        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        $em->remove($user);
        $em->flush();

        $tokenStorage->setToken(null);
        $request->getSession()->invalidate();

        $this->addFlash('success', 'Votre compte a bien été supprimer.');

        return $this->redirectToRoute('home');

    }
}
