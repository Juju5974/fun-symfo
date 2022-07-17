<?php

namespace App\FormManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PostType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
}