<?php

namespace App\Controller;

use DateTime;
use Stripe\Stripe;
use App\Entity\Order;
use DateTimeImmutable;
use App\Entity\Product;
use Stripe\Checkout\Session;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PaymentController extends AbstractController {

    #[Route('/checkout', name:'payment_checkout')]
    public function checkout($stripeSK, SessionInterface $session, ManagerRegistry $doctrine)
    {

        Stripe::setApiKey($stripeSK);

        #On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $cart = $session->get('cart', []);

        #Ici on formate un tableau appelé panierData pour que les données soient plus facilement lisibles
        $cartData = [];
        foreach($cart as $id => $quantity)
        {
            #On enrichi le tableau avec l'objet (qui contient toutes les informations du produit) + la quantité
            $cartData[] = [
                "product" => $doctrine->getRepository(Product::class)->find($id),
                "quantity" => $quantity
            ];
        }

        #On construit le line_items pour envoyer ce format a Stripe, afin qu'il puisse afficher correctement dans le module de paiement Stripe.
        foreach($cartData as $id => $value)
        {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $value['product']->getName(),
                    ],
                    'unit_amount' => $value['product']->getPrice()*100, //Attention: bien mettre le format sans virgule et collé avec les centimes => dans notre cas, le prix est un entier donc ici on multiplie simplement par 100 (exemple 20€ donne 2000)
                    ],
                    'quantity' => $value['quantity'],                
                ];
        }



        $session = Session::create([
            'line_items' => [
                $line_items //On place le tableau construit juste au-dessus, pour les line_items.
            ],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }

    #[Route('/payment/success', name:"success_url")]
    public function success(SessionInterface $session, ManagerRegistry $doctrine)
    {

        $cart = $session->get('cart', []);

        $cartData = [];
        foreach($cart as $id => $quantity)
        {
            $cartData[] = [
                "product" => $doctrine->getRepository(Product::class)->find($id),
                "quantity" => $quantity
            ];
        }

        // Création de la commande dans la base de données
        $order = new Order;
        $order->setNumber(uniqid());
        $order->setCreatedAt( new DateTimeImmutable("now"));
        $order->setIsPaid(true);
        $order->setPaidAt(new DateTimeImmutable("now"));
        $user = $this->getUser();
        $order->setUser($user);
        $price = 0;
        foreach ($cartData as $item) {
            $price += $item['product']->getPrice()* $item['quantity'];
        }
        $order->setPrice($price);
        
        $entityManager = $doctrine->getManager();
        $entityManager->persist($order);
        $entityManager->flush();

        $session->remove('cart');
        
        return $this->render("payment/success.html.twig");
    }

    #[Route('/payment/cancel', name:"cancel_url")]
    public function cancel()
    {
        return $this->render("payment/cancel.html.twig");
    }

}
