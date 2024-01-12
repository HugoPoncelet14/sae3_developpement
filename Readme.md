# SAE3_Developpement Cuisinisi

## Poncelet Hugo / Lherm Hugo / Pinon Mathias / Mathieu Léo

## Installation / Configurations

Lancer `composer install` pour installer les différents composants nécessaires au fonctionnement du projet et installer [PHP Coding Standards Fixer](https://cs.symfony.com/). Configurez le dans PhpStorm (le fichier `.php-cs-fixer.php` contient les règles personnalisées basées sur la recommandation [Symfony](https://symfony.com/doc/current/contributing/code/standards.html))

### Configuration de PHP Coding Standards Fixer

Configurer l'intégration de PHP Coding Standards Fixer dans PhpStorm en fixant le jeu de règles sur `Custom` et en désignant `.php-cs-fixer.php` comme fichier de configuration de règles de codage. 

### Base de données

Copier le fichier `.env` en `.env.local` et modifier `.env.local` pour ajuster la configuration du serveur de base de données.

## Serveur Web distant

Vous pouvez accédez au site web sur le serveur distant avec cette adresse : <http://10.31.33.45>

Accédez à la machine virtuelle grâce au fichier sae-3.1.vv

## Serveur Web local

### Sur Linux

Lancez le serveur Web local avec cette commande :
```
composer start
```

### Sur Windows

Lancez le serveur Web local avec cette commande :
```
composer start:w
```

### Accès au serveur Web
Naviguez alors à partir de cette adresse : <http://localhost:8000/>

## Style de codage

Le code suit la recommandation [Symfony](https://symfony.com/doc/current/contributing/code/standards.html) :
- il peut être contrôlé avec `composer test:cs`
- il peut être reformaté automatiquement avec `composer fix:cs`

## Tests

### Users
Les emails et mots de passes associés sont présents dans le fichier src\DataFixtures\data\User.json