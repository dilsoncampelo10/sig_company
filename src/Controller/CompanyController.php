<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Service\CompanyService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CompanyController extends AbstractController
{
    function __construct(private CompanyService $companyService)
    {
    }
    #[Route('/companies', name: 'companies', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $companies = $this->companyService->findAll();
        return $this->json(
           $companies
        );
    }

    #[Route('/companies/{company}', name: 'companies_show', methods: ['GET'])]
    public function show(int $company): JsonResponse
    {
        $company = $this->companyService->findById($company);

        return $this->json(
            $company
        );
    }

    #[Route('/companies', name: 'companies_store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $data = $request->toArray();

        $company = $this->companyService->create($data);

        return $this->json([
            'message' => 'Company Created successfuly',
            'data' => $company,
        ], 201);
    }

    #[Route('/companies/{company}', name: 'companies_update', methods: ['PUT'])]
    public function update(int $company, Request $request): JsonResponse
    {
        $data = $request->toArray();

        $company = $this->companyService->update($company, $data);

        return $this->json([
            'message' => 'Company Updated successfuly',
            'data' => $company,
        ], 201);
    }


    #[Route('/companies/{company}', name: 'companies_delete', methods: ['DELETE'])]
    public function delete(int $company): JsonResponse
    {
        $company = $this->companyService->delete($company);

        return $this->json(
            ['data' => $company->getId()],
            204

        );
    }
}
