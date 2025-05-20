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

    $user= $this->getUser();
    $commandes = $em->getRepository(Commande::class)->findBy(
        ['user'=> $user],
        ['createdAt' => 'DESC']
    );
        return $this->render('profil/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
