<?php

namespace App\Service;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyService
{
    function __construct(private CompanyRepository $companyRepository, private ManagerRegistry $doctrine)
    {
    }
    public function findAll()
    {
        $company = $this->companyRepository->findAll();

        return $company;
    }
    public function findById(int $id)
    {
        $company = $this->companyRepository->find($id);

        if (!$company) throw new NotFoundHttpException();

        return $company;
    }

    public function create(array $data)
    {

        $company = new Company();

        $company->setName($data['name']);
        $company->setCnpj($data['cnpj']);
        $company->setSite($data['site']);
        $company->setPhone($data['phone']);
        $company->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $this->companyRepository->add($company, true);

        return $company;
    }

    public function update(int $id, array $data)
    {
        $company = $this->findById($id);

        $company->setName($data['name']);
        $company->setCnpj($data['cnpj']);
        $company->setSite($data['site']);
        $company->setPhone($data['phone']);

        $company->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $this->doctrine->getManager()->flush();

        return $company;
    }

    public function delete(int $id)
    {
        $company = $this->findById($id);

        $this->companyRepository->remove($company, true);

        return $company;
    }
}
