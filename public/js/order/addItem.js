const orderItems = document.getElementById('orderItems');
// Variável que representa o id de cada produto adicionado
let counterId = 0;

/**
 * Adiciona os produtos da encomenda.
 */
document.getElementById('addOrderItemBtn').addEventListener('click', function () {
    // Os valores das constantes, são definidos em productAjax.js
    const productId = productIdInput.value;
    const productName = productNameInput.value;
    const productQuantity = parseQuantity(productQuantityInput.value);
    const productSellPrice = parsePrice(productSellPriceInput.value);

    // Verifica se os inputs do produto estão preenchidos corretamente
    if (productName === '' || productQuantity <= 0 || productSellPrice <= 0) {
        return;
    }

    // Incrementa o contador de produtos
    counterId++;
    const divId = `item-${counterId}`;
    // Armazena o valor de cada item
    const finalItemPrice = calcItemTotal(productQuantity, productSellPrice);

    // Adiciona o item
    orderItems.innerHTML += `
        <div class="orderItems d-flex flex-column flex-md-row gap-2 border p-2 mb-2 rounded-3 shadow-sm" id="${divId}">
            <div class="d-flex gap-2">
                <input type="hidden" name="product_id${counterId}" value="${productId}">

                <div style="width: 90%">
                    <p class="m-0" style="font-size: 0.8rem;">Nome</p>
                    <input name="product_name${counterId}"
                        class="form-control bg-body-tertiary rounded-4" value="${productName}"
                        readonly>
                </div>

                <div style="width: 40%">
                    <p class="m-0" style="font-size: 0.8rem;">Quantidade</p>
                    <input name="product_quantity${counterId}"
                        class="form-control bg-body-tertiary rounded-4" value="${productQuantity}"
                        readonly>
                </div>
            </div>

            <div class="d-flex gap-2">
                <div class="flex-grow-1">
                    <p class="m-0" style="font-size: 0.8rem;">Preço</p>
                    <input name="product_sell_price${counterId}"
                        class="form-control bg-body-tertiary rounded-4"
                        value="${formatOutputValue(productSellPrice)}" readonly>
                </div>

                <div class="flex-grow-1 align-self-end">
                    <button data-id="${divId}" data-item-total="${finalItemPrice}"
                        class="deleteButton btn bg-danger-subtle text-danger-emphasis rounded-4 d-flex align-items-center justify-content-center"
                        type="button" style="width: 100%; height: 41px;">
                        <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                    </button>
                </div>
            </div>
            <br class="hidden">
        </div>
    `;

    // Adiciona o valor do item ao subtotal
    updateSubtotalValue(finalItemPrice);

    // Limpa os inputs após adicionar um item
    productIdInput.value = '';
    productNameInput.value = '';
    productSellPriceInput.value = '';
    productQuantityInput.value = '';
});