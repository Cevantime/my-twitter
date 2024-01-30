<?php

namespace App\Controller;

use App\Repository\TweetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $tweetRepository;

    public function __construct(TweetRepository $tweetRepository)
    {
        $this->tweetRepository = $tweetRepository;
    }

    #[Route('', name: 'app_home')]
    public function index(): Response
    {
        $lastTweets = $this->tweetRepository->findLastTweetsWithAuthors();

        return $this->render('home/index.html.twig', [
            'last_tweets' => $lastTweets,
        ]);
    }
}
