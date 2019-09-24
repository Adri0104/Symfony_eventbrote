<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EventRepository $repo) : Response
    {
//        $repo = $em->getRepository(Event::class);
        $events = $repo->findAll();
        return $this->render('events/index.html.twig', compact('events'));
    }
}
