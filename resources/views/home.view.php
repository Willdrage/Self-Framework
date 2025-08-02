<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Framework PHP - En développement</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: #2c3e50;
            color: white;
            padding: 2rem 0;
            margin-bottom: 3rem;
        }



        .hero {
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
        }

        .status {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            text-align: center;
        }

        .status strong {
            color: #856404;
        }

        .features {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .features h2 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        .feature-list {
            list-style: none;
        }

        .feature-list li {
            padding: 0.8rem 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .feature-list li:last-child {
            border-bottom: none;
        }

        .feature-list li::before {
            content: "✓";
            color: #27ae60;
            font-weight: bold;
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .code-section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .code-section h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .code-example {
            background: #2d3748;
            color: #e2e8f0;
            padding: 1.5rem;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            overflow-x: auto;
            margin: 1rem 0;
        }

        .bash { color: #68d391; }
        .comment { color: #a0aec0; }
        .string { color: #fbb6ce; }

        .roadmap {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .roadmap h2 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .roadmap ul {
            list-style-type: none;
        }

        .roadmap li {
            padding: 0.5rem 0;
            color: #666;
        }

        .roadmap li::before {
            content: "◯";
            color: #bdc3c7;
            margin-right: 1rem;
        }

        footer {
            text-align: center;
            padding: 2rem 0;
            color: #666;
            font-size: 0.9rem;
        }
    </style>
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