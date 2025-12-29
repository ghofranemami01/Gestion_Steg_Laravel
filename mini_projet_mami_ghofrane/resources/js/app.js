import { createApp } from 'vue'
import './bootstrap'
import ListeAbonnes from './components/ListeAbonnes.vue'

// Configuration globale de l'application Vue
const app = createApp({
    components: {
        ListeAbonnes
    }
})

// Configuration globale des messages
app.config.globalProperties.$showAlert = function(message, type = 'info') {
    const alertClass = type === 'error' ? 'danger' : type;
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${alertClass} alert-dismissible fade show position-fixed`;
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
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Configuration du formatage des dates
app.config.globalProperties.$formatDate = function(dateString) {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('fr-FR');
}

// Configuration de l'API base URL
app.config.globalProperties.$apiBase = '/api/v1';

// Monter l'application sur l'élément #app
app.mount('#app')
