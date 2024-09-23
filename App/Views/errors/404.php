<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Página não econtrada!</title>
</head>
<body class="bg-body-tertiary">
    <main class="d-flex justify-content-center align-items-center vh-100">
        <section class="card rounded-5 shadow p-5 text-center">
            <h1 class="display-1"><b>404</b></h1>
            <h3>Oops! Página não encontrada</h3>

            <!-- Botão retornar -->
            <div class="mt-3">
                <button class="btn bg-body-secondary p-3 lh-1 rounded-5" type="button" style="width: 60px; height: 60px;" onclick="window.location='<?= BASE_URL ?>'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                    </svg>
                </button>
            </div>
        </section>
    </main>
</body>
</html>