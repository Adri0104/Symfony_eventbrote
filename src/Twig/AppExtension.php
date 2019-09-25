<?php

namespace App\Twig;

use App\Entity\Event;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
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
}
