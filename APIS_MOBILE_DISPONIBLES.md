# 📱 APIs Disponibles pour la Version Mobile

## 🇨🇫 Application Officielle du Président Faustin Archange Touadéra

### 🌐 **Base URL**
```
http://localhost:8001/api/v1
```

---

## 🔐 **Authentification**

### ✅ **Connexion Admin**
```http
POST /api/v1/auth/login
```

**Paramètres :**
```json
{
    "email": "admin@example.com",
    "password": "password123"
}
```

**Réponse :**
```json
{
    "success": true,
    "message": "Connexion réussie",
    "data": {
        "user": {
            "id": 1,
            "name": "Admin",
            "email": "admin@example.com",
            "roles": ["admin"]
        },
        "token": "1|abc123...",
        "token_type": "Bearer"
    }
}
```

### ✅ **Déconnexion**
```http
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

**Réponse :**
```json
{
    "success": true,
    "message": "Déconnexion réussie"
}
```

### ✅ **Informations Utilisateur**
```http
GET /api/v1/auth/user
Authorization: Bearer {token}
```

**Réponse :**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Admin",
        "email": "admin@example.com",
        "roles": ["admin"],
        "permissions": ["view_speeches", "create_speeches"]
    }
}
```

---

## 🏠 **Page d'Accueil**

### ✅ **Page d'Accueil Complète**
```http
GET /api/v1/home
```

**Réponse :**
```json
{
    "success": true,
    "data": {
        "welcome_message": "Bienvenue sur l'application officielle...",
        "featured_speeches": [...],
        "latest_news": [...],
        "featured_videos": [...],
        "featured_photos": [...],
        "quote_of_day": {...},
        "social_links": [...]
    }
}
```

### ✅ **Message de Bienvenue**
```http
GET /api/v1/app/welcome
```

**Réponse :**
```json
{
    "success": true,
    "data": {
        "message": "Bienvenue sur l'application officielle...",
        "president_name": "Faustin Archange Touadéra",
        "app_version": "1.0.0",
        "last_updated": "2024-09-04 13:30:00"
    }
}
```

---

## 🎤 **Discours**

### ✅ **Liste des Discours**
```http
GET /api/v1/speeches
```

**Paramètres de filtrage :**
- `category_id` : Filtrer par catégorie
- `year` : Filtrer par année
- `location` : Filtrer par lieu
- `search` : Recherche textuelle
- `featured` : Discours mis en avant uniquement
- `page` : Pagination
- `per_page` : Nombre d'éléments par page

**Réponse :**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Discours d'investiture",
            "excerpt": "Résumé du discours...",
            "content": "Contenu complet...",
            "location": "Palais de la Renaissance",
            "event_type": "Investiture",
            "speech_date": "2024-01-01",
            "category": {
                "id": 1,
                "name": "Cérémonies officielles"
            },
            "is_featured": true,
            "audio_url": "https://...",
            "video_url": "https://...",
            "created_at": "2024-09-04T13:30:00Z"
        }
    ],
    "count": 10,
    "meta": {
        "current_page": 1,
        "total": 25,
        "per_page": 10
    }
}
```

### ✅ **Détail d'un Discours**
```http
GET /api/v1/speeches/{id}
```

**Réponse :**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Discours d'investiture",
        "excerpt": "Résumé du discours...",
        "content": "Contenu complet...",
        "location": "Palais de la Renaissance",
        "event_type": "Investiture",
        "speech_date": "2024-01-01",
        "category": {
            "id": 1,
            "name": "Cérémonies officielles"
        },
        "tags": [
            {"id": 1, "name": "Investiture"},
            {"id": 2, "name": "Présidence"}
        ],
        "is_featured": true,
        "audio_url": "https://...",
        "video_url": "https://...",
        "media": [...],
        "created_at": "2024-09-04T13:30:00Z"
    }
}
```

---

## 📰 **Actualités**

### ✅ **Liste des Actualités**
```http
GET /api/v1/news
```

**Paramètres de filtrage :**
- `category_id` : Filtrer par catégorie
- `featured` : Actualités mises en avant
- `search` : Recherche textuelle
- `page` : Pagination
- `per_page` : Nombre d'éléments par page

**Réponse :**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Nouvelle politique économique",
            "excerpt": "Résumé de l'actualité...",
            "content": "Contenu complet...",
            "category": {
                "id": 2,
                "name": "Économie"
            },
            "is_featured": true,
            "published_at": "2024-09-04T13:30:00Z",
            "created_at": "2024-09-04T13:30:00Z"
        }
    ],
    "count": 15
}
```

### ✅ **Détail d'une Actualité**
```http
GET /api/v1/news/{id}
```

---

## 🎬 **Vidéos**

### ✅ **Liste des Vidéos**
```http
GET /api/v1/videos
```

**Paramètres de filtrage :**
- `category_id` : Filtrer par catégorie
- `featured` : Vidéos mises en avant
- `search` : Recherche textuelle
- `page` : Pagination

**Réponse :**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Interview exclusive",
            "description": "Description de la vidéo...",
            "url": "https://youtube.com/watch?v=...",
            "youtube_id": "abc123",
            "duration": 1800,
            "category": {
                "id": 3,
                "name": "Interviews"
            },
            "is_featured": true,
            "published_at": "2024-09-04T13:30:00Z"
        }
    ],
    "count": 8
}
```

