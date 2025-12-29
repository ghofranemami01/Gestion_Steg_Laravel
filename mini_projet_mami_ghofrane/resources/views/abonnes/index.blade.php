<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Abonnés - STEG</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --steg-blue: #0056b3;
            --steg-purple: #343a40;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
        }

        /* Navbar identique */
        .navbar {
            background: linear-gradient(90deg, var(--steg-purple) 50%, var(--steg-blue) 100%);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
            font-size: 1.3rem;
        }
        .nav-link {
            color: #f8f9fa !important;
            font-weight: 500;
        }
        .nav-link.active {
            color: #ffffff !important;
        }

        .card {
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border-radius: 0.75rem;
        }

        .table th {
            background-color: var(--light-gray);
            font-weight: 600;
        }

        footer {
            background: var(--dark-gray);
            color: #fff;
            padding: 2rem 1rem;
            margin-top: 3rem;
            text-align: center;
        }
    </style>
</head>

<body>

<!-- NAVBAR (IDENTIQUE À VUE.JS) -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-bolt me-2"></i>STEG - Gestion
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-user-cog me-1"></i> Administration
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/abonnes">
                                <i class="fas fa-users me-2"></i> Gestion des Abonnés
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs me-2"></i> Paramètres
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#">
                                <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>

<!-- CONTENU -->
<div class="container-fluid mt-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-users me-2"></i>Gestion des Abonnés</h2>
            <p class="text-muted">Liste complète des abonnés STEG</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('abonnes.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i> Nouvel Abonné
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i> Liste des Abonnés
                <span class="badge bg-secondary ms-2">{{ $abonnes->total() }}</span>
            </h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Nom & Prénom</th>
                            <th>CIN</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($abonnes as $abonne)
                        <tr>
                            <td><span class="badge bg-primary">{{ $abonne->reference }}</span></td>
                            <td><strong>{{ $abonne->nom }}</strong> {{ $abonne->prenom }}</td>
                            <td>{{ $abonne->num_cin }}</td>
                            <td>{{ $abonne->email }}</td>
                            <td>{{ $abonne->tel }}</td>
                            <td>{{ \Carbon\Carbon::parse($abonne->date_abonnement)->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('abonnes.show',$abonne->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('abonnes.edit',$abonne->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('abonnes.destroy',$abonne->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Supprimer cet abonné ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $abonnes->links() }}
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2025 STEG Tunisie – Tous droits réservés</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
