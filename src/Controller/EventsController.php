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
     * @Route("/", name="home", methods={"GET"})
     * @Route("/events", name="events.index", methods={"GET"})
     */
    public function index(EventRepository $repo) : Response
    {
//        $repo = $em->getRepository(Event::class);
        $events = $repo->findAll();
        return $this->render('events/index.html.twig', compact('events'));
    }

    /**
     * @Route("/events/{id<[0-9]+>}", name="events.show", methods={"GET"})
     */
    public function show(/*EventRepository $repo,*/ /*$id*/ Event $event)
    {
        /*$event = $repo->find($id);
        if(!$event) {
            throw $this->createNotFoundException('Event with id #' . $id . ' not found');
        }*/
        return $this->render('events/show.html.twig', compact('event'));
    }

    /**
     * @Route("/events/{id<[0-9]+>}/edit", name="events.edit", methods={"GET"})
     */
    public function edit(/*EventRepository $repo,*/ /*$id*/ Event $event)
    {
        /*$event = $repo->find($id);
        if(!$event) {
            throw $this->createNotFoundException('Event with id #' . $id . ' not found');
        }*/
        return $this->render('events/edit.html.twig', compact('event'));
    }
}
