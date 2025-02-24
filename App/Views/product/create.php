<?php

use App\Helpers\FlashMessage;

FlashMessage::render()

?>

<main class="d-flex align-items-center justify-content-center" style="margin-bottom: 7rem;">
    <section class="container">
        <!-- Título -->
        <h1 class="text-center" style="font-size: 1.8rem; margin-top: 1.5rem; margin-bottom: 3.5rem;">
            Novo Produto
        </h1>
        <div class="bg-body mt-5 rounded-5 p-3 shadow border col-md-8 mx-auto">
            <!-- Icone -->
            <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                <div class="bg-success-subtle d-flex justify-content-center align-items-center shadow"
                    style="width: 4rem; height: 4rem; border-radius: 100%;">
                    <i class="bi bi-cake-fill text-success-emphasis" style="font-size: 1.8rem;"></i>
                </div>
            </div>

            <form action="<?= BASE_URL . '/produto/store' ?>" method="POST" class="mt-3 needs-validation" novalidate>
                <div class="row g-3 mb-3">
                    <!-- Nome -->
                    <div class="col">
                        <label class="form-label">
                            Nome <b class="text-danger">*</b>
                        </label>
                        <input type="text" name="name" class="form-control rounded-4 p-3 to-uppercase" minlength="10"
                            required autocomplete="off" autofocus>
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
                            inputmode="numeric" required>
                        <div class="invalid-feedback">
                            Informe o preço de venda.
                        </div>
                    </div>

                    <!-- Preço de custo -->
                    <div class="col">
                        <label class="form-label">
                            Preço de custo <span class="text-danger"><b>*</b></span>
                        </label>
                        <input type="text" name="cost_price" class="money form-control rounded-4 p-3"
                            inputmode="numeric" required>
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
                            <option value="1">Ativo</option>
                            <option value="0">Desativo</option>
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
                    <textarea type="text" name="description" rows="3" class="form-control rounded-4 p-3"></textarea>
                </div>

                <!-- Botões -->
                <div class="row mb-3">
                    <div class="col d-flex align-items-center justify-content-center">
                        <!-- Retornar -->
                        <div class="text-center mt-3">
                            <button
                                class="btn bg-body-secondary rounded-5 d-flex align-items-center justify-content-center"
                                type="button" style="width: 9rem;" onclick="window.location='<?= BASE_URL ?>'">
                                <p class="m-0"><b>Retornar</b></p>
                                <i class="bi bi-arrow-left ms-3" style="font-size: 1.5rem;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col d-flex align-items-center justify-content-center">
                        <!-- Cadastrar -->
                        <div class="text-center mt-3">
                            <button
                                class="btn bg-success-subtle text-success-emphasis rounded-5 d-flex align-items-center justify-content-center"
                                type="submit" style="width: 9rem;">
                                <p class="m-0"><b>Cadastrar</b></p>
                                <i class="bi bi-plus ms-2" style="font-size: 1.5rem;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<script src="<?= BASE_URL . '/public/js/inputMask.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/toUppercase.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/checkEmptyForm.js' ?>"></script>