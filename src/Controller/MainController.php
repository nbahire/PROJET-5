<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */

    public function index(Request $request, PostsRepository $postsRepository)
    {
        $posts = $postsRepository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('main/index.html.twig', compact('posts'));
    }

    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact()
    {
        return $this->render('main/contact.html.twig');
    }
    /**
     * @Route("/about", name="app_about")
     */
    public function about()
    {
        return $this->render('main/about.html.twig');
    }

}
