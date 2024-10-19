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

// Função para exibir ou ocultar o input de parcelas
function toggleInstallments() {
    const order_payment_installments_div = $('#order_payment_installments_div');
    const paymentMethod = $('#order_payment_method').val();
    
    if (paymentMethod === '1') { // '1' é o valor para "Cartão de Crédito"
        order_payment_installments_div.removeClass('d-none');
    } else {
        order_payment_installments_div.addClass('d-none');
    }
}

// Verifica o método de pagamento ao carregar a página
$(document).ready(function() {
    toggleInstallments(); // Executa a função quando a página carrega

    // Exibe o input de parcelas se o pagamento for Cartão de Crédito ao alterar o método de pagamento
    $('#order_payment_method').on('change', function () {
        toggleInstallments(); // Executa a função sempre que o método de pagamento é alterado
    });
});