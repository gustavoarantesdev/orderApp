const subtotal = document.getElementById('subtotal');
const additional = document.getElementById('additional'); // Campo de adicional
const discount = document.getElementById('discount'); // Campo de desconto
const orderItems = document.getElementById('orderItems');

const paymentValueInput = document.getElementById('paymentValue');
let count = 0;
let currentSubtotal = 0;

// Verifica e preenche os inputs se estiverem vazios
function verifyInputs() {
    if (!additional.value || isNaN(formatInputValue(additional.value))) {
        additional.value = '0,00';
    }
    if (!discount.value || isNaN(formatInputValue(discount.value))) {
        discount.value = '0,00';
    }
}

// Formata os valores de entrada (input).
function formatInputValue(value) {
    // Remove espaços e converte vírgula para ponto
    return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
}

// Formata o valor de saída do cálculo.
function formatOutputValue(value) {
    return new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
}

document.getElementById('addOrderItemBtn').addEventListener('click', function () {
    const id = productId.value;
    const name = productName.value;
    const sell = formatInputValue(productSellPrice.value);
    const qtd = formatInputValue(productQuantity.value);

    // Verifica se os inputs estão preenchidos corretamente
    if (name === '' || sell <= 0 || qtd <= 0) {
        return;
    }

    productId.value = '';
    productName.value = '';
    productSellPrice.value = '';
    productQuantity.value = '';

    count++;
    const divId = `item-${count}`;
    const itemTotal = sell * qtd;
    currentSubtotal += itemTotal; // Atualiza o subtotal

    orderItems.innerHTML += `
        <div class="orderItems row g-2 mb-2" id="${divId}">
            <input type="hidden" name="product_id${count}" value="${id}">
            <div class="col-4">
                <input name="product_name${count}" class="form-control bg-body-tertiary rounded-4 p-2" value="${name}" readonly>
            </div>
            <div class="col">
                <input name="product_sell_price${count}" class="form-control bg-body-tertiary rounded-4 p-2" value="${formatOutputValue(sell)}" readonly>
            </div>
            <div class="col">
                <input name="product_quantity${count}" class="form-control bg-body-tertiary rounded-4 p-2" value="${qtd}" readonly>
            </div>
            <div class="col d-flex justify-content-start align-items-center">
                <button data-id="${divId}" data-total="${itemTotal}" class="deleteButton btn bg-danger-subtle text-danger-emphasis rounded-4 d-flex align-items-center justify-content-center"
                    type="button" style="width: 100%; height: 41px;">
                    <i class="bi bi-trash" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <br>
        </div>
    `;

    updateSubtotal();
});

// Delegação de eventos para remover itens corretamente
orderItems.addEventListener('click', function (event) {
    let target = event.target;

    // Se o clique foi no ícone, pega o elemento pai (botão)
    if (target.tagName === 'I') {
        target = target.closest('.deleteButton');
    }

    if (target && target.classList.contains('deleteButton')) {
        const divId = target.getAttribute('data-id');
        const itemTotal = formatInputValue(target.getAttribute('data-total'));

        currentSubtotal -= itemTotal;

        const element = document.getElementById(divId);
        if (element) {
            element.remove();
        }

        updateSubtotal();
    }
});


// Atualiza o subtotal considerando adicional e desconto
function updateSubtotal() {
    verifyInputs(); // Garante que os inputs estejam preenchidos corretamente

    const additionalValue = formatInputValue(additional.value);
    const discountValue = formatInputValue(discount.value);

    // Cálcula o valor do subtotal.
    const finalTotal = currentSubtotal + additionalValue - discountValue;

    // Armazena o resultado do cálculo no input de Subtotal.
    subtotal.value = formatOutputValue(finalTotal);
    // Armazena o valor do cálculo no input de Valor de Pagamento.
    paymentValueInput.value = subtotal.value;
}


// Atualiza o total sempre que adicional ou desconto forem alterados
[additional, discount].forEach((input) => {
    input.addEventListener('change', updateSubtotal);
});


// Executa quando a página de editar a encomenda é carregada.
document.addEventListener('DOMContentLoaded', function () {
    let existingItems = document.querySelectorAll('.orderItems'); // Pega os itens já carregados pelo PHP
    count = existingItems.length; // Atualiza o count com o número correto

    // Recalcula o subtotal inicial somando os itens existentes
    currentSubtotal = 0;
    existingItems.forEach((item) => {
        const price = formatInputValue(item.querySelector('[name^="product_sell_price"]').value);
        const quantity = formatInputValue(item.querySelector('[name^="product_quantity"]').value);
        currentSubtotal += price * quantity;
    });

    updateSubtotal(); // Atualiza os valores com adicional e desconto
});