<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Agenda Personnel</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Agenda personnel intelligent avec interface d\'administration'; ?>">
    <meta name="keywords" content="agenda, calendrier, événements, tâches, organisation, personnel">
    <meta name="author" content="Agenda Personnel">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- FullCalendar CSS -->
    <?php if (isset($include_fullcalendar) && $include_fullcalendar): ?>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <?php endif; ?>
    
    <!-- Chart.js CSS -->
    <?php if (isset($include_chartjs) && $include_chartjs): ?>
    <link href="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.min.css" rel="stylesheet">
    <?php endif; ?>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <!-- Page specific CSS -->
    <?php if (isset($page_css)): ?>
    <link rel="stylesheet" href="<?php echo $page_css; ?>">
    <?php endif; ?>
</head>
<body class="<?php echo isset($_SESSION['theme']) && $_SESSION['theme'] == 'dark' ? 'dark-theme' : 'light-theme'; ?>">

<?php if (isset($_SESSION['user_id'])): ?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ? '/admin/dashboard.php' : '/index.php'; ?>">
            <i class="fas fa-calendar-alt me-2"></i>Agenda Personnel
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                <!-- Admin Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="/admin/dashboard.php">
                        <i class="fas fa-tachometer-alt me-1"></i>Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/users.php">
                        <i class="fas fa-users me-1"></i>Utilisateurs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/logs.php">
                        <i class="fas fa-list-alt me-1"></i>Logs d'activité
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/export.php">
                        <i class="fas fa-download me-1"></i>Export
                    </a>
                </li>
                <?php else: ?>
                <!-- User Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">
                        <i class="fas fa-calendar me-1"></i>Calendrier
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/tasks.php">
                        <i class="fas fa-tasks me-1"></i>Tâches
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profile.php">
                        <i class="fas fa-user me-1"></i>Profil
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            
            <!-- Notifications -->
            <div class="navbar-nav me-3">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger notification-badge" id="notificationCount" style="display: none;">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" id="notificationsList">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><div class="dropdown-item text-muted">Chargement...</div></li>
                    </ul>
                </div>
            </div>
            
            <!-- User Menu -->
            <div class="navbar-nav">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header"><?php echo htmlspecialchars($_SESSION['username']); ?></h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="toggleTheme()">
                                <i class="fas fa-palette me-2"></i>
                                <span id="themeText"><?php echo isset($_SESSION['theme']) && $_SESSION['theme'] == 'dark' ? 'Mode clair' : 'Mode sombre'; ?></span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="/profile.php">
                                <i class="fas fa-user-cog me-2"></i>Paramètres
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Flash Messages -->
<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    <?php echo htmlspecialchars($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <?php echo htmlspecialchars($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['error']); endif; ?>

<?php if (isset($_SESSION['warning'])): ?>
<div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    <?php echo htmlspecialchars($_SESSION['warning']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['warning']); endif; ?>

<?php if (isset($_SESSION['info'])): ?>
<div class="alert alert-info alert-dismissible fade show m-3" role="alert">
    <i class="fas fa-info-circle me-2"></i>
    <?php echo htmlspecialchars($_SESSION['info']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['info']); endif; ?>

<?php endif; ?>

<main class="<?php echo isset($main_class) ? $main_class : ''; ?>"> 