<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Entity\Livre;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

class TestFixtures extends Fixture
{
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create('fr_FR');

        $this->loadAuteur($manager, $faker);
        $this->loadEmprunt($manager, $faker);
        $this->loadEmprunteur($manager, $faker);
        $this->loadGenres($manager, $faker);
        $this->loadLivre($manager, $faker);
        $this->loadUser($manager, $faker);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function loadAuteur(ObjectManager $manager, FakerGenerator $faker): void 
    {
        $auteurDatas = [
            [
                'nom' => 'auteur inconnu',
                'prenom' => ''
            ]
            [
                'nom' => 'Cartier',
                'prenom' => 'Hugues'
            ]
            [
                'nom' => 'Lambert',
                'prenom' => 'Armand'
            ]
            [
                'nom' => 'Moitessier',
                'prenom' => 'Thomas'
            ]
            ];

        foreach ($auteurDatas as $auteurData) {
            $auteur = new Auteur();
            $auteur->setLastName($auteurData['nom']);
            $auteur->setFirstName($auteurData['prenom']);

            $manager->persist($auteur);
        }

        for($i = 0; $i < 500; $i++) {
            $auteur = new Auteur();
            $auteur->setLastName({$faker->});
            $auteur->setFirstName({})
            $manager->persist($auteur);
        }

        $manager->flush();

    }

    public function loadEmprunt(ObjectManager $manager, FakerGenerator $faker): void 
    {
        $empruntDatas = 
        [
            'date_emprunt' => '2020-02-01 10:00:00',
            'date_retour' => '2020-02-01 10:00:00'
        ]
        [
            'date_emprunt' => '2020-03-01 10:00:00',
            'date_retour' => '2020-04-01 10:00:00'
        ]
        [
            'date_emprunt' => '2020-04-01 10:00:00',
            'date_retour' => ''
        ]
        $manager->flush();

    }

    public function loadEmprunteur(ObjectManager $manager, FakerGenerator $faker): void
    {
        $emprunteurDatas = [
            [
                'nom' => 'foo',
                'prenom' => 'foo',
                'tel' => '123456789',
                'actif' => 'true',
                'created_at' => '20200101 10:00:00',
                'updated_at' =>'20200101 10:00:00'
            ]
            [
                'nom' => 'bar',
                'prenom' => 'bar',
                'tel' => '123456789',
                'actif' => 'false',
                'created_at' => '20200201 11:00:00',
                'updated_at' =>'20200501 12:00:00'
            ]
            [
                'nom' => 'baz',
                'prenom' => 'baz',
                'tel' => '123456789',
                'actif' => 'true',
                'created_at' => '20200301 12:00:00',
                'updated_at' =>'20200301 12:00:00'
            ]
        ]
        $manager->flush();

    }

    public function loadGenres(ObjectManager $manager, FakerGenerator $faker): void
    {
        $genreDatas = [
            [   'nom' => 'poésie',
                'description' => ''
            ],
            [   'nom' => 'nouvelle',
                'description' => ''
            ],
            [   'nom' => 'roman historique',
                'description' => ''
            ],
            [   'nom' => "roman d'amour",
                'description' => ''
            ],
            [   'nom' => "roman d'aventure",
                'description' => ''
            ],
            [   'nom' => 'science-fiction',
                'description' => ''
            ],
            [   'nom' => 'fantasy',
                'description' => ''
            ],
            [   'nom' => 'biographie',
                'description' => ''
            ],
            [   'nom' => 'conte',
                'description' => ''
            ],
            [   'nom' => 'témoignage',
                'description' => ''
            ],
            [   'nom' => 'théâtre',
                'description' => ''
            ],
            [   'nom' => 'essai',
                'description' => ''
            ],
            [   'nom' => 'journal intime',
                'description' => ''
            ],
        ];
        $manager->flush();
    }

    public function loadLivre(ObjectManager $manager, FakerGenerator $faker): void
    {
        $livreDatas = [
            [
                'titre' => 'Lorem ipsum dolor sit amet',
                'annee_edition' => '2010',
                'nombre_pages' => '100',
                'code_isbn' => '9785786930024'
            ]
            [
                'titre' => 'Consectetur adipiscing elit',
                'annee_edition' => '2011',
                'nombre_pages' => '150',
                'code_isbn' => '9783817260935'
            ]
            [
                'titre' => 'Mihi quidem Antiochum',
                'annee_edition' => '2012',
                'nombre_pages' => '200',
                'code_isbn' => '9782020493727'
            ]
            [
                'titre' => 'Quem audis satis belle',
                'annee_edition' => '2013',
                'nombre_pages' => '250',
                'code_isbn' => '9794059561353'
            ]
        ]
        $manager->flush();
    }

    public function loadUser(ObjectManager $manager, FakerGenerator $faker):void
    {
        $userDatas = [
            [
                'email' => 'admin@example.com',
                'roles' => 'ROLE_ADMIN',
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'true',
                'created_at' => '20200101 09:00:00',
                'updated_at' => '20200101 09:00:00'
            ]
            [
                'email' => 'foo.foo@example.com',
                'roles' => 'ROLE_EMPRUNTEUR',
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'true',
                'created_at' => '20200101 10:00:00',
                'updated_at' => '20200101 10:00:00'
            ]
            [
                'email' => 'bar.bar@example.com',
                'roles' => 'ROLE_EMPRUNTEUR',
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'false',
                'created_at' => '20200201 11:00:00',
                'updated_at' => '20200501 12:00:00'
            ]
            [
                'email' => 'baz.baz@example.com',
                'roles' => 'ROLE_EMPRUNTEUR',
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'false',
                'created_at' => '20200301 12:00:00',
                'updated_at' => '20200301 12:00:00'
            ]

        ]
        $manager->flush();
    }
}
