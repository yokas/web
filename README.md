# Site web de l'AFUP


## Dépendances

 * MySQL
 * Composer


## Applications

* Backoffice  ( admin/admin) : /pages/administration/
* Site AFUP : /pages/site/
* Forum PHP 2013 : /pages/forumphp2013/
* PHP Tour 2014 : /pages/phptourlyon2014/
* Annuaire :
  * Docroot : htdocs/annuaire
  * Application Symfony2:
    * kernel : sf2/app/directory
    * bundles :
      * sf2/src/Afup/CoreBundle
      * sf2/src/Afup/DirectoryBundle

## Installation

### Copie du fichier de config

```sh
$ cp configs/application/config.php.dist configs/application/config.php
```

### Configurer les paramètres de BDD et de path ( 6 pre)
```php
$configuration['bdd']['hote']='localhost';
$configuration['bdd']['base']='afup_web';
$configuration['bdd']['utilisateur']='root';
$configuration['bdd']['mot_de_passe']='';
$configuration['web']['path']='/';
```

### Import du fichier SQL

```sh
$ mysql afup_web < sql/*.sql
```

### Création du répertoire de cache

```sh
$ mkdir -p  htdocs/cache/templates
```

### Évolutions en cours

Dans le cadre d'un travail progressif d'amélioration, Symfony est installé en tant que dépendance [Composer](https://getcomposer.org/) du projet.

Afin de permettre le plus de modularité possible, un kernel est mis en place par "application". Pour l'instant, seul l'annuaire des entreprises utilise Symfony, mais d'autres parties du site pourraient progressivement en profiter.

L'activation de l'annuaire suppose différentes étapes :

 * installation des dépendances Composer :

```sh
$ composer install
```

 * configurer le modèle de données dans `sf2/app/directory/config/parameters.yml` :

```sh
$ cp sf2/app/directory/config/parameters.yml.dist sf2/app/directory/config/parameters.yml
$ vi sf2/app/directory/config/parameters.yml
```

Il est possible de créer de nouvelles applications Symfony:

 * créer un nouveau kernel dans `sf2/app/APP_NAME` sur le modèle de `sf2/apps/directory`, qui contient le kernel de l'annuaire. Ne chargez dans cet annuaire que les éléments essentiels à votre application...
 * créer le bundle correspondant dans `sf2/src`, en veillant à capitaliser le modèle de données dans le bundle `sf2/src/Afup/CoreBundle`
 * créer le `DocRoot` pour ce kernel : voir l'exemple dans `htdocs/annuaire`

Il est alors possible d'employer la console Symfony pour cette application :

```sh
$ php ./sf2/app/APP_NAME/console
```
