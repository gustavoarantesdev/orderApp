// Máscara para formatar os input.
$(document).ready(function () {
    $('.phone_with_ddd').mask('(00) 00000-0000');
    $('.cpf').mask('000.000.000-00');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.money').mask('00.000,00', { reverse: true });
});