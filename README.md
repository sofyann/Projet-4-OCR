Projet4 OPENCLASSROOMS SOFYANN FAHIM
=======
## SETUP
**Setup parameters.yml**

Tout d'abord, assurez-vous d'avoir le fichier 'app/config/parameters.yml'.
Si ce n'est pas le cas copiez 'app/config/parameters.yml.dist' pour l'avoir.

Veuillez ensuite y mettre vos propres informations de base de données (comme 
'database_password').

**Télécharger les dependances avec Composer**
Assurez-vous d'avoir [Composer] d'installer (https://getcomposer.org/download/)
et lancer la commande : 

```
composer install
```

Ou 'php composer.phar install' en fonction de la façon dont vous avez installé
Composer.

**Créer la base de données**

Assurez-vous, d'avoir mis les informations souhaité dans 'app/config/parameters.yml'.
Ensuite, vous devez créer la base de données :

```
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --dump-sql
php bin/console doctrine:schema:update --force
```
**Le serveur**

Pour finir, vous pouvez choisir d'utiliser Nginx ou Apache. Ou encore le serveur web
intégré:
 ```
 php bin/console server:run
 ```
Le site sera accessible à l'adresse 'http://localhost:8000'