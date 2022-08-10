<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Subscriber;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\FormManager\FormSetting;
use App\FormManager\FormFlushing;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        
    }

    #[Route('/register', name: 'register')]
    public function register(FormSetting $formSetting, FormFlushing $formFlushing, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $newUser = new Subscriber();
        $newUserForm = $formSetting->getNewUserForm($request, $newUser);
        if ($newUserForm->isSubmitted() && $newUserForm->isValid()) 
        {
            $formFlushing->flushnewUserForm($newUser, $em, $passwordHasher);
            return $this->redirectToRoute('index');
        }
        return $this->render('login/register.html.twig', [
            'newUserForm' => $newUserForm->createView()
        ]);
    }
}

