<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Repository\ArticlesRepository;
use App\Repository\CouleursRepository;
use App\Repository\PanierRepository;
use App\Repository\TaillesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PanierController extends AbstractController
{
    #[Route('/panier', name:'panier')]
    #[IsGranted('ROLE_USER')]
    public function voirPanier(PanierRepository $panierRepository): Response
    {
        $user = $this->getUser();
        $panier = $panierRepository->findBy(['user' => $user]);

        $total = 0;
        foreach ($panier as $ligne) {
            $total += $ligne->getArticle()->getPrix();
        }

        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
            'total' => $total
        ]);
    }

    #[Route('/ajoutPanier/{id}', name: 'ajoutPanier', methods:['POST'])]
    #[IsGranted('ROLE_USER')]
    public function ajouterAuPanier(Request $request, ArticlesRepository $articlesRepository, TaillesRepository $tailleRepository, CouleursRepository $couleursRepository, EntityManagerInterface $em, Security $security, int $id): Response
    {
        $user = $security->getUser();
        $article = $articlesRepository->find($id);

        $couleurId = $request->request->get('couleur');
        $tailleId = $request->request->get('taille');

        if (empty($tailleId) || empty($couleurId)) {
            $this->addFlash('error', 'Veuillez choisir un taille et une couleur');
            return $this->redirectToRoute('article_detail', ['id',$id]);

        }

        $taille = $tailleRepository->find($tailleId);
        $couleur = $couleursRepository->find($couleurId);

        $panier = new Panier();
        $panier->setUser($user);
        $panier->setArticle($article);
        $panier->setCouleur($couleur);
        $panier->setTaille($taille);

        $em->persist($panier);
        $em->flush();

        $this->addFlash('success', 'Article ajouté au panier !');
        return $this->redirectToRoute('article_detail', ['id' => $id]);

    }
    #[Route('/panier/supprimer/{id}', name:'panier_supprimer')]
    public function supprimer(int $id, PanierRepository $panierRepository, EntityManagerInterface $em): Response
    {

        $ligne = $panierRepository->find($id);

        if ($ligne) {
            $em->remove($ligne);
            $em->flush();
        }
        $this->addFlash('success', 'Article supprimer');
        return $this->redirectToRoute('panier');

    }
}
