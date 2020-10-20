<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostsController extends AbstractController
{
    /**
     * @Route("/posts", name="app_posts")
     */
    public function index(PostsRepository $postsRepository)
    {
        $posts = $postsRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('posts/index.html.twig', compact('posts'));
    }
}
