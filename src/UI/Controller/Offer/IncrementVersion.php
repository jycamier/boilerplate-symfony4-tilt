<?php


namespace App\UI\Controller\Offer;

use App\Application\Command\Offer\IncrementVersion as IncrementVersionCommand;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
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
        try {
            $this->messageBus->dispatch(new IncrementVersionCommand($version, $uuid, Uuid::uuid4()->toString()));
            $this->addFlash('success', "Offer {$uuid} have been increment on the {$version} type");
        } catch (HandlerFailedException $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }

        return $this->redirectToRoute('offer_create');
    }
}
