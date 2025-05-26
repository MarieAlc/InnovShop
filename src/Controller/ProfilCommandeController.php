<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfilCommandeController extends AbstractController
{
    #[Route('/profil/commandes', name: 'profil_commandes')]
    public function index(EntityManagerInterface $em): Response
    {
        /** @var User $user  */

        $user = $this->getUser();
        $commandes = $em->getRepository(Commande::class)->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC']
        );
        return $this->render('profil/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/profil/commande/{id}', name: 'commande_detail')]
    public function detail(Commande $commande): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($commande->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Cette commande ne vous appartient pas.');
        }

        return $this->render('profil/commande_detail.html.twig', [
            'commande' => $commande,
        ]);
    }
}
