<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Article;
use App\Entity\Category;

class BlogController extends AbstractController
{

    /**
     * @Route("/blog/{slug}", requirements={"slug"="^[a-z0-9]+(?:-[a-z0-9]+)*$"}, name="blog")
     */
    public function show($slug="article-sans-titre")
    {
        $title = str_replace('-',' ',$slug);
        $title = ucwords($title);
        return $this->render('blog/index.html.twig', [
            'title' => $title,
        ]);

    }

    /**  
     * Show all row from article's entity
     *  
     * @Route("/", name="blog_index")  
     * @return Response A response instance  
     */
    public function index() : Response  
    {  
        $articles = $this->getDoctrine()  
            ->getRepository(Article::class)  
            ->findAll();  

        if (!$articles) {  
            throw $this->createNotFoundException(  
            'No article found in article\'s table.'
            );  
        }  

        return $this->render(  
                'blog/index.html.twig',  
                ['articles' => $articles]  
        );  
    }

    /**  
     * Show all article from one category
     *  
     * @Route("/blog/category/{category}", name="blog_show_category")  
     * @return Response A response instance  
     */
    public function showByCategory(string $category) : Response  
    {  
        $categoryToPrint = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByName($category);

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['category' => $categoryToPrint->getId()]);

        return $this->render(  
                'blog/category.html.twig',  
                ['articles' => $articles]  
        );  
    }
}
