<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Articles;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer 10 articles
        for ($i=1; $i <= 10 ; $i++) { 
            $article = new Articles();
            $article->setTitle("Titre de l'article n°$i")
                    ->setContent("<p>Contenu de l'article n°$i</p>")
                    ->setImage("#")
                    ->setCreatedAt(new \DateTimeImmutable());

            //faire persister l'article
            $manager->persist($article);
        }
        
        //envoie la requette sql
        $manager->flush();
    }
}
