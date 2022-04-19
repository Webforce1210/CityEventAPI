# City Event

## lancer le server de développement
* symfony serve -d
* symfony open:local

## Arrêter le server de développement
* symfony server:stop

## créer la base de donnée
* php bin/console doctrine:database:create
* php bin/console d:m:m

## installer les dépendances
* composer install

## base de donnée de test
* php bin/console doctrine:database:create --env=test
* php bin/console d:m:m --env=test
