 InnovShop – Site e-commerce Symfony

Bienvenue sur le dépôt du projet InnovShop, une plateforme e-commerce développée avec le framework Symfony.

Front Office:
- Navigation dans un catalogue d’articles
- Filtres par couleur, taille, type
- Ajout d’articles au panier (chaque ajout = nouvelle ligne)
- Création et gestion de compte utilisateur
- Historique des commandes
- Modification du profil utilisateur
- Réinitialisation du mot de passe

Back Office (EasyAdmin):
- CRUD sur les articles, utilisateurs, commandes, types, tailles, couleurs
- Visualisation et gestion des comptes clients


    Technologies utilisées

- Symfony 6.
- PHP 8.3+
- PostgreSQL
- Doctrine ORM
- Twig
- Webpack Encore
- EasyAdmin pour le back-office
- Mailpit pour simuler les emails en local

    Installation en local

Cloner le projet:
- git clone https://github.com/MARIEALC/innovshop.git
- cd innovshop

Installer les dépendances PHP:
- composer install

Initialiser la base de données:
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate

Lancer le serveur Symfony:
- symfony server:start

    Accès local

Front Office (clients) : http://localhost:8000

Back Office (admin – EasyAdmin) : http://localhost:8000/admin

Mailpit (mails simulés) : http://localhost:8025

liens en ligne : https://louanges.website/

    

