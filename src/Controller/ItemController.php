<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\User;
use App\Entity\InventoryItem;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ItemController extends AbstractController
{
    public function __construct(private ItemRepository $itemRepository) {}

    
    #[Route('/api/shop', name: 'app_item', methods: ['GET'])]
    public function shop(): Response
    {
        $items = $this->itemRepository->findAll();

        return $this->json($items);
    }

    
    #[Route('/api/shop/buy/{id}', methods: ['POST'])]
    public function buy(int $id, EntityManagerInterface $em): Response {
        $user = $this->getUser();

        if (!$user instanceof User) {
            return $this->json(['message' => 'Non authentifié'], );
        }

        $item = $this->itemRepository->find($id);

        if (!$item) {
            return $this->json(['message' => 'Item introuvable'], );
        }

        if ($user->getCredits() < $item->getPrice()) {
            return $this->json(['message' => 'Crédits insuffisants'], );
        }

       
        $user->setCredits(
            $user->getCredits() - $item->getPrice()
        );

        $inventoryItem = new InventoryItem();
        $inventoryItem->setUser($user);
        $inventoryItem->setItem($item);
        $inventoryItem->setQuantity(1);

        $em->persist($inventoryItem);
        $em->flush();

        return $this->json([
            'message' => 'Item acheté avec succès'
        ]);
    }
}
