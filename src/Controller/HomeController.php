<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticlesRepository $articlesRepository): Response
    {
    
        $articlesALaUne = $articlesRepository->findBy(['aLaUne' => true], ['createdAt' => 'DESC'], 3);
        $dernierArticles = $articlesRepository->findBy([],['id'=>'DESC'], 3);
        $idsALaUne = array_map(fn($article) => $article->getId(), $articlesALaUne);
        $queryBuilder = $articlesRepository->createQueryBuilder('a');

        if (!empty($idsALaUne)) {
            $queryBuilder
                ->where($queryBuilder->expr()->notIn('a.id', ':ids'))
                ->setParameter('ids', $idsALaUne);
        }

        $dernierArticles = $queryBuilder
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();

       
       return $this->render('home/index.html.twig', [
        'aLaUne'=>$articlesALaUne,
        'derniersArticles'=>$dernierArticles,
       ]);
    }
}
