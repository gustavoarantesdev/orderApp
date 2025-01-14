<?php
use App\Helpers\FlashMessage; 

FlashMessage::render(); 
?>

<main  style="margin-top: 100px">
    <section class="container">
        <div class="bg-body rounded-5 p-3 shadow border col-md-8 col-lg-6 mx-auto">
            <!-- Icone -->
            <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                <div class="bg-info-subtle d-flex justify-content-center align-items-center shadow"
                style="width: 70px; height: 70px; border-radius: 100%;">
                    <i class="bi bi-bag-heart-fill text-info-emphasis" style="font-size: 2rem;"></i>
                </div>
            </div>
        <div>
        </div>
            <div class="text-center mt-3">
                <h1>OrderApp</h1>
                <p>Acesse sua conta</p>
            </div>

            <form action="<?= BASE_URL . '/login' ?>" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail <span class="text-danger"><strong>*</strong></span></label>
                    <input type="email" name="email" class="form-control rounded-4 p-3"
                    placeholder="Digite seu e-mail" required>
                        <div class="invalid-feedback">
                            Informe um e-mail válido!
                        </div>
                    </input>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha <span class="text-danger"><strong>*</strong></span></label>
                    <input type="password" name="password" class="form-control rounded-4 p-3"
                    placeholder="Digite sua senha" minlength="5" required>
                        <div class="invalid-feedback">
                            Informe uma senha!
                        </div>
                    </input>
                </div>

                <!-- Botão Acessar -->
                <div class="text-center">
                    <button class="btn bg-info-subtle text-info-emphasis p-3 lh-1 rounded-5" type="submit"
                    style="width: 8rem;">
                        <strong>Acessar</strong>
                    </button>
                </div>

                <div class="text-center mt-3">
                    <p class="m-0">Não tem uma conta? <a href="<?= BASE_URL . '/login/create' ?>">Criar Conta</a></p>
                </div>
            </form>
        </div>
    </section>
</main>

<script src="<?= BASE_URL . '/public/js/checkEmptyForm.js' ?>"></script>
