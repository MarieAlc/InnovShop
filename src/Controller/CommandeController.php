<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\User;
use App\Entity\Commande;
use App\Entity\CommandeLigne;
use App\Entity\Panier;
use App\Form\AdresseLivraisonTypeForm;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CommandeController extends AbstractController
{
    #[Route('/commande/recap', name:'commande_recap')]
    #[IsGranted('ROLE_USER')]
    public function validerCommande(MailerInterface $mailer, EntityManagerInterface $em, Request $request): Response
    {

        /** @var User $user */

        $user = $this->getUser();
        $panier = $em->getRepository(Panier::class)->findBy(['user' => $user]);

        $commande = new Commande();

        $form = $this->createForm(AdresseLivraisonTypeForm::class, $commande);
        $form->handleRequest($request);
        

        $total = 0;
        foreach ($panier as $ligne) {
            $total += $ligne->getArticle()->getPrix();

        }

        if ($form->isSubmitted() && $form->isValid()) {
            $commande->setUser($user);
            $commande->setCreatedAt(new \DateTimeImmutable());
            $commande->setStatus('En attente');
            $commande->setTotal($total);

            $em->persist($commande);

            foreach ($panier as $ligne) {
                $commandeLigne = new CommandeLigne();

                $commandeLigne->setCommande($commande);
                $commandeLigne->setArticle($ligne->getArticle());
                $commandeLigne->setTaille($ligne->getTaille());
                $commandeLigne->setCouleur($ligne->getCouleur());
                $commandeLigne->setPrix($ligne->getArticle()->getPrix());

                $em->persist($commandeLigne);
                $em->remove($ligne);
            }
            $em->flush();
            $em->refresh($commande);

            $commande = $em->getRepository(Commande::class)->find($commande->getId());



            $email = (new Email())
                ->from('contact@louanges.website')
                ->to($user->getEmail())
                ->subject('Confirmation de votre commande')
                ->html($this->renderView('emails/confirmation.html.twig', [
                    'commande' => $commande,
                    'user' => $user,
                ]));

            $mailer->send($email);

            $this->addFlash('success', 'Commande envoyé');
            return $this->redirectToRoute('commande_confirmation', [
                'id' => $commande->getId(),
            ]);
        }

        return $this->render('commande/recap.html.twig', [
            'panier' => $panier,
            'total' => $total,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/commande/confirmation/{id}', name:'commande_confirmation')]
    #[IsGranted('ROLE_USER')]
    public function confirmation(Commande $commande): Response
    {

        return $this->render('commande/confirmation.html.twig', [
            'commande' => $commande
        ]);
    }

}
