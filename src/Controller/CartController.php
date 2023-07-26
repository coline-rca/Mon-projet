<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(SessionInterface $session, ManagerRegistry $doctrine): Response
    {

        # On récupère la session 'cart' si elle existe, sinon elle est créée avec un tableau vide, (on appelle 'cart' pas la variable !)
        $cart = $session->get('cart', []);

        $cartData = [];

        # On boucle sur la session 'cart' pour récuperer l'objet (au lieu de l'id) et la quantite
        foreach ($cart as $id => $quantity) {
            $cartData[] = [
                "product" => $doctrine->getRepository(Product::class)->find($id),
                "quantity" => $quantity
            ];
        }

        // dd($cartData);

        # On calcule le total du panier 
        $total = 0;

        foreach ($cartData as $id => $value)
        {
            $total += $value['product']->getPrice() * $value['quantity'];
        }

        # On calcule la quantite
        $qtty = 0;
        foreach ($cartData as $id => $value)
        {
            $qtty += $value['quantity'];
        }

        return $this->render('cart/cart.html.twig', [
            // 'cart' => $cart,
            'items' => $cartData,
            'total' => $total,
            'qtty' => $qtty
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function cartAdd($id, SessionInterface $session)
    {
        # On récupère la session 'cart' si elle existe, sinon elle est créée avec un tableau vide
        $cart = $session->get('cart', []);

        #On ajoute la quantité 1 au produit d'id $id
        if (empty($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }

        # On remplace la variable de session panier par le nouveau tableau
        $session->set('cart', $cart);

        // dd($session->get('cart', []));
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove/{id}', name:'cart_remove')]
    public function cartDelete($id, SessionInterface $session)
    {
        # On récupère la session 'cart' si elle existe, sinon elle est créée avec un tableau vide
        $cart = $session->get('cart', []);

        if (!empty($cart[$id]))
        {
            # Pour enlever 1 en 1 :
             $cart[$id]--;

             if ($cart[$id] <= 0)
             {
                 unset($cart[$id]); // unset pour dépiler de la session
             }
        }

        # On réaffecte le nouveau panier a la session
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');

    }

    #[Route('/cart/all/delete', name:'cart_all_delete')]
    public function cartDeleteAll(SessionInterface $session)
    {

        $cart = $session->get('cart', []);

        unset($cart);

        $session->set('cart', []);

        return $this->redirectToRoute('index');

    }

}
