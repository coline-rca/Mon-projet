<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController{

    #[Route('/user', name: 'user')]
    public function index()
    {
        return $this->render('user/index.html.twig');
    }

    #[Route('/user/update/{id}', name: 'user_update')]
    public function update(Request $request, ManagerRegistry $doctrine, $id){
        
        $user = $doctrine->getRepository(User::class)->find($id);

        $formUser = $this->createForm(ProfileType::class, $user);

        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()){

            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("user");
        }

        return $this->render("user/form.html.twig", [
            "formUser" => $formUser->createView()
        ]);
    }

}



