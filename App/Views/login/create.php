<?php
use App\Helpers\FlashMessage;

FlashMessage::render();
?>

<main style="margin-top: 100px">
    <section class="container">
        <div class="bg-body rounded-5 p-3 shadow border col-md-8 col-lg-6 mx-auto">
            <!-- Icone -->
            <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                <div class="bg-primary-subtle d-flex justify-content-center align-items-center shadow"
                style="width: 70px; height: 70px; border-radius: 100%;">
                    <i class="bi bi-person-fill-add text-primary" style="font-size: 2rem;"></i>
                </div>
            </div>

            <div class="text-center mt-3">
                <h1>Cadastre-se</h1>
                <p>Crie sua conta</p>
            </div>

            <form action="<?= BASE_URL . '/login/store' ?>" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Nome de usuário <span class="text-danger"><strong>*</strong></span></label>
                    <input type="text" name="name" class="form-control rounded-4 p-3"
                    placeholder="Seu nome" minlength="3" required>
                        <div class="invalid-feedback">
                            Informe seu nome de usuário!
                        </div>
                    </input>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail <span class="text-danger"><strong>*</strong></span></label>
                    <input type="email" name="email" class="form-control rounded-4 p-3"
                    placeholder="Seu e-mail" required>
                        <div class="invalid-feedback">
                            Informe seu e-mail!
                        </div>
                    </input>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha <span class="text-danger"><strong>*</strong></span></label>
                    <input type="password" name="password" class="form-control rounded-4 p-3"
                    placeholder="Sua senha" minlength="5" required>
                        <div class="invalid-feedback">
                            Informe sua senha. A senha deve ter no mínimo 5 caracteres!
                        </div>
                    </input>
                </div>

                <div class="mb-3">
                    <label for="password2" class="form-label">Confirme a senha <span class="text-danger"><strong>*</strong></span></label>
                    <input type="password" name="password2" class="form-control rounded-4 p-3"
                    placeholder="Confirme sua senha" required>
                        <div class="invalid-feedback">
                            Confirme sua senha!
                        </div>
                    </input>
                </div>

                <!-- Botão cadastrar -->
                <div class="text-center">
                    <button class="btn bg-primary-subtle text-primary p-3 lh-1 rounded-5" type="submit"
                    style="width: 8rem;">
                        <strong>Cadastrar</strong>
                    </button>
                </div>

                <div class="text-center mt-3">
                    <p class="m-0">Já tem uma conta? <a href="<?= BASE_URL ?>">Acesse</a></p>
                </div>
            </form>
        </div>
    </section>
</main>

<script src="<?= BASE_URL . '/public/js/checkEmptyForm.js' ?>"></script>
