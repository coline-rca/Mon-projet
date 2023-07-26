<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    #[Route('admin/product/new', name: 'admin_product_new')]
    public function new(Request $request, ManagerRegistry $doctrine){
        $product = new Product;

        $formProduct = $this->createForm(ProductType::class, $product);

        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid()){

            $product->setCreatedAt(new DateTimeImmutable("now"));

            $entityManager = $doctrine->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute("user");
        }

        return $this->render("admin/form.html.twig", [
            "formProduct" => $formProduct->createView()
        ]);
    }
    
    #[Route('/admin/product/update/{id}', name: 'admin_product_update')]
    public function update(Request $request, ManagerRegistry $doctrine, $id){
        
        $product = $doctrine->getRepository(Product::class)->find($id);

        $formProduct = $this->createForm(ProductType::class, $product);

        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid()){

            $product->setUpdatedAt(new DateTimeImmutable("now"));

            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("user");
        }

        return $this->render("admin/form.html.twig", [
            "formProduct" => $formProduct->createView()
        ]);
    }

    #[Route('admin/product/delete/{id}', name:'admin_product_delete')]
    public function delete(ManagerRegistry $doctrine, $id)
    {

        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $doctrine->getManager();
        $product = $doctrine->getRepository(Product::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute("user");
    }

}
