/**
 * Script para exibir ou ocultar o input de parcelas quando o pagamamento é
 * cartão de crédito.
 */
const paymentMethod = document.getElementById('paymentMethod');

// Executa a função quando a forma de pagamento é alterada
paymentMethod.addEventListener('change', function () {
    toggleInstallments();
});

// Executa a função quando a página é carregada
document.addEventListener('DOMContentLoaded', function () {
    toggleInstallments();
})

/**
 * Verifica se a forma de pagamento é cartão de crédito, se for aparece
 * o select para escolher a quantidade de parcelas
 */
function toggleInstallments() {
    const installmentsDiv = document.getElementById('installmentsDiv');

    if (paymentMethod.value === '1') { // '1' é o valor para "Cartão de Crédito"
        installmentsDiv.classList.remove('d-none');
    } else {
        installmentsDiv.classList.add('d-none');
    }
}
