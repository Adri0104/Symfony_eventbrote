<?php

namespace App\Twig;

use App\Entity\Event;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('datetime', [$this, 'formatDateTime']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_price', [$this, 'formatPrice'], ['is_safe' => ['html']]),
            new TwigFunction('pluralize', [$this, 'pluralize']),
            new TwigFunction('register_link_or_sold_out', [$this, 'registerLinkOrSoldOut'], ['is_safe' => ['html']]),
        ];
    }

    public function formatPrice(Event $event) : string
    {
        /*if($event->isFree()) {
            return '<b>Free</b>';
        } else {
            return '€'.$event->getPrice();
        }*/
        return $event->isFree() ? '<span class="badge badge-primary">Free!</span>' : twig_localized_currency_filter($event->getPrice(), 'EUR');
    }

    public function formatDateTime(\DateTimeInterface $dateTime): string
    {
        return$dateTime->format('F d, Y \\a\\t H:i A');
    }

    public function pluralize(int $count, string $singular, ?string $plural = null): string
    {
        $plural = $plural ?? $singular . 's';
        $string = $count == 1 ? $singular : $plural;
        return "$count $string";
    }

    public function registerLinkOrSoldOut(Event $event): string
    {
        if ($event->isSoldOut()) {
            return '<span class="badge badge-warning text-uppercase">Sold out</span>';
        } else {
            return sprintf('<p><a href="%s">Register</a></p>', $this->router->generate('registrations.create', ['event' => $event->getId()]));
        }
    }
}
