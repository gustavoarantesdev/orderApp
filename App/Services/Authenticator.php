<?php

namespace App\Services;

use App\Models\UserModel;

/**
 * Classe responável por gerenciar o login do usuário.
 *
 * Essa classe lida com o login, logout e verificação se o usuário está logado.
 */
abstract class Authenticator
{
    /**
     * Autentica o usuário utilizando o e-mail e senha informados.
     *
     * @param string $userEmail
     * @param string $userPassword
     * @return bool
     */
    public static function authenticate(string $userEmail, string $userPassword): bool
    {
        $userModel = new UserModel();

        // Armazena os dados do usuário encontrado.
        $userData = $userModel->getUserByEmail($userEmail);

        // Verifica se o usuário foi encontrado e compara a senha.
        if ($userData && password_verify($userPassword, $userData->user_password_hash)) {
            $_SESSION['user_id'] = $userData->user_id;
            return true;
        }

        return false;
    }

    /**
     * Verifica se o usuário está autenticado.
     *
     * @return bool
     */
    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Faz o Logout do usuário.
     *
     * @return void
     */
    public static function logout(): void
    {
        session_unset();
        session_destroy();

        header('Location:' . BASE_URL);
        exit;
    }
}
