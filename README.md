
InnovShop – Site e-commerce Symfony

Bienvenue sur le dépôt du projet InnovShop, une plateforme e-commerce développée avec le framework Symfony.

=== Front Office ===
- Navigation dans un catalogue d’articles
- Filtres par couleur, taille, type
- Ajout d’articles au panier (chaque ajout = nouvelle ligne)
- Création et gestion de compte utilisateur
- Historique des commandes
- Modification du profil utilisateur
- Réinitialisation du mot de passe

=== Back Office (EasyAdmin) ===
- CRUD sur les articles, utilisateurs, commandes, types, tailles, couleurs
- Visualisation et gestion des comptes clients

=== Technologies utilisées ===
- Symfony 6
- PHP 8.3+
- PostgreSQL
- Doctrine ORM
- Twig
- Webpack Encore
- EasyAdmin pour le back-office
- Mailpit pour simuler les emails en local

=== Préparation de l'environnement ===
- Avoir PHP (>=8.1), Composer, Node.js, Yarn et PostgreSQL installés.

=== Installation en local ===

Cloner le projet :
> git clone https://github.com/MARIEALC/innovshop.git
> cd innovshop

Installer les dépendances PHP :
> composer install

Installer les dépendances front :
> yarn install
> yarn encore dev

Initialiser la base de données :
> php bin/console doctrine:database:create
> php bin/console doctrine:migrations:migrate

Lancer le serveur Symfony :
> symfony server:start

=== Accès local ===
Front Office : http://localhost:8000  
Back Office (admin) : http://localhost:8000/admin  
Mailpit : http://localhost:8025  
En ligne : https://louanges.website/

=== Déploiement en production ===

1. Étapes :

> composer install --no-dev --optimize-autoloader
> yarn install
> yarn encore production
> php bin/console doctrine:migrations:migrate
> php bin/console cache:clear --env=prod
> php bin/console cache:warmup --env=prod

2. Configuration de production :

Dans `.env.local`, s'assurer d’avoir :

APP_ENV=prod  
APP_DEBUG=0

3. Sécurité en production :

- Activer HTTPS avec certificat SSL (Let’s Encrypt par exemple)
- Protéger les accès au back-office par rôle (admin uniquement)
- Mettre à jour régulièrement les dépendances
- Filtrer les entrées utilisateur (protection XSS/CSRF via Symfony)

4. Logs & gestion des erreurs :

- Les logs sont stockés dans : var/log/prod.log
- Consultation des logs sous Windows PowerShell :
> Get-Content .\var\log\prod.log -Tail 30
- Symfony utilise Monolog pour tracer les erreurs par niveau : info, warning, error, critical


