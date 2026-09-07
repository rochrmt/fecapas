# FECAPAS-RCA

Site vitrine administrable de l’Association des Femmes Courageuses en Action pour la Paix et la Sécurité.

## Prérequis

- PHP 8.1 ou version ultérieure
- extensions PHP `fileinfo` et `session`
- droits d’écriture pour PHP sur les dossiers `data` et `uploads`

## Lancer le site

```bash
php -S 0.0.0.0:4173
```

Le site est disponible sur `http://localhost:4173` et l’administration sur
`http://localhost:4173/admin/`.

À la première ouverture de l’administration, créez le mot de passe administrateur.
Aucun identifiant ou mot de passe par défaut n’est inclus dans le dépôt.

L’administration permet de modifier la page d’accueil, les pages détaillées de la
mission, des actions et des actualités, leurs images de couverture et leurs galeries.

## Stockage

- le contenu modifié est enregistré dans `data/content.json`
- le mot de passe haché est enregistré dans `data/auth.json`
- les images ajoutées depuis l’administration sont enregistrées dans `uploads`

Ces fichiers sont ignorés par Git. En production, sauvegardez les dossiers `data` et
`uploads` et utilisez un volume persistant si l’hébergement est conteneurisé.
