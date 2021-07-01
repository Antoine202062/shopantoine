<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            1 => [
                'title' => 'Vêtements',
                'slug' => 'vêtements'
            ],
           2 => [
            'title'=> 'Chaussures',
            'slug' => 'chaussures'
           ],
           3 => [
            'title'=> 'Accessoires',
            'slug' => 'accessoires'
           ],
           4 => [
            'title'=> 'Sport',
            'slug' => 'sport'
           ],
        ];

        foreach($categories as $key => $value){
            $categorie = new Categories();
            $categorie->setTitle($value['title']);
            $categorie->setSlug($value['slug']);
            $manager->persist($categorie);
            $this->addReference('categories_' . $key, $categorie);
        }
        
        $manager->flush();
    }
}
