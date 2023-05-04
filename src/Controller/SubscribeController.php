<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Model\ErrorResponse;
use App\Model\SubscriberRequest;
use App\Service\SubscriberService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeController extends AbstractController
{
    public function __construct(private readonly SubscriberService $subscriberService)
    {
    }

    #[OA\RequestBody(attachables: [new Model(type: SubscriberRequest::class)])]
    #[OA\Response(
        response: 200,
        description: 'Subscribe by email',
    )]
    #[OA\Response(
        response: 400,
        description: 'Validation failed',
        attachables: [new Model(type: ErrorResponse::class)]
    )]
    #[OA\Response(
        response: 409,
        description: 'Subscriber already exists',
    )]
    #[OA\Tag(name: 'Subscribe to newsletter')]
    #[Route(path: 'api/v1/subscribe', methods: ['POST'])]
    public function action(#[RequestBody] SubscriberRequest $subscriberRequest): Response
    {
        $this->subscriberService->subscribe($subscriberRequest);

        return $this->json(['']);
    }
}
