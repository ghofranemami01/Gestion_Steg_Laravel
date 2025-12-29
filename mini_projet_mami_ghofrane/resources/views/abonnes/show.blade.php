<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Abonné - {{ $abonne->nom }} {{ $abonne->prenom }} - STEG</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --steg-blue: #0056b3;
            --steg-blue-dark: #0b1f3b;
            --steg-blue-light: #1e88e5;
            --steg-gray-light: #f4f6f9;
            --steg-gray: #6c757d;
            --steg-danger: #c62828;
            --steg-warning: #f9a825;
        }

        /* Navbar */
        .navbar {
            background-color: var(--steg-blue) !important;
        }
        .navbar-brand {
            font-weight: 700;
            color: #fff !important;
        }

        /* Cards */
        .card {
            border-radius: 0.75rem;
            border: none;
            background-color: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        /* Buttons */
        .btn-success {
            background: linear-gradient(135deg, var(--steg-blue), var(--steg-blue-light));
            border: none;
            color: #fff;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, var(--steg-blue-dark), var(--steg-blue));
        }

        .btn-secondary {
            background-color: var(--steg-gray);
            border: none;
            color: #fff;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-warning {
            background-color: var(--steg-warning);
            border: none;
            color: #212529;
        }

        .btn-danger {
            background-color: var(--steg-danger);
            border: none;
            color: #fff;
        }

        /* Info blocks */
        .info-label {
            font-weight: 600;
            color: var(--steg-blue-dark);
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #212529;
            padding: 0.45rem 0.75rem;
            background-color: var(--steg-gray-light);
            border: 1px solid #dde3ea;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        /* Badges */
        .badge {
            font-size: 0.85em;
            padding: 0.45em 0.65em;
        }

        /* Header */
        .steg-header {
            background: linear-gradient(90deg, var(--steg-blue-dark), var(--steg-blue));
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-bolt me-2"></i>
                STEG - Gestion des Abonnés
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/abonnes/liste">
                            <i class="fas fa-users me-1"></i> Vue Vue.js
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/abonnes">
                            <i class="fas fa-list me-1"></i> Liste Classique
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="navbar-text me-3">
                            <i class="fas fa-user me-1"></i>
                            Administrateur
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container-fluid mt-4">
        <!-- En-tête -->
        <div class="steg-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2"><i class="fas fa-user-circle me-2"></i>{{ $abonne->nom }} {{ $abonne->prenom }}</h1>
                    <p class="mb-1"><i class="fas fa-id-card me-2"></i>CIN: {{ $abonne->num_cin }}</p>
                    <p class="mb-0"><i class="fas fa-hashtag me-2"></i>Référence: <span class="badge bg-light text-dark">{{ $abonne->reference }}</span></p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="btn-group" role="group">
                        <a href="{{ route('abonnes.edit', $abonne->id) }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-edit me-2"></i> Modifier
                        </a>
                        <button type="button" class="btn btn-danger btn-lg" onclick="confirmDelete({{ $abonne->id }}, '{{ $abonne->nom }} {{ $abonne->prenom }}')">
                            <i class="fas fa-trash me-2"></i> Supprimer
                        </button>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('abonnes.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i> Retour à la Liste
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de suppression caché -->
        <form id="delete-form-{{ $abonne->id }}" action="{{ route('abonnes.destroy', $abonne->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <!-- Informations Personnelles -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2 text-primary"></i> Informations Personnelles</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Nom complet</div>
                            <div class="col-sm-8 info-value">{{ $abonne->nom }} {{ $abonne->prenom }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Numéro CIN</div>
                            <div class="col-sm-8 info-value">{{ $abonne->num_cin }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Email</div>
                            <div class="col-sm-8 info-value"><a href="mailto:{{ $abonne->email }}" class="text-decoration-none"><i class="fas fa-envelope me-1"></i>{{ $abonne->email }}</a></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Téléphone</div>
                            <div class="col-sm-8 info-value"><a href="tel:{{ $abonne->tel }}" class="text-decoration-none"><i class="fas fa-phone me-1"></i>{{ $abonne->tel }}</a></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date d'abonnement</div>
                            <div class="col-sm-8 info-value"><i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($abonne->date_abonnement)->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations STEG -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2 text-warning"></i> Informations STEG</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Référence</div>
                            <div class="col-sm-8 info-value"><span class="badge bg-primary fs-6">{{ $abonne->reference }}</span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Compteur Électricité</div>
                            <div class="col-sm-8 info-value"><i class="fas fa-bolt text-warning me-1"></i>{{ $abonne->num_compteur_elec }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Compteur Gaz</div>
                            <div class="col-sm-8 info-value"><i class="fas fa-fire text-danger me-1"></i>{{ $abonne->num_compteur_gaz }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date de création</div>
                            <div class="col-sm-8 info-value"><i class="fas fa-clock me-1"></i>{{ $abonne->created_at->format('d/m/Y à H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Dernière modification</div>
                            <div class="col-sm-8 info-value"><i class="fas fa-edit me-1"></i>{{ $abonne->updated_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Adresse -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Adresse</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-value" style="font-size: 1.1rem;"><i class="fas fa-home me-2"></i>{{ $abonne->adresse }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2 text-info"></i> Informations Complémentaires</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <i class="fas fa-calendar-check fa-2x text-primary mb-2"></i>
                                    <h6 class="mb-1">Ancien Abonné</h6>
                                    <small class="text-muted">Depuis {{ \Carbon\Carbon::parse($abonne->date_abonnement)->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <i class="fas fa-id-card fa-2x text-primary mb-2"></i>
                                    <h6 class="mb-1">Type</h6>
                                    <small class="text-muted">Abonné Complet</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <i class="fas fa-bolt fa-2x text-warning mb-2"></i>
                                    <h6 class="mb-1">Services</h6>
                                    <small class="text-muted">Électricité + Gaz</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <i class="fas fa-shield-alt fa-2x text-info mb-2"></i>
                                    <h6 class="mb-1">Statut</h6>
                                    <small class="text-muted"><span class="badge bg-success">Actif</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function confirmDelete(id, nom) {
            if (confirm('Êtes-vous sûr de vouloir supprimer l\'abonné "' + nom + '" ? Cette action est irréversible.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</body>
</html>

