<?php
declare(strict_types=1);

final class AuthController extends Controller
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_validate($_POST['csrf'] ?? null)) {
                flash_set('danger', 'Session expirée. Réessayez.');
                redirect(base_url('index.php?c=auth&a=login'));
            }

            $email = trim((string)($_POST['email'] ?? ''));
            $password = (string)($_POST['password'] ?? '');

            $user = $email !== '' ? User::findByEmail($email) : null;
            if (!$user || !User::verifyPassword($user, $password)) {
                flash_set('danger', 'Email ou mot de passe incorrect.');
                redirect(base_url('index.php?c=auth&a=login'));
            }

            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'name' => (string)$user['name'],
                'email' => (string)$user['email'],
                'role' => (string)$user['role'],
            ];
            flash_set('success', 'Bienvenue, ' . (string)$user['name'] . ' !');
            redirect(base_url('index.php'));
        }

        $title = 'Login • E-Kata';
        $this->view('auth/login', compact('title'));
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_validate($_POST['csrf'] ?? null)) {
                flash_set('danger', 'Session expirée. Réessayez.');
                redirect(base_url('index.php?c=auth&a=register'));
            }

            $name = trim((string)($_POST['name'] ?? ''));
            $email = trim((string)($_POST['email'] ?? ''));
            $phone = trim((string)($_POST['phone'] ?? ''));
            $password = (string)($_POST['password'] ?? '');

            if ($name === '' || $email === '' || $password === '') {
                flash_set('warning', 'Veuillez remplir les champs obligatoires.');
                redirect(base_url('index.php?c=auth&a=register'));
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                flash_set('warning', 'Email invalide.');
                redirect(base_url('index.php?c=auth&a=register'));
            }
            if (strlen($password) < 8) {
                flash_set('warning', 'Le mot de passe doit contenir au moins 8 caractères.');
                redirect(base_url('index.php?c=auth&a=register'));
            }
            if (User::findByEmail($email)) {
                flash_set('danger', 'Cet email est déjà utilisé.');
                redirect(base_url('index.php?c=auth&a=register'));
            }

            $id = User::create($name, $email, $phone, $password);
            $_SESSION['user'] = ['id' => $id, 'name' => $name, 'email' => $email, 'role' => 'customer'];
            flash_set('success', 'Compte créé. Bienvenue sur E-Kata !');
            redirect(base_url('index.php'));
        }

        $title = 'Inscription • E-Kata';
        $this->view('auth/register', compact('title'));
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        flash_set('success', 'Vous êtes déconnecté.');
        redirect(base_url('index.php'));
    }
}

