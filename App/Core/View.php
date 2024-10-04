<?php

namespace App\Core;

use App\Exceptions\ViewException;

/**
 * Classe responsável por renderiza as views da aplicação.
 */
abstract class View
{
    /**
     * Renderiza uma view com base no nome do arquivo fornecido.
     *
     * @param string $viewName Nome da view.
     * @param [type] $data Dados para a view.
     * @return void
     */
    public static function render(string $viewName, $data = null): void
    {
        // Caminho base pasta App/.
        $baseDir = dirname(__DIR__, 1);

        // Caminho completo do arquivo da view.
        $viewFilePath = "{$baseDir}/Views/{$viewName}.php";

        try {
            // Lança exceção se o arquivo da view não for encontrado.
            if (!file_exists($viewFilePath)) {
                throw ViewException::ViewNotFound($viewName);
            }

            // Inclui o header da aplicação.
            require "{$baseDir}/Views/partials/header.php";

            // Inclui a view solicitada.
            require $viewFilePath;

            // Inclui o footer da aplicação.
            require "{$baseDir}/Views/partials/footer.php";
        } catch (ViewException $e) {
            http_response_code($e->getCode());
            require __DIR__ . '/../Views/errors/404.php';
        }
    }
}
