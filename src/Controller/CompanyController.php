<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CompanyController extends AbstractController
{
    #[Route('/companies', name: 'companies', methods: ['GET'])]
    public function index(CompanyRepository $companyRepository): JsonResponse
    {
        return $this->json(
            $companyRepository->findAll(),
        );
    }

    #[Route('/companies/{company}', name: 'companies_show', methods: ['GET'])]
    public function show(int $company, CompanyRepository $companyRepository): JsonResponse
    {
        $company = $companyRepository->find($company);

        if (!$company) throw $this->createNotFoundException();

        return $this->json(
            $company

        );
    }

    #[Route('/companies', name: 'companies_store', methods: ['POST'])]
    public function store(Request $request, CompanyRepository $companyRepository): JsonResponse
    {
        $data = $request->request->all();
        $company = new Company();
        $company->setName($data['name']);
        $company->setCnpj($data['cnpj']);
        $company->setSite($data['site']);
        $company->setPhone($data['phone']);
        $company->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $companyRepository->add($company, true);

        return $this->json([
            'message' => 'Company Created successfuly',
            'data' => $company,
        ], 201);
    }

    #[Route('/companies/{company}', name: 'companies_update', methods: ['PUT'])]
    public function update(int $company, Request $request, ManagerRegistry $doctrine, CompanyRepository $companyRepository): JsonResponse
    {
        $data = $request->request->all();
        $company = $companyRepository->find($company);


        if (!$company) throw $this->createNotFoundException();

        $company->setName($data['name']);
        $company->setCnpj($data['cnpj']);
        $company->setSite($data['site']);
        $company->setPhone($data['phone']);

        $company->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine->getManager()->flush();

        return $this->json([
            'message' => 'Company Updated successfuly',
            'data' => $company,
        ], 201);
    }
}
