/**
 * Deleta o item da encomenda.
 */
orderItems.addEventListener('click', function (event) {
    let target = event.target;

    // Se o clique foi no ícone, pega o elemento pai (botão)
    if (target.tagName === 'I') {
        target = target.closest('.deleteButton');
    }

    if (target && target.classList.contains('deleteButton')) {
        const divId = target.getAttribute('data-id');
        // Armazena o preço do item
        const finalItemPrice = parsePrice(target.getAttribute('data-item-total'));

        // Subtrai o preço do item no subtotal
        updateSubtotalValue(finalItemPrice, false);

        const element = document.getElementById(divId);
        if (element) {
            element.remove();
        }
    }
});