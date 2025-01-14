// Função para exibir ou ocultar o input de CPF/CNPJ
function togglePersonType() {
    const personTypeCpfDiv = $('#person_type_cpf_div');
    const personTypeCnpjDiv = $('#person_type_cnpj_div');

    const genderDiv = $('#gender_div');
    const birthDateDiv = $('#birth_date_div');

    const personTypeCpfInput = $('#person_type_cpf_input');
    const personTypeCnpjInput = $('#person_type_cnpj_input');

    const genderInput = $('#gender_input');
    const birthDateInput = $('#birth_date_input');

    const personType = $('#person_type').val();

    // Exibe ou oculta o campo CNPJ com base no tipo de cliente
    if (personType === 'PJ') {
        // Exibe o campo CNPJ e esconde o CPF
        personTypeCnpjDiv.removeClass('d-none');
        personTypeCpfDiv.addClass('d-none');

        // Esconde os campos de gênero e data de nascimento para PJ
        genderDiv.addClass('d-none');
        birthDateDiv.addClass('d-none');

        // Remove obrigatoriedade de gênero e data de nascimento
        genderInput.prop('required', false).val('');
        birthDateInput.prop('required', false).val('');

        // Define "required" para CNPJ e remove para CPF
        personTypeCnpjInput.prop('required', true);
        personTypeCpfInput.prop('required', false).val('');
    } else if (personType == 'PF') {
        // Exibe o campo CPF e esconde o CNPJ
        personTypeCpfDiv.removeClass('d-none');
        personTypeCnpjDiv.addClass('d-none');

        // Exibe os campos de gênero e data de nascimento para PF
        genderDiv.removeClass('d-none');
        birthDateDiv.removeClass('d-none');

        // Define obrigatoriedade para gênero e data de nascimento
        genderInput.prop('required', true);
        birthDateInput.prop('required', true);

        // Define "required" para CPF e remove para CNPJ
        personTypeCpfInput.prop('required', true);
        personTypeCnpjInput.prop('required', false).val('');
    }
}

$(document).ready(function () {
    // Chama a função imediatamente quando a página for carregada
    togglePersonType();

    // Executa a função sempre que o tipo de cliente for alterado
    $('#person_type').on('change', function () {
        togglePersonType();
    });
});