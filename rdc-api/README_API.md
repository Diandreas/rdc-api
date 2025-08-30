# API Laravel - Application Mobile FAT (Faustin Archange Touadéra)

## 🚀 Installation et Configuration

### Prérequis
- PHP 8.4+
- Composer
- SQLite (ou MySQL/PostgreSQL pour la production)

### Installation
```bash
# Installer les dépendances
composer install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Exécuter les migrations et seeders
php artisan migrate:fresh --seed

# Démarrer le serveur de développement
php artisan serve
```

## 📊 Base de Données

### Tables créées
- ✅ `users` - Utilisateurs admin
- ✅ `categories` - Catégories de contenu
- ✅ `tags` - Tags pour organiser le contenu
- ✅ `speeches` - Discours du président
- ✅ `videos` - Vidéos officielles
- ✅ `news` - Actualités et communiqués
- ✅ `photos` - Galerie photos
- ✅ `biographies` - Sections biographiques
- ✅ `quotes` - Citations du président
- ✅ `contact_messages` - Messages de contact
- ✅ `social_links` - Liens réseaux sociaux
- ✅ `taggables` - Table pivot pour les tags
- ✅ `media` - Gestion des fichiers (Spatie Media Library)
- ✅ `permissions` & `roles` - Système de permissions

### Données de test créées
- **2 utilisateurs** : admin@presidence-rca.cf (Admin123!) et editor@presidence-rca.cf (Editor123!)
- **6 catégories** : Discours Officiels, Cérémonies, Visites, Communiqués, Actualités, Événements
- **15 tags** : Développement, Économie, Éducation, Santé, etc.
- **3 discours** avec contenu complet
- **3 actualités** avec différents types et priorités
- **5 citations** du président
- **4 réseaux sociaux** : Facebook, Twitter, YouTube, Instagram

## 🔗 Endpoints API Disponibles

### Routes Publiques (`/api/v1/`)

#### Authentification
- `POST /auth/login` - Connexion admin
- `POST /auth/register` - Inscription (dev uniquement)

#### Contenu
- `GET /app/welcome` - Message de bienvenue
- `GET /categories` - Liste des catégories
- `GET /speeches` - Liste des discours
- `GET /news` - Liste des actualités
- `GET /quotes` - Liste des citations
- `GET /social-links` - Liens réseaux sociaux
- `POST /contact` - Envoyer un message

### Exemples de réponses

#### GET /api/v1/app/welcome
```json
{
  "success": true,
  "data": {
    "message": "Bienvenue sur l'application officielle du Président Faustin Archange Touadéra",
    "president_name": "Faustin Archange Touadéra",
    "app_version": "1.0.0",
    "last_updated": "2025-08-31 00:47:28"
  }
}
```

#### GET /api/v1/speeches
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Discours d'investiture du Président Faustin Archange Touadéra",
      "slug": "discours-dinvestiture-du-president-faustin-archange-touadera",
      "excerpt": "Discours prononcé lors de la cérémonie d'investiture...",
      "location": "Palais de la Renaissance, Bangui",
      "event_type": "Investiture",
      "speech_date": "2021-03-30",
      "is_featured": true,
      "views_count": 15420,
      "shares_count": 892,
      "category": {
        "id": 1,
        "name": "Discours Officiels",
        "color": "#1E40AF"
      }
    }
  ],
  "count": 3
}
```

#### POST /api/v1/contact
```json
// Request
{
  "name": "Jean Dupont",
  "email": "jean@example.com",
  "subject": "Message au Président",
  "message": "Votre message ici...",
  "city": "Bangui"
}

// Response
{
  "success": true,
  "message": "Votre message a été envoyé avec succès.",
  "data": {
    "id": 1,
    "reference": "MSG-000001"
  }
}
```

#### POST /api/v1/auth/login
```json
// Request
{
  "email": "admin@presidence-rca.cf",
  "password": "Admin123!"
}

// Response
{
  "success": true,
  "message": "Connexion réussie",
  "data": {
    "user": {
      "id": 1,
      "name": "Administrateur",
      "email": "admin@presidence-rca.cf",
      "roles": ["admin"]
    },
    "token": "1|gTEYn9NTJgreW6KCWryaAefD1UfaO3wDHTH8ZcQZ15d4b183",
    "token_type": "Bearer"
  }
}
```

## 🔒 Sécurité

- ✅ Laravel Sanctum pour l'authentification API
- ✅ Système de rôles et permissions (Spatie)
- ✅ Validation des données d'entrée
- ✅ Protection CSRF
- ✅ Middleware d'authentification
- ✅ Hashage sécurisé des mots de passe

## 📱 Fonctionnalités Implémentées

### ✅ Gestion de Contenu
- Discours avec audio/vidéo
- Actualités avec priorités
- Citations du président
- Galerie photos
- Biographie par sections
- Catégorisation et tags

### ✅ Communication
- Système de contact
- Réseaux sociaux
- Messages de bienvenue personnalisés

### ✅ Administration
- Authentification sécurisée
- Système de permissions
- Gestion des médias

### ✅ Performance
- Index optimisés
- Pagination
- Eager loading des relations
- Cache des configurations

## 🧪 Tests Réalisés

Tous les endpoints principaux ont été testés avec succès :

1. ✅ **Welcome** - Status 200
2. ✅ **Categories** - Status 200 (6 catégories)
3. ✅ **Speeches** - Status 200 (3 discours avec relations)
4. ✅ **News** - Status 200 (3 actualités)
5. ✅ **Quotes** - Status 200 (5 citations)
6. ✅ **Social Links** - Status 200 (4 plateformes)
7. ✅ **Contact** - Status 201 (création réussie)
8. ✅ **Auth Login** - Status 200 (token généré)

## 🔧 Prochaines Étapes

Pour une utilisation en production :

1. **Base de données** : Migrer vers MySQL/PostgreSQL
2. **Médias** : Configurer le stockage cloud (AWS S3)
3. **Email** : Configurer SMTP pour les notifications
4. **Push Notifications** : Intégrer OneSignal
5. **SSL** : Configurer HTTPS
6. **Cache** : Activer Redis pour les performances
7. **Monitoring** : Ajouter des logs et métriques

## 👥 Comptes de Test

- **Admin** : admin@presidence-rca.cf / Admin123!
- **Éditeur** : editor@presidence-rca.cf / Editor123!

---

🇨🇫 **Application officielle du Président Faustin Archange Touadéra**  
République Centrafricaine
