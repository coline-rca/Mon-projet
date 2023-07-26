<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController {
    #[Route('/orders', name: 'orders')]
    public function orders(ManagerRegistry $doctrine)
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $orders = $doctrine->getRepository(Order::class)->findAll();

        return $this->render("order/list.html.twig", [
            "orders" => $orders
        ]);
    }
}