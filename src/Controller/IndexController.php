<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    #[Route('/', name:"index")]
    public function index(ManagerRegistry $doctrine)
    {
        $products = $doctrine->getRepository(Product::class)->mainProduct();

        return $this->render('index/index.html.twig', [
            "products" => $products
        ]);
        
    }
}
