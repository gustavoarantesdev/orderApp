<?php

use App\Helpers\FlashMessage;

FlashMessage::render()

?>

<main class="d-flex align-items-center justify-content-center" style="margin-bottom: 7rem;">
    <section class="container col-md-8 col-lg-8">
        <!-- Título -->
        <h1 class="text-center" style="font-size: 1.8rem; margin-top: 1.5rem; margin-bottom: 3.5rem;">
            Editar Dados
        </h1>
        <div class="bg-body mt-5 rounded-5 p-3 shadow border col-md-8 mx-auto">
            <!-- Icone -->
            <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                <div class="bg-warning-subtle d-flex justify-content-center align-items-center shadow"
                    style="width: 4rem; height: 4rem; border-radius: 100%;">
                    <i class="bi bi-person-fill-gear text-warning-emphasis" style="font-size: 1.8rem;"></i>
                </div>
            </div>

            <form action="<?= BASE_URL . '/usuario/update' ?>" method="POST" class="mt-3 needs-validation" novalidate>
                <input type="hidden" name="id" value="<?= htmlspecialchars($viewData->id) ?>">

                <div class="row g-3 mb-3">
                    <!-- Nome -->
                    <div class="col">
                        <label class="form-label">
                            Nome
                        </label>
                        <div class="input-group">
                            <input type="text" name="name" id="inputName" class="form-control rounded-4 p-3"
                                minlength="3" value="<?= htmlspecialchars($viewData->name) ?>" autocomplete="off"
                                disabled required>
                            <div class="invalid-feedback">
                                Informe seu nome de usuário!
                            </div>

                            <!-- Botão para habilitar a edição -->
                            <button type="button" data-toggle-input="inputName"  class="btn bg-primary-subtle rounded-4 p-3 ms-3"
                                style="width: 65px;" title="Habilitar campo para edição">
                                <i class="bi bi-eye" style="font-size: 1.3em;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- E-mail -->
                    <div class="col">
                        <label class="form-label">
                            E-mail
                        </label>
                        <div class="input-group">
                            <input type="email" name="email" id="inputEmail" class="form-control rounded-4 p-3"
                                value="<?= htmlspecialchars($viewData->email) ?>" autocomplete="off" disabled
                                required>
                            <div class="invalid-feedback">
                                Informe seu e-mail!
                            </div>

                            <!-- Botão para habilitar a edição -->
                            <button type="button" data-toggle-input="inputEmail" class="btn bg-primary-subtle rounded-4 p-3 ms-3"
                                style="width: 65px;" title="Habilitar campo para edição">
                                <i class="bi bi-eye" style="font-size: 1.3em;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Senha -->
                    <div class="col">
                        <label class="form-label">
                            Nova Senha
                        </label>
                        <div class="input-group">
                            <input type="password" name="password" id="inputPassword" class="form-control rounded-4 p-3"
                                minlength="5" disabled required>
                            <div class="invalid-feedback">
                                Informe sua senha. A senha deve ter no mínimo 5 caracteres!
                            </div>

                            <!-- Botão para habilitar a edição -->
                            <button type="button" data-toggle-input="inputPassword" class="btn bg-primary-subtle rounded-4 p-3 ms-3"
                                style="width: 65px;" title="Habilitar campo para edição">
                                <i class="bi bi-eye" style="font-size: 1.3em;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="row">
                    <div class="col d-flex align-items-center justify-content-center">
                        <!-- Retornar -->
                        <div class="text-center mt-3">
                            <button
                                class="btn bg-body-secondary rounded-5 d-flex align-items-center justify-content-center"
                                type="button" style="width: 9rem;"
                                onclick="window.location='<?= BASE_URL . '/encomenda/home' ?>'">
                                <p class="m-0"><b>Retornar</b></p>
                                <i class="bi bi-arrow-left ms-3" style="font-size: 1.5rem;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col d-flex align-items-center justify-content-center">
                        <!-- Excluir -->
                        <div class="text-center mt-3">
                            <button id="deleteButton"
                                class="btn bg-danger-subtle text-danger-emphasis rounded-5 d-flex align-items-center justify-content-center"
                                type="button" style="width: 9rem;">
                                <p class="m-0"><b>Excluir</b></p>
                                <i class="bi bi-trash ms-2" style="font-size: 1.5rem;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col d-flex align-items-center justify-content-center">
                        <!-- Salvar -->
                        <div class="text-center mt-3">
                            <button
                                class="btn bg-warning-subtle text-warning-emphasis rounded-5 d-flex align-items-center justify-content-center"
                                type="submit" style="width: 9rem;">
                                <p class="m-0"><b>Salvar</b></p>
                                <i class="bi bi-check-lg ms-2" style="font-size: 1.5rem;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    // Exibe um alerta para o usuário confirmar antes de excluir
    $('#deleteButton').on('click', function () {
        if (confirm("Tem certeza de que deseja excluir?")) {
            window.location.href = '<?= BASE_URL . "/usuario/deletar/$viewData->id" ?>';
        }
    });
</script>

<script src="<?= BASE_URL . '/public/js/checkEmptyForm.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/user/toggleInput.js' ?>"></script>