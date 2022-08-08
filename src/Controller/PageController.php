<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use App\Entity\Vote;
use App\Repository\VoteRepository;
use App\FormManager\FormSetting;
use App\FormManager\FormFlushing;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

Class PageController extends AbstractController {
    #[Route('/', name: 'index')]
    public function index(FormSetting $formSetting, FormFlushing $formFlushing, Request $request, EntityManagerInterface $em, PostRepository $postRepository, VoteRepository $voteRepository)
    {
        $user = $this->getUser();

        $post = new Post();
        $postForm = $formSetting->getPostForm($request, $post);
        if ($postForm->isSubmitted() && $postForm->isValid()) 
        {
            if (!$this->getUser())
            {
                return $this->redirectToRoute('login');
            }   
            $formFlushing->flushPostForm($post, $em, $user);
            return $this->redirectToRoute('index');
        }

        $vote = new Vote();
        $voteForm = $formSetting->getVoteForm($request, $vote);
        if ($voteForm->isSubmitted() && $voteForm->isValid()) 
        {
            if (!$this->getUser())
            {
                return $this->redirectToRoute('login');
            }   
            $formFlushing->flushVoteForm($vote, $em, $user, $postRepository, $post);
            return $this->redirectToRoute('index');
        }

        $posts = $postRepository->findBy([],['rating'=> 'DESC'], 5);
        $votes = $voteRepository->findBy(['subscriber' => $user]);
        return $this->render('index.html.twig', [
            'posts' => $posts,
            'postForm' => $postForm->createView(),
            'voteForm' => $voteForm->createView(),
            'votes' => $votes
        ]);
    }

    #[Route('/collection', name: 'collection')]
    public function collection(
        FormSetting $formSetting, FormFlushing $formFlushing, 
        PostRepository $postRepository, VoteRepository $voteRepository, 
        Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $post = new Post();
        $postForm = $formSetting->getPostForm($request, $post);
        if ($postForm->isSubmitted() && $postForm->isValid()) 
        {
            if (!$this->getUser())
            {
                return $this->redirectToRoute('login');
            }   
            $formFlushing->flushPostForm($post, $em, $user);
            return $this->redirectToRoute('collection');
        }

        $vote = new Vote();
        $voteForm = $formSetting->getVoteForm($request, $vote);
        if ($voteForm->isSubmitted() && $voteForm->isValid()) 
        {
            if (!$this->getUser())
            {
                return $this->redirectToRoute('login');
            }   
            $formFlushing->flushVoteForm($vote, $em, $user, $postRepository, $post);
            return $this->redirectToRoute('collection');
        }

        $posts = $postRepository->findBy([],['id'=> 'DESC']);
        $votes = $voteRepository->findBy(['subscriber' => $user]);

        return $this->render('collection.html.twig', [
            'posts' => $posts,
            'postForm' => $postForm->createView(),
            'voteForm' => $voteForm->createView(),
            'votes' => $votes
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer)
    {
        $postRequest = $request->request;

        $pseudo = $request->request->get('pseudo');
        $mail = $request->request->get('email');
        $category = $request->request->get('category');
        $message = $request->request->get('message');
        //$newsletter = $request->request->get('');
                
        $email = new TemplatedEmail();
        $email->from('juju5974.dev@gmail.com')
            ->to('juju5974.dev@gmail.com')
            ->cc($mail)
            ->subject('test email')
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'pseudo' => $pseudo,
                'mail' => $mail,
                'category' => $category,
                'message' => $message
            ]);

        $mailer->send($email);



        //dump($_POST);

        return $this->render('contact.html.twig');
    }

}