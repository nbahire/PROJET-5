<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostFormType;
use App\Repository\PostsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/posts/{id<[0-9]+>}", name="app_posts_show", methods="GET")
     */
    public function show(posts $post): Response
    {
        return $this->render('posts/show.html.twig', compact('post'));
    }

    /**
     * @Route("/posts/create", name="app_posts_create", methods={"GET","POST"})
     */

    public function create(Request $request, EntityManagerInterface $em, UsersRepository $userRepository): Response

    {
        $post = new Posts;
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'Post successfully created!');
            return $this->redirectToRoute('app_posts', ['id' => $post->getId()]);
        }
        return $this->render('posts/create.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/posts/{id<[0-9]+>}/edit", name="app_posts_edit", methods={"GET", "PUT"})
     */
    public function edit(Request $request, EntityManagerInterface $em, posts $post): Response
    {
        $form = $this->createForm(postFormType::class, $post, ['method' => 'PUT']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'post successfully updated!');

            return $this->redirectToRoute('app_posts_show', ['id' => $post->getId()]);
        }
        return $this->render('posts/edit.html.twig', ['post' => $post, 'form' => $form->createView()]);
    }
    /**
     * @Route("/posts/{id<[0-9]+>}", name="app_posts_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $em, posts $post): Response
    {
        if ($this->isCsrfTokenValid('post_deletion_' . $post->getId(), $request->request->get('csrf_token'))) {
            $em->remove($post);
            $em->flush();
            $this->addFlash('info', 'post successfully deleted!');
        }
        return $this->redirectToRoute('app_home');
    }

}
