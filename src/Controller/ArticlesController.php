<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'articles')]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        $articles = $articlesRepository->findAll();

        return $this->render('articles/index.html.twig',[
            'articles' => $articles
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
