<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Personnel - Tableau de bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body class="dashboard-page" data-theme="light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-calendar-alt me-2"></i>
                Agenda Personnel
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-view="calendar">
                            <i class="fas fa-calendar me-1"></i>
                            Calendrier
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-view="stats">
                            <i class="fas fa-chart-bar me-1"></i>
                            Statistiques
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="themeDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-palette me-1"></i>
                            Thème
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-theme="light">
                                <i class="fas fa-sun me-2"></i>Clair
                            </a></li>
                            <li><a class="dropdown-item" href="#" data-theme="dark">
                                <i class="fas fa-moon me-2"></i>Sombre
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>
                            <span id="userName">Utilisateur</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <i class="fas fa-user-edit me-2"></i>Profil
                            </a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                <i class="fas fa-key me-2"></i>Changer mot de passe
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" id="logoutBtn">
                                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container-fluid mt-4">
        <!-- Messages d'alerte -->
        <div id="alert-container"></div>

        <!-- Vue Calendrier -->
        <div id="calendarView" class="view-content">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-plus me-2"></i>
                                Nouvel événement
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="eventForm">
                                <div class="mb-3">
                                    <label for="eventTitle" class="form-label">Titre</label>
                                    <input type="text" class="form-control" id="eventTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="eventDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="eventDescription" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="eventStart" class="form-label">Début</label>
                                        <input type="datetime-local" class="form-control" id="eventStart" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="eventEnd" class="form-label">Fin</label>
                                        <input type="datetime-local" class="form-control" id="eventEnd" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="eventColor" class="form-label">Couleur</label>
                                    <input type="color" class="form-control form-control-color" id="eventColor" value="#3788d8">
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="eventAllDay">
                                        <label class="form-check-label" for="eventAllDay">
                                            Toute la journée
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="eventReminder" class="form-label">Rappel (minutes)</label>
                                    <select class="form-select" id="eventReminder">
                                        <option value="0">Aucun</option>
                                        <option value="5">5 minutes</option>
                                        <option value="15" selected>15 minutes</option>
                                        <option value="30">30 minutes</option>
                                        <option value="60">1 heure</option>
                                        <option value="1440">1 jour</option>
                                    </select>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        Créer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Événements à venir -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clock me-2"></i>
                                À venir
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="upcomingEvents">
                                <div class="text-center text-muted">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    Chargement...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendrier principal -->
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar me-2"></i>
                                Mon Calendrier
                            </h5>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="todayBtn">Aujourd'hui</button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="prevBtn">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="nextBtn">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vue Statistiques -->
        <div id="statsView" class="view-content d-none">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-4">
                        <i class="fas fa-chart-bar me-2"></i>
                        Statistiques
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title" id="totalEvents">0</h4>
                                    <p class="card-text">Total événements</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title" id="completedEvents">0</h4>
                                    <p class="card-text">Terminés</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title" id="pendingEvents">0</h4>
                                    <p class="card-text">En attente</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title" id="overdueEvents">0</h4>
                                    <p class="card-text">En retard</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Événements en retard</h5>
                        </div>
                        <div class="card-body">
                            <div id="overdueEventsList">
                                <div class="text-center text-muted">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    Chargement...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Événement -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalTitle">Détails de l'événement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="eventEditForm">
                        <input type="hidden" id="editEventId">
                        <div class="mb-3">
                            <label for="editEventTitle" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="editEventTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEventDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editEventDescription" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="editEventStart" class="form-label">Début</label>
                                <input type="datetime-local" class="form-control" id="editEventStart" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="editEventEnd" class="form-label">Fin</label>
                                <input type="datetime-local" class="form-control" id="editEventEnd" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editEventColor" class="form-label">Couleur</label>
                            <input type="color" class="form-control form-control-color" id="editEventColor">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="editEventAllDay">
                                <label class="form-check-label" for="editEventAllDay">
                                    Toute la journée
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editEventReminder" class="form-label">Rappel (minutes)</label>
                            <select class="form-select" id="editEventReminder">
                                <option value="0">Aucun</option>
                                <option value="5">5 minutes</option>
                                <option value="15">15 minutes</option>
                                <option value="30">30 minutes</option>
                                <option value="60">1 heure</option>
                                <option value="1440">1 jour</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deleteEventBtn">
                        <i class="fas fa-trash me-2"></i>Supprimer
                    </button>
                    <button type="button" class="btn btn-success" id="completeEventBtn">
                        <i class="fas fa-check me-2"></i>Terminer
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="saveEventBtn">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Profil -->
    <div class="modal fade" id="profileModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mon Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="profileFirstName" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control" id="profileLastName" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="profileUsername" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="profileEmail" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rôle</label>
                        <input type="text" class="form-control" id="profileRole" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Changement de mot de passe -->
    <div class="modal fade" id="passwordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Changer le mot de passe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="passwordForm">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Mot de passe actuel</label>
                            <input type="password" class="form-control" id="currentPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="newPassword" required minlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPassword" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" id="confirmNewPassword" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="changePasswordBtn">
                        <i class="fas fa-key me-2"></i>Changer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="../../assets/js/dashboard.js"></script>
</body>
</html> 