<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
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
     *@Route("/blog/form", name="blog_form")
     *@Route("/blog/{id}/edit", name="article_edit")
     */
    public function form(Articles $article = null, Request $request, EntityManagerInterface $manager) 
    {

        if(!$article) {
            $article = new Articles();
        }

        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('content')
                     ->add('image')
                     ->getForm();

        $form->handleRequest($request); //analyse la requette

        if($form->isSubmitted() && $form->isValid()) {

            if(!$article->getId()) {
                $article->setCreatedAt(new \DateTimeImmutable());
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);

        }


        return $this->render('blog/form.html.twig',[
            'formArticle' => $form->createView(), //crée un objet pour l'affichage
            'editMode' => $article->getId() !== null
        ]);

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
