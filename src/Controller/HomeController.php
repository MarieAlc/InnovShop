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
       $articleAlaUne = $articlesRepository->findBy([], null, 3);

       $dernierArticles = $articlesRepository->findBy([],['id'=>'DESC'], 3);

       return $this->render('home/index.html.twig', [
        'aLaUne'=>$articleAlaUne,
        'derniersArticles'=>$dernierArticles,
       ]);
    }
}
