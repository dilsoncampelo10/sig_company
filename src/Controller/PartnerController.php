<?php

namespace App\Controller;

use App\Repository\PartnerRepository;
use App\Service\PartnerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PartnerController extends AbstractController
{

    function __construct(private PartnerService $partnerService)
    {
    }
    #[Route('/partners', name: 'partners', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $partners = $this->partnerService->findAll();

        return $this->json(
            $partners,
            200,
            [],
            [ObjectNormalizer::IGNORED_ATTRIBUTES => ['partnerId', 'password']]
        );
    }

    #[Route('/partners/{partner}', name: 'partners_show', methods: ['GET'])]
    public function show(int $partner): JsonResponse
    {
        $partner = $this->partnerService->findById($partner);

        return $this->json(
            $partner,
            200,
            [],
            [ObjectNormalizer::IGNORED_ATTRIBUTES => ['partnerId', 'password']]

        );
    }

    #[Route('/partners', name: 'partners_store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $data = $request->toArray();

        $partner = $this->partnerService->create($data);

        return $this->json(
            [
                'message' => 'Partner Created successfuly',
                'data' => $partner,
            ],
            201,
            [],
            [ObjectNormalizer::IGNORED_ATTRIBUTES => ['partnerId', 'password']]
        );
    }

    #[Route('/partners/{partner}', name: 'partners_update', methods: ['PUT'])]
    public function update(int $partner, Request $request, ManagerRegistry $doctrine, PartnerRepository $companyRepository): JsonResponse
    {
        $data = $request->toArray();

        $partner = $this->partnerService->update($partner, $data);

        return $this->json(
            [
                'message' => 'Company Updated successfuly',
                'data' => $partner,
            ],
            201,
            [],
            [ObjectNormalizer::IGNORED_ATTRIBUTES => ['partnerId', 'password']]
        );
    }

    #[Route('/partners/{partner}', name: 'partners_delete', methods: ['DELETE'])]
    public function delete(int $partner, PartnerRepository $partnerRepository): JsonResponse
    {
        $partner = $this->partnerService->delete($partner);

        return $this->json(
            ['data' => $partner->getId()],
            204

        );
    }
}
