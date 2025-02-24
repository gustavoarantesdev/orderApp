<?php

use App\Helpers\FlashMessage;

FlashMessage::render()

?>

<main class="d-flex align-items-center justify-content-center" style="margin-bottom: 7rem;">
    <section class="container">
        <!-- Título -->
        <h1 class="text-center" style="font-size: 1.8rem; margin-top: 1.5rem; margin-bottom: 3.5rem;">
            Editar Produto
        </h1>
        <div class="bg-body mt-5 rounded-5 p-3 shadow border col-md-8 mx-auto">
            <!-- Icone -->
            <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                <div class="bg-warning-subtle d-flex justify-content-center align-items-center shadow"
                    style="width: 4rem; height: 4rem; border-radius: 100%;">
                    <i class="bi bi-cake-fill text-warning-emphasis" style="font-size: 1.8rem;"></i>
                </div>
            </div>

            <form action="<?= BASE_URL . '/produto/update' ?>" method="POST" class="mt-3 needs-validation" novalidate>
                <input type="hidden" name="id" value="<?= htmlspecialchars($viewData->id) ?>">

                <div class="row g-3 mb-3">
                    <!-- Nome -->
                    <div class="col">
                        <label class="form-label">
                            Nome <b class="text-danger">*</b>
                        </label>
                        <input type="text" name="name" class="form-control rounded-4 p-3 to-uppercase" minlength="10"
                            value="<?= htmlspecialchars($viewData->name) ?>" required autocomplete="off">
                        <div class="invalid-feedback">
                            Informe o nome do produto.
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Preço de venda -->
                    <div class="col">
                        <label class="form-label">
                            Preço de venda <span class="text-danger"><b>*</b></span>
                        </label>
                        <input type="text" name="sell_price" class="money form-control rounded-4 p-3"
                            inputmode="numeric" value="<?= htmlspecialchars($viewData->sell_price) ?>" required>
                        <div class="invalid-feedback">
                            Informe o preço de venda.
                        </div>
                    </div>

                    <!-- Preço de custo -->
                    <div class="col">
                        <label class="form-label">
                            Preço de custo <span class="text-danger"><b>*</bn></span>
                        </label>
                        <input type="text" name="cost_price" class="money form-control rounded-4 p-3"
                            inputmode="numeric" value="<?= htmlspecialchars($viewData->cost_price) ?>" required>
                        <div class="invalid-feedback">
                            Informe o preço de custo.
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Status -->
                    <div class="col">
                        <label class="form-label">
                            Status <b class="text-danger">*</b>
                        </label>
                        <select name="status" class="form-select rounded-4 p-3" required>
                            <option value="1"
                                <?= htmlspecialchars($viewData->status) == true ? 'selected' : '' ?>>
                                Ativo
                            </option>
                            <option value="0"
                                <?= htmlspecialchars($viewData->status) == false ? 'selected' : '' ?>>
                                Desativo
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione o status.
                        </div>
                    </div>
                </div>

                <!-- Observação -->
                <div class="mb-3">
                    <label class="form-label">
                        Observação
                    </label>
                    <textarea type="text" name="description" rows="3"
                        class="form-control rounded-4 p-3"><?= $viewData->description != null ? htmlspecialchars($viewData->description) : '' ?>
                    </textarea>
                </div>

                <!-- Botões -->
                <div class="row">
                    <div class="col d-flex align-items-center justify-content-center">
                        <!-- Retornar -->
                        <div class="text-center mt-3">
                            <button
                                class="btn bg-body-secondary rounded-5 d-flex align-items-center justify-content-center"
                                type="button" style="width: 9rem;"
                                onclick="window.location='<?= BASE_URL . '/produto/todos' ?>'">
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
                    <div class="text-body-tertiary text-center mt-3">
                        <?= "Códito: {$viewData->id} - Cadastrado em: {$viewData->created_at}" ?>
                    </div>
            </form>
        </div>
    </section>
</main>

<script>
    // Exibe um alerta para o usuário confirmar antes de excluir
    $('#deleteButton').on('click', function () {
        if (confirm("Tem certeza de que deseja excluir?")) {
            window.location.href = '<?= BASE_URL . "/produto/deletar/$viewData->id" ?>';
        }
    });
</script>

<script src="<?= BASE_URL . '/public/js/inputMask.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/customer/togglePersonType.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/toUppercase.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/checkEmptyForm.js' ?>"></script>