# user-interface
## Pour l'installation
Cloner le dépot  
Installer les dépendances  
`composer install`

Créer une base de donnée  
`symfony console doctrine:database:create`

Jouer les migrations  
`symfony console doctrine:migrations:migrate`

Jouer le script de création des utilisateurs  
`symfony console add-users`

Lancer le serveur  
`symfony serve`

Accès de test :  
Utilisateur : test@test.fr / test
Admin : admin@admin.fr / admin

