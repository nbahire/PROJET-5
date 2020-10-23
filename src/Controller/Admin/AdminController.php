<?php

namespace App\Controller\Admin;

use App\Entity\Posts;
use App\Entity\Users;
use App\Entity\Comments;
use App\Repository\PostsRepository;
use App\Repository\UsersRepository;
use App\Repository\CommentsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class AdminController extends AbstractDashboardController
{
    protected $usersRepository;
    protected $commentsRepository;
    public function __construct(UsersRepository $usersRepository, CommentsRepository $commentsRepository, PostsRepository $postsRepository )
    {

        $this->usersRepository = $usersRepository;
        $this->commentsRepository = $commentsRepository;
        $this->postsRepository = $postsRepository;
    }
    /**
     * @Route("/admin_1804", name="admin_")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index(): Response
    {
        return $this->render(
            'bundles/EasyAdminBundle/welcome.html.twig',
            [
                'countAllComments' => $this->commentsRepository->countAllComments(),
                'countAllUsers' => $this->usersRepository->countAllUsers(),
                'posts' => $this->postsRepository->findAll()

            ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MyPortefolio');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Articles', 'fa fa-book',Posts::class);
        yield MenuItem::linkToCrud('Commentaires', 'fa fa-comments',Comments::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users',Users::class);
    }
    
}
