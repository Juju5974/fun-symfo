<?php

namespace App\FormManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PostType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

Class FormSetting extends AbstractController {
    public function getPostForm ($request, $post)
    {
        $postForm = $this->createForm(PostType::class, $post);
        $postForm->handleRequest($request);

        return $postForm;
    }

    public function getVoteForm ($request, $vote)
    {
        $voteForm =  $this->createFormBuilder($vote)
            ->add('rating', ChoiceType::class, [
                'choices'  => [
                    'Choisissez une note :' => false,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ], 
            ])
            ->add('post', EntityType::class, ['class' => Post::class, 'choice_label' => 'id'])
            ->add('submit', SubmitType::class)
            ->getForm();
        $voteForm->handleRequest($request);

        return $voteForm;
    }
    public function getNewUserForm ($request, $newUser)
    {
        $newUserForm =  $this->createFormBuilder($newUser)
            ->add('username',TextType::class, ['attr' => ['placeholder' => 'Pseudo']])
            ->add('email',TextType::class, ['attr' => ['placeholder' => 'Email']])
            ->add('password',TextType::class, ['attr' => ['placeholder' => 'Mot de passe']])
            //->add('post', EntityType::class, ['class' => Post::class, 'choice_label' => 'id'])
            ->add('submit', SubmitType::class)
            ->getForm();
        $newUserForm->handleRequest($request);

        return $newUserForm;
    }
}