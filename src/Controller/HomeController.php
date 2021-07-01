<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function home(): Response
    {
        $catRepo = $this->getDoctrine()->getRepository(Categories::class);
        $categories = $catRepo->findAll();

        $ProRepo = $this->getDoctrine()->getRepository(Product::class);
        $products = $ProRepo->findAll();

        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categories,
            'products' => $products
        ]);
    }
}


