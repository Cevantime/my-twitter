<?php

namespace App\Controller;

use App\Repository\TweetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TweetController extends AbstractController
{
    #[Route('/tweet/{id}', name: 'app_tweet')]
    public function one(TweetRepository $tweetRepository, $id): Response
    {
        $tweet = $tweetRepository->find($id);
        return $this->render('tweet/one.html.twig', [
            'tweet' => $tweet,
        ]);
    }
}
