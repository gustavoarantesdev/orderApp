/**
 * Faz o AJAX de clientes, e preenche os campos de cliente, ao selecionar um
 * cliente.
 */
const xhrCustomer = new XMLHttpRequest();

xhrCustomer.open('POST', '/orderApp/encomenda/clientes');

xhrCustomer.onreadystatechange = function () {
    if (xhrCustomer.readyState === 4 && xhrCustomer.status === 200) {
        const data = JSON.parse(xhrCustomer.responseText);
        const datalist = document.getElementById('customerDatalist');

        data.forEach(data => {
            const option = document.createElement('option');
            option.value = data.name;
            option.dataset.customerId = data.id;
            option.dataset.customerPhone = data.phone;
            option.dataset.customerAddress = data.address;
            datalist.appendChild(option);
        });
    }
}

xhrCustomer.send();

// Preenche os campos de dados do cliente, de acordo com o cliente selecionado.
document.getElementById('customerInput').addEventListener('change', function () {
    const selectedName = this.value;
    const options = document.querySelectorAll('#customerDatalist option');

    options.forEach(option => {
        if (option.value === selectedName) {
            document.getElementById('customerId').value = option.dataset.customerId;
            document.getElementById('customerPhone').value = option.dataset.customerPhone;
            document.getElementById('customerAddress').value = option.dataset.customerAddress;
        }
    });
});