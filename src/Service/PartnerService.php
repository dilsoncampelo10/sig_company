<?php

namespace App\Service;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PartnerService
{
    function __construct(private PartnerRepository $partnerRepository, private ManagerRegistry $doctrine, private UserPasswordHasherInterface $passwordHasher)
    {
    }
    public function findAll()
    {
        $partner = $this->partnerRepository->findAll();

        return $partner;
    }
    public function findById(int $id)
    {
        $partner = $this->partnerRepository->find($id);

        if (!$partner) throw new NotFoundHttpException();

        return $partner;
    }

    public function create(array $data)
    {

        $partner = new Partner();

        $partner->setName($data['name']);
        $partner->setEmail($data['email']);
        $partner->setPassword(
            $this->passwordHasher->hashPassword(
                $partner,
                $data['password']
            )
        );
        $partner->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $this->partnerRepository->add($partner, true);

        return $partner;
    }

    public function update(int $id, array $data)
    {
        $partner = $this->findById($id);

        $partner->setName($data['name']);
        $partner->setStatus(boolval($data['status']));

        $partner->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $this->doctrine->getManager()->flush();

        return $partner;
    }

    public function delete(int $id)
    {
        $partner = $this->findById($id);

        $this->partnerRepository->remove($partner, true);

        return $partner;
    }
}
