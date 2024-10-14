// Validação do formulário, script do Bootstrap.
(() => {
    'use strict'

    // Busca todos os campos que será aplicado a validação.
    const forms = document.querySelectorAll('.needs-validation')

    // Loop para evitar enviar um formulário vázio.
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()

// Máscara para formatar o input de dinheiro e quantidade.
$(document).ready(function () {
    $('.order_quantity').mask('0000',  { reverse: true });
    $('.order_price').mask('0.000,00', { reverse: true });
});

// Exibe o input de parcelas se o pagamento for Cartão de Crédito.
$('#order_payment_method').on('change', function () {
    const order_payment_installments_div = $('#order_payment_installments_div');
    if (this.value === '1') { // '1' é o valor para "Cartão de Crédito"
        order_payment_installments_div.removeClass('d-none');
    } else {
            order_payment_installments_div.addClass('d-none');
    }
});