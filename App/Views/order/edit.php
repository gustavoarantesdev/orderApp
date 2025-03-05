<?php

use App\Helpers\FlashMessage;

FlashMessage::render()

    ?>

<main class="d-flex align-items-center justify-content-center" style="margin-bottom: 7rem;">
    <section class="container">
        <!-- Título -->
        <h1 class="text-center" style="font-size: 1.8rem; margin-top: 1.5rem; margin-bottom: 3.5rem;">
            Editar Encomenda
        </h1>

        <div class="bg-body mt-5 rounded-5 p-3 shadow border col-md-8 mx-auto">
            <!-- Icone -->
            <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                <div class="bg-warning-subtle d-flex justify-content-center align-items-center shadow"
                    style="width: 4rem; height: 4rem; border-radius: 100%;">
                    <i class="bi bi-bag-dash text-warning-emphasis" style="font-size: 1.8rem;"></i>
                </div>
            </div>

            <form action="<?= BASE_URL . '/encomenda/update' ?>" method="POST" class="needs-validation" novalidate>
                <!-- Id da encomenda -->
                <input type="hidden" name="id" value="<?= htmlspecialchars($viewData->id) ?>">


                <div class="accordion mt-4" id="accordionPanelsStayOpenExample">
                    <!-- Dados do Cliente -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h2 class="mb-0 fs-5">1. Dados do Cliente</h2>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body p-3">
                                <div class="d-flex flex-column flex-sm-row gap-3 mb-3">
                                    <!-- Id cliente -->
                                    <input type="hidden" name="customer_id" id="customerId"
                                        value="<?= htmlspecialchars($viewData->customer_id) ?>" autocomplete="off">

                                    <!-- Cliente -->
                                    <div class="flex-grow-1">
                                        <label class="form-label">
                                            Nome do cliente <span class="text-danger"><b>*</b></span>
                                        </label>
                                        <input type="text" id="customerInput" list="customerDatalist"
                                            class="form-control rounded-4 p-3" required
                                            value="<?= htmlspecialchars($viewData->customer_name) ?>"
                                            autocomplete="off">
                                        <datalist id="customerDatalist"></datalist>
                                        <div class="invalid-feedback">
                                            Informe o nome do cliente.
                                        </div>
                                    </div>

                                    <!-- Tel. de Contato -->
                                    <div class="">
                                        <label class="form-label">Telefone de contato</label>
                                        <input type="text" id="customerPhone" class="form-control rounded-4 p-3"
                                            value="<?= htmlspecialchars($viewData->customer_phone) ?>" readonly>
                                    </div>
                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <!-- Endereço -->
                                    <div class="flex-fill">
                                        <label class="form-label">
                                            Endereço da entrega <span class="text-danger"><b>*</b></span>
                                        </label>
                                        <input type="text" name="customer_address" id="customerAddress"
                                            class="form-control rounded-4 p-3"
                                            value="<?= htmlspecialchars($viewData->delivery_address) ?>" required
                                            autocomplete="off">
                                        <div class="invalid-feedback">
                                            Informe o endereço da entrega.
                                        </div>
                                    </div>
                                </div>

                                <!-- Link para cadastro de cliente -->
                                <p class="mt-3 mb-0 align-self-end" style="font-size: 0.9rem;">Cliente não encontrado?
                                    <a href="<?= BASE_URL . '/cliente/cadastrar' ?>">Cadastrar</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Dados do Pedido -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h2 class="mb-0 fs-5">2. Dados do Pedido</h2>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body p-3">
                                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                                    <!-- Id do produto -->
                                    <input type="hidden" id="productIdInput">

                                    <!-- Produto -->
                                    <div class="flex-grow-1">
                                        <label class="form-label">
                                            Nome do produto <span class="text-danger"><b>*</b></span>
                                        </label>
                                        <input type="text" list="productDatalist" id="productNameInput"
                                            class="form-control rounded-4 p-3" autocomplete="off">
                                        <datalist id="productDatalist"></datalist>
                                        <div class="invalid-feedback">
                                            Informe o nome do produto.
                                        </div>
                                    </div>

                                    <!-- Quantidade -->
                                    <div class="flex-fill">
                                        <label class="form-label">
                                            Quantidade <span class="text-danger"><b>*</b></span>
                                        </label>
                                        <input type="text" id="productQuantityInput"
                                            class="quantity form-control rounded-4 p-3" inputmode="numeric">
                                        <div class="invalid-feedback">
                                            Informe a quantidade.
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <!-- Preço unitário-->
                                    <div class="flex-shrink-1">
                                        <label for="sell_price" class="form-label">
                                            Preço unitário <span class="text-danger"><b>*</b></span>
                                        </label>
                                        <input type="text" id="productSellPriceInput"
                                            class="money form-control rounded-4 p-3" inputmode="numeric">
                                        <div class="invalid-feedback">
                                            Informe o preço unitário.
                                        </div>
                                    </div>

                                    <!-- Botão de novo produto -->
                                    <div class="d-flex flex-grow-1 justify-content-start align-items-end mt-2">
                                        <button id="addOrderItemBtn"
                                            class="btn bg-info-subtle text-info-emphasis rounded-4" type="button"
                                            style="width: 100%; height: 57px;">
                                            <i class="bi bi-plus-lg" style="font-size: 1.5rem;"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Link para cadastro de produto -->
                                <div class="d-flex justify-content-end">
                                    <p class="mt-3 mb-sm-3" style="font-size: 0.9rem;">
                                        Produto não encontrado?
                                        <a href="<?= BASE_URL . '/produto/cadastrar' ?>">Cadastrar</a>
                                    </p>
                                </div>

                                <label class="mb-2">
                                    <b>Itens do Pedido</b>
                                </label>
                                <div>
                                    <!-- Itens do Pedido -->
                                    <div id="orderItems">
                                        <?php $phpCount = 0; ?>
                                        <?php foreach ($viewData->items as $item) { ?>
                                            <!-- Variável que representa cada item da encomanda -->
                                            <?php $phpCount++; ?>
                                            <div class="orderItems d-flex flex-column flex-md-row gap-2 border p-2 mb-2 rounded-3 shadow-sm"
                                                id="item-<?= $phpCount ?>">
                                                <div class="d-flex gap-2">
                                                    <input type="hidden" name="product_id<?= $phpCount ?>"
                                                        value="<?= htmlspecialchars($item->product_id) ?>">

                                                    <div style="width: 90%;">
                                                        <p class="m-0" style="font-size: 0.8rem;">Nome</p>
                                                        <input name="product_name<?= $phpCount ?>"
                                                            class="form-control bg-body-tertiary rounded-4"
                                                            value="<?= htmlspecialchars($item->product_name) ?>" readonly>
                                                    </div>

                                                    <div style="width: 40%;">
                                                        <p class="m-0" style="font-size: 0.8rem;">Quantidade</p>
                                                        <input name="product_quantity<?= $phpCount ?>"
                                                            class="form-control bg-body-tertiary rounded-4"
                                                            value="<?= htmlspecialchars($item->quantity) ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <div class="flex-grow-1">
                                                        <p class="m-0" style="font-size: 0.8rem;">Preço</p>
                                                        <input name="product_sell_price<?= $phpCount ?>"
                                                            class="form-control bg-body-tertiary rounded-4"
                                                            value="<?= htmlspecialchars($item->sell_price) ?>" readonly>
                                                    </div>

                                                    <div class="flex-grow-1 align-self-end">
                                                        <button data-id="item-<?= $phpCount ?>"
                                                            data-item-total="<?= (float) $item->sell_price * $item->quantity ?>"
                                                            class="deleteButton btn bg-danger-subtle text-danger-emphasis rounded-4 d-flex align-items-center justify-content-center align-self-center"
                                                            type="button" style="width: 100%; height: 37px;">
                                                            <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                                <br class="hidden">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <!-- Subtotal -->
                                <div class="mt-3">
                                    <label class="form-label">
                                        <b>Subtotal</b>
                                    </label>
                                    <input type="text" name="subtotal" id="subtotal"
                                        class="money form-control rounded-4 p-3" inputmode="numeric"
                                        value="<?= htmlspecialchars($viewData->subtotal) ?>" inputmode="numeric"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dados do Pagamento -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h2 class="mb-0 fs-5">3. Dados do Pagamento</h2>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body p-3">
                                <div class="d-flex gap-3 mb-3">
                                    <!-- Adicional -->
                                    <div class="flex-grow-1">
                                        <label class="form-label">
                                            Adicional
                                        </label>
                                        <input type="text" name="additional" id="additional"
                                            class="money form-control rounded-4 p-3" inputmode="numeric"
                                            value="<?= htmlspecialchars($viewData->additional) ?>"
                                            inputmode="numeric" autocomplete="off">
                                    </div>

                                    <!-- Desconto -->
                                    <div class="flex-grow-1">
                                        <label class="form-label">
                                            Desconto
                                        </label>
                                        <input type="text" name="discount" id="discount"
                                            class="money form-control rounded-4 p-3" inputmode="numeric"
                                            value="<?= htmlspecialchars($viewData->discount) ?>"
                                            inputmode="numeric" autocomplete="off">
                                    </div>
                                </div>
                                <div class="d-flex gap-3 mb-3">
                                    <!-- Valor do pagamento -->
                                    <div style="width: 60%;">
                                        <label class="form-label">
                                            Valor do pagamento
                                        </label>
                                        <input type="text" name="payment_value" id="paymentValue"
                                            class="money form-control rounded-4 p-3"
                                            value="<?= htmlspecialchars($viewData->payment_value) ?>"
                                            inputmode="numeric" required autocomplete="off">
                                        <div class="invalid-feedback">
                                            Informe o valor do pagamento.
                                        </div>
                                    </div>

                                    <!-- Situação de pagamento -->
                                    <div style="width: 40%;">
                                        <label class="form-label">
                                            Já foi pago?
                                        </label>
                                        <select name="payment_status" class="form-select rounded-4 p-3" required>
                                            <option value="1" <?= htmlspecialchars($viewData->payment_status) == 1 ? 'selected' : '' ?>>Não</option>
                                            <option value="2" <?= htmlspecialchars($viewData->payment_status) == 2 ? 'selected' : '' ?>>Sim</option>
                                            <option value="3" <?= htmlspecialchars($viewData->payment_status) == 3 ? 'selected' : '' ?>>Parcialmente</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <!-- Forma de Pagamento -->
                                    <div class="flex-grow-1">
                                        <label class="form-label">
                                            Forma de pagamento <span class="text-danger"><b>*</b></span>
                                        </label>
                                        <select name="payment_method" id="paymentMethod"
                                            class="form-select rounded-4 p-3" required>
                                            <option hidden value="">Selecione...</option>
                                            <option value="1" <?= htmlspecialchars($viewData->payment_method) == 1 ? 'selected' : '' ?>>Cartão de Crédito</option>
                                            <option value="2" <?= htmlspecialchars($viewData->payment_method) == 2 ? 'selected' : '' ?>>Cartão de Débito</option>
                                            <option value="3" <?= htmlspecialchars($viewData->payment_method) == 3 ? 'selected' : '' ?>>Dinheiro</option>
                                            <option value="4" <?= htmlspecialchars($viewData->payment_method) == 4 ? 'selected' : '' ?>>PIX</option>
                                            <option value="5" <?= htmlspecialchars($viewData->payment_method) == 5 ? 'selected' : '' ?>>Promissória</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Selecione a forma de pagamento.
                                        </div>
                                    </div>

                                    <!-- Parcelas -->
                                    <div class="flex-grow-1 d-none" id="installmentsDiv">
                                        <label class="form-label">
                                            Quantidade de parcelas
                                        </label>
                                        <select name="payment_installments" class="form-select rounded-4 p-3" required>
                                            <option value="1" <?= htmlspecialchars($viewData->payment_installments) == 1 ? 'selected' : '' ?>>1x</option>
                                            <option value="2" <?= htmlspecialchars($viewData->payment_installments) == 2 ? 'selected' : '' ?>>2x</option>
                                            <option value="3" <?= htmlspecialchars($viewData->payment_installments) == 3 ? 'selected' : '' ?>>3x</option>
                                            <option value="4" <?= htmlspecialchars($viewData->payment_installments) == 4 ? 'selected' : '' ?>>4x</option>
                                            <option value="5" <?= htmlspecialchars($viewData->payment_installments) == 5 ? 'selected' : '' ?>>5x</option>
                                            <option value="6" <?= htmlspecialchars($viewData->payment_installments) == 6 ? 'selected' : '' ?>>6x</option>
                                            <option value="7" <?= htmlspecialchars($viewData->payment_installments) == 7 ? 'selected' : '' ?>>7x</option>
                                            <option value="8" <?= htmlspecialchars($viewData->payment_installments) == 8 ? 'selected' : '' ?>>8x</option>
                                            <option value="9" <?= htmlspecialchars($viewData->payment_installments) == 9 ? 'selected' : '' ?>>9x</option>
                                            <option value="10" <?= htmlspecialchars($viewData->payment_installments) == 10 ? 'selected' : '' ?>>10x</option>
                                            <option value="11" <?= htmlspecialchars($viewData->payment_installments) == 11 ? 'selected' : '' ?>>11x</option>
                                            <option value="12" <?= htmlspecialchars($viewData->payment_installments) == 12 ? 'selected' : '' ?>>12x</option>
                                        </select>
                                    </div>

                                    <!-- Data do pagamento -->
                                    <div class="flex-grow-1">
                                        <label class="form-label">
                                            Data do pagamento <span class="text-danger"><b>*</b></span>
                                        </label>
                                        <input type="date" min="2023-12-31" name="payment_date"
                                            class="form-control rounded-4 p-3" required
                                            value="<?= htmlspecialchars($viewData->payment_date) ?>" required>
                                        <div class="invalid-feedback">
                                            Informe a data do pagamento.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dados da Entrega -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFor" aria-expanded="false" aria-controls="collapseFor">
                                <h2 class="mb-0 fs-5">4. Dados da Entrega</h2>
                            </button>
                        </h2>
                        <div id="collapseFor" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body p-3">
                                <div class="d-flex flex-column flex-sm-row gap-3 mb-3">
                                    <!-- Data de entrega -->
                                    <div class="flex-grow-1">
                                        <label class="form-label">Data da entrega <span
                                                class="text-danger"><b>*</b></span></label>
                                        <input type="date" min="2023-12-31" name="completion_date"
                                            class="form-control rounded-4 p-3"
                                            value="<?= htmlspecialchars($viewData->completion_date) ?>" required>
                                        <div class="invalid-feedback">
                                            Informe a data da entrega.
                                        </div>
                                    </div>

                                    <!-- Horário de entrega -->
                                    <div class="flex-grow-1">
                                        <label class="form-label">Hora <span class="text-danger"><b>*</b></span>
                                        </label>
                                        <input type="time" name="completion_time" class="form-control rounded-4 p-3"
                                            value="<?= htmlspecialchars($viewData->completion_time) ?>" required>
                                        <div class="invalid-feedback">
                                            Informe o horário da entrega.
                                        </div>
                                    </div>

                                    <!-- Retirada -->
                                    <div class="flex-grow-1">
                                        <label class="form-label">
                                            Retirada?
                                        </label>
                                        <select name="withdraw" class="form-select rounded-4 p-3" required>
                                            <option value="f" <?= htmlspecialchars($viewData->withdraw) == false ? 'selected' : '' ?>>Não</option>
                                            <option value="t" <?= htmlspecialchars($viewData->withdraw) == true ? 'selected' : '' ?>>Sim</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <!-- Status da Encomenda -->
                                    <div class="col">
                                        <label class="form-label">
                                            Status da encomenda
                                        </label>
                                        <select name="order_status" class="form-select rounded-4 p-3" required>
                                            <option value="1" <?= htmlspecialchars($viewData->order_status) == '1' ? 'selected' : '' ?>>Agendada</option>
                                            <option value="2" <?= htmlspecialchars($viewData->order_status) == '2' ? 'selected' : '' ?>>Em produção</option>
                                            <option value="3" <?= htmlspecialchars($viewData->order_status) == '3' ? 'selected' : '' ?>>Finalizada/Entregue</option>
                                            <option value="4" <?= htmlspecialchars($viewData->order_status) == '4' ? 'selected' : '' ?>>Cancelada</option>
                                        </select>
                                    </div>

                                    <!-- Observação -->
                                    <div>
                                        <label class="form-label">Observação</label>
                                        <textarea type="text" name="description" rows="3"
                                            class="form-control rounded-4 p-3"><?= htmlspecialchars($viewData->description) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                <div class="text-body-tertiary text-center mt-3">
                    <?= 'Número da encomenda: ' . htmlspecialchars($viewData->order_number) . ' - Cadastrada em: ' . htmlspecialchars($viewData->created_at) ?>
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    // Exibe um alerta para o usuário confirmar antes de excluir
    $('#deleteButton').on('click', function () {
        if (confirm("Tem certeza de que deseja excluir?")) {
            window.location.href = "<?= BASE_URL . '/encomenda/deletar/' . htmlspecialchars($viewData->id) ?>";
        }
    });
</script>

<script src="<?= BASE_URL . '/public/js/inputMask.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/toUppercase.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/checkEmptyForm.js' ?>"></script>

<script src="<?= BASE_URL . '/public/js/order/customerAjax.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/order/productAjax.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/order/toggleInstallments.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/order/addItem.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/order/deleteItem.js' ?>"></script>
<script src="<?= BASE_URL . '/public/js/order/calcSubtotal.js' ?>"></script>