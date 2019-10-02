<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/events/{event}/registrations", name="registrations.index", methods={"GET"})
     */
    public function index(Event $event)
    {
        return $this->render('registration/index.html.twig', [
            'event' => $event,
            'registrations' => $event->getRegistrations()
        ]);
    }

    /**
     * @Route("/events/{event}/registrations/create", name="registrations.create", methods={"GET", "POST"})
     */
    public function create(Event $event, Request $request, EntityManagerInterface $em)
    {
        $registration = new Registration();
        $form = $this->createForm(RegistrationFormType::class, $registration);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $registration->setEvent($event);
            $em->persist($registration);
            $em->flush();
            $this->addFlash('success', 'Thanks, you are registered');
            return $this->redirectToRoute('registrations.index', ['event' => $event->getId()]);
        }
        return $this->render('registration/create.html.twig', [
            'event' => $event,
            'form' => $form->createView()
        ]);
    }
}
