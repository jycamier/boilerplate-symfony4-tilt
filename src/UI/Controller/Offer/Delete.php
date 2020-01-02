<?php


namespace App\UI\Controller\Offer;

use App\Application\Command\CommandMessageBus;
use App\Application\Command\Offer\DeleteOffer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class Delete extends AbstractController
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request, string $uuid)
    {
        try {
            $this->messageBus->dispatch(new DeleteOffer($uuid));

            $this->addFlash('success', "Offer {$uuid} is successfully deleted");
        } catch (HandlerFailedException $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }

        return $this->redirectToRoute('offer_create');
    }
}
