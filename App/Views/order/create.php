<main class="d-flex align-items-center justify-content-center" style="margin-bottom: 7rem;">
    <section class="container">
        <!-- Título -->
        <h1 class="text-center" style="font-size: 1.8rem; margin-top: 1.5rem; margin-bottom: 3.5rem;">
            Nova Encomenda
        </h1>

        <div class="bg-body mt-5 rounded-5 p-3 shadow border col-md-8 mx-auto">
            <!-- Icone -->
            <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                <div class="bg-success-subtle d-flex justify-content-center align-items-center shadow"
                    style="width: 4rem; height: 4rem; border-radius: 100%;">
                    <i class="bi bi-bag-plus text-success-emphasis" style="font-size: 1.8rem;"></i>
                </div>
            </div>

            <form action="<?= BASE_URL . '/encomenda/store' ?>" method="POST" class="needs-validation" novalidate>
                <h5 class="mt-4">Dados do Cliente:</h5>

                <div class="row g-3 mb-3">
                    <!-- Id cliente -->
                    <input type="hidden" name="customer_id" id="customerId">

                    <!-- Cliente -->
                    <div class="col-7">
                        <label class="form-label">
                            Cliente <span class="text-danger"><b>*</b></span>
                        </label>
                        <input type="text" id="customerInput" list="customerDatalist"
                            class="form-control rounded-4 p-3" required autocomplete="off" autofocus>
                        <datalist id="customerDatalist"></datalist>
                        <div class="invalid-feedback">
                            Informe o nome do cliente.
                        </div>
                    </div>

                    <!-- Tel. de Contato -->
                    <div class="col">
                        <label class="form-label">Tel. Contato</label>
                        <input type="text" id="customerPhone" class="form-control rounded-4 p-3"
                            readonly>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Endereço -->
                    <div class="col">
                        <label class="form-label">
                            Endereço da entrega <span class="text-danger"><b>*</b></span>
                        </label>
                        <input type="text" name="customer_address" id="customerAddress"
                            class="form-control rounded-4 p-3" required autocomplete="off">
                        <div class="invalid-feedback">
                            Informe o endereço da entrega.
                        </div>
                    </div>

                    <!-- Link para cadastro de cliente -->
                    <div class="mt-3" style="font-size: 0.9rem;">
                        <p class="m-0">Cliente não encontrado?
                            <a href="<?= BASE_URL . '/cliente/cadastrar' ?>">Cadastrar</a>
                        </p>
                    </div>
                </div>

                <hr class="mt-4 w-75 mx-auto border border-1">
                <h5 class="mt-4">Dados do Pedido:</h5>

                <div class="row g-3 mb-2">
                    <!-- Id do produto -->
                    <input type="hidden" id="productIdInput">

                    <!-- Produto -->
                    <div class="col-4">
                        <label class="form-label">
                            Produto <span class="text-danger"><b>*</b></span>
                        </label>
                        <input type="text" list="productDatalist" id="productNameInput"
                            class="form-control rounded-4 p-3" autocomplete="off">
                        <datalist id="productDatalist"></datalist>
                        <div class="invalid-feedback">
                            Informe o nome do produto.
                        </div>
                    </div>

                    <!-- Valor unitário-->
                    <div class="col">
                        <label for="sell_price" class="form-label">
                            V. Un. <span class="text-danger"><b>*</b></span>
                        </label>
                        <input type="text" id="productSellPriceInput"
                            class="money form-control rounded-4 p-3" inputmode="numeric">
                        <div class="invalid-feedback">
                            Informe o valor unitário.
                        </div>
                    </div>

                    <!-- Quantidade -->
                    <div class="col">
                        <label class="form-label">
                            Qtd. <span class="text-danger"><b>*</b></span>
                        </label>
                        <input type="text" id="productQuantityInput" class="quantity form-control rounded-4 p-3"
                            inputmode="numeric">
                        <div class="invalid-feedback">
                            Informe a quantidade.
                        </div>
                    </div>

                    <!-- Botão de novo produto -->
                    <div class="col d-flex justify-content-start align-items-center">
                        <button id="addOrderItemBtn"
                            class="btn bg-info-subtle text-info-emphasis rounded-4 d-flex align-items-center justify-content-center"
                            type="button" style="width: 100%; height: 57px; margin-top: 30px;">
                            <i class="bi bi-plus-lg" style="font-size: 1.5rem;"></i>
                        </button>
                    </div>

                    <!-- Itens do Pedido -->
                    <label><b>Itens do Pedido:</b></label>
                    <div class="col mt-2" id="orderItems">

                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Link para cadastro de produto -->
                    <div class="mt-3" style="font-size: 0.9rem;">
                        <p class="m-0">Produto não encontrado?
                            <a href="<?= BASE_URL . '/produto/cadastrar' ?>">Cadastrar</a>
                        </p>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Adicional -->
                    <div class="col">
                        <label class="form-label">
                            Adicional
                        </label>
                        <input type="text" name="additional" id="additional" class="money form-control rounded-4 p-3"
                            inputmode="numeric">
                    </div>

                    <!-- Desconto -->
                    <div class="col">
                        <label class="form-label">
                            Desconto
                        </label>
                        <input type="text" name="discount" id="discount" class="money form-control rounded-4 p-3"
                            inputmode="numeric">
                    </div>

                    <!-- Subtotal -->
                    <div class="col">
                        <label class="form-label">
                            <b>Subtotal</b>
                        </label>
                        <input type="text" name="subtotal" id="subtotal" class="money form-control rounded-4 p-3"
                            inputmode="numeric" readonly>
                        <div class="invalid-feedback">
                            Informe o subtotal da encomanda.
                        </div>
                    </div>
                </div>

                <hr class="mt-4 w-75 mx-auto border border-1">
                <h5 class="mt-4">Dados do Pagamento:</h5>

                <div class="row g-3 mb-3">
                    <!-- Valor do pagamento -->
                    <div class="col">
                        <label class="form-label">
                            Valor do Pagamento
                        </label>
                        <input type="text" name="payment_value" id="paymentValue" class="money form-control rounded-4 p-3"
                            inputmode="numeric" required>
                        <div class="invalid-feedback">
                            Informe o subtotal da encomanda.
                        </div>
                    </div>

                    <!-- Situação de pagamento -->
                    <div class="col">
                        <label class="form-label">
                            Já foi Pago? <span class="text-danger"><b>*</b></span>
                        </label>
                        <select name="payment_status" class="form-select rounded-4 p-3" required>
                            <option value="1">Não</option>
                            <option value="2">Sim</option>
                            <option value="3">Parcialmente</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione se já foi pago.
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Forma de Pagamento -->
                    <div class="col-6">
                        <label class="form-label">
                            For. de Pagamento <span class="text-danger"><b>*</b></span>
                        </label>
                        <select name="payment_method" id="paymentMethod" class="form-select rounded-4 p-3"
                            required>
                            <option hidden>Selecione...</option>
                            <option value="1">Cartão de Crédito</option>
                            <option value="2">Cartão de Débito</option>
                            <option value="3">Dinheiro</option>
                            <option value="4">PIX</option>
                            <option value="5">Promissória</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione a forma de pagamento.
                        </div>
                    </div>

                    <!-- Parcelas -->
                    <div class="col-6 d-none" id="installmentsDiv">
                        <label class="form-label">
                            Qtd. de Parcelas
                        </label>
                        <select name="payment_installments" class="form-select rounded-4 p-3" required>
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

                    <!-- Data do pagamento -->
                    <div class="col">
                        <label class="form-label">
                            Data Pagamento <span class="text-danger"><b>*</b></span>
                        </label>
                        <input type="date" min="2023-12-31" name="payment_date"
                            class="form-control rounded-4 p-3" required>
                        <div class="invalid-feedback">
                            Informe a data da entrega.
                        </div>
                    </div>
                </div>

                <hr class="mt-4 w-75 mx-auto border border-1">
                <h5 class="mt-4">Dados da Entrega:</h5>

                <div class="row g-3 mb-3">
                    <!-- Data de entrega -->
                    <div class="col-7">
                        <label class="form-label">Data da entrega <span
                            class="text-danger"><b>*</b></span></label>
                        <input type="date" min="2023-12-31" name="completion_date"
                            class="form-control rounded-4 p-3" required>
                        <div class="invalid-feedback">
                            Informe a data da entrega.
                        </div>
                    </div>

                    <!-- Horário de entrega -->
                    <div class="col">
                        <label class="form-label">Hora <span
                            class="text-danger"><b>*</b></span>
                        </label>
                        <input type="time" name="completion_time" class="form-control rounded-4 p-3" required>
                        <div class="invalid-feedback">
                            Informe o horário da entrega.
                        </div>
                    </div>

                    <!-- Retirada -->
                    <div class="col">
                        <label class="form-label">Retirada? <span
                            class="text-danger"><b>*</b></span>
                        </label>
                        <select name="withdraw" class="form-select rounded-4 p-3" required>
                            <option value="f">Não</option>
                            <option value="t">Sim</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Status do Pedido -->
                    <div class="col">
                        <label class="form-label">
                            Status
                        </label>
                        <select name="order_status" class="form-select rounded-4 p-3" required>
                            <option value="1">Agendada</option>
                            <option value="2">Em produção</option>
                            <option value="3">Finalizada/Entregue</option>
                            <option value="4">Cancelada</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione o status do pedido.
                        </div>
                    </div>

                    <!-- Observação -->
                    <div class="mb-3">
                        <label class="form-label">Observação</label>
                        <textarea type="text" name="description" rows="3"
                            class="form-control rounded-4 p-3"></textarea>
                    </div>
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

<script src="<?= BASE_URL . '/public/js/order/customerAjax.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/order/productAjax.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/order/toggleInstallments.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/order/addItem.js' ?>"></script>
