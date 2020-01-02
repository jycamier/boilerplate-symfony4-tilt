<?php


namespace App\UI\Controller\Offer;

use App\Application\Command\Offer\CreateOffer;
use App\Application\Query\Offer\GetLastOfferForList;
use App\Domain\Offer\OfferRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class Create extends AbstractController
{
    private MessageBusInterface $messageBus;
    private OfferRepositoryInterface $offerRepository;

    public function __construct(MessageBusInterface $messageBus, OfferRepositoryInterface $offerRepository)
    {
        $this->messageBus = $messageBus;
        $this->offerRepository = $offerRepository;
    }

    public function __invoke(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, ['help' => 'Offer name', 'attr' => ['class' => 'form-control']])
            ->add(
                'uuid',
                TextType::class,
                ['required' => false, 'help' => 'Offer identifier', 'attr' => ['class' => 'form-control']]
            )
            ->add('save', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        $form->handleRequest($request);

        try {
            if ($form->isSubmitted()) {
                $name = $form->getData()['name'];
                $uuid = $form->getData()['uuid'] ?? Uuid::uuid4()->toString();
                $this->messageBus->dispatch(new CreateOffer($name, $uuid));
                $this->addFlash('success', "Offer {$name}:{$uuid} is successfully created");
            }
        } catch (HandlerFailedException $exception) {
            $this->addFlash('danger', $exception->getMessage());
            foreach ($exception->getNestedExceptions() as $nestedException) {
                foreach ($nestedException->getViolations() as $violation) {
                    $this->addFlash('danger', $violation->getMessage());
                }
            }
        }

        $envelope = $this->messageBus->dispatch(new GetLastOfferForList());
        $handledStamp = $envelope->last(HandledStamp::class);

        return $this->render(
            'ui/offer/offer.html.twig',
            [
                'form' => $form->createView(),
                'offers' => $handledStamp->getResult(),
            ]
        );
    }
}
