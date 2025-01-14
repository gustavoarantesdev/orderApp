// Script de validação no frontend para evitar enviar o formulário vazio.
// Script JS retirado do site do Bootstrap 5.3.
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