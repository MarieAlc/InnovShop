<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CouleursRepository;
use App\Repository\TaillesRepository;
use App\Repository\TypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'articles')]
    public function index(ArticlesRepository $articlesRepository, Request $request,TypesRepository $typesRepository, CouleursRepository $couleursRepository, TaillesRepository $taillesRepository ): Response
    {
        $typeId = $request->query->get('type');
        $couleurId = $request->query->get('couleur');
        $tailleId = $request->query->get('taille');

        $qb = $articlesRepository->createQueryBuilder('a');

        if ($typeId){
            $qb->andWhere('a.type = :type')->setParameter('type',$typeId);
        }
        if ($couleurId) {
        $qb->join('a.couleurs', 'c')->andWhere('c.id = :couleur')->setParameter('couleur', $couleurId);
        }
        if ($tailleId) {
            $qb->join('a.tailles', 't')->andWhere('t.id = :taille')->setParameter('taille', $tailleId);
        }
        $articles = $qb->getQuery()->getResult();

        return $this->render('articles/index.html.twig',[
            'articles' => $articles,
            'types'=>$typesRepository->findAll(),
            'couleur'=>$couleursRepository->findAll(),
            'tailles'=>$taillesRepository->findAll()

        ]);
   
    }

    #[Route('/articles/{id}', name: 'article_detail')]
    public function showDetail(int $id, ArticlesRepository $repository):response{

        $article = $repository->find($id);

        if(!$article){
            throw $this->createNotFoundException('Article introuvable. ');
        }

        return $this->render('articles/showDetail.html.twig', [
            'article'=> $article
        ]);


    }
}
