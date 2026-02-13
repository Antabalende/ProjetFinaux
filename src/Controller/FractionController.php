<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Faction;
use App\Repository\FactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FactionController extends AbstractController
{
    #[Route('/api/faction', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            return $this->json(['message' => 'Non authentifié']);
        }

        if ($user->getCredits() < 1000) {
            return $this->json(['message' => 'Crédits insuffisants']);
        }

        $data = json_decode($request->getContent(), true);

        if (empty($data['name'])) {
            return $this->json(['message' => 'Nom requis']);
        }

        $faction = new Faction();
        $faction->setName($data['name']);
        $faction->setDescription($data['description'] ?? null);
        $faction->setPower(0);

   
        $user->setCredits($user->getCredits() - 1000);
        $user->setFaction($faction);

        $em->persist($faction);
        $em->flush();

        return $this->json(['message' => 'Faction créée'], 201);
    }
}
