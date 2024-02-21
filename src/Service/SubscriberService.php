<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Subscriber;
use App\Exception\SubscriberAlreadyExistsException;
use App\Repository\SubscriberRepository;
use App\Request\SubscriberRequest;
use Doctrine\ORM\EntityManagerInterface;

class SubscriberService
{
    /**
     * @param SubscriberRepository $subscriberRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private readonly SubscriberRepository $subscriberRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param SubscriberRequest $request
     * @return void
     */
    public function subscribe(SubscriberRequest $request): void
    {
        if ($this->subscriberRepository->existsByEmail($request->getEmail())) {
            throw new SubscriberAlreadyExistsException();
        }

        $subscriber = new Subscriber();
        $subscriber->setEmail($request->getEmail());

        $this->entityManager->persist($subscriber);
        $this->entityManager->flush();
    }
}
