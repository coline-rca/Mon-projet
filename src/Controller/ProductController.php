<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    #[Route('/products', name: 'products')]
    public function products(ManagerRegistry $doctrine)
    {

        // $this->denyAccessUnlessGranted('ROLE_USER');
        $products = $doctrine->getRepository(Product::class)->findAll();

        return $this->render("products/list.html.twig", [
            "products" => $products
        ]);
    }


    #[Route('/item/{id}', name: 'item')]
    public function item(ManagerRegistry $doctrine, $id)
    {

        $item = $doctrine->getRepository(Product::class)->find($id);

        return $this->render("products/item.html.twig", [
            "item" => $item
        ]);
    }
}
