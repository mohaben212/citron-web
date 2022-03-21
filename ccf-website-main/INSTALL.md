# Citron RH


## Pré-requis

* Système Linux ou assimilé
* Serveur Web Apache, NGinx ou IIS
* PHP version 7.4+
* MySQL, MariaDB, PostgreSQL ou SQLite selon votre cas


## Installation

Copiez le contenu du dossier à la racine de votre VirtualHost
ou de votre répertoire d'exécution web.

Vérifiez les droits d'installation :
tous les fichiers doivent pouvoir être exécutés
par l'utilisateur de votre serveur Web
(root pour Nginx, www pour Apache par défaut).


## Configuration initiale

Modifiez les fichiers de configuration dans le dossier `config`
à la racine selon vos besoins.
Pour cela, copiez dans le dossier `config` chaque fichier terminant
par `.json.dist`, pour créer un fichier `.json` contenant votre configuration.
Par exemple, vous allez créer un
fichier `general.json` en copiant `general.json.dist`.

Tous les fichiers de configuration doivent être vérifiés:
* `general` : configuration générale de l'application
* `sql` : configuration de la base de données
* `api` : configuration de l'API


## Tests unitaires

Une fois la configuration minimale effectuée, lancez les tests unitaires,
en lançant le fichier "test.php" via php.


## Import initial

Lancez l'import SQL initial, en important le fichier "install.sql"
sur la base de données choisie.  
**Attention** vous devrez créer deux bases de données :  
* votre base de production, par exemple `citron`
* votre base de test, nommée comme celle de production, mais suffixée avec "_test", par exemple `citron_test`


## Test d'intégration

Lancez finalement l'application, en accédant depuis votre navigateur,
à l'adresse de votre serveur web.


## Langages

Les fichiers de langues sont présents dans le dossier `langs`.
La langue est automatiquement déduite de la langue préférée du navigateur.
