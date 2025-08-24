<?php
$page_title = 'Connexion';
$page_description = 'Connectez-vous à votre agenda personnel';
$main_class = 'login-page';
include __DIR__ . '/../components/header.php';
?>

<style>
* {
    margin: 0;
    padding: 0;
}
.login-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 40px;
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.login-container h1 {
    color: #333;
    margin-bottom: 30px;
    font-size: 2rem;
    font-weight: 600;
}

.login-form {
    text-align: left;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #555;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-login {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.btn-login:hover {
    transform: translateY(-2px);
}

.demo-credentials {
    margin-top: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.demo-credentials h4 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 14px;
}

.demo-credentials p {
    margin: 5px 0;
    font-size: 13px;
    color: #666;
}

.dark-theme .login-container {
    background: #2d3748;
    color: white;
}

.dark-theme .login-container h1 {
    color: white;
}

.dark-theme .form-group label {
    color: #e2e8f0;
}

.dark-theme .form-control {
    background: #4a5568;
    border-color: #718096;
    color: white;
}

.dark-theme .form-control:focus {
    border-color: #667eea;
}

.dark-theme .demo-credentials {
    background: #4a5568;
    color: #e2e8f0;
}
</style>

<div class="login-container">
    <h1><i class="fas fa-calendar-alt me-2"></i>Agenda Personnel</h1>
    
    <form class="login-form" method="POST" action="">
        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
        </button>
    </form>
    
    <div class="demo-credentials">
        <h4><i class="fas fa-info-circle me-2"></i>Compte de démonstration</h4>
        <p><strong>Utilisateur:</strong> admin</p>
        <p><strong>Mot de passe:</strong> admin123</p>
    </div>
</div>

<?php include __DIR__ . '/../components/footer.php'; ?> 