# La gestion des mails (mailer)
## Interception des mails dans le profiler (la webdebug toolbar)

1) Modifier le fichier web_profiler.yaml ==> intercept_redirects: true (passer de false a true)
2) Décommenter la variable DSN du fichier .env
3)Créer un controller et ajouter la méthode contact 

## Interception des mails dans un faker client (mailtrap.io)
1) Configurer la variable DSN du .env avec le fake mailer ==> user:password@smtp.mailtrap.io:2525
 les données se trouve sur le site . Choisir la version pour le language utilisé
2) Dans le terminal : 
   - composer require symfony/messenger
   - php bin/console messenger:consume async pour demmarer le serveur d'envoi d'email 

## Utilisation d'un formulaire (données dynamique)
### Création d'une Entitée Contact qui ne sera pas migrée en DB 
   -Créer l'entité sans passer par le maker pour ne pas a avoir a supprimer tous le code inutile . Ajouter les getters et les setters
## Création du formType mais aucune liaison avec l'entité contact car pas une classe orm 
### Création d'une méthode de controller
- Instancier la classe contact pour pouvoir utiliser les getters et récuperer les données du formulaire
- La méthode html de la classe email permet de formater le contenu avec du code HTML