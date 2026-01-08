# rdc-api

## Notifications push (FCM)

Cette API envoie des notifications FCM lors de la création de contenu
(discours, citations, actualités, actes, vidéos, galerie).

### Configuration

1. Créer un projet Firebase et activer Cloud Messaging.
2. Générer un compte de service (JSON) et placer le fichier sur le serveur.
3. Renseigner ces variables dans `.env` :

```
FCM_ENABLED=true
FCM_PROJECT_ID=your-project-id
FCM_SERVICE_ACCOUNT_PATH=/chemin/vers/service-account.json
FCM_TOPIC_PREFIX=fat_
```

### Topics utilisés

- `fat_speeches`
- `fat_quotes`
- `fat_news`
- `fat_acts`
- `fat_videos`
- `fat_gallery`
