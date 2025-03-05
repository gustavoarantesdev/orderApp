/**
 * Faz o calculo do subtotal da encomenda, de acordo com o item adicionado ou removido.
 */
const subtotalInput = document.getElementById('subtotal');
const additionalInput = document.getElementById('additional');
const discountInput = document.getElementById('discount');

// Valor do subtotal
let currentSubtotal = 0;

/**
 * Formata o valor de preço para um número válido.
 */
function parsePrice(price) {
    return Number(price.trim().replace(',', '.'));
}

/**
 * Formata o valor de quantidade para um número válido.
 */
function parseQuantity(quantity) {
    return Number(quantity.trim());
}

/**
 * Ajusta valores com precisão de centavos.
 */
function roundToCents(price) {
    return Math.round(price * 100) / 100;
}

/**
 * Formata um valor monetário para moeda BRL.
 */
function formatCurrency(price) {
    return new Intl.NumberFormat('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(price);
}

/**
 * Garante que os inputs adicional e desconto tenham valores válidos.
 */
function verifyInputs() {
    if (!additionalInput.value || isNaN(parsePrice(additionalInput.value))) {
        additionalInput.value = '0,00';
    }

    if (!discountInput.value || isNaN(parsePrice(discountInput.value))) {
        discountInput.value = '0,00';
    }
}


// Formata o o valor de preço para o formato BRL.
function formatOutputValue(price) {
    return new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(price);
}

/**
 * Calcula o valor total de um item.
 */
function calcItemTotal(quantity, price) {
    return roundToCents(quantity * price);
}

/**
 * Atualiza o subtotal somando ou subtraindo um valor.
 */
function updateSubtotalValue(totalPrice, isAddition = true) {
    currentSubtotal = roundToCents(isAddition ? currentSubtotal + totalPrice : currentSubtotal - totalPrice);
    subtotalInput.value = formatCurrency(currentSubtotal);
    updateFinalSubtotal();
}

/**
 * Atualiza o subtotal considerando adicional e desconton.
 */
function updateFinalSubtotal() {
    // Verifica se os inputs estão preenchidos.
    verifyInputs();

    const additionalValue = parsePrice(additionalInput.value);
    const discountValue = parsePrice(discountInput.value);
    const finalSubtotal = roundToCents(currentSubtotal + additionalValue - discountValue);

    subtotalInput.value = formatCurrency(finalSubtotal);
}

// Atualiza o subtotal sempre que o adicional ou desconto forem alterados.
[additionalInput, discountInput].forEach((input) => {
    input.addEventListener('change', updateFinalSubtotal);
});


/**
 * Calcula o subtotal ao carregar a página.
 */
document.addEventListener('DOMContentLoaded', () => {
    let existingItems = document.querySelectorAll('.orderItems');
    currentSubtotal = 0;

    existingItems.forEach((item) => {
        const price = parsePrice(item.querySelector('[name^="product_sell_price"]').value);
        const quantity = parseQuantity(item.querySelector('[name^="product_quantity"]').value);

        currentSubtotal = roundToCents(currentSubtotal + calcItemTotal(quantity, price));
    });

    updateFinalSubtotal();
});