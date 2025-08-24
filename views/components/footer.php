</main>

<?php if (isset($_SESSION['user_id'])): ?>
<footer class="footer mt-auto py-3 bg-light border-top">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <small class="text-muted">
                    <i class="fas fa-code me-1"></i>
                    Agenda Personnel v1.0.0
                </small>
            </div>
            <div class="col-md-6 text-end">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    <span id="currentDateTime"></span>
                </small>
            </div>
        </div>
    </div>
</footer>
<?php endif; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- FullCalendar JS -->
<?php if (isset($include_fullcalendar) && $include_fullcalendar): ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/fr.global.min.js"></script>
<?php endif; ?>

<!-- Chart.js -->
<?php if (isset($include_chartjs) && $include_chartjs): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.min.js"></script>
<?php endif; ?>

<!-- Custom JS -->
<script src="/assets/js/app.js"></script>

<!-- Calendar JS -->
<?php if (isset($include_calendar_js) && $include_calendar_js): ?>
<script src="/assets/js/calendar.js"></script>
<?php endif; ?>

<!-- Page specific JS -->
<?php if (isset($page_js)): ?>
<script src="<?php echo $page_js; ?>"></script>
<?php endif; ?>

<script>
// Fonction pour changer le thème
function toggleTheme() {
    const currentTheme = document.body.classList.contains('dark-theme') ? 'dark' : 'light';
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    fetch('/api/auth.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=changeTheme&theme=' + newTheme
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.body.classList.toggle('dark-theme');
            document.body.classList.toggle('light-theme');
            
            const themeText = document.getElementById('themeText');
            if (themeText) {
                themeText.textContent = newTheme === 'dark' ? 'Mode clair' : 'Mode sombre';
            }
            
            // Sauvegarder dans localStorage
            localStorage.setItem('theme', newTheme);
            
            showNotification('Thème changé avec succès', 'success');
        } else {
            showNotification('Erreur lors du changement de thème', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors du changement de thème', 'error');
    });
}

// Fonction pour afficher les notifications
function showNotification(message, type = 'info') {
    const alertClass = type === 'error' ? 'alert-danger' : 
                      type === 'success' ? 'alert-success' : 
                      type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const icon = type === 'error' ? 'exclamation-triangle' : 
                 type === 'success' ? 'check-circle' : 
                 type === 'warning' ? 'exclamation-circle' : 'info-circle';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="fas fa-${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insérer au début du main
    const main = document.querySelector('main');
    if (main) {
        main.insertAdjacentHTML('afterbegin', alertHtml);
    }
    
    // Auto-dismiss après 5 secondes
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
}

// Fonction pour charger les notifications
function loadNotifications() {
    fetch('/api/notifications.php?action=get')
    .then(response => response.json())
    .then(data => {
        const notificationsList = document.getElementById('notificationsList');
        const notificationCount = document.getElementById('notificationCount');
        
        if (notificationsList && data.notifications) {
            notificationsList.innerHTML = '';
            
            if (data.notifications.length === 0) {
                notificationsList.innerHTML = '<li><div class="dropdown-item text-muted">Aucune notification</div></li>';
            } else {
                data.notifications.forEach(notification => {
                    const item = document.createElement('li');
                    item.innerHTML = `
                        <a class="dropdown-item ${notification.is_read ? '' : 'fw-bold'}" href="#" onclick="markNotificationAsRead(${notification.id})">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-${notification.type === 'event' ? 'calendar' : 'tasks'} me-2 text-primary"></i>
                                <div>
                                    <div class="small">${notification.title}</div>
                                    <div class="text-muted small">${notification.created_at}</div>
                                </div>
                            </div>
                        </a>
                    `;
                    notificationsList.appendChild(item);
                });
            }
        }
        
        if (notificationCount && data.unread_count > 0) {
            notificationCount.textContent = data.unread_count;
            notificationCount.style.display = 'inline';
        } else if (notificationCount) {
            notificationCount.style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Erreur lors du chargement des notifications:', error);
    });
}

// Fonction pour marquer une notification comme lue
function markNotificationAsRead(id) {
    fetch('/api/notifications.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=markRead&id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications();
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}

// Fonction pour formater la date
function formatDate(date) {
    return new Intl.DateTimeFormat('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }).format(new Date(date));
}

// Fonction de confirmation
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Fonction de validation de formulaire
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

// Fonction pour basculer la visibilité du mot de passe
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.querySelector(`[onclick="togglePasswordVisibility('${inputId}')"] i`);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Fonction de debounce
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Fonction de throttle
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Lazy loading pour les images
function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Mettre à jour la date et l'heure
    function updateDateTime() {
        const now = new Date();
        const dateTimeElement = document.getElementById('currentDateTime');
        if (dateTimeElement) {
            dateTimeElement.textContent = now.toLocaleString('fr-FR');
        }
    }
    
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Charger les notifications si l'utilisateur est connecté
    if (document.querySelector('.navbar')) {
        loadNotifications();
        // Recharger les notifications toutes les 30 secondes
        setInterval(loadNotifications, 30000);
    }
    
    // Initialiser le lazy loading
    lazyLoadImages();
    
    // Gestionnaire pour les formulaires
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                showNotification('Veuillez remplir tous les champs requis', 'warning');
            }
        });
    });
    
    // Gestionnaire pour les liens de suppression
    document.querySelectorAll('[data-confirm]').forEach(element => {
        element.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm');
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
    
    // Auto-dismiss des alertes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});

// Gestionnaire d'erreurs global
window.addEventListener('error', function(e) {
    console.error('Erreur JavaScript:', e.error);
    showNotification('Une erreur est survenue', 'error');
});

// Gestionnaire pour les requêtes AJAX échouées
window.addEventListener('unhandledrejection', function(e) {
    console.error('Promesse rejetée:', e.reason);
    showNotification('Erreur de communication avec le serveur', 'error');
});
</script>

<?php if (isset($include_analytics) && $include_analytics): ?>
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'GA_MEASUREMENT_ID');
</script>
<?php endif; ?>

</body>
</html> 