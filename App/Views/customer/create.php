<?php

use App\Helpers\FlashMessage;

FlashMessage::render()

?>
<main class="d-flex align-items-center justify-content-center" style="margin-bottom: 7rem;">
    <section class="container">
        <!-- Título -->
        <h1 class="text-center" style="font-size: 1.8rem; margin-top: 1.5rem; margin-bottom: 3.5rem;">
            Novo Cliente
        </h1>
        <div class="bg-body mt-5 rounded-5 p-3 shadow border col-md-8 mx-auto">
            <!-- Icone -->
            <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                <div class="bg-success-subtle d-flex justify-content-center align-items-center shadow"
                    style="width: 4rem; height: 4rem; border-radius: 100%;">
                    <i class="bi bi-person-fill-add text-success-emphasis" style="font-size: 1.8rem;"></i>
                </div>
            </div>

            <form action="<?= BASE_URL . '/cliente/store' ?>" method="POST" class="mt-3 needs-validation" novalidate>
                <div class="row g-3 mb-3">
                    <!-- Tipo cliente -->
                    <div class="col-4">
                        <label for="person_type" class="form-label">
                            Tipo <b class="text-danger">*</b>
                        </label>
                        <select name="person_type" class="form-select rounded-4 p-3" id="person_type" required>
                            <option value="PF">P. Física</option>
                            <option value="PJ">P. Jurídica</option>
                        </select>
                    </div>

                    <!-- Nome -->
                    <div class="col-8">
                        <label for="name" class="form-label">
                            Nome <b class="text-danger">*</b>
                        </label>
                        <input type="text" name="name" class="form-control rounded-4 p-3 to-uppercase" minlength="10"
                            required>
                        <div class="invalid-feedback">
                            Informe o nome.
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Gênero -->
                    <div class="col-5" id="gender_div">
                        <label for="gender" class="form-label">
                            Gênero <b class="text-danger">*</b>
                        </label>
                        <select name="gender" class="form-select rounded-4 p-3" id="gender_input" required>
                            <option hidden value="">Selecione...</option>
                            <option value="F">Feminino</option>
                            <option value="M">Masculino</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione o gênero.
                        </div>
                    </div>

                    <!-- CPF -->
                    <div class="col" id="person_type_cpf_div">
                        <label for="cpf" class="form-label">
                            CPF <b class="text-danger">*</b>
                        </label>
                        <input type="text" name="cpf" class="form-control rounded-4 p-3 cpf" id="person_type_cpf_input"
                            inputmode="numeric" minlength="14" required>
                        <div class="invalid-feedback">
                            Informe o CPF.
                        </div>
                    </div>

                    <!-- CNPJ -->
                    <div class="col d-none" id="person_type_cnpj_div">
                        <label for="cnpj_number" class="form-label">
                            CNPJ <b class="text-danger">*</b>
                        </label>
                        <input type="text" name="cnpj" class="form-control rounded-4 p-3 cnpj"
                            id="person_type_cnpj_input" inputmode="numeric" minlength="18" required>
                        <div class="invalid-feedback">
                            Informe o CNPJ.
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Celular -->
                    <div class="col">
                        <label for="phone" class="form-label">
                            Celular <b class="text-danger">*</b>
                        </label>
                        <input type="text" name="phone" class="form-control rounded-4 p-3 phone_with_ddd"
                            inputmode="numeric" minlength="14" required>
                        <div class="invalid-feedback">
                            Informe número de celular.
                        </div>
                    </div>

                    <!-- Data de aniversário -->
                    <div class="col" id="birth_date_div">
                        <label for="birth_date" class="form-label">
                            Data de aniversário <b class="text-danger">*</b>
                        </label>
                        <input type="date" name="birth_date" class="form-control rounded-4 p-3" id="birth_date_input"
                            min="1960-01-01" required>
                        <div class="invalid-feedback">
                            Informe a data de aniversário.
                        </div>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="mb-3">
                    <label (11) 11111-1111for="address" class="form-label">
                        Endereço <b class="text-danger">*</b>
                    </label>
                    <input type="text" name="address" class="form-control rounded-4 p-3 to-uppercase" minlength="5"
                        required>
                    <div class="invalid-feedback">
                        Informe o endereço de entrega.
                    </div>
                </div>

                <!-- Observação -->
                <div class="mb-3">
                    <label for="description" class="form-label">
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
<script src="<?= BASE_URL . '/public/js/customer/togglePersonType.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/toUppercase.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/checkEmptyForm.js' ?>"></script>
