// Colocar o valor do input em maiúsculo.
$(document).ready(function() {
    $('.to-uppercase').on('blur', function() {
        $(this).val($(this).val().toUpperCase());
    });
});
