<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
