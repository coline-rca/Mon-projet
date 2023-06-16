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

        $products = $doctrine->getRepository(Product::class)->findAll();

        $this->render("products/products.html.twig", [
            "products" => $products
        ]);
    }


    #[Route('/item', name: 'item')]
    public function item()
    {

        return $this->render("products/item.html.twig");
    }
}
