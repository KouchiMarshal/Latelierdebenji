# L'Atelier de Benji — site e-commerce

Boutique en ligne WordPress + WooCommerce pour la vente de créations
artisanales, hébergée sur OVH (offre Business) sous le domaine
`latelierdebenji.fr`.

## Structure du dépôt

```
wp-content/themes/atelier-benji/   Thème sur-mesure (le seul code versionné)
.github/workflows/deploy.yml       Déploiement automatique vers OVH par FTP
```

Le cœur de WordPress et les plugins (WooCommerce, extension Stripe, etc.)
ne sont pas versionnés ici : ils s'installent directement sur
l'hébergement OVH. Seul le thème, qui porte le design du site, est géré
dans ce dépôt et déployé automatiquement.

## 1. Installer WordPress sur l'hébergement OVH

1. Dans l'espace client OVH, ouvrez l'hébergement Business associé à
   `latelierdebenji.fr`.
2. Onglet **Modules web** → **WordPress** → lancer l'installation en un
   clic (crée automatiquement la base MySQL). À défaut, installation
   manuelle : créer une base MySQL dans l'onglet **Bases de données**,
   téléverser WordPress par FTP, puis lancer l'assistant d'installation
   sur `https://latelierdebenji.fr/`.
3. Vérifiez dans l'onglet **Domaines** que `latelierdebenji.fr` pointe
   bien vers cet hébergement (normalement automatique si le domaine et
   l'hébergement ont été commandés ensemble chez OVH).

## 2. Installer WooCommerce et Stripe

Dans l'admin WordPress (`/wp-admin`) :

1. **Extensions → Ajouter** → installer et activer **WooCommerce**, puis
   suivre l'assistant de configuration (devise EUR, adresse de la
   boutique, etc.).
2. Installer et activer l'extension **WooCommerce Stripe Gateway**.
3. **WooCommerce → Réglages → Paiements → Stripe** : renseigner les clés
   API de votre compte Stripe (clé publique / clé secrète, disponibles
   sur [dashboard.stripe.com](https://dashboard.stripe.com)).

## 3. Activer le thème Atelier Benji

**Premier déploiement (manuel)** : téléversez par FTP le contenu de
`wp-content/themes/atelier-benji/` vers le même chemin sur le serveur OVH,
puis dans l'admin WordPress : **Apparence → Thèmes → Activer**.

Une fois ce premier déploiement fait, les mises à jour du thème se font
automatiquement via GitHub Actions (voir ci-dessous) — plus besoin de
manipuler le FTP à la main.

## 4. Déploiement automatique (GitHub Actions)

Le workflow `.github/workflows/deploy.yml` redéploie le thème par FTP à
chaque push sur `main` qui modifie `wp-content/`.

Dans les réglages du dépôt GitHub (**Settings → Secrets and variables →
Actions → New repository secret**), ajoutez :

| Secret | Valeur |
|---|---|
| `OVH_FTP_SERVER` | Hôte FTP OVH (onglet **FTP-SSH** de l'hébergement) |
| `OVH_FTP_USERNAME` | Identifiant FTP |
| `OVH_FTP_PASSWORD` | Mot de passe FTP (utilisez un identifiant FTP dédié, pas le mot de passe du compte client OVH) |
| `OVH_FTP_THEME_DIR` | Chemin serveur vers le dossier du thème, ex. `/www/wp-content/themes/atelier-benji/` |

Le déploiement se fait en FTPS (chiffré). Une fois les secrets en place,
fusionnez cette branche dans `main` pour déclencher le premier
déploiement automatique.

## 5. Personnalisation du design

Le thème part sur une palette et une mise en page provisoires
(`wp-content/themes/atelier-benji/assets/css/main.css`), en attendant
l'intégration du logo et de la charte graphique. Envoyez les fichiers
(logo, couleurs, polices) pour que le design définitif soit intégré.

## 6. À prévoir avant l'ouverture de la boutique

- Créer les fiches produits dans **WooCommerce → Produits**.
- Configurer les frais de livraison et la TVA (**WooCommerce → Réglages
  → Livraison / Impôts**).
- Pages légales obligatoires pour un e-commerce en France : Mentions
  légales, CGV, politique de confidentialité, droit de rétractation.
