<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index()
    {
        return $this->render('main/index.html.twig');
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
