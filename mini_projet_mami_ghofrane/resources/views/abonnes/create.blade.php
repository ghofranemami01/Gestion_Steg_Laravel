<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Abonné - STEG</title>

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
    --steg-gray-dark: #343a40;
    --steg-success: #2e7d32;
}

/* Navbar */
.navbar {
    background: linear-gradient(90deg, var(--steg-blue-dark), var(--steg-blue));
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}
.navbar-brand {
    font-weight: 700;
    color: #ffffff !important;
    letter-spacing: 0.5px;
}
.nav-link {
    color: #e3f2fd !important;
    font-weight: 500;
}
.nav-link.active {
    color: #ffffff !important;
    border-bottom: 2px solid var(--steg-blue-light);
}

/* Cards */
.card {
    border-radius: 0.9rem;
    border: none;
    background-color: #ffffff;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}
.card-header {
    background-color: var(--steg-gray-light);
    border-bottom: none;
    font-weight: 600;
    color: var(--steg-gray-dark);
}

/* Buttons */
.btn-success {
    background: linear-gradient(135deg, var(--steg-success), #43a047);
    border: none;
}
.btn-success:hover {
    background: linear-gradient(135deg, #1b5e20, var(--steg-success));
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
}
.btn-secondary:hover {
    background-color: #5a6268;
}

.btn-warning {
    background: linear-gradient(135deg, #ffca28, #ffb300);
    border: none;
    color: #212529;
}

.btn-info {
    background: linear-gradient(135deg, var(--steg-blue-light), var(--steg-blue));
    border: none;
    color: #fff;
}

/* Form labels */
.form-label {
    font-weight: 600;
    color: var(--steg-gray-dark);
}

/* Required star */
.required::after {
    content: " *";
    color: #e53935;
}

/* Inputs */
.form-control {
    border-radius: 0.6rem;
    border: 1px solid #ced4da;
    transition: all 0.25s ease;
}
.form-control:focus {
    border-color: var(--steg-blue);
    box-shadow: 0 0 0 0.2rem rgba(0,86,179,0.25);
}

/* Info badges */
.info-badge {
    background-color: var(--steg-gray-light);
    padding: 0.55rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--steg-gray-dark);
}

/* Section titles */
h6.text-primary {
    color: var(--steg-blue) !important;
}

/* Alerts */
.alert-danger {
    border-left: 5px solid #e53935;
}

/* Smooth UI */
button, input, textarea {
    transition: all 0.2s ease-in-out;
}
</style>

</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
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
        <div class="row mb-4">
            <div class="col-md-8">
                <h1><i class="fas fa-user-plus me-2"></i>Ajouter un Nouvel Abonné</h1>
                <p class="text-muted">Formulaire d'enregistrement d'un nouvel abonné STEG</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('abonnes.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>
                    Retour à la Liste
                </a>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Informations de l'Abonné
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Erreurs de validation :</h6>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('abonnes.store') }}" method="POST" id="abonneForm">
                            @csrf

                            <!-- Informations personnelles -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-user me-2"></i>
                                        Informations Personnelles
                                    </h6>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label required">Nom</label>
                                    <input type="text"
                                           class="form-control @error('nom') is-invalid @enderror"
                                           id="nom"
                                           name="nom"
                                           value="{{ old('nom') }}"
                                           required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="prenom" class="form-label required">Prénom</label>
                                    <input type="text"
                                           class="form-control @error('prenom') is-invalid @enderror"
                                           id="prenom"
                                           name="prenom"
                                           value="{{ old('prenom') }}"
                                           required>
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="num_cin" class="form-label required">Numéro CIN</label>
                                    <input type="text"
                                           class="form-control @error('num_cin') is-invalid @enderror"
                                           id="num_cin"
                                           name="num_cin"
                                           value="{{ old('num_cin') }}"
                                           required>
                                    @error('num_cin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label required">Email</label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tel" class="form-label required">Téléphone</label>
                                    <input type="tel"
                                           class="form-control @error('tel') is-invalid @enderror"
                                           id="tel"
                                           name="tel"
                                           value="{{ old('tel') }}"
                                           required>
                                    @error('tel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="date_abonnement" class="form-label required">Date d'Abonnement</label>
                                    <input type="date"
                                           class="form-control @error('date_abonnement') is-invalid @enderror"
                                           id="date_abonnement"
                                           name="date_abonnement"
                                           value="{{ old('date_abonnement') }}"
                                           required>
                                    @error('date_abonnement')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Informations STEG -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-bolt me-2"></i>
                                        Informations STEG
                                    </h6>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="reference" class="form-label required">Référence Abonné</label>
                                    <input type="text"
                                           class="form-control @error('reference') is-invalid @enderror"
                                           id="reference"
                                           name="reference"
                                           value="{{ old('reference') }}"
                                           required>
                                    @error('reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="num_compteur_elec" class="form-label required">Numéro Compteur Électricité</label>
                                    <input type="text"
                                           class="form-control @error('num_compteur_elec') is-invalid @enderror"
                                           id="num_compteur_elec"
                                           name="num_compteur_elec"
                                           value="{{ old('num_compteur_elec') }}"
                                           required>
                                    @error('num_compteur_elec')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="num_compteur_gaz" class="form-label required">Numéro Compteur Gaz</label>
                                    <input type="text"
                                           class="form-control @error('num_compteur_gaz') is-invalid @enderror"
                                           id="num_compteur_gaz"
                                           name="num_compteur_gaz"
                                           value="{{ old('num_compteur_gaz') }}"
                                           required>
                                    @error('num_compteur_gaz')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        Adresse
                                    </h6>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="adresse" class="form-label required">Adresse Complète</label>
                                    <textarea class="form-control @error('adresse') is-invalid @enderror"
                                              id="adresse"
                                              name="adresse"
                                              rows="3"
                                              required>{{ old('adresse') }}</textarea>
                                    @error('adresse')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('abonnes.index') }}" class="btn btn-secondary btn-lg">
                                            <i class="fas fa-times me-2"></i>
                                            Annuler
                                        </a>
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-save me-2"></i>
                                            Enregistrer l'Abonné
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-génération de la référence
        document.getElementById('nom').addEventListener('input', function() {
            generateReference();
        });

        document.getElementById('prenom').addEventListener('input', function() {
            generateReference();
        });

        function generateReference() {
            const nom = document.getElementById('nom').value.toUpperCase();
            const prenom = document.getElementById('prenom').value.toUpperCase();

            if (nom && prenom) {
                const randomNum = Math.floor(Math.random() * 9999).toString().padStart(4, '0');
                const reference = nom.substring(0, 3) + prenom.substring(0, 2) + randomNum;
                document.getElementById('reference').value = reference;
            }
        }

        // Validation en temps réel
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value;
            if (email && !isValidEmail(email)) {
                this.classList.add('is-invalid');
                showInvalidFeedback(this, 'Veuillez saisir une adresse email valide');
            } else {
                this.classList.remove('is-invalid');
                hideInvalidFeedback(this);
            }
        });

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showInvalidFeedback(element, message) {
            let feedback = element.nextElementSibling;
            if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                element.parentNode.appendChild(feedback);
            }
            feedback.textContent = message;
        }

        function hideInvalidFeedback(element) {
            const feedback = element.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.remove();
            }
        }
    </script>
</body>
</html>
