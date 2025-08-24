<?php
$page_title = 'Calendrier';
$page_description = 'Gérez vos événements et rendez-vous avec notre calendrier interactif';
$include_fullcalendar = true;
$include_calendar_js = true;
$main_class = 'calendar-page';
include __DIR__ . '/../components/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <div class="sidebar-content">
                <div class="quick-actions mb-4">
                    <h5><i class="fas fa-bolt me-2"></i>Actions rapides</h5>
                    <button class="btn btn-primary btn-sm w-100 mb-2" onclick="openEventModal()">
                        <i class="fas fa-plus me-2"></i>Nouvel événement
                    </button>
                    <button class="btn btn-success btn-sm w-100 mb-2" onclick="openTaskModal()">
                        <i class="fas fa-tasks me-2"></i>Nouvelle tâche
                    </button>
                </div>

                <div class="upcoming-events mb-4">
                    <h5><i class="fas fa-clock me-2"></i>Événements à venir</h5>
                    <div id="upcomingEventsList">
                        <div class="text-muted small">Chargement...</div>
                    </div>
                </div>

                <div class="quick-stats">
                    <h5><i class="fas fa-chart-bar me-2"></i>Statistiques</h5>
                    <div id="quickStats">
                        <div class="text-muted small">Chargement...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="calendar-container">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">
                    <i class="fas fa-calendar-plus me-2"></i>Nouvel événement
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="eventForm">
                <div class="modal-body">
                    <input type="hidden" id="eventId" name="id">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="eventTitle" class="form-label">Titre *</label>
                                <input type="text" class="form-control" id="eventTitle" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="eventColor" class="form-label">Couleur</label>
                                <input type="color" class="form-control form-control-color" id="eventColor" name="color" value="#3788d8">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventStartDate" class="form-label">Date de début *</label>
                                <input type="datetime-local" class="form-control" id="eventStartDate" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventEndDate" class="form-label">Date de fin *</label>
                                <input type="datetime-local" class="form-control" id="eventEndDate" name="end_date" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventLocation" class="form-label">Lieu</label>
                                <input type="text" class="form-control" id="eventLocation" name="location">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="eventReminder" class="form-label">Rappel</label>
                                <select class="form-select" id="eventReminder" name="reminder_minutes">
                                    <option value="0">Aucun</option>
                                    <option value="5">5 minutes avant</option>
                                    <option value="15">15 minutes avant</option>
                                    <option value="30">30 minutes avant</option>
                                    <option value="60">1 heure avant</option>
                                    <option value="1440">1 jour avant</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="eventAllDay" name="is_all_day">
                            <label class="form-check-label" for="eventAllDay">
                                Toute la journée
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="eventDescription" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">
                    <i class="fas fa-tasks me-2"></i>Nouvelle tâche
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="taskForm">
                <div class="modal-body">
                    <input type="hidden" id="taskId" name="id">
                    
                    <div class="mb-3">
                        <label for="taskTitle" class="form-label">Titre *</label>
                        <input type="text" class="form-control" id="taskTitle" name="title" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="taskDueDate" class="form-label">Date d'échéance</label>
                                <input type="datetime-local" class="form-control" id="taskDueDate" name="due_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="taskPriority" class="form-label">Priorité</label>
                                <select class="form-select" id="taskPriority" name="priority">
                                    <option value="low">Basse</option>
                                    <option value="medium" selected>Moyenne</option>
                                    <option value="high">Haute</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="taskDescription" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../components/footer.php'; ?> 