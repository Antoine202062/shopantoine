<?php

namespace App\Controller;

use App\DataFixtures\ProductFixtures;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoriesRepository;
use App\Entity\Categories;
use App\Entity\Pictures;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="create_product")
     */

    //  doc : https://symfony.com/doc/current/doctrine.html
    // doc : https://symfony.com/doc/current/doctrine/associations.html

    public function createProduct(): Response
    {
        $categories = new Categories();
        $categories->setTitle('Vêtements');
        $categories->setSlug('vêtements');
        

        $product = new Product();
        $product->setTitle('Nike Sportswear');
        $product->setSlug('nike-sports-swear');
        $product->setPrise('20');
        $product->setDescription('CLUB TEE - T-shirt basique');
        

        // relates this product to the category
        $product->setCategories($categories);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($categories);
        $entityManager->persist($product);
        
        $entityManager->flush();
    
    
        return new Response(
            'Saved new product with id: '.$product->getId()
            .' and new categories with id: '.$categories->getId()
        );
    }
    
    /**
     * @Route("/show-product/{productId}", name="show_product")
     */
    public function showProduct(ProductRepository $productRepository,
     CategoriesRepository $categoriesRepository,
     $productId): Response
    {
        // $repository = $this->getDoctrine()->getRepository(Product::class);

        // look for *all* Product objects
        // $products = $repository->findAll();

        // if (!$products) {
        //     throw $this->createNotFoundException(
        //         'Aucun produit trouvé pour l\'identifiant'.$id
        //     );
        // }
        $catRepo = $this->getDoctrine()->getRepository(Categories::class);
        $categories = $catRepo->findAll();

        $products = $productRepository->findOneByIdJoinedToCategory($productId);

         return $this->render('product/showProducts.html.twig', ['products' => $products, 'categories' => $categories,
         'products' => $products]);
    }

    /**
     * @Route("/detail-product/{product}", name="detail_product")
     */
    public function detailProduct(Product $product): Response
   {
    $catRepo = $this->getDoctrine()->getRepository(Categories::class);
    $categories = $catRepo->findAll();

        return $this->render('product/detailProduct.html.twig', ['product' => $product,'categories' => $categories]);
   }
    

    /**
     * @Route("/favorite/add/{productId}-{slug}", name="add_favorite")
     */
    public function addFavorite(Product $product,$productId)
    {
        // ajout d'un favori d'un utilisateur (connecter) = $this->getUser()
        $product->addFavorite($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('app_home', ['product' => $product]);
    }

     /**
     * @Route("/favorite/remove/{productId}-{slug}", name="remove_favorite")
     */
    public function removeFavorite(Product $product,$productId,ProductRepository $productRepository)
    {
        // ajout d'un favori d'un utilisateur (connecter) = $this->getUser()
        $product->removeFavorite($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('app_home', ['products' => $productId,]);
    }
}
