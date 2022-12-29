<?php
// TODO : ADD relation to the entity concerned
// AND transfer the User and Emprunteur fixtures on AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class TestFixtures extends Fixture
{
    private $doctrine;
    private $faker;
    private $hasher;

    public function __construct(ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher)
    {
        $this->doctrine = $doctrine;
        $this->faker = FakerFactory::create('fr_FR');
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadGenres($manager,$faker);
        $this->loadAuteur($manager, $faker);
        $this->loadLivre($manager, $faker);    
        $this->loadUserEmprunteur($manager, $faker);
        // $this->loadEmprunteur($manager, $faker);
        // $this->loadEmprunt($manager, $faker);
    }

    public function loadAuteur(ObjectManager $manager, FakerGenerator $faker): void 
    {
        $auteurDatas = [
            [
                'nom' => 'auteur inconnu',
                'prenom' => ''
            ],
            [
                'nom' => 'Cartier',
                'prenom' => 'Hugues'
            ],
            [
                'nom' => 'Lambert',
                'prenom' => 'Armand'
            ],
            [
                'nom' => 'Moitessier',
                'prenom' => 'Thomas'
            ]
        ];

        foreach ($auteurDatas as $auteurData) {
            $auteur = new Auteur();
            $auteur->setNom($auteurData['nom']);
            $auteur->setPrenom($auteurData['prenom']);

            $manager->persist($auteur);
        }

        for($i = 0; $i < 500; $i++) {
            $auteur = new Auteur();
            $auteur->setNom($faker->lastName());
            $auteur->setPrenom($faker->firstName());
            $manager->persist($auteur);
        }

        $manager->flush();

    }

    public function loadEmprunt(ObjectManager $manager, FakerGenerator $faker): void 
    {
        $empruntDatas = 
        [        
            [
                'date_emprunt' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','2020-02-01 10:00:00'),
                'date_retour' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','2020-02-01 10:00:00')
            ],
            [
                'date_emprunt' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','2020-03-01 10:00:00'),
                'date_retour' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','2020-04-01 10:00:00')
            ],
            [
                'date_emprunt' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','2020-04-01 10:00:00'),
                'date_retour' => ''
            ]
        ];
        
        foreach ($empruntDatas as $empruntData) {
            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt($empruntData['date_emprunt']);
            $emprunt->setDateRetour($empruntData['date_retour']);

            $manager->persist($emprunt);
        }

        for ($i = 0; $i < 200; $i++) {
            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt($faker->dateTime());
            $emprunt->setDateRetour($faker->dateTime());

            $manager->persist($emprunt);
        }
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

        foreach ($genreDatas as $genreData) {
            $genre = new Genre();
            $genre->setNom($genreData['nom']);
            $genre->setDescription($genreData['description']);

            $manager->persist($genre);
        }
        $manager->flush();
    }

    public function loadLivre(ObjectManager $manager, FakerGenerator $faker): void
    {
        $repository = $this->doctrine->getRepository(Auteur::class);
        $auteur = $repository->findAll();

        $repository = $this->doctrine->getRepository(Genre::class);
        $genres = $repository->findAll();



        $livreDatas = [
            [
                'titre' => 'Lorem ipsum dolor sit amet',
                'annee_edition' => '2010',
                'nombre_pages' => '100',
                'code_isbn' => '9785786930024',
                'auteur' => $auteur[0],
                'genre' => [$genres[0]]
            ],
            [
                'titre' => 'Consectetur adipiscing elit',
                'annee_edition' => '2011',
                'nombre_pages' => '150',
                'code_isbn' => '9783817260935',
                'auteur' => $auteur[1],
                'genre' => [$genres[1]]
            ],
            [
                'titre' => 'Mihi quidem Antiochum',
                'annee_edition' => '2012',
                'nombre_pages' => '200',
                'code_isbn' => '9782020493727',
                'auteur' => $auteur[2],
                'genre' => [$genres[2]]
            ],
            [
                'titre' => 'Quem audis satis belle',
                'annee_edition' => '2013',
                'nombre_pages' => '250',
                'code_isbn' => '9794059561353',
                'auteur' => $auteur[3],
                'genre' => [$genres[3]]

            ]
        ];

        foreach ($livreDatas as $livreData) {
            $livre = new Livre();
            $livre->setTitre($livreData['titre']);
            $livre->setAnneeEdition($livreData['annee_edition']);
            $livre->setNombrePages($livreData['nombre_pages']);
            $livre->setCodeIsbn($livreData['code_isbn']);
            // Un livre peut avoir plusieurs genre
            // Pas d'auteur ici car un livre = un auteur
            foreach ($livreData['genre'] as $genre) {
                $livre->addGenre($genre);
            }
            $livre->setAuteurs($livreData['auteur']);

            $manager->persist($livre);
        }

        for ($i = 0; $i < 1000; $i++) {
            $livre = new Livre();
            $livre->setTitre($faker->sentence());
            $livre->setAnneeEdition($faker->year());
            $livre->setNombrePages($faker->numberBetween(100, 500));
            $livre->setCodeIsbn($faker->isbn13());
            // On délimite le nombre d'élèments à ajouter, donc entre 1 & 3
            $count = random_int(1, 3);
            $randomGenres = $faker->randomElements($genres, $count);
            // On fait une boucle pour intégrer plusieurs genres
            foreach ($randomGenres as $genre) {
                $livre->addGenre($genre);
            }
            $randomAuteur = $faker->randomElement($auteur);
            $livre->setAuteurs($randomAuteur);
            

            $manager->persist($livre);
        }

        $manager->flush();
    }

    public function loadUserEmprunteur(ObjectManager $manager, FakerGenerator $faker):void
    {
        $emprunteurDatas = [
            [
                'email' => 'admin@example.com',
                'roles' => 'ROLE_ADMIN',
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'true',
                'created_at' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','20200101 09:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','20200101 09:00:00')
            ],
            [
                'nom' => 'foo',
                'prenom' => 'foo',
                'tel' => '123456789',
                'actif' => 'true',
                'email' => 'foo.foo@example.com',
                'roles' => 'ROLE_EMPRUNTEUR',
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'true',
                'created_at' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','20200101 10:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','20200101 10:00:00')
            ],
            [
                'nom' => 'bar',
                'prenom' => 'bar',
                'tel' => '123456789',
                'actif' => 'false',
                'email' => 'bar.bar@example.com',
                'roles' => 'ROLE_EMPRUNTEUR',
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'false',
                'created_at' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','20200201 11:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','20200501 12:00:00')
            ],
            [
                'nom' => 'baz',
                'prenom' => 'baz',
                'tel' => '123456789',
                'actif' => 'true',
                'email' => 'baz.baz@example.com',
                'roles' => 'ROLE_EMPRUNTEUR',
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'false',
                'created_at' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','20200301 12:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('y-m-d H:i:s','20200301 12:00:00')
            ]
        ];

        foreach ($emprunteurDatas as $emprunteurData) {
            $user =  new User();
            $user->setEmail($emprunteurData['email']);
            $user->setRoles($emprunteurData['roles']);
            $password = $this->hasher->hashPassword($user, $emprunteurData['password']);
            $user->setEnabled($emprunteurData['enabled']);
            $user->setCreatedAt($emprunteurData['created_at']);
            $user->setUpdatedAt($emprunteurData['updated_at']);

            $manager->persist($user);

            $emprunteur = new Emprunteur();
            $emprunteur->setUser($user);
            $emprunteur->setNom($emprunteurData['nom']);
            $emprunteur->setPrenom($emprunteurData['prenom']);
            $emprunteur->setTel($emprunteurData['tel']);
            $emprunteur->setActif($emprunteurData['actif']);
            $emprunteur->setCreatedAt($emprunteurData['created_at']);
            $emprunteur->setUpdatedAt($emprunteurData['updated_at']);

            $manager->persist($emprunteur);
        }

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail($this->faker->safeEmail());
            $user->setRoles(['ROLE_EMPRUNTEUR']);
            $password = $this->hasher->hashPassword($user, '123');
            $user->setPassword($password);
            $user->setEnabled($faker->boolean());
            $user->setCreatedAt($faker->dateTime());
            $user->setUpdatedAt($faker->dateTime());

            $manager->persist($user);

            $emprunteur = new Emprunteur();
            $emprunteur->setUser($user);
            $emprunteur->setNom($this->faker->lastName());
            $emprunteur->setPrenom($this->faker->firstName());
            $emprunteur->setTel($this->faker->phoneNumber());
            $emprunteur->setActif(true);
            $emprunteur->setCreateAt($faker->dateTime());
            $emprunteur->setUpdatedAt($faker->dateTime());

            $manager->persist($emprunteur);

        }
        $manager->flush();
    }
}
