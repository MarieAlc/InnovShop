<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Couleurs;
use App\Entity\Tailles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $categories = ['T-shirt', 'Pull', 'Pantalon', 'Robe', 'Veste'];
        $styles = ['sport', 'chic', 'casual', 'élégant', 'décontracté'];

        $taillesLabels = ['XS', 'S', 'M', 'L', 'XL'];
        $tailles = [];
        foreach ($taillesLabels as $label) {
            $taille = new Tailles();
            $taille->setValeur($label);
            $manager->persist($taille);
            $tailles[] = $taille;
        }

        $couleursLabels = ['Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Beige', 'Gris'];
        $couleurs = [];

        foreach ($couleursLabels as $label) {
            $couleur = new Couleurs();
            $couleur->setValeur($label);
            $manager->persist($couleur);
            $couleurs[] = $couleur;
        }

        
        for ($i = 0; $i < 10; $i++) {
            $article = new Articles();

            $titre = ucfirst($faker->randomElement($categories) . ' ' . $faker->randomElement($styles));

        
            $article
                ->setTitre($titre)
                ->setDetail($faker->paragraph(3))
                ->setSpecification("Composition : " . $faker->word . ", Lavage : " . $faker->randomElement(['30°C', 'à sec', 'main']))
                ->setPrix($faker->randomFloat(2, 10, 150))
                ->setImage('https://picsum.photos/seed/' . uniqid() . '/400/300');

            foreach ($tailles as $taille) {
                $article->addTaille($taille);
            }

                $couleur1 = $faker->randomElement($couleurs);
                $couleur2 = $faker->randomElement($couleurs);
                $article->addCouleur($couleur1);

                if ($couleur2 !== $couleur1) {
                    $article->addCouleur($couleur2);
                }


        
            $manager->persist($article);

        }
        $manager->flush();
    }
}
