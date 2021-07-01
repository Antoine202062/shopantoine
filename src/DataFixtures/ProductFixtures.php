<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Pictures;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    const PICTURE= ['adrian-ordonez-xrvWzRVwAmM-unsplash.jpg',
    'alexander-lemann-gC_iESfp7a8-unsplash.jpg',
    'bannon-morrissy-li2MZaE12BE-unsplash.jpg',
    'christian-bolt-VW5VjskNXZ8-unsplash.jpg',
    'faith-yarn-Wr0TpKqf26s-unsplash.jpg',
    'gabriel-dizzi-LVOOspoOao0-unsplash.jpg',
    'guilian-fremaux-SYelgwGFD4Y-unsplash.jpg',
    'heber-galindo-esfElMv6EuA-unsplash.jpg',
    'himanshu-dewangan-k9tUQNeOfx0-unsplash.jpg',
    'howard-bouchevereau-YdnaXinPcUo-unsplash.jpg',
    'jade-scarlato-Pb7UGXyLcZs-unsplash.jpg',
    'james-barr-NrUI1gjdcY4-unsplash.jpg',
    'kenneth-schipper-vera-1krmlJ9ODKM-unsplash.jpg',
    'kukuvaja-feinkost-o7E4siDrKH8-unsplash.jpg',
    'lacoste.jpg',
    'laura-chouette-2X6N0AveRes-unsplash.jpg',
    'logan-weaver-ohfvVIOzV3g-unsplash.jpg',
    'molnar-balint-7hLEteqDvZY-unsplash.jpg',
    'nike_produit.jpg',
    'nike_white.jfif',
    'nike2.jpg',
    'project-290-PTorAkUcYHg-unsplash.jpg',
    'rohan-pandavadra-t2SzJlRxQgg-unsplash.jpg',
    'scorpio-creative-yjoK0w3OVpc-unsplash.jpg',
    'sham-abdo-1QeWqOz1ibU-unsplash.jpg',
    'sincerely-media-9ShY-Tq70Mc-unsplash.jpg',
    'tamirlan-maratov-OcI6sNgM_NQ-unsplash.jpg',
    'taylor-0RmYRuqDXpE-unsplash.jpg',
    'thatknat-2tZWezLG30Q-unsplash.jpg',
    'victor-b-Tm9Oj_mAxZw-unsplash.jpg',
    'vinicius-henrique-photography-FKeGskJ0Ivs-unsplash.jpg',
    'ceinture.jpg',
    'ceinture2.jpg',
    'montre.jpg',
    'casquette.jpg',
    'sneakers.jpg',
    'sneakers2.jpg',
    'nike-sneakers.jpg',
    'reebok.gif',
    'nike-sport.jpeg',
    'nike-sport2.jpeg',
    'short.jfif',
    'short2.jpg'];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($nbProducts = 1; $nbProducts <= 100; $nbProducts++){
        //    $products = $this->getReference('product_'. $faker->numberBetween(1 ,5));
            $categorie = $this->getReference('categories_'. $faker->numberBetween(1 ,4));
            
        $product = new Product();
        $product->setCategories($categorie);
        $product->setTitle($faker->realText(25));
        $product->setSlug($faker->realText(25));
        $product->setPrise($faker->numberBetween(10, 20));
        $product->setDescription($faker->realText(50));

        //  $categorie = new Categories();
        //  $categorie->setProducts($products);
        //  $categorie->setTitle($faker->realText(25));
        //  $categorie->setSlug($faker->realText(25));

         // on upload and on generate
             for($picture = 1; $picture <= 2; $picture++){
                 $pictureProduct = new Pictures();
                //  $prod = $manager->getRepository(Product::class)->find(self::PICTURE[range(0,6)]);
                 $pictureProduct->setName(self::PICTURE[random_int(0,42)]);
                 $manager->persist($pictureProduct);
                 $product->addPicture($pictureProduct);
             }

            $manager->persist($product);
            
            
            //  $manager->persist($categorie);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoriesFixtures::class,
            UserFixture::class
        ];
    }
}
