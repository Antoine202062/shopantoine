<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, ProductRepository $productsRepository)
    {
        $cart = $session->get("panier", []);

        // On "fabrique" les données
        $dataCart = [];
        $total = 0;

        foreach($cart as $id => $quantity){
            $product = $productsRepository->find($id);
            $dataCart[] = [
                "product" => $product,
                "quantity" => $quantity
            ];
            $total += $product->getPrise() * $quantity;
        }

        return $this->render('cart/index.html.twig', compact("dataCart", "total"));
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(Product $product, SessionInterface $session)
    {
        // On récupère le panier actuel
        $cart = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $cart);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Product $product, SessionInterface $session)
    {
        // On récupère le panier actuel
        $cart = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($cart[$id])){
            if($cart[$id] > 1){
                $cart[$id]--;
            }else{
                unset($cart[$id]);
            }

        // On sauvegarde dans la session
        $session->set("panier", $cart);

        return $this->redirectToRoute("cart_index");
    }

   }

   /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Product $product, SessionInterface $session)
    {
        // On récupère le panier actuel
        $cart = $session->get("panier", []);
        $id = $product->getId();

        // si le panier n'est pas vide on supprime //
        if(!empty($cart[$id])){
            unset($cart[$id]);
            }

        // On sauvegarde dans la session
        $session->set("panier", $cart);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
         $session->remove("panier");
           
        return $this->redirectToRoute("cart_index");
    }

   }
