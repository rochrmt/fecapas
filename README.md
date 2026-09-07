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

Sur une installation neuve, connectez-vous avec le nom d’utilisateur `FECAPAS` et
le mot de passe initial communiqué au responsable du site. Le tableau de bord impose
leur modification avant toute publication.

L’administration permet de modifier la page d’accueil, les pages détaillées de la
mission, des actions et des actualités, leurs images de couverture et leurs galeries.
Les boutons d’ajout et de suppression permettent de gérer jusqu’à 20 actions et
20 actualités sans modifier le code.

## Stockage

- le contenu modifié est enregistré dans `data/content.json`
- le nom d’utilisateur et le mot de passe haché sont enregistrés dans `data/auth.json`
- les images ajoutées depuis l’administration sont enregistrées dans `uploads`

Ces fichiers sont ignorés par Git. En production, sauvegardez les dossiers `data` et
`uploads` et utilisez un volume persistant si l’hébergement est conteneurisé.
