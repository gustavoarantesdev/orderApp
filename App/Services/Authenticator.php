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
     * @param string $email E-mail do usuário.
     * @param string $password Senha do usuário.
     * @return bool
     */
    public static function authenticate(string $email, string $password): bool
    {
        $userModel = new UserModel();

        // Armazena os dados do usuário encontrado.
        $userData = $userModel->getUserByEmail($email);

        // Verifica se o usuário foi encontrado e compara a senha.
        if ($userData && password_verify($password, $userData->password_hash)) {
            $_SESSION['user_id'] = $userData->id;
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