### ✅ **Détail d'une Vidéo**
```http
GET /api/v1/videos/{id}
```

---

## 📸 **Photos**

### ✅ **Liste des Photos**
```http
GET /api/v1/photos
```

**Paramètres de filtrage :**
- `category_id` : Filtrer par catégorie
- `featured` : Photos mises en avant
- `search` : Recherche textuelle
- `page` : Pagination

**Réponse :**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Cérémonie officielle",
            "description": "Description de la photo...",
            "image_url": "https://...",
            "category": {
                "id": 1,
                "name": "Cérémonies"
            },
            "is_featured": true,
            "published_at": "2024-09-04T13:30:00Z"
        }
    ],
    "count": 20
}
```

### ✅ **Détail d'une Photo**
```http
GET /api/v1/photos/{id}
```

---

## 💬 **Citations**

### ✅ **Liste des Citations**
```http
GET /api/v1/quotes
```

**Paramètres de filtrage :**
- `featured` : Citations mises en avant
- `author` : Filtrer par auteur
- `search` : Recherche textuelle
- `page` : Pagination

**Réponse :**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "quote": "La paix et la stabilité sont les fondements du développement.",
            "author": "Faustin Archange Touadéra",
            "context": "Discours d'investiture",
            "is_featured": true,
            "created_at": "2024-09-04T13:30:00Z"
        }
    ],
    "count": 12
}
```

### ✅ **Citation du Jour**
```http
GET /api/v1/quotes/featured
```

---

## 📚 **Catégories**

### ✅ **Liste des Catégories**
```http
GET /api/v1/categories
```

**Réponse :**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Cérémonies officielles",
            "description": "Cérémonies et événements officiels",
            "color": "#003DA5",
            "icon": "flag",
            "content_count": 15
        }
    ],
    "count": 8
}
```

### ✅ **Contenu par Catégorie**
```http
GET /api/v1/categories/{id}/content
```

---

## 👤 **Biographies**

### ✅ **Liste des Biographies**
```http
GET /api/v1/biographies
```

**Réponse :**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Faustin Archange Touadéra",
            "title": "Président de la République Centrafricaine",
            "content": "Biographie complète...",
            "birth_date": "1957-04-21",
            "birth_place": "Bangui",
            "is_featured": true,
            "created_at": "2024-09-04T13:30:00Z"
        }
    ],
    "count": 5
}
```

### ✅ **Détail d'une Biographie**
```http
GET /api/v1/biographies/{id}
```

---

## 📞 **Contact**

### ✅ **Envoyer un Message**
```http
POST /api/v1/contact
```

**Paramètres :**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+236 123456789",
    "subject": "Question importante",
    "message": "Contenu du message...",
    "city": "Bangui",
    "country": "République Centrafricaine"
}
```

**Réponse :**
```json
{
    "success": true,
    "message": "Votre message a été envoyé avec succès.",
    "data": {
        "id": 123,
        "reference": "MSG-000123"
    }
}
```

---

## 🔗 **Réseaux Sociaux**

### ✅ **Liste des Réseaux Sociaux**
```http
GET /api/v1/social-links
```

**Réponse :**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "platform": "Facebook",
            "url": "https://facebook.com/president",
            "icon": "fab fa-facebook",
            "is_active": true,
            "order": 1
        }
    ],
    "count": 6
}
```

---

## 🔍 **Recherche**

### ✅ **Recherche Globale**
```http
GET /api/v1/search
```

**Paramètres :**
- `q` : Terme de recherche
- `type` : Type de contenu (speeches, news, videos, photos)
- `page` : Pagination

**Réponse :**
```json
{
    "success": true,
    "data": {
        "speeches": [...],
        "news": [...],
        "videos": [...],
        "photos": [...],
        "quotes": [...]
    },
    "meta": {
        "total_results": 45,
        "query": "développement"
    }
}
```

---

## 📊 **Statistiques**

### ✅ **Statistiques de l'Application**
```http
GET /api/v1/stats
```

**Réponse :**
```json
{
    "success": true,
    "data": {
        "total_speeches": 150,
        "total_news": 89,
        "total_videos": 45,
        "total_photos": 234,
        "total_quotes": 67,
        "featured_content": 23,
        "last_updated": "2024-09-04T13:30:00Z"
    }
}
```

---

## 🧪 **Test**

