<?php

namespace App\Controller\Admin;

use App\Entity\Posts;
use App\Entity\Users;
use App\Entity\Comments;
use App\Repository\PostsRepository;
use App\Repository\UsersRepository;
use App\Repository\CommentsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class AdminController extends AbstractDashboardController
{
    protected $usersRepository;
    protected $commentsRepository;
    public function __construct(UsersRepository $usersRepository, CommentsRepository $commentsRepository, PostsRepository $postsRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->commentsRepository = $commentsRepository;
        $this->postsRepository = $postsRepository;
    }
    /**
     * @Route("/admin_1804", name="app_admin_")
     * Require ROLE_ADMIN for *every* controller method in this class.
     *
     * @IsGranted("ROLE_ADMIN")
     */

    public function index(): Response
    {
        return $this->render(
            'bundles/EasyAdminBundle/welcome.html.twig',
            [
                'countAllComments' => $this->commentsRepository->countAllComments(),
                'countAllUsers' => $this->usersRepository->countAllUsers(),
                'posts' => $this->postsRepository->findAll()

            ]
        );
    }
    /**
     * Require ROLE_ADMIN for only this controller method.
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminDashboard()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTranslationDomain('')
            ->setTitle('Alain N Bahire')
            ->setFaviconPath('assets/img/favicon-a.ico')
            ->setTextDirection('ltr')
        ;
    }
    

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Articles', 'fa fa-book', Posts::class);
        yield MenuItem::linkToCrud('Commentaires', 'fa fa-comments', Comments::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', Users::class);
    }
}
