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

const productId = document.getElementById('productIdInput');
const productName = document.getElementById('productNameInput');
const productSellPrice = document.getElementById('productSellPriceInput');
const productQuantity = document.getElementById('productQuantityInput');

// Preenche os campos de valor unitário e quantidade de acordo com o item selecionado.
document.getElementById('productNameInput').addEventListener('change', function () {
    const productSelectedName = this.value;
    const options = document.querySelectorAll('#productDatalist option');

    options.forEach(option => {
        if (option.value === productSelectedName) {
            productId.value = option.dataset.productId;

            productSellPrice.value = option.dataset.productSellPrice;
            productQuantity.value = 1;

            // Disparar eventos manualmente após alterar os valores
            productSellPrice.dispatchEvent(new Event('input'));
            productQuantity.dispatchEvent(new Event('change'));
        }
    });
});