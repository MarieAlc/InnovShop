<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PanierController extends AbstractController
{
    #[Route('/ajoutPanier/{id}', name: 'ajoutPanier', methods:['POST'])]
    public function ajouterAuPanier( Request $request, ArticlesRepository $articlesRepository, EntityManagerInterface $em, Security $security, int $id): Response
    {
        $user = $security->getUser();
        $article = $articlesRepository->find($id);

        if(!$user){
            $this->addFlash('error','Vous devez être connecté pour ajouterun article au panier');
            return $this->redirectToRoute('app_login');
        }
        $taille = $request->request->get('taille');
        $couleur = $request->request->get('couleur');

        if(empty($taille) || empty($couleur)){
            $this->addFlash('error', 'Veuillez choisir un taille et une couleur' );
            return $this->redirectToRoute('article_detail', ['id',$id]);

        }
        $panier = new Panier();
        $panier->setUser($user);
        $panier->setArticle($article);
        $panier->setTaille($taille);
        $panier->setCouleur($couleur);

        $em->persist($panier);
        $em->flush();

        $this->addFlash('success', 'Article ajouté au panier !' );
        return $this->redirectToRoute('article_detail', ['id'=> $id]);
      
    }
}
