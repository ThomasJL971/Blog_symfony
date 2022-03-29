<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;
use App\Repository\ArticlesRepository;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="app_blog")
     */
    public function index(ArticlesRepository $repo)
    {
        //$repo = $this->getDoctrine()->getRepository(Articles::class); = index(ArticlesRepository $repo) "injection dépendence"

        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }


    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }


    /**
    *@Route("/blog/{id}", name="article_show")
    */
    public function show(ArticlesRepository $repo, $id)
    {
        //$repo = $this->getDoctrine()->getRepository(Articles::class);show(ArticlesRepository $repo) "injection dépendence"

        //trouve l'aticle qui à l'id dans la route
        $article = $repo->find($id);

        return $this->render('blog/show.html.twig', [

            'article' => $article

        ]);
    }
}
