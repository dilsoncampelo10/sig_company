<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class PartnerController extends AbstractController
{
    #[Route('/partners', name: 'partners', methods: ['GET'])]
    public function index(PartnerRepository $partnerRepository): JsonResponse
    {
        return $this->json(
            $partnerRepository->findAll(),
        );
    }

    #[Route('/partners/{partner}', name: 'partners_show', methods: ['GET'])]
    public function show(int $partner, PartnerRepository $partnerRepository): JsonResponse
    {
        $partner = $partnerRepository->find($partner);

        if (!$partner) throw $this->createNotFoundException();

        return $this->json(
            $partner

        );
    }

    #[Route('/partners', name: 'partners_store', methods: ['POST'])]
    public function store(Request $request, UserPasswordHasherInterface $passwordHasher, PartnerRepository $partnerRepository): JsonResponse
    {
        $data = $request->toArray();
        $partner = new Partner();
        $partner->setName($data['name']);
        $partner->setEmail($data['email']);
        $partner->setPassword(
            $passwordHasher->hashPassword(
                $partner,
                $data['password']
            )
        );
        $partner->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $partnerRepository->add($partner, true);

        return $this->json([
            'message' => 'Partner Created successfuly',
            'data' => $partner,
        ], 201);
    }
}
