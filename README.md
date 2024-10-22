# 🎓 CVthèque
Bienvenue dans CVthèque, une application web interactive permettant aux utilisateurs de gérer, partager et explorer des CVs professionnels. 📄✨

# 📁 Structure du Projet

/CVth-que
│
├── Docker/
│   ├── services/
│   │   ├── php/
│   │   │   └── Dockerfile          # Configuration Docker pour PHP
│   └── docker-compose.yml          # Configuration Docker Compose pour orchestrer les services
│
├── Docker/app/
│   ├── public/                     # Fichiers accessibles publiquement (index.php, etc.)
│   ├── src/                        # Code source de l'application
│   └── vendor/                     # Dépendances PHP (gérées via Composer)
│
├── composer.json                   # Dépendances PHP
├── bdd.sql                         # Script pour la base de données
└── README.md                       # Documentation du projet

# 🌟 Fonctionnalités principales

**Page d'accueil - CV 🏠 :**
Affiche votre CV personnel et permet d'explorer les CVs récents via un carrousel.

**Téléchargement de CV 📥 :**
 Permet de télécharger et convertir automatiquement des fichiers Word en PDF.

**Gestion des utilisateurs 👤 :**
 Inscription, connexion et déconnexion des utilisateurs avec des formulaires simples.

**Profil utilisateur 📝 :**
 Consultez et modifiez vos informations personnelles et téléchargez votre CV.

**Portefeuille de projets 💼 :**
Présentez vos projets professionnels avec une gestion basée sur une base de données.

**Carrousel des CVs récents 🔄 :**
 Explorez les 6 derniers CVs téléchargés.

# ⚙️ Installation et configuration
**Prérequis**
- PHP 8.1+ 🐘
- Docker 🐳
- Composer 📦 (gestionnaire de dépendances PHP)

**Étapes d'installation**
Clonez le dépôt :

git clone https://github.com/votre-utilisateur/CVth-que.git
cd CVth-que

**Installez les dépendances Composer :**

**composer install**
Lancez l'application avec Docker :

docker-compose up --build
Accédez à l'application :

**Ouvrez votre navigateur et allez à http://localhost 🚀**

Base de données
Initialisez la base de données :

mysql -u root -p cv_db < bdd.sql
Les informations de connexion sont dans le fichier docker-compose.yml :

**environment:**
  MYSQL_ROOT_PASSWORD: "root"
  MYSQL_DATABASE: "cv_db"

# 🚀 Utilisation 
**Inscription/Connexion 👤 :**
 Créez un compte et connectez-vous.

**Téléchargement de CV 📄 :**
Une fois connecté, vous pouvez télécharger votre CV (PDF uniquement/option vendor avenir) sur la page dédiée.

**Carrousel des CVs 🎠 :**
Consultez les CVs récemment ajoutés directement depuis la page d'accueil.

**Profil utilisateur 📝 :**
Accédez à votre profil pour visualiser ou modifier vos informations personnelles.

# 🐳 Déploiement avec Docker
Grâce à Docker, vous pouvez facilement lancer l'application et ses services associés.

docker-compose up --build
Ce fichier configure 3 services :

Nginx : Serveur web.
PHP-FPM : Serveur PHP.
MariaDB : Base de données MySQL.

# 📄 Licence
Ce projet est sous licence MIT.