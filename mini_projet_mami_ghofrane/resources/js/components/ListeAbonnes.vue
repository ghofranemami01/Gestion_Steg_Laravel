<template>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="fas fa-users me-2"></i>
                                Liste des Abonnés STEG
                            </h6>
                            <button @click="showAddModal = true" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>
                                Ajouter Abonné
                            </button>
                        </div>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <!-- Barre de recherche et filtres -->
                        <div class="row px-4 mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Rechercher par nom, prénom, référence ou CIN..."
                                        v-model="searchQuery"
                                        @input="searchAbonnes"
                                    >
                                </div>
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

                        <!-- Tableau des abonnés -->
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Référence
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Abonné
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            CIN
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date Abonnement
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Contact
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="abonne in abonnes" :key="abonne.id">
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ abonne.reference }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <p class="text-xs font-weight-bold mb-0">{{ abonne.nom }} {{ abonne.prenom }}</p>
                                                <p class="text-xs text-secondary mb-0">
                                                    Élec: {{ abonne.num_compteur_elec }} | Gaz: {{ abonne.num_compteur_gaz }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ abonne.num_cin }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ formatDate(abonne.date_abonnement) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <p class="text-xs font-weight-bold mb-0">{{ abonne.tel }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ abonne.email }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <button
                                                    @click="editAbonne(abonne)"
                                                    class="btn btn-sm btn-info me-1"
                                                    title="Modifier"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button
                                                    @click="deleteAbonne(abonne.id)"
                                                    class="btn btn-sm btn-danger"
                                                    title="Supprimer"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3" v-if="pagination && pagination.last_page > 1">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                        <button class="page-link" @click="changePage(pagination.current_page - 1)">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                    </li>
                                    <li
                                        v-for="page in pages"
                                        :key="page"
                                        class="page-item"
                                        :class="{ active: page === pagination.current_page }"
                                    >
                                        <button class="page-link" @click="changePage(page)">{{ page }}</button>
                                    </li>
                                    <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                                        <button class="page-link" @click="changePage(pagination.current_page + 1)">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <!-- Message si aucun résultat -->
                        <div v-if="loading === false && abonnes.length === 0" class="text-center py-5">
                            <p class="text-muted">Aucun abonné trouvé</p>
                        </div>

                        <!-- Loading -->
                        <div v-if="loading" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Chargement...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal d'ajout/modification -->
        <div class="modal fade" id="abonneModal" tabindex="-1" aria-labelledby="abonneModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="abonneModalLabel">
                            {{ editingAbonne ? 'Modifier Abonné' : 'Ajouter Abonné' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="saveAbonne">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reference" class="form-control-label">Référence *</label>
                                        <input
                                            id="reference"
                                            type="text"
                                            class="form-control"
                                            v-model="formData.reference"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="num_cin" class="form-control-label">Numéro CIN *</label>
                                        <input
                                            id="num_cin"
                                            type="text"
                                            class="form-control"
                                            v-model="formData.num_cin"
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nom" class="form-control-label">Nom *</label>
                                        <input
                                            id="nom"
                                            type="text"
                                            class="form-control"
                                            v-model="formData.nom"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prenom" class="form-control-label">Prénom *</label>
                                        <input
                                            id="prenom"
                                            type="text"
                                            class="form-control"
                                            v-model="formData.prenom"
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_abonnement" class="form-control-label">Date d'abonnement *</label>
                                        <input
                                            id="date_abonnement"
                                            type="date"
                                            class="form-control"
                                            v-model="formData.date_abonnement"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tel" class="form-control-label">Téléphone *</label>
                                        <input
                                            id="tel"
                                            type="tel"
                                            class="form-control"
                                            v-model="formData.tel"
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="num_compteur_elec" class="form-control-label">Numéro Compteur Électricité *</label>
                                        <input
                                            id="num_compteur_elec"
                                            type="text"
                                            class="form-control"
                                            v-model="formData.num_compteur_elec"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="num_compteur_gaz" class="form-control-label">Numéro Compteur Gaz *</label>
                                        <input
                                            id="num_compteur_gaz"
                                            type="text"
                                            class="form-control"
                                            v-model="formData.num_compteur_gaz"
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-control-label">Email *</label>
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control"
                                    v-model="formData.email"
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label for="adresse" class="form-control-label">Adresse *</label>
                                <textarea
                                    id="adresse"
                                    class="form-control"
                                    rows="3"
                                    v-model="formData.adresse"
                                    required
                                ></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="saveAbonne"
                            :disabled="saving"
                        >
                            {{ saving ? 'Enregistrement...' : (editingAbonne ? 'Modifier' : 'Ajouter') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ListeAbonnes',
    data() {
        return {
            abonnes: [],
            pagination: null,
            loading: false,
            saving: false,
            searchQuery: '',
            sortBy: 'nom',
            sortDirection: 'asc',
            editingAbonne: null,
            showAddModal: false,
            formData: {
                reference: '',
                num_cin: '',
                nom: '',
                prenom: '',
                date_abonnement: '',
                num_compteur_elec: '',
                num_compteur_gaz: '',
                adresse: '',
                tel: '',
                email: ''
            }
        }
    },
    computed: {
        pages() {
            if (!this.pagination) return [];
            const pages = [];
            const start = Math.max(1, this.pagination.current_page - 2);
            const end = Math.min(this.pagination.last_page, this.pagination.current_page + 2);

            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        }
    },
    mounted() {
        this.fetchAbonnes();
    },
    methods: {
        async fetchAbonnes(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    sort_by: this.sortBy,
                    sort_direction: this.sortDirection
                });

                if (this.searchQuery) {
                    params.append('search', this.searchQuery);
                }

                const response = await fetch(`/api/v1/abonnes?${params}`);
                const data = await response.json();

                if (data.success) {
                    this.abonnes = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Erreur lors du chargement des abonnés:', error);
                this.showAlert('Erreur lors du chargement des abonnés', 'error');
            } finally {
                this.loading = false;
            }
        },
        async searchAbonnes() {
            await this.fetchAbonnes(1);
        },
        async sortAbonnes() {
            await this.fetchAbonnes(1);
        },
        async changePage(page) {
            await this.fetchAbonnes(page);
        },
        formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('fr-FR');
        },
        editAbonne(abonne) {
            this.editingAbonne = abonne;
            this.formData = { ...abonne };
            const modal = new bootstrap.Modal(document.getElementById('abonneModal'));
            modal.show();
        },
        async deleteAbonne(id) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet abonné ?')) {
                return;
            }

            try {
                const response = await fetch(`/api/v1/abonnes/${id}`, {
                    method: 'DELETE'
                });
                const data = await response.json();

                if (data.success) {
                    this.showAlert('Abonné supprimé avec succès', 'success');
                    this.fetchAbonnes();
                } else {
                    this.showAlert(data.message || 'Erreur lors de la suppression', 'error');
                }
            } catch (error) {
                console.error('Erreur lors de la suppression:', error);
                this.showAlert('Erreur lors de la suppression', 'error');
            }
        },
        async saveAbonne() {
            this.saving = true;
            try {
                const url = this.editingAbonne
                    ? `/api/v1/abonnes/${this.editingAbonne.id}`
                    : '/api/v1/abonnes';

                const method = this.editingAbonne ? 'PUT' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.formData)
                });

                const data = await response.json();

                if (data.success) {
                    this.showAlert(
                        this.editingAbonne ? 'Abonné modifié avec succès' : 'Abonné créé avec succès',
                        'success'
                    );
                    this.resetForm();
                    this.fetchAbonnes();
                    const modal = bootstrap.Modal.getInstance(document.getElementById('abonneModal'));
                    modal.hide();
                } else {
                    this.showAlert(data.message || 'Erreur lors de la sauvegarde', 'error');
                }
            } catch (error) {
                console.error('Erreur lors de la sauvegarde:', error);
                this.showAlert('Erreur lors de la sauvegarde', 'error');
            } finally {
                this.saving = false;
            }
        },
        resetForm() {
            this.formData = {
                reference: '',
                num_cin: '',
                nom: '',
                prenom: '',
                date_abonnement: '',
                num_compteur_elec: '',
                num_compteur_gaz: '',
                adresse: '',
                tel: '',
                email: ''
            };
            this.editingAbonne = null;
        },
        showAddModal() {
            this.resetForm();
            const modal = new bootstrap.Modal(document.getElementById('abonneModal'));
            modal.show();
        },
        showAlert(message, type = 'info') {
            // Créer une alerte Bootstrap
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(alertDiv);

            // Supprimer automatiquement après 5 secondes
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    }
}
</script>

<style scoped>
.card {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

.text-xs {
    font-size: 0.75rem;
}

.pagination .page-link {
    padding: 0.375rem 0.75rem;
}

.modal-lg {
    max-width: 800px;
}

.form-control {
    border-radius: 0.5rem;
    border: 1px solid #e0e6ed;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #5a6fd8 0%, #6a4190 100%);
}
</style>
