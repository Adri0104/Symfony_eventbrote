<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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
//        $events = $repo->findBy([], ['startsAt' => 'ASC']);
        $events = $repo->findUpComing();
        return $this->render('events/index.html.twig', compact('events'));
    }

    /**
     * @Route("/events/create", name="events.create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $event = new Event();
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('events.show', ['id' => $event->getId()]);
        }
        return $this->render('events/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/events/{id<[0-9]+>}", name="events.show", methods={"GET"})
     */
    public function show(/*EventRepository $repo,*/ /*$id*/ Event $event): Response
    {
        /*$event = $repo->find($id);
        if(!$event) {
            throw $this->createNotFoundException('Event with id #' . $id . ' not found');
        }*/
        return $this->render('events/show.html.twig', compact('event'));
    }

    /**
     * @Route("/events/{id<[0-9]+>}/edit", name="events.edit", methods={"GET", "PATCH"})
     */
    public function edit(Event $event, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EventFormType::class, $event, ['method' => 'PATCH']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('events.show', ['id' => $event->getId()]);
        }
        return $this->render('events/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/events/{id<[0-9]+>}/delete", name="events.delete", methods={"DELETE"})
     */
    public function delete(Event $event, Request $request, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('deleteEvent', $request->get('_token'))) {
            $em->remove($event);
            $em->flush();
        }
        return $this->redirectToRoute('events.index');
    }
}
