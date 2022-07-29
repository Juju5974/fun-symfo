<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Vote;

Class TestForm extends AbstractController {
    #[Route('/testpost', name: 'testpost')]
    public function testPostForm (Request $request, ValidatorInterface $validator)
    {
        header("Access-Control-Allow-Origin: http://radiant-hamlet-79456.herokuapp.com/collection");
        header("Access-Control-Allow-Methods: POST");
        header("HTTP/1.1 200 OK");
        header("Content-Type: text/html");
        // On créé l'entité $post avec les données fourni en POST
        $post = new Post();
        $post->setContent($request->request->get('content'));


		// On récupère la liste des erreurs de notre entité $user
		$errors = $validator->validate($post);
        
        //$response = new JsonResponse($errors);
        return $this->json([$errors]);
    }

    #[Route('/testvote', name: 'testvote')]
    public function testVoteForm (Request $request, ValidatorInterface $validator)
    {
        header("Access-Control-Allow-Origin: http://radiant-hamlet-79456.herokuapp.com/collection");
        header("Access-Control-Allow-Methods: POST");
        header("HTTP/1.1 200 OK");
        header("Content-Type: text/html");
        // On créé l'entité $post avec les données fourni en POST
        $vote = new Vote();
        $vote->setRating($request->request->get('rating'));

		// On récupère la liste des erreurs de notre entité $user
		$errors = $validator->validate($vote);
        dump($errors);
        //$response = new JsonResponse($errors);
        return $this->json([$errors]);
    }
}