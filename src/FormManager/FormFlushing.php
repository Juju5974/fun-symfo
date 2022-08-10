<?php

namespace App\FormManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

Class FormFlushing extends AbstractController {
    public function flushPostForm ($post, $em, $user)
    {
        $post->setDate(new \DateTime('now'));
        $post->setSubscriber($user);
        $em->persist($post);
        $em->flush();
        //dump($post);
        $this->addFlash('success', 'Votre contribution a bien été prise en compte.');
        return $this->json(['success' => 'ok']);
    }

    public function flushVoteForm ($vote, $em, $user, $postRepository, $post)
    {
        $voteRating = $vote->getRating();
        $postId = $vote->getPost();
        $post = $postRepository->findBy(['id'=> $postId]);
        $postRating = $post[0]->getRating() ;
        $postVotesCount = $post[0]->getVotesCount();
        $post[0]->setRating(($postRating * $postVotesCount + $voteRating) / ($postVotesCount + 1));
        $post[0]->setVotesCount($postVotesCount + 1);
        $vote->setSubscriber($user);
        $em->persist($vote, $post);
        $em->flush();
        $this->addFlash('success', 'Votre contribution a bien été prise en compte');
    }

    public function flushNewUserForm ($newUser, $em, $passwordHasher)
    {      
        $password = $newUser->getPassword();
        $hashedPassword = $passwordHasher->hashPassword($newUser, $password);
        $newUser->setPassword($hashedPassword);
        $em->persist($newUser);
        $em->flush();
        $this->addFlash('success', 'Merci pour votre inscription !');
    }
}