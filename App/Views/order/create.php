<main class="d-flex align-items-center justify-content-center" style="margin-bottom: 7rem;">
    <section class="container">
        <h1 class="text-center" style="font-size: 1.8rem; margin-top: 1.5rem; margin-bottom: 3.5rem;">Nova Encomenda</h1>
        <div class="bg-body mt-5 rounded-5 p-3 shadow border col-md-8 mx-auto">
            <!-- Icone -->
            <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                <div class="bg-success-subtle d-flex justify-content-center align-items-center shadow"
                    style="width: 4rem; height: 4rem; border-radius: 100%;">
                    <i class="bi bi-bag-plus text-success-emphasis" style="font-size: 1.8rem;"></i>
                </div>
            </div>

            <form action="<?= BASE_URL . '/order/store' ?>" method="POST" class="needs-validation" novalidate>
                <div class="row g-3 mb-3">
                    <!-- Encomenda -->
                    <div class="col-8">
                        <label for="order_title" class="form-label">Encomenda <span
                                class="text-danger">*</strong></span></label>
                        <input type="text" name="order_title" class="form-control rounded-4 p-3" required>
                        <div class="invalid-feedback">
                            Informe o nome da encomenda.
                        </div>
                    </div>

                    <!-- Quantidade -->
                    <div class="col">
                        <label for="order_quantity" class="form-label">Quantidade <span
                                class="text-danger"><strong>*</strong></span></label>
                        <input type="text" name="order_quantity" class="order_quantity form-control rounded-4 p-3"
                            inputmode="numeric" value="1" required>
                        <div class="invalid-feedback">
                            Informe a quantidade.
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Cliente -->
                    <div class="col-8">
                        <label for="order_client_name" class="form-label">Cliente <span
                                class="text-danger"><strong>*</strong></span></label>
                        <input type="text" name="order_client_name" class="form-control rounded-4 p-3" required>
                        <div class="invalid-feedback">
                            Informe o nome do cliente.
                        </div>
                    </div>

                    <!-- Retirada -->
                    <div class="col">
                        <label for="order_withdraw" class="form-label">Retirada? <span
                                class="text-danger"><strong>*</strong></span></label>
                        <select name="order_withdraw" class="form-select rounded-4 p-3" required>
                            <option value="f">Não</option>
                            <option value="t">Sim</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Data -->
                    <div class="col-7">
                        <label for="order_completion_date" class="form-label">Data da entrega <span
                                class="text-danger"><strong>*</strong></span></label>
                        <input type="date" min="2023-12-31" name="order_completion_date"
                            class="form-control rounded-4 p-3" required>
                        <div class="invalid-feedback">
                            Informe a data da entrega.
                        </div>
                    </div>

                    <!-- Horário -->
                    <div class="col">
                        <label for="order_completion_time" class="form-label">Hora <span
                                class="text-danger"><strong>*</strong></span></label>
                        <input type="time" name="order_completion_time" class="form-control rounded-4 p-3" required>
                        <div class="invalid-feedback">
                            Informe o horário da entrega.
                        </div>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="mb-3">
                    <label for="order_delivery_address" class="form-label">Endereço da entrega <span
                            class="text-danger"><strong>*</strong></span></label>
                    <input type="text" name="order_delivery_address" class="form-control rounded-4 p-3" required>
                    <div class="invalid-feedback">
                        Informe o endereço da entrega.
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Preço -->
                    <div class="col">
                        <label for="order_price" class="form-label">Preço <span
                                class="text-danger"><strong>*</strong></span></label>
                        <input type="text" name="order_price" class="order_price form-control rounded-4 p-3"
                            inputmode="numeric" required>
                        <div class="invalid-feedback">
                            Informe o preço da encomanda.
                        </div>
                    </div>

                    <!-- Forma de Pagamento -->
                    <div class="col-6">
                        <label for="order_payment_method" class="form-label">Pagamento <span
                                class="text-danger"><strong>*</strong></span></label>
                        <select name="order_payment_method" id="order_payment_method" class="form-select rounded-4 p-3"
                            required>
                            <option hidden>Selecione...</option>
                            <option value="1">Cartão de Crédito</option>
                            <option value="2">Cartão de Débito</option>
                            <option value="3">Dinheiro</option>
                            <option value="4">PIX</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione a forma de pagamento.
                        </div>
                    </div>

                    <!-- Parcelas -->
                    <div class="col-3 d-none" id="order_payment_installments_div">
                        <label for="order_payment_installments" class="form-label">Parcelas</label>
                        <select name="order_payment_installments" class="form-select rounded-4 p-3" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                </div>

                <!-- Observação -->
                <div class="mb-3">
                    <label for="order_description" class="form-label">Observação</label>
                    <textarea type="text" name="order_description" rows="3"
                        class="form-control rounded-4 p-3"></textarea>
                </div>

                <!-- Botões -->
                <div class="row mb-3">
                    <div class="col d-flex align-items-center justify-content-center">
                        <!-- Retornar -->
                        <div class="text-center mt-3">
                            <button
                                class="btn bg-body-secondary rounded-5 d-flex align-items-center justify-content-center"
                                type="button" style="width: 9rem;" onclick="window.location='<?= BASE_URL ?>'">
                                <p class="m-0"><strong>Retornar</strong></p>
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
                                <p class="m-0"><strong>Cadastrar</strong></p>
                                <i class="bi bi-plus ms-2" style="font-size: 1.5rem;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<script src="<?= BASE_URL . '/public/js/scripts.js' ?>"></script>