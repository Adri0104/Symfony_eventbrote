<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/events/{event}/registrations", name="registration.index")
     */
    public function index(Event $event)
    {
        return $this->render('registration/index.html.twig', [
            'event' => $event,
            'registrations' => $event->getRegistrations()
        ]);
    }
}
