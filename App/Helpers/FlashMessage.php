<?php

namespace App\Helpers;

/**
 * Classe responsável por gerenciar as flash messages da aplicação.
 * 
 * Flash messages são notificações temporárias que desaparecem após serem exibidas.
 * Esta classe permite definir, recuperar e renderizar mensagens de diferentes
 * tipos como sucesso, aviso, erro e informação.
 */
class FlashMessage
{
    /**
     * Define uma flash message.
     *
     * Armazena uma mensagem temporária associada a uma chave (tipo), que
     * será exibida para o usuário na próxima requisição.
     *
     * @param string $key O tipo da mensagem (ex: success, error, etc).
     * @param string $message O conteúdo da mensagem a ser exibida.
     * @return void
     */
    public static function set(string $key, string $message): void
    {
        $_SESSION[$key] = $message;
    }

    /**
     * Retorna e remove a flash message definida.
     *
     * Recupera a mensagem temporária associada a uma chave e remove da sessão
     * para que seja exibida novamente.
     *
     * @param string $key O tipo da mensagem.
     * @return mixed Retorna string se a mensagem for encontrada, ou null se não
     * houver.
     */
    public static function get(string $key): mixed
    {
        if (isset($_SESSION[$key])) {
            $message = $_SESSION[$key];
            unset($_SESSION[$key]); // Remove a mensagem após ser lida
            return $message;
        }
        return null;
    }

    /**
     * Renderiza as flash message.
     *
     * Verifica se há mensagens definidas para cada tipo e, se houver, carrega
     * o template correspondente para exibi-las.
     *
     * @return void
     */
    public static function render(): void
    {
        $flashTypes = [
            FLASH_SUCCESS => 'success.php',
            FLASH_INFO    => 'info.php',
            FLASH_WARNING => 'warning.php',
            FLASH_ERROR   => 'danger.php'
        ];

        // Percorre o array verificando se está definida a flash message.
        foreach ($flashTypes as $type => $template) {
            if ($message = self::get($type)) {
                require __DIR__ . '/../Views/flashMessages/' . $template;
            }
        }
    }
}
