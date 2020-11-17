<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Repository\PostsRepository;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
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
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form= $this->createForm(ContactFormType::class);
        $contact = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to(new Address('moi@gmail.com'))
                ->subject('Contact par le biai du formulaire de contact')

                // path of the Twig template to render
                ->htmlTemplate('emails/contact_email.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'Nom' => $contact->get('username')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData(),
                ]);
                $mailer->send($email);

                $this->addFlash('success','Votre message a bien été envoyé');
                return $this->redirectToRoute('app_home');
        }
        return $this->render('main/contact.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/about", name="app_about")
     */
    public function about()
    {
        return $this->render('main/about.html.twig');
    }

}
