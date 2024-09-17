<?php

namespace App\Core;

use App\Exceptions\NotFoundException;

/**
 * Classe responsável por renderiza as views da aplicação.
 */
abstract class View
{
    /**
     * Renderiza uma view com base no nome do arquivo fornecido.
     * Se dados forem passados, eles serão extraídos e disponibilizado na view.
     */
    public static function render(string $viewName, array $data = []): void
    {
        // Caminho base pasta App/.
        $baseDir = dirname(__DIR__, 1);

        // Caminho completo do arquivo da view.
        $viewFilePath = "{$baseDir}/Views/{$viewName}.php";

        // Lança exceção se o arquivo da view não for encontrado.
        if (!file_exists($viewFilePath)) {
            // throw new NotFoundException('<center><h1>404 - View file not found!</h1></center>');
        }

        // Inclui o header da aplicação.
        require "{$baseDir}/Views/partials/header.php";

        // Extrai os dados passados e os disponibiliza como variáveis na view.
        extract($data);

        // Inclui a view solicitada.
        require $viewFilePath;

        // Inclui o footer da aplicação.
        require "{$baseDir}/Views/partials/footer.php";
    }
}