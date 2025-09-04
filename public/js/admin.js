// Fonctionnalités JavaScript pour l'admin
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du mode sombre
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        });
    }

    // Initialisation du mode sombre depuis localStorage
    if (localStorage.getItem('darkMode') === 'true') {
        document.documentElement.classList.add('dark');
    }

    // Gestion du sidebar mobile
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });
    }

    // Gestion du menu utilisateur
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function() {
            userMenu.classList.toggle('hidden');
        });
    }

    // Fermer les menus quand on clique ailleurs
    document.addEventListener('click', function(event) {
        if (!event.target.closest('#user-menu-button')) {
            const userMenu = document.getElementById('user-menu');
            if (userMenu && !userMenu.classList.contains('hidden')) {
                userMenu.classList.add('hidden');
            }
        }
    });

    // Gestion des formulaires avec confirmation
    const deleteForms = document.querySelectorAll('form[data-confirm]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const message = this.getAttribute('data-confirm');
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Gestion des compteurs de caractères
    const textareas = document.querySelectorAll('textarea[data-max-length]');
    textareas.forEach(textarea => {
        const maxLength = parseInt(textarea.getAttribute('data-max-length'));
        const counter = document.getElementById(textarea.id + '-count');
        
        if (counter) {
            function updateCounter() {
                const remaining = maxLength - textarea.value.length;
                counter.textContent = remaining;
                counter.className = remaining < 0 ? 'text-red-500' : 'text-gray-500';
            }
            
            textarea.addEventListener('input', updateCounter);
            updateCounter();
        }
    });

    // Gestion des notifications
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    });

    // Gestion des tooltips
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute z-50 px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg';
            tooltip.textContent = this.getAttribute('data-tooltip');
            tooltip.style.left = this.offsetLeft + 'px';
            tooltip.style.top = (this.offsetTop - 30) + 'px';
            document.body.appendChild(tooltip);
            
            this.addEventListener('mouseleave', function() {
                tooltip.remove();
            });
        });
    });
});

// Fonctions utilitaires
window.adminUtils = {
    // Confirmation de suppression
    confirmDelete: function(message = 'Êtes-vous sûr de vouloir supprimer cet élément ?') {
        return confirm(message);
    },

    // Affichage de notification
    showNotification: function(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-lg shadow-lg notification ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    },

    // Formatage de date
    formatDate: function(date) {
        return new Date(date).toLocaleDateString('fr-FR');
    },

    // Formatage de nombre
    formatNumber: function(number) {
        return new Intl.NumberFormat('fr-FR').format(number);
    }
};
