<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="products")
     */
    public function products(ManagerRegistry $doctrine)
    {

        $products = $doctrine->getRepository(Product::class)->findAll();

        $this->render("Products/products.html.twig", [
            "products" => $products
        ]);

        
    }
}