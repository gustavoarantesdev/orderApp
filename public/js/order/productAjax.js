/**
 * Faz o AJAX de protudos, e preenche os campos de produto, ao selecionar um
 * produto.
 */
const xhrProducts = new XMLHttpRequest();

xhrProducts.open('POST', '/orderApp/encomenda/produtos');

xhrProducts.onreadystatechange = function () {
    if (xhrProducts.readyState === 4 && xhrProducts.status === 200) {
        const data = JSON.parse(xhrProducts.responseText);
        const datalist = document.getElementById('productDatalist');

        data.forEach(data => {
            const option = document.createElement('option');
            option.value = data.name;
            option.dataset.productId = data.id;
            option.dataset.productSellPrice = data.sell_price;
            datalist.appendChild(option);
        });
    }
}

xhrProducts.send();

const productIdInput = document.getElementById('productIdInput');
const productNameInput = document.getElementById('productNameInput');
const productSellPriceInput = document.getElementById('productSellPriceInput');
const productQuantityInput = document.getElementById('productQuantityInput');

// Preenche os campos de valor unitário e quantidade de acordo com o item selecionado.
document.getElementById('productNameInput').addEventListener('change', function () {
    const productSelectedName = this.value;
    const options = document.querySelectorAll('#productDatalist option');

    options.forEach(option => {
        if (option.value === productSelectedName) {
            productIdInput.value = option.dataset.productId;
            productSellPriceInput.value = option.dataset.productSellPrice;
            productQuantityInput.value = 1;

            // Disparar eventos manualmente após alterar os valores
            productSellPriceInput.dispatchEvent(new Event('input'));
            productQuantityInput.dispatchEvent(new Event('change'));
        }
    });
});