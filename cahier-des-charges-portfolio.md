# Cahier des Charges — Portfolio Personnel

**Projet :** Site portfolio professionnel avec interface d'administration
**Auteur :** Jean
**Date :** 31 mars 2026
**Version :** 1.1 — Sécurité renforcée + Routing par slug
**Référence visuelle :** [ptoke.me](https://www.ptoke.me/)

---

## 1. Contexte et objectifs du projet

### 1.1 Contexte

Création d'un site portfolio professionnel inspiré du site de Parfait TOKE (ptoke.me), avec une valeur ajoutée majeure : un panneau d'administration complet permettant de gérer l'intégralité du contenu sans toucher au code. Le site doit refléter un profil de développeur/chercheur en informatique spécialisé en vision par ordinateur, machine learning et développement logiciel.

### 1.2 Objectifs

- **Côté client (public)** : Présenter de manière professionnelle et attrayante le profil, les compétences, les expériences, les projets, les publications, le parcours académique et les articles de blog.
- **Côté administrateur (privé)** : Offrir une interface complète pour créer, modifier, supprimer et réorganiser tout le contenu du portfolio, avec un tableau de bord de statistiques de fréquentation.
- **Maintenabilité** : Architecture propre, modulaire et documentée permettant des évolutions futures sans dette technique.

---

## 2. Architecture technique

### 2.1 Stack retenue

| Couche | Technologie | Justification |
|--------|-------------|---------------|
| **Backend / API** | Laravel 11+ | Framework PHP robuste, écosystème riche, ORM Eloquent, migrations, seeders |
| **Admin** | Laravel Filament 3 | Panel admin PHP natif, CRUD auto-généré, widgets dashboard, zéro JS custom nécessaire |
| **Frontend client** | Next.js 14+ (App Router) | SSR/SSG pour le SEO, React, performance optimale, déploiement flexible |
| **Styling** | Tailwind CSS 3 | Cohérence avec le design de référence, responsive natif, utility-first |
| **Base de données** | PostgreSQL 16 | Robuste, support JSON natif, full-text search pour le blog |
| **Stockage fichiers** | Laravel + S3 compatible (ou local) | Images, CV PDF, médias — abstraction via filesystem Laravel |
| **Cache** | Redis | Cache API, sessions admin, file d'attente pour analytics |

### 2.2 Recommandation admin — Pourquoi Filament ?

Filament est le choix optimal pour ce projet pour plusieurs raisons :

1. **Zéro frontend séparé à maintenir** — Filament vit dans le même projet Laravel, un seul dépôt à gérer.
2. **CRUD auto-généré** — Les ressources (projets, expériences, articles) se créent en quelques commandes artisan.
3. **Widgets natifs** — Graphiques, statistiques, compteurs pour le dashboard admin.
4. **Upload d'images intégré** — Drag & drop, crop, redimensionnement natif.
5. **Cohérence avec la référence** — Parfait TOKE utilise lui-même Filament sur la majorité de ses projets.
6. **Maintenance simplifiée** — Une seule stack PHP à mettre à jour, pas de dépendances frontend complexes côté admin.

### 2.3 Architecture globale

```
┌─────────────────────────────────────────────────────┐
│                    INTERNET                          │
└──────────┬──────────────────────┬────────────────────┘
           │                      │
   ┌───────▼───────┐     ┌───────▼────────┐
   │  Next.js App  │     │  Laravel App   │
   │  (Frontend    │     │  (API REST +   │
   │   client)     │     │   Filament     │
   │               │     │   Admin)       │
   │  Port 3000    │     │  Port 8000     │
   └───────┬───────┘     └───────┬────────┘
           │                      │
           │    API REST (JSON)   │
           └──────────┬───────────┘
                      │
              ┌───────▼───────┐
              │  PostgreSQL   │
              │  + Redis      │
              └───────────────┘
```

### 2.4 Communication Frontend ↔ Backend

- **API REST** exposée par Laravel (routes `/api/v1/*`)
- **Next.js** consomme l'API côté serveur (SSR) pour le SEO et côté client pour les interactions dynamiques
- **Authentification admin** : Laravel Sanctum (sessions + CSRF pour Filament)
- **Cache API** : réponses mises en cache avec Redis, invalidation automatique à chaque modification via Filament

---

## 3. Fonctionnalités détaillées — Côté client (public)

### 3.1 Navigation et Header

| Élément | Description |
|---------|-------------|
| Logo / Avatar | Image de profil cliquable (retour accueil) |
| Menu desktop | Liens : Accueil, Services, Expériences, Projets, Éducation, Blog, Publications, Contact |
| Menu mobile | Hamburger menu avec navigation slide-in |
| Scroll actif | Highlight automatique de la section visible |
| Smooth scroll | Navigation fluide entre les sections |

### 3.2 Section Hero

| Élément | Description | Géré en admin |
|---------|-------------|---------------|
| Photo de profil | Image ronde avec bordure/ombre | ✅ Upload |
| Nom complet | Titre principal H1 | ✅ Texte |
| Titre professionnel | Sous-titre (ex: "Étudiant M.Sc. & Développeur") | ✅ Texte |
| Texte rotatif animé | Phrases qui défilent automatiquement | ✅ Liste de phrases |
| Barre de skills défilante | Icônes/logos des technologies maîtrisées, défilement horizontal infini | ✅ Gestion skills |
| Boutons CTA | Télécharger CV + Contact | ✅ Fichier CV + lien |

### 3.3 Section Services

| Élément | Description | Géré en admin |
|---------|-------------|---------------|
| Grille de cartes | 3 colonnes desktop, 1 mobile | — |
| Chaque carte | Icône, titre, description, tags technos | ✅ CRUD complet |
| Ordre d'affichage | Position personnalisable | ✅ Drag & drop |
| Nombre de services | Illimité | — |

**Champs par service :**
- Icône (upload SVG/PNG ou sélection depuis bibliothèque)
- Titre (string, max 100 caractères)
- Description (texte, max 500 caractères)
- Technologies associées (relation many-to-many avec table `technologies`)
- Ordre d'affichage (integer, tri automatique)
- Actif/Inactif (boolean — permet de masquer sans supprimer)

### 3.4 Section Expériences

| Élément | Description | Géré en admin |
|---------|-------------|---------------|
| Filtres par onglets | All / Emploi / Fondé / Bénévolat / Stage | ✅ Catégories gérables |
| Timeline | Présentation chronologique | Automatique |
| Chaque carte | Logo entreprise, poste, entreprise, période, catégorie(s), description, tags | ✅ CRUD complet |

**Champs par expérience :**
- Logo entreprise (upload image)
- Nom du poste (string)
- Nom de l'entreprise (string)
- URL entreprise (string, optionnel)
- Date début (date) + Date fin (date, nullable = "Présent")
- Catégorie(s) (enum multiple : paid_position, founded, volunteer, internship)
- Description (texte riche, max 1000 caractères)
- Technologies/compétences (relation many-to-many)
- Lieu (string, optionnel)
- Type de travail (enum : on_site, remote, hybrid)
- Ordre d'affichage (integer, fallback : tri par date)
- Actif/Inactif (boolean)

### 3.5 Section Projets

| Élément | Description | Géré en admin |
|---------|-------------|---------------|
| Filtres par onglets | All / Client / Personnel / Open Source / Académique | ✅ Catégories |
| Grille de cartes | Screenshots + infos | — |
| Chaque carte | Screenshot, nom, description, tags technos, liens externes | ✅ CRUD complet |

**Champs par projet :**
- Screenshot (upload image, avec génération automatique de thumbnail)
- Nom (string)
- Description courte (texte, max 500 caractères)
- Description longue (texte riche, optionnel — pour page détail future)
- Catégorie (enum : customer, personal, open_source, academic)
- Technologies (relation many-to-many)
- Lien site web (URL, optionnel)
- Lien app mobile (URL, optionnel)
- Lien GitHub (URL, optionnel)
- Lien démo/vidéo (URL, optionnel)
- Date de réalisation (date)
- Projet mis en avant / featured (boolean)
- Ordre d'affichage (integer)
- Actif/Inactif (boolean)

### 3.6 Section Éducation / Formation *(nouveau)*

| Élément | Description | Géré en admin |
|---------|-------------|---------------|
| Timeline verticale | Parcours académique chronologique | Automatique |
| Chaque entrée | Logo établissement, diplôme, établissement, période, description, mention | ✅ CRUD complet |

**Champs par formation :**
- Logo établissement (upload image)
- Nom du diplôme (string)
- Nom de l'établissement (string)
- URL établissement (string, optionnel)
- Date début (date) + Date fin (date, nullable = "En cours")
- Description / spécialisation (texte riche)
- Mention / GPA (string, optionnel)
- Lieu (string)
- Ordre d'affichage (integer, fallback : tri par date)
- Actif/Inactif (boolean)

### 3.7 Section Blog / Articles *(nouveau)*

| Élément | Description | Géré en admin |
|---------|-------------|---------------|
| Liste d'articles | Grille ou liste avec pagination | — |
| Chaque article | Image couverture, titre, extrait, date, catégorie, temps de lecture | ✅ CRUD complet |
| Page article | Contenu complet avec markdown rendu en HTML | ✅ Éditeur riche |
| Catégories | Tags filtrants | ✅ CRUD |
| Recherche | Full-text search | Automatique |

**Champs par article :**
- Titre (string)
- Slug (string, auto-généré)
- Image de couverture (upload image)
- Extrait (texte, max 300 caractères)
- Contenu (texte riche / markdown)
- Catégorie(s) (relation many-to-many)
- Tags (relation many-to-many)
- Date de publication (datetime)
- Statut (enum : draft, published, archived)
- Temps de lecture estimé (calculé automatiquement)
- SEO : meta title, meta description, og:image
- Auteur (relation, prêt pour multi-auteur futur)
- Actif/Inactif (boolean)

### 3.8 Section Publications et Références *(nouveau)*

| Élément | Description | Géré en admin |
|---------|-------------|---------------|
| Liste de publications | Articles scientifiques, mémoires, rapports | — |
| Chaque publication | Titre, auteurs, venue, année, lien DOI/PDF, résumé | ✅ CRUD complet |
| Catégories | Journal / Conférence / Mémoire / Rapport technique | ✅ Filtres |

**Champs par publication :**
- Titre (string)
- Auteurs (string — format "Nom1, A., Nom2, B.")
- Type (enum : journal, conference, thesis, technical_report, book_chapter)
- Venue / revue / conférence (string)
- Année de publication (integer)
- Lien DOI (URL, optionnel)
- Lien PDF (upload ou URL externe)
- Résumé / abstract (texte)
- Mots-clés (relation many-to-many)
- Citation BibTeX (texte, optionnel)
- Projet associé (relation, optionnel — lie à un projet du portfolio)
- Featured (boolean)
- Ordre d'affichage (integer, fallback : tri par année)

### 3.9 Section Contact

| Élément | Description | Géré en admin |
|---------|-------------|---------------|
| Liens sociaux | LinkedIn, GitHub, Twitter/X, Email + autres | ✅ CRUD liens |
| Bouton CV | Téléchargement PDF | ✅ Upload fichier |
| Vidéo bio | Embed YouTube/Vimeo | ✅ URL |
| Formulaire contact (optionnel) | Nom, email, message → notification email | ✅ Voir messages en admin |

**Champs pour liens sociaux :**
- Plateforme (enum : linkedin, github, twitter, email, youtube, website, other)
- URL (string)
- Libellé (string, optionnel)
- Icône personnalisée (upload, optionnel)
- Ordre d'affichage (integer)
- Actif/Inactif (boolean)

---

## 4. Fonctionnalités détaillées — Côté administrateur (Filament)

### 4.1 Dashboard principal

| Widget | Description |
|--------|-------------|
| Compteurs | Nombre total de : projets, expériences, articles publiés, publications, messages contact |
| Graphique visites | Courbe des visites des 30 derniers jours |
| Pages populaires | Top 10 des pages/sections les plus visitées |
| Visites aujourd'hui | Compteur temps réel |
| Articles récents | Liste des derniers brouillons et articles publiés |
| Messages non lus | Derniers messages de contact |

### 4.2 Ressources CRUD (auto-générées par Filament)

| Ressource | Actions |
|-----------|---------|
| **Profil / Settings** | Modifier nom, titre, bio, photo, CV, textes rotatifs hero, vidéo bio |
| **Services** | CRUD + réordonner (drag & drop) |
| **Expériences** | CRUD + filtres par catégorie + réordonner |
| **Projets** | CRUD + filtres par catégorie + featured toggle |
| **Éducation** | CRUD + réordonner |
| **Blog > Articles** | CRUD + éditeur riche + gestion statut (brouillon/publié) |
| **Blog > Catégories** | CRUD |
| **Publications** | CRUD + filtres par type |
| **Technologies** | CRUD centralisé (utilisé en relation par services, projets, expériences) |
| **Liens sociaux** | CRUD + réordonner |
| **Messages contact** | Liste, lecture, suppression, marquer comme lu |

### 4.3 Statistiques visiteurs

| Fonctionnalité | Implémentation |
|----------------|----------------|
| Tracking | Middleware Laravel custom + table `page_views` |
| Données collectées | URL, timestamp, referrer, user-agent, pays (GeoIP), appareil |
| Respect RGPD | Pas de cookies tiers, IP anonymisée (hashée), aucune donnée personnelle |
| Dashboard widgets | Graphiques Filament (Chart.js intégré) |
| Rétention | Données agrégées après 90 jours, détail supprimé |

**Table `page_views` :**
```
id | url | referrer | country | device_type | browser | created_at
```

### 4.4 Gestion des médias

| Fonctionnalité | Description |
|----------------|-------------|
| Bibliothèque centralisée | Toutes les images uploadées au même endroit |
| Redimensionnement auto | Thumbnails générés à l'upload (small, medium, large) |
| Formats acceptés | JPG, PNG, SVG, WebP, PDF (pour CV) |
| Optimisation | Compression automatique, conversion WebP |
| Limite de taille | 5 MB par fichier |

---

## 5. Modèle de données

### 5.1 Diagramme des entités (UUID + Slug — jamais d'ID séquentiel)

**Convention : Toutes les tables utilisent `uuid` comme clé primaire et `slug` comme identifiant public.**

```
┌──────────────────┐     ┌──────────────────┐     ┌──────────────┐
│    profiles      │     │   technologies   │     │    tags      │
│──────────────────│     │──────────────────│     │──────────────│
│ id (UUID, PK)    │     │ id (UUID, PK)    │     │ id (UUID, PK)|
│ name             │     │ name             │     │ name         │
│ title            │     │ slug (unique)    │     │ slug (unique)│
│ bio              │     │ icon             │     │ type         │
│ photo            │     │ order            │     └──────────────┘
│ cv_file          │     └────────┬─────────┘
│ video_url        │              │ M:N
│ hero_phrases     │              │
│ email            │     ┌────────┴─────────┐
└──────────────────┘     │  technologables  │  (polymorphic pivot)
                         │──────────────────│
┌──────────────────┐     │ technology_id    │     ┌──────────────────┐
│    services      │────▶│ technologable_id │     │   experiences    │
│──────────────────│     │ technologable_   │◀────│──────────────────│
│ id (UUID, PK)    │     │   type           │     │ id (UUID, PK)    │
│ slug (unique)    │     └──────────────────┘     │ slug (unique)    │
│ title            │                              │ position         │
│ description      │                              │ company          │
│ icon             │                              │ company_logo     │
│ order            │     ┌──────────────────┐     │ company_url      │
│ is_active        │     │    projects      │     │ start_date       │
└──────────────────┘     │──────────────────│     │ end_date         │
                         │ id (UUID, PK)    │     │ category         │
┌──────────────────┐     │ slug (unique)    │     │ description      │
│   educations     │     │ name             │     │ location         │
│──────────────────│     │ description      │     │ work_type        │
│ id (UUID, PK)    │     │ long_description │     │ order            │
│ slug (unique)    │     │ screenshot       │     │ is_active        │
│ degree           │     │ category         │     └──────────────────┘
│ institution      │     │ website_url      │
│ institution_logo │     │ mobile_url       │     ┌──────────────────┐
│ start_date       │     │ github_url       │     │   publications   │
│ end_date         │     │ demo_url         │     │──────────────────│
│ description      │     │ date             │     │ id (UUID, PK)    │
│ mention          │     │ is_featured      │     │ slug (unique)    │
│ location         │     │ order            │     │ title            │
│ order            │     │ is_active        │     │ authors          │
│ is_active        │     └──────────────────┘     │ type             │
└──────────────────┘                              │ venue            │
                         ┌──────────────────┐     │ year             │
┌──────────────────┐     │     posts        │     │ doi_url          │
│  social_links    │     │──────────────────│     │ pdf_file         │
│──────────────────│     │ id (UUID, PK)    │     │ abstract         │
│ id (UUID, PK)    │     │ slug (unique)    │     │ bibtex           │
│ platform         │     │ title            │     │ project_id (FK)  │
│ url              │     │ cover_image      │     │ is_featured      │
│ label            │     │ excerpt          │     │ order            │
│ icon             │     │ content          │     └──────────────────┘
│ order            │     │ status           │
│ is_active        │     │ published_at     │     ┌──────────────────┐
└──────────────────┘     │ reading_time     │     │   page_views     │
                         │ seo_title        │     │──────────────────│
┌──────────────────┐     │ seo_description  │     │ id (UUID, PK)    │
│   categories     │     │ author_id        │     │ url              │
│──────────────────│     └──────────────────┘     │ referrer         │
│ id (UUID, PK)    │                              │ country          │
│ slug (unique)    │     ┌──────────────────┐     │ device_type      │
│ name             │     │ contact_messages │     │ browser          │
│ type             │     │──────────────────│     │ created_at       │
└──────────────────┘     │ id (UUID, PK)    │     └──────────────────┘
                         │ name             │
┌──────────────────┐     │ email (chiffré)  │
│   audit_logs     │     │ message          │
│──────────────────│     │ is_read          │
│ id (UUID, PK)    │     │ created_at       │
│ user_id (FK)     │     └──────────────────┘
│ model_type       │
│ model_id         │
│ action           │
│ old_values (JSON)│
│ new_values (JSON)│
│ ip_address       │
│ user_agent       │
│ created_at       │
└──────────────────┘
```

### 5.2 Relations polymorphiques

- **`technologables`** — Pivot polymorphique reliant `technologies` à `services`, `projects`, `experiences`, `educations`
- **`categorizables`** — Pivot polymorphique reliant `categories` à `posts`, `publications`
- **`taggables`** — Pivot polymorphique reliant `tags` à `posts`, `publications`, `projects`

---

## 6. API REST — Endpoints

### 6.1 Endpoints publics (consommés par Next.js)

```
GET  /api/v1/profile              → Infos profil + hero + skills
GET  /api/v1/services             → Liste services actifs (triés)
GET  /api/v1/experiences          → Liste expériences actives (triées)
GET  /api/v1/experiences?category=paid_position  → Filtre par catégorie
GET  /api/v1/projects             → Liste projets actifs
GET  /api/v1/projects?category=open_source       → Filtre par catégorie
GET  /api/v1/projects/{slug}      → Détail projet (futur)
GET  /api/v1/educations           → Liste formations
GET  /api/v1/posts                → Liste articles publiés (paginés)
GET  /api/v1/posts?category={slug}               → Filtre par catégorie
GET  /api/v1/posts/{slug}         → Détail article
GET  /api/v1/publications         → Liste publications
GET  /api/v1/publications?type=conference         → Filtre par type
GET  /api/v1/social-links         → Liens sociaux actifs
GET  /api/v1/categories           → Catégories disponibles
POST /api/v1/contact              → Envoi message contact (rate-limited)
POST /api/v1/track                → Enregistrement page view (analytics)
```

### 6.2 Conventions API

- Format : JSON
- **Identification : par slug uniquement — aucun ID numérique ni UUID dans les URLs ou réponses**
- Pagination : `?page=1&per_page=12`
- Tri : `?sort=-created_at` (préfixe `-` pour décroissant)
- Filtrage : query params
- Réponse standard : `{ data: [...], meta: { current_page, last_page, total } }`
- Erreurs : `{ message: "...", errors: { field: ["..."] } }`
- Versioning : préfixe `/v1/`
- Rate limiting : 60 requêtes/minute (public), 10/minute (contact)
- Cache : headers `Cache-Control`, invalidation via événements Filament

### 6.3 Règle absolue — Aucun ID dans les réponses API

Les API Resources (transformers) filtrent systématiquement les champs exposés. Jamais d'`id`, jamais d'`uuid` dans le JSON public :

```php
// ❌ INTERDIT — Expose l'ID interne
{
    "id": "a8f5f167-...",
    "name": "Mon projet",
    "created_at": "2026-03-31"
}

// ✅ CORRECT — Seul le slug est exposé comme identifiant
{
    "slug": "mon-projet",
    "name": "Mon projet",
    "created_at": "2026-03-31"
}
```

```php
// App/Http/Resources/ProjectResource.php
class ProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'slug'        => $this->slug,          // Identifiant public
            // 'id'       => JAMAIS EXPOSÉ
            'name'        => $this->name,
            'description' => $this->description,
            'category'    => $this->category,
            'screenshot'  => $this->screenshot_url, // URL complète, pas le path
            'technologies'=> TechnologyResource::collection($this->technologies),
            'website_url' => $this->website_url,
            'github_url'  => $this->github_url,
            'mobile_url'  => $this->mobile_url,
            'is_featured' => $this->is_featured,
            'date'        => $this->date?->format('Y-m-d'),
        ];
    }
}
```

---

## 7. SEO et Performance

### 7.1 Stratégie SEO

| Aspect | Implémentation |
|--------|----------------|
| SSR / SSG | Next.js App Router avec `generateStaticParams` pour les articles |
| Meta tags | Dynamiques par page (title, description, og:image) |
| Sitemap | Généré automatiquement (`/sitemap.xml`) |
| Robots.txt | Configuré pour indexation |
| Structured Data | JSON-LD (Person, Article, BreadcrumbList) |
| URLs | Slugs propres, pas d'IDs dans les URLs |
| Images | Alt text obligatoire, format WebP, lazy loading |
| Open Graph | Tags OG pour partage social (LinkedIn, Twitter) |

### 7.2 Performance

| Aspect | Cible |
|--------|-------|
| Lighthouse score | > 90 sur les 4 métriques |
| LCP | < 2.5s |
| FID | < 100ms |
| CLS | < 0.1 |
| Images | WebP, responsive (`srcset`), lazy loading |
| API Cache | Redis, TTL 5 min, invalidation événementielle |
| Bundle | Code splitting par route Next.js |
| CDN | Assets statiques via CDN |

---

## 8. Design et UX

### 8.1 Principes de design

- **Mobile-first** : design responsive, breakpoints Tailwind (sm, md, lg, xl)
- **Dark mode / Light mode** : toggle avec persistance locale
- **Animations subtiles** : scroll reveal, hover effects, transitions CSS (pas de bibliothèques lourdes)
- **Accessibilité** : WCAG 2.1 AA minimum (contraste, navigation clavier, ARIA labels)

### 8.2 Composants à animer (inspirés de ptoke.me)

| Composant | Animation |
|-----------|-----------|
| Barre de skills | Défilement horizontal infini (CSS `@keyframes`) |
| Texte hero | Rotation/typing effect |
| Cartes | Fade-in au scroll (Intersection Observer) |
| Filtres | Transition layout fluide au changement d'onglet |
| Navigation | Shrink header au scroll |
| Boutons | Hover scale + transition couleur |

### 8.3 Palette de couleurs (personnalisable en admin)

```
--color-primary:    #2563EB (bleu)
--color-secondary:  #7C3AED (violet)
--color-accent:     #06B6D4 (cyan)
--color-bg-light:   #FFFFFF
--color-bg-dark:    #0F172A
--color-text-light: #1E293B
--color-text-dark:  #E2E8F0
```

---

## 9. Sécurité — Politique zéro compromis

### 9.1 Principe fondamental — Jamais d'ID dans les URLs

**Problème :** Les URLs de type `/project/1`, `/post/2`, `/experience/3` sont dangereuses car elles exposent les IDs auto-incrémentés de la base de données. Cela permet à un attaquant de deviner et énumérer toutes les ressources (en incrémentant simplement l'ID), de déduire le volume de données (l'ID 500 = au moins 500 projets), et de cibler des ressources spécifiques.

**Solution retenue — Double identification : UUID + Slug**

Chaque modèle possède deux identifiants non-séquentiels :

| Champ | Usage | Exemple |
|-------|-------|---------|
| `uuid` (UUID v4) | Identifiant interne, clé primaire | `a8f5f167-7d3b-4eca-9c0b-1c3e2f4a5b6d` |
| `slug` | Identifiant public dans l'URL | `mon-super-projet-ia` |

**Implémentation Laravel :**

```php
// Migration — chaque table suit ce modèle
Schema::create('projects', function (Blueprint $table) {
    $table->uuid('id')->primary();            // UUID comme clé primaire
    $table->string('slug')->unique()->index(); // Slug unique et indexé
    // ... autres colonnes
});

// Modèle — génération automatique
class Project extends Model
{
    use HasUuids;                              // Trait Laravel natif

    public function getRouteKeyName(): string
    {
        return 'slug';                         // Route binding par slug
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name); // Auto-génération
        });
    }
}

// Route — résolution automatique par slug
Route::get('/api/v1/projects/{project}', [ProjectController::class, 'show']);
// Produit : /api/v1/projects/mon-super-projet  ✅
// Au lieu de : /api/v1/projects/3              ❌
```

**Règles slug :**
- Généré automatiquement à partir du titre/nom
- Modifiable manuellement en admin (pour le SEO)
- Unicité garantie (ajout d'un suffixe `-2`, `-3` si collision)
- Format : minuscules, tirets, pas de caractères spéciaux
- Indexé en base pour des performances de lookup optimales

**Tables concernées :** `projects`, `posts`, `experiences`, `services`, `educations`, `publications`, `categories`, `technologies`

### 9.2 Authentification et contrôle d'accès

| Couche | Mesure | Détail |
|--------|--------|--------|
| **Authentification** | Laravel Sanctum | Sessions sécurisées (cookies HttpOnly, SameSite=Strict) + CSRF token |
| **2FA obligatoire** | TOTP | Google Authenticator / Authy — activé dès la première connexion admin |
| **Mots de passe** | Argon2id | Algorithme plus résistant que Bcrypt, minimum 14 caractères, vérification contre les listes de mots de passe compromis (Have I Been Pwned API) |
| **Verrouillage compte** | Rate limiting login | 5 tentatives max, verrouillage 15 min, notification par email après 3 échecs |
| **Sessions** | Expiration stricte | Timeout 2h d'inactivité, une seule session active à la fois, invalidation à la déconnexion |
| **Récupération** | Reset password | Token signé à usage unique, expiration 1h, notification de changement |

**Implémentation concrète :**

```php
// config/auth.php — Hasheur sécurisé
'passwords' => [
    'users' => [
        'expire' => 60,        // Token reset expire après 1h
        'throttle' => 120,     // 2 min entre chaque demande de reset
    ],
],

// Middleware personnalisé — vérification IP admin
class AdminIpRestriction
{
    public function handle($request, Closure $next)
    {
        $allowedIps = config('admin.allowed_ips'); // Liste blanche optionnelle
        if ($allowedIps && !in_array($request->ip(), $allowedIps)) {
            abort(403, 'Accès interdit depuis cette adresse IP');
        }
        return $next($request);
    }
}
```

### 9.3 Protection de l'API publique

| Vecteur d'attaque | Protection | Implémentation |
|-------------------|------------|----------------|
| **Brute force / DDoS** | Rate limiting multi-niveaux | 60 req/min global, 10/min contact, 5/min login |
| **Injection SQL** | Requêtes paramétrées | Eloquent ORM exclusivement, jamais de raw SQL |
| **XSS** | Échappement + CSP | Blade auto-escape, React auto-escape, Content-Security-Policy strict |
| **CSRF** | Token Sanctum | Double submit cookie pattern sur toutes les mutations |
| **Mass Assignment** | Guarded/Fillable | Chaque modèle déclare explicitement les champs modifiables |
| **Énumération** | Slugs + réponses uniformes | Pas d'ID, erreur 404 identique pour "n'existe pas" et "pas autorisé" |
| **Data leaking** | API Resources | Chaque réponse passe par un transformer qui filtre les champs exposés |
| **Requêtes malformées** | Form Requests | Validation stricte avec types, formats, et tailles sur chaque endpoint |
| **Surcharge serveur** | Pagination forcée | Maximum 50 items par page, pas de `?per_page=99999` |

**Headers de sécurité HTTP (Middleware Laravel) :**

```php
class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $response
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('X-Frame-Options', 'DENY')
            ->header('X-XSS-Protection', '0')  // Désactivé car CSP le remplace
            ->header('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->header('Permissions-Policy', 'camera=(), microphone=(), geolocation=()')
            ->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload')
            ->header('Content-Security-Policy', implode('; ', [
                "default-src 'self'",
                "script-src 'self'",
                "style-src 'self' 'unsafe-inline'",    // Tailwind inline styles
                "img-src 'self' data: https:",          // Images externes autorisées
                "font-src 'self'",
                "connect-src 'self' https://api.votredomaine.com",
                "frame-ancestors 'none'",               // Anti-clickjacking
                "base-uri 'self'",
                "form-action 'self'",
            ]));
    }
}
```

### 9.4 Sécurité des uploads de fichiers

Les uploads sont un des vecteurs d'attaque les plus courants. Politique stricte :

| Règle | Détail |
|-------|--------|
| **Validation MIME** | Vérification réelle du contenu du fichier (pas juste l'extension) via `finfo_file()` |
| **Extensions autorisées** | Images : jpg, jpeg, png, webp, svg. Documents : pdf uniquement |
| **Taille maximale** | 5 MB par fichier image, 10 MB pour les PDF |
| **Renommage systématique** | Le fichier uploadé est renommé avec un hash unique (jamais le nom original) |
| **Stockage isolé** | Dossier `storage/app/private/` — jamais dans `public/` directement |
| **Pas d'exécution** | Directive Nginx `location ~* \.(php|phtml)$ { deny all; }` sur le dossier uploads |
| **Scan SVG** | Les SVG sont nettoyés (suppression des balises `<script>`, `onclick`, etc.) via `enshrined/svgSanitize` |
| **Traitement images** | Reprocessing via Intervention Image — suppression des métadonnées EXIF (GPS, appareil) |

```php
// App/Http/Requests/UploadImageRequest.php
class UploadImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp',     // Extensions autorisées
                'mimetypes:image/jpeg,image/png,image/webp', // Double vérification MIME
                'max:5120',                      // 5 MB max
                'dimensions:max_width=4000,max_height=4000', // Anti-bomb
            ],
        ];
    }
}
```

### 9.5 Protection de la base de données

| Mesure | Détail |
|--------|--------|
| **Accès restreint** | PostgreSQL accessible uniquement depuis le réseau Docker interne (pas d'exposition de port public) |
| **Utilisateur dédié** | Un user PostgreSQL par application, privilèges minimaux (pas de SUPERUSER) |
| **Chiffrement au repos** | Activation du chiffrement disque sur le volume PostgreSQL |
| **Données sensibles** | Les emails du formulaire contact sont chiffrés en base via `Crypt::encryptString()` |
| **Soft deletes** | Les données ne sont jamais physiquement supprimées immédiatement (récupération possible) |
| **Audit log** | Table `audit_logs` traçant toutes les modifications admin (qui, quoi, quand, ancienne valeur) |

```php
// Trait d'audit automatique sur chaque modèle admin
trait Auditable
{
    protected static function bootAuditable()
    {
        static::updated(function ($model) {
            AuditLog::create([
                'user_id'    => auth()->id(),
                'model_type' => get_class($model),
                'model_id'   => $model->id,
                'action'     => 'updated',
                'old_values' => json_encode($model->getOriginal()),
                'new_values' => json_encode($model->getChanges()),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
            ]);
        });
    }
}
```

### 9.6 Protection côté frontend (Next.js)

| Mesure | Détail |
|--------|--------|
| **Pas de secrets côté client** | Aucune clé API, token, ou secret dans le bundle JS |
| **Variables d'environnement** | Seules les vars préfixées `NEXT_PUBLIC_` sont exposées (URL API uniquement) |
| **Sanitization** | Tout contenu provenant de l'API est sanitized avant rendu (`DOMPurify` pour le HTML du blog) |
| **Formulaire contact** | Honeypot anti-bot + rate limiting côté client + validation avant envoi |
| **Liens externes** | Attribut `rel="noopener noreferrer"` systématique |

### 9.7 Sécurité réseau et infrastructure

| Couche | Mesure | Détail |
|--------|--------|--------|
| **CDN / Proxy** | Cloudflare | Protection DDoS L3/L4/L7, WAF rules, cache edge, masquage IP serveur |
| **HTTPS** | Let's Encrypt | TLS 1.3 obligatoire, HSTS preload, certificat auto-renouvelé |
| **Firewall** | UFW / iptables | Ports ouverts : 22 (SSH, clé uniquement), 80→443 redirect, 443 |
| **SSH** | Clé uniquement | Désactivation authentification par mot de passe, port custom optionnel |
| **Docker** | Réseau isolé | Chaque service dans son propre réseau, seul Nginx expose les ports |
| **Secrets** | Variables d'environnement | `.env` jamais commité, secrets injectés via CI/CD |
| **Dépendances** | Audit automatique | `composer audit` + `npm audit` dans la pipeline CI, blocage si vulnérabilité critique |
| **Monitoring** | Alertes | Notification email/Slack sur : tentatives login échouées, erreurs 500, certificat proche expiration |

### 9.8 Plan de sauvegarde et récupération

| Élément | Fréquence | Rétention | Stockage |
|---------|-----------|-----------|----------|
| Base de données complète | Quotidien (3h du matin) | 30 jours | S3 / Backblaze B2 |
| Fichiers uploads/médias | Quotidien | 30 jours | S3 / Backblaze B2 |
| Snapshot complet serveur | Hebdomadaire | 4 semaines | Provider VPS |
| Test de restauration | Mensuel | — | Environnement staging |

```php
// config/backup.php (spatie/laravel-backup)
'backup' => [
    'name' => 'portfolio-backup',
    'source' => [
        'databases' => ['pgsql'],
        'files' => [
            'include' => [storage_path('app')],
            'exclude' => [storage_path('app/public/cache')],
        ],
    ],
    'destination' => [
        'disks' => ['s3'],
    ],
    'notifications' => [
        'mail' => ['to' => 'votre@email.com'],
        // Notification si backup échoue
    ],
],
```

### 9.9 Checklist sécurité pré-déploiement

- [ ] `APP_DEBUG=false` en production
- [ ] `APP_ENV=production` configuré
- [ ] `.env` absent du dépôt Git (`.gitignore`)
- [ ] Clés de chiffrement uniques générées (`php artisan key:generate`)
- [ ] HTTPS forcé sur toutes les routes
- [ ] Headers de sécurité vérifiés (test via securityheaders.com)
- [ ] Rate limiting actif et testé
- [ ] 2FA activé sur le compte admin
- [ ] Ports DB/Redis fermés depuis l'extérieur
- [ ] SSH par clé uniquement, mot de passe désactivé
- [ ] Backups automatiques testés et fonctionnels
- [ ] Dépendances auditées (`composer audit`, `npm audit`)
- [ ] Logs configurés et rotation en place
- [ ] Telescope désactivé en production (ou protégé par auth)
- [ ] Formulaire contact testé contre le spam
- [ ] Aucun ID numérique exposé dans les URLs ou réponses API

---

## 10. Déploiement — Recommandation

### 10.1 Option recommandée : VPS + Docker

| Composant | Service |
|-----------|---------|
| **VPS** | DigitalOcean Droplet ($12/mois, 2 GB RAM) ou équivalent OVH |
| **Conteneurisation** | Docker Compose (Laravel + Nginx + PostgreSQL + Redis) |
| **Frontend** | Vercel (gratuit, Next.js natif) OU dans le même VPS |
| **CI/CD** | GitHub Actions (tests + déploiement auto) |
| **SSL** | Let's Encrypt (auto-renouvelé) |
| **DNS** | Cloudflare (CDN + protection DDoS gratuite) |
| **Monitoring** | Laravel Telescope (dev) + logs structurés |
| **Backups** | `spatie/laravel-backup` → stockage S3 ou Backblaze B2 |

### 10.2 Alternative économique

| Composant | Service | Coût |
|-----------|---------|------|
| Backend Laravel | Railway ou Render | Gratuit → $5/mois |
| Frontend Next.js | Vercel | Gratuit (hobby) |
| Base de données | Neon PostgreSQL | Gratuit (tier) |
| Redis | Upstash | Gratuit (tier) |
| **Total** | | **~$0-5/mois** |

### 10.3 Structure Docker Compose

```yaml
services:
  app:          # Laravel (PHP-FPM)
  nginx:        # Serveur web
  postgres:     # Base de données
  redis:        # Cache + sessions
  queue:        # Laravel Queue Worker
  scheduler:    # Laravel Task Scheduler (cron)
  nextjs:       # Frontend (optionnel si Vercel)
```

---

## 11. Plan de développement — Sprints

### Phase 1 — Fondations (Sprint 1-2, ~2 semaines)

- [ ] Initialisation projet Laravel + configuration PostgreSQL + Redis
- [ ] Création des migrations pour toutes les tables
- [ ] Création des modèles Eloquent avec relations
- [ ] Seeders avec données de démonstration
- [ ] Installation et configuration de Filament
- [ ] Configuration Sanctum + middleware API
- [ ] Tests unitaires des modèles et relations

### Phase 2 — Admin Filament (Sprint 3-4, ~2 semaines)

- [ ] Ressource Filament : Profile/Settings
- [ ] Ressource Filament : Services (CRUD + reorder)
- [ ] Ressource Filament : Expériences (CRUD + filtres)
- [ ] Ressource Filament : Projets (CRUD + featured)
- [ ] Ressource Filament : Éducation (CRUD)
- [ ] Ressource Filament : Blog (Articles + Catégories + éditeur riche)
- [ ] Ressource Filament : Publications
- [ ] Ressource Filament : Technologies (centralisé)
- [ ] Ressource Filament : Liens sociaux
- [ ] Ressource Filament : Messages contact
- [ ] Gestion des médias centralisée
- [ ] Tests fonctionnels admin

### Phase 3 — API REST (Sprint 5, ~1 semaine)

- [ ] Contrôleurs API pour chaque ressource
- [ ] API Resources (transformers JSON)
- [ ] Pagination, filtrage, tri
- [ ] Cache Redis avec invalidation
- [ ] Rate limiting
- [ ] Documentation API (optionnel : Swagger/OpenAPI)
- [ ] Tests d'intégration API

### Phase 4 — Frontend Next.js (Sprint 6-8, ~3 semaines)

- [ ] Initialisation Next.js + Tailwind CSS + TypeScript
- [ ] Layout principal (Header, Footer, Navigation responsive)
- [ ] Section Hero (photo, texte rotatif, skills défilants)
- [ ] Section Services (grille de cartes)
- [ ] Section Expériences (timeline + filtres)
- [ ] Section Projets (grille + filtres + liens)
- [ ] Section Éducation (timeline)
- [ ] Section Blog (liste + page article)
- [ ] Section Publications (liste + filtres)
- [ ] Section Contact (liens + formulaire)
- [ ] Dark mode / Light mode
- [ ] Animations et transitions
- [ ] SEO (meta tags, sitemap, JSON-LD)
- [ ] Tests E2E

### Phase 5 — Analytics et polish (Sprint 9, ~1 semaine)

- [ ] Middleware tracking page views
- [ ] Dashboard widgets analytics (Filament)
- [ ] Optimisation performance (Lighthouse audit)
- [ ] Optimisation images (WebP, lazy loading)
- [ ] Tests de charge basiques
- [ ] Documentation technique

### Phase 6 — Déploiement et lancement (Sprint 10, ~1 semaine)

- [ ] Configuration Docker Compose production
- [ ] Setup CI/CD GitHub Actions
- [ ] Configuration DNS + SSL
- [ ] Déploiement staging → tests → production
- [ ] Backup automatique configuré
- [ ] Monitoring en place
- [ ] Checklist de lancement final

---

## 12. Stratégie de maintenance

### 12.1 Pratiques pour une maintenance facile

| Pratique | Détail |
|----------|--------|
| **Conventions de code** | PSR-12 (PHP), ESLint + Prettier (JS/TS) |
| **Architecture** | Repository pattern pour les modèles complexes, Service classes pour la logique métier |
| **Migrations** | Jamais modifier une migration existante, toujours en créer une nouvelle |
| **Versionning** | Git flow (main, develop, feature branches) |
| **Tests** | Minimum 80% couverture sur les API controllers et modèles |
| **Documentation** | README détaillé, commentaires PHPDoc, types TypeScript stricts |
| **Dépendances** | Audit mensuel (`composer audit`, `npm audit`) |
| **Mises à jour** | Laravel : suivre le guide officiel à chaque release mineure |
| **Logs** | Structurés (JSON), rotation automatique, niveaux appropriés |
| **Backups** | Quotidiens automatiques, test de restauration mensuel |

### 12.2 Arborescence du projet Laravel

```
portfolio-api/
├── app/
│   ├── Filament/
│   │   ├── Resources/          # Ressources CRUD admin
│   │   ├── Widgets/            # Widgets dashboard
│   │   └── Pages/              # Pages custom admin
│   ├── Http/
│   │   ├── Controllers/Api/V1/ # Contrôleurs API versionnés
│   │   ├── Middleware/          # Tracking, CORS, etc.
│   │   └── Requests/           # Form Requests (validation)
│   ├── Models/                 # Modèles Eloquent
│   ├── Services/               # Logique métier
│   ├── Observers/              # Cache invalidation
│   └── Enums/                  # PHP 8.1 Enums (catégories, statuts)
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── routes/
│   ├── api.php                 # Routes API
│   └── web.php                 # Routes admin Filament
├── config/
├── tests/
│   ├── Unit/
│   └── Feature/
├── docker/
│   ├── nginx/
│   ├── php/
│   └── postgres/
├── docker-compose.yml
├── .github/workflows/          # CI/CD
└── README.md
```

### 12.3 Arborescence du projet Next.js

```
portfolio-frontend/
├── src/
│   ├── app/                    # App Router pages
│   │   ├── page.tsx            # Page principale (sections)
│   │   ├── blog/
│   │   │   ├── page.tsx        # Liste articles
│   │   │   └── [slug]/page.tsx # Article détail
│   │   ├── layout.tsx          # Layout racine
│   │   └── globals.css
│   ├── components/
│   │   ├── layout/             # Header, Footer, Navigation
│   │   ├── sections/           # Hero, Services, Experiences, etc.
│   │   ├── ui/                 # Boutons, Cards, Badges, Modals
│   │   └── shared/             # FilterTabs, SkillBar, Timeline
│   ├── lib/
│   │   ├── api.ts              # Client API centralisé
│   │   ├── types.ts            # Types TypeScript
│   │   └── utils.ts            # Helpers
│   ├── hooks/                  # Custom hooks React
│   └── styles/                 # Tokens Tailwind custom
├── public/                     # Assets statiques
├── next.config.js
├── tailwind.config.ts
├── tsconfig.json
└── README.md
```

---

## 13. Livrables attendus

| # | Livrable | Format |
|---|----------|--------|
| 1 | Code source backend (Laravel + Filament) | Dépôt Git |
| 2 | Code source frontend (Next.js) | Dépôt Git |
| 3 | Configuration Docker Compose | Fichiers YAML |
| 4 | Pipeline CI/CD | GitHub Actions |
| 5 | Documentation technique (README) | Markdown |
| 6 | Seeders avec données de démonstration | PHP |
| 7 | Site déployé et fonctionnel | URL production |
| 8 | Accès admin fonctionnel | URL + credentials |

---

## 14. Critères d'acceptation

- [ ] Toutes les sections du site public s'affichent correctement sur mobile, tablette et desktop
- [ ] L'admin Filament permet de gérer 100% du contenu sans toucher au code
- [ ] Le score Lighthouse est supérieur à 90 sur les 4 métriques
- [ ] Le dark mode fonctionne correctement sur toutes les sections
- [ ] Les filtres (expériences, projets, publications) fonctionnent côté client sans rechargement
- [ ] Le blog supporte le markdown avec rendu riche (code, images, liens)
- [ ] Les statistiques visiteurs s'affichent dans le dashboard admin
- [ ] Le formulaire de contact envoie les messages et notifie l'administrateur
- [ ] Le site est accessible via HTTPS avec certificat valide
- [ ] Les backups automatiques sont configurés et testés
- [ ] La documentation permet à un développeur tiers de reprendre le projet

---

*Document généré le 31 mars 2026 — Version 1.1 — Sécurité renforcée + Routing par slug*