### ✅ **Test de l'API**
```http
GET /api/v1/test
```

**Réponse :**
```json
{
    "message": "API fonctionne!"
}
```

---

## 📋 **Codes de Statut HTTP**

| Code | Description |
|------|-------------|
| `200` | Succès |
| `201` | Créé avec succès |
| `400` | Requête invalide |
| `401` | Non authentifié |
| `403` | Accès interdit |
| `404` | Ressource non trouvée |
| `422` | Données de validation invalides |
| `500` | Erreur serveur |

---

## 🔧 **Format de Réponse Standard**

### ✅ **Succès**
```json
{
    "success": true,
    "data": {...},
    "message": "Opération réussie",
    "meta": {
        "current_page": 1,
        "total": 100,
        "per_page": 10
    }
}
```

### ❌ **Erreur**
```json
{
    "success": false,
    "message": "Message d'erreur",
    "errors": {
        "field": ["Erreur de validation"]
    }
}
```

---

## 🔐 **Authentification**

### ✅ **Utilisation du Token**
```http
Authorization: Bearer {token}
```

### ✅ **Exemple d'Utilisation**
```bash
curl -H "Authorization: Bearer 1|abc123..." \
     -H "Content-Type: application/json" \
     http://localhost:8001/api/v1/speeches
```

---

## 📱 **Endpoints Mobile Spécifiques**

### ✅ **Configuration de l'App**
```http
GET /api/v1/app/config
```

**Réponse :**
```json
{
    "success": true,
    "data": {
        "app_name": "Président RCA",
        "version": "1.0.0",
        "build_number": "1",
        "min_version": "1.0.0",
        "update_required": false,
        "maintenance_mode": false,
        "features": {
            "offline_mode": true,
            "push_notifications": true,
            "media_download": true
        }
    }
}
```

### ✅ **Mise à Jour de l'App**
```http
GET /api/v1/app/update
```

---

## 🎯 **Fonctionnalités Avancées**

### ✅ **Contenu Hors Ligne**
- Téléchargement des discours en PDF
- Sauvegarde des médias pour consultation hors ligne
- Synchronisation automatique

### ✅ **Notifications Push**
- Notifications des nouveaux discours
- Alertes des actualités importantes
- Rappels des événements

### ✅ **Recherche Avancée**
- Recherche par date
- Filtrage par catégorie
- Recherche dans le contenu

### ✅ **Partage Social**
- Partage des discours sur les réseaux sociaux
- Génération de liens de partage
- Intégration avec les plateformes sociales

---

## 📊 **Statistiques d'Utilisation**

### ✅ **Métriques Disponibles**
- Nombre de téléchargements
- Temps de consultation
- Contenu le plus populaire
- Zones géographiques d'utilisation

---

## 🚀 **Optimisations**

### ✅ **Performance**
- Pagination automatique
- Compression des réponses
- Cache intelligent
- Images optimisées

### ✅ **Sécurité**
- Validation des données
- Protection CSRF
- Rate limiting
- Chiffrement des données sensibles

---

## 📚 **Documentation Complète**

### ✅ **Swagger/OpenAPI**
```http
GET /api/v1/documentation
```

### ✅ **Postman Collection**
- Collection complète disponible
- Environnements de test
- Exemples de requêtes

---

## 🎯 **Résumé des APIs**

| Catégorie | Endpoints | Description |
|-----------|-----------|-------------|
| **🔐 Auth** | 3 | Authentification et gestion utilisateur |
| **🏠 Accueil** | 2 | Page d'accueil et bienvenue |
| **🎤 Discours** | 2 | Gestion des discours présidentiels |
| **📰 Actualités** | 2 | Actualités et informations |
| **🎬 Vidéos** | 2 | Contenu vidéo |
| **📸 Photos** | 2 | Galerie photos |
| **💬 Citations** | 2 | Citations du Président |
| **📚 Catégories** | 2 | Organisation du contenu |
| **👤 Biographies** | 2 | Biographies officielles |
| **📞 Contact** | 1 | Messages au Président |
| **🔗 Réseaux Sociaux** | 1 | Liens sociaux officiels |
| **🔍 Recherche** | 1 | Recherche globale |
| **📊 Stats** | 1 | Statistiques de l'app |
| **🧪 Test** | 1 | Test de l'API |

**Total : 25 endpoints disponibles pour la version mobile !** 📱

---

## 🎉 **Conclusion**

L'API mobile offre une expérience complète avec :
- **25 endpoints** couvrant tous les aspects de l'application
- **Authentification sécurisée** avec tokens Bearer
- **Gestion du contenu** riche et varié
- **Fonctionnalités avancées** (recherche, partage, hors ligne)
- **Performance optimisée** pour les appareils mobiles
- **Documentation complète** pour les développeurs

**L'API est prête pour le développement de l'application mobile !** 🚀

