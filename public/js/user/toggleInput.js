/**
 * Script responsável por habilitar a edição do input.
 */
document.addEventListener('click', function (event) {
    if (event.target.matches('[data-toggle-input]')) {
        let inputId = event.target.getAttribute('data-toggle-input');
        let input = document.getElementById(inputId);

        if (input) {
            input.toggleAttribute('disabled'); // Alterna o atributo "disabled"
        }
    }
});
