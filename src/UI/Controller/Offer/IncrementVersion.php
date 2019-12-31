<?php


namespace App\UI\Controller\Offer;

use App\Application\Command\Offer\IncrementVersion as IncrementVersionCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class IncrementVersion extends AbstractController
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request, string $uuid, string $version)
    {
        $this->messageBus->dispatch(new IncrementVersionCommand($version, $uuid));

        return $this->redirectToRoute('offer_create');
    }
}
