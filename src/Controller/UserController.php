<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    public function __construct(private UserRepository $user){}

    #[Route('/api/register', name: 'app_user', methods: ['POST'])]
    
    public function inscription(Request $request, EntityManagerInterface $em, ): Response {

        $data = json_decode($request->getContent(), true);

        if (
            empty($data['email']) || empty($data['password']) || empty($data['pseudoMinecraft'])
           )
         {
            return $this->json([
                'message' => 'Champs manquants'
            ], 400);
          }

     
        if ($this->user->findOneBy(['email' => $data['email']])) {
            return $this->json([
                'message' => 'Cet email est déjà utilisé'
            ], 409);
        }

  
        $user = new User();
        $user->setEmail($data['email']);
        $user->setPseudoMinecraft($data['pseudoMinecraft']);
        $user->setRoles(['ROLE_USER']);
        $user->setCredits(0);
        $user->setDateInscription(new \DateTime());
        $user->setPassword(md5 ($data['password']));


      
        $em->persist($user);
        $em->flush();

        return $this->json([
            'message' => 'Utilisateur créé avec succès'
        ], 201);
    }

   
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function connexion(): Response {

        return new Response();

    }

  
    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
      public function me(): Response
         {
             $user = $this->getUser();

             if (!$user instanceof User) {
             return $this->json([
            'message' => 'Utilisateur non authentifié'
        ], 401);
        
         }

         return $this->json([
        'email' => $user->getEmail(),
        'pseudoMinecraft' => $user->getPseudoMinecraft(),
        'credits' => $user->getCredits(),
        'roles' => $user->getRoles(),
    ]);
}


    
    #[Route('/api/me', name: 'api_me_update', methods: ['PUT'])]
    public function updateProfile(Request $request, EntityManagerInterface $em ):Response {
        /** @var User $user */
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);

        if (isset($data['pseudoMinecraft'])) {
            $user->setPseudoMinecraft($data['pseudoMinecraft']);
        }

        $em->flush();

        return $this->json(['message' => 'Profil mis à jour']);
    }

}