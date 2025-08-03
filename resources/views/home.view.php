<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Framework PHP - En développement</title>
    <link rel="stylesheet" href="public/css/home.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="hero">
                <h1>Mon Framework PHP</h1>
                <p>Un framework simple et pratique pour mes projets</p>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="status">
            <strong>🚧 En cours de développement</strong> - Version actuelle : v0.1-alpha
        </div>

        <section class="features">
            <h2>Fonctionnalités actuelles</h2>
            <ul class="feature-list">
                <li>Pattern MVC de base</li>
                <li>Routeur simple et efficace</li>
                <li>Système de migration pour la base de données</li>
                <li>Scripts bash pour l'automatisation</li>
                <li>Génération automatique de controllers, modèles et migrations</li>
                <li>Méthodes de base pour les opérations CRUD</li>
            </ul>
        </section>

        <section class="code-section">
            <h3>Exemple d'utilisation des scripts</h3>
            <div class="code-example">
                <span class="comment"># Créer un nouveau controller</span><br>
                <span class="bash">php make.php controller UserController</span><br>

                <span class="comment"># Créer un nouveau modèle</span><br>
                <span class="bash">php make.php model User</span><br>

                <span class="comment"># Lancer les migrations</span><br>
                <span class="bash">php make.php migrate</span><br>
            </div>
        </section>

        <section class="code-section" id="documentation">
            <h3>Documentation de base</h3>
            <p>Le framework utilise une structure MVC simple :</p>
            <ul style="margin: 1rem 0; padding-left: 2rem;">
                <li><strong>Controllers</strong> : Gèrent la logique métier</li>
                <li><strong>Models</strong> : Interagissent avec la base de données</li>
                <li><strong>Routes</strong> : Dirigent les requêtes vers les bons controllers</li>
                <li><strong>Migrations</strong> : Gèrent l'évolution de la base de données</li>
            </ul>
        </section>

        <section class="code-section">
            <h3>Exemple de routeur</h3>
            <div class="code-example">
                <span class="comment">// Routes de base</span><br>
                Route::get('/', [HomeController::class, 'index']);<br>
                Route::post('/users', [UserController::class, 'store']);<br>
                Route::get('/users/{id}', [UserController::class, 'show']);<br>
            </div>
        </section>

        <section class="roadmap">
            <h2>À venir</h2>
            <ul>
                <li>Système de vues avec templates</li>
                <li>Gestion des middlewares</li>
                <li>Validation des données</li>
                <li>Système de logs</li>
                <li>Cache de base</li>
                <li>Documentation complète</li>
            </ul>
        </section>
    </div>

    <footer>
        <p>Framework PHP personnel - Fait avec ❤️ pour apprendre et expérimenter</p>
    </footer>

    <script>
        // Smooth scrolling pour les liens d'ancrage
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>