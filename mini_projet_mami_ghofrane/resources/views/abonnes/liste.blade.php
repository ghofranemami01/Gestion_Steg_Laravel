<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion des Abonnés - STEG</title>

<!-- Bootstrap CSS -->
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

/* Navbar */
.navbar {
    background: linear-gradient(90deg,   var(--steg-purple) 50%, var(--steg-blue) 100%);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.navbar-brand { font-weight: bold; color: #fff !important; font-size: 1.3rem; }
.nav-link { color: #f8f9fa !important; font-weight: 500; }
.nav-link.active { color: white !important; }

/* Card */
.card { border-radius: 0.75rem; box-shadow: 0 8px 20px rgba(0,0,0,0.08); margin-top: 1rem; }
.card-header { background-color: #fff; border-bottom: none; font-size: 1.1rem; font-weight: 600; color: var(--dark-gray); }

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, var(--steg-blue) 0%, var(--steg-purple) 100%);
    border: none; color: #fff; font-weight: 600; border-radius: 0.5rem; transition: all 0.3s ease;
}
.btn-primary:hover { background: linear-gradient(135deg, #343a40 0%, #5a3a92 100%); color: #fff; }
.btn-secondary { background-color: #6c757d; border-radius: 0.5rem; color: #fff; }
.btn-secondary:hover { background-color: #5a6268; color: #fff; }

/* Table */
.table th { background-color: var(--light-gray); font-weight: 600; color: var(--dark-gray); }
.table tbody tr:hover { background-color: rgba(116, 106, 192, 0.1); }

/* Form Controls */
.form-control { border-radius: 0.5rem; border: 1px solid #ced4da; transition: all 0.3s ease; }
.form-control:focus { border-color: var(--steg-purple); box-shadow: 0 0 0 0.2rem rgba(116,106,192,0.25); }

/* Pagination */
.pagination .page-link { color: var(--steg-purple); border-radius: 0.5rem; transition: all 0.3s ease; }
.pagination .page-link:hover { background-color: var(--steg-blue); color: #fff; }
.pagination .active .page-link { background-color: var(--steg-purple); color: #fff; }

/* Spinner */
.spinner-border { width: 3rem; height: 3rem; border-width: 0.3em; }

/* Modal */
.modal-lg { max-width: 850px; border-radius: 1rem; }

/* Footer */
footer { background: var(--dark-gray); color: #fff; padding: 2rem 1rem; text-align: center; margin-top: 2rem; }
footer a { color: white; text-decoration: none; }
footer a:hover { text-decoration: underline; }

/* Responsive spacing */
.mt-1rem { margin-top: 1rem; }
.mb-1rem { margin-bottom: 1rem; }
.p-1rem { padding: 1rem; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-bolt me-2"></i>STEG - Gestion</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="/abonnes/liste"><i class="fas fa-list me-1"></i> Liste des Abonnés</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i> Administrateur
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/abonnes"><i class="fas fa-users me-2"></i> Gestion des Abonnés</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cogs me-2"></i> Paramètres</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<div id="app" class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Gestion des Abonnés STEG</h6>
                </div>

                <div class="mb-3"></div> <!-- espace -->

                <div class="card-body px-0 pt-0 pb-2">
                    <!-- Barre de recherche et filtres -->
                    <div class="row px-3 mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Rechercher par nom, prénom..." v-model="searchQuery" @input="searchAbonnes">
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" v-model="sortBy" @change="sortAbonnes">
                                <option value="nom">Trier par nom</option>
                                <option value="prenom">Trier par prénom</option>
                                <option value="date_abonnement">Trier par date d'abonnement</option>
                                <option value="reference">Trier par référence</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" v-model="sortDirection" @change="sortAbonnes">
                                <option value="asc">Croissant</option>
                                <option value="desc">Décroissant</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tableau abonnés -->
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Abonné</th>
                                    <th>CIN</th>
                                    <th class="text-center">Date Abonnement</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="abonne in abonnes" :key="abonne.id">
                                    <td>@{{ abonne.reference }}</td>
                                    <td>@{{ abonne.nom }} @{{ abonne.prenom }}<br>Élec: @{{ abonne.num_compteur_elec }} | Gaz: @{{ abonne.num_compteur_gaz }}</td>
                                    <td>@{{ abonne.num_cin }}</td>
                                    <td class="text-center">@{{ formatDate(abonne.date_abonnement) }}</td>
                                    <td>@{{ abonne.tel }}<br>@{{ abonne.email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3" v-if="pagination && pagination.last_page > 1">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                    <button class="page-link" @click="changePage(pagination.current_page - 1)"><i class="fas fa-chevron-left"></i></button>
                                </li>
                                <li v-for="page in pages" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
                                    <button class="page-link" @click="changePage(page)">@{{ page }}</button>
                                </li>
                                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                                    <button class="page-link" @click="changePage(pagination.current_page + 1)"><i class="fas fa-chevron-right"></i></button>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Messages -->
                    <div v-if="loading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"><span class="sr-only">Chargement...</span></div>
                    </div>
                    <div v-if="!loading && abonnes.length === 0" class="text-center py-5">
                        <p class="text-muted">Aucun abonné trouvé</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ajout / Modification -->
    <div class="modal fade" id="abonneModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@{{ editingAbonne ? 'Modifier Abonné' : 'Ajouter Abonné' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveAbonne">
                        <div class="row">
                            <div class="col-md-6"><input type="text" class="form-control mb-2" placeholder="Référence" v-model="formData.reference" required></div>
                            <div class="col-md-6"><input type="text" class="form-control mb-2" placeholder="Numéro CIN" v-model="formData.num_cin" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><input type="text" class="form-control mb-2" placeholder="Nom" v-model="formData.nom" required></div>
                            <div class="col-md-6"><input type="text" class="form-control mb-2" placeholder="Prénom" v-model="formData.prenom" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><input type="date" class="form-control mb-2" placeholder="Date abonnement" v-model="formData.date_abonnement" required></div>
                            <div class="col-md-6"><input type="tel" class="form-control mb-2" placeholder="Téléphone" v-model="formData.tel" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><input type="text" class="form-control mb-2" placeholder="Compteur Élec" v-model="formData.num_compteur_elec" required></div>
                            <div class="col-md-6"><input type="text" class="form-control mb-2" placeholder="Compteur Gaz" v-model="formData.num_compteur_gaz" required></div>
                        </div>
                        <input type="email" class="form-control mb-2" placeholder="Email" v-model="formData.email" required>
                        <textarea class="form-control mb-2" placeholder="Adresse" rows="3" v-model="formData.adresse" required></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" @click="saveAbonne">@{{ saving ? 'Enregistrement...' : (editingAbonne ? 'Modifier' : 'Ajouter') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2025 STEG Tunisie. Tous droits réservés.</p>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue;
const app = createApp({
    data() {
        return {
            abonnes: [], pagination: null, loading: false, saving: false,
            searchQuery: '', sortBy: 'nom', sortDirection: 'asc',
            editingAbonne: null,
            formData: { reference:'', num_cin:'', nom:'', prenom:'', date_abonnement:'', num_compteur_elec:'', num_compteur_gaz:'', adresse:'', tel:'', email:'' }
        }
    },
    computed: {
        pages() {
            if(!this.pagination) return [];
            const pages = [];
            const start = Math.max(1, this.pagination.current_page - 2);
            const end = Math.min(this.pagination.last_page, this.pagination.current_page + 2);
            for(let i=start;i<=end;i++) pages.push(i);
            return pages;
        }
    },
    mounted() { this.fetchAbonnes(); },
    methods: {
        async fetchAbonnes(page=1){
            this.loading = true;
            try {
                const params = new URLSearchParams({ page, sort_by:this.sortBy, sort_direction:this.sortDirection });
                if(this.searchQuery) params.append('search', this.searchQuery);
                const res = await fetch(`/api/v1/abonnes?${params}`);
                const data = await res.json();
                if(data.success){ this.abonnes = data.data; this.pagination = data.pagination; }
            } catch(e){ console.error(e); }
            finally{ this.loading=false; }
        },
        searchAbonnes(){ this.fetchAbonnes(1); },
        sortAbonnes(){ this.fetchAbonnes(1); },
        changePage(page){ this.fetchAbonnes(page); },
        formatDate(dateStr){ return dateStr ? new Date(dateStr).toLocaleDateString('fr-FR') : ''; },
        editAbonne(abonne){ this.editingAbonne = abonne; this.formData = { ...abonne }; new bootstrap.Modal(document.getElementById('abonneModal')).show(); },
        deleteAbonne(id){
            if(!confirm('Êtes-vous sûr de vouloir supprimer cet abonné ?')) return;
            fetch(`/api/v1/abonnes/${id}`, { method:'DELETE' }).then(res=>res.json()).then(data=>{ if(data.success)this.fetchAbonnes(); });
        },
        saveAbonne(){
            this.saving=true;
            const url = this.editingAbonne ? `/api/v1/abonnes/${this.editingAbonne.id}` : '/api/v1/abonnes';
            const method = this.editingAbonne ? 'PUT' : 'POST';
            fetch(url, { method, headers:{'Content-Type':'application/json'}, body:JSON.stringify(this.formData) })
                .then(res=>res.json()).then(data=>{
                    this.saving=false;
                    if(data.success){ this.fetchAbonnes(); new bootstrap.Modal(document.getElementById('abonneModal')).hide(); this.editingAbonne=null; }
                });
        }
    }
});
app.mount('#app');
</script>

</body>
</html>
