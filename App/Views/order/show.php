<main>
    <section>
        <div class="container mt-3 mb-3">
            <div class="p-3">
                <h4 class="mb-4 text-center">Todas Encomendas</h4>
            </div>
            <div class="card p-3 rounded-5 shadow">
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ENCOMENDA</th>
                                <th scope="col">CLIENTE</th>
                                <th scope="col">ENTREGA</th>
                                <th scope="col">PREÇO</th>
                                <th scope="col">PAGAMENTO</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">EDITAR</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($data as $order) { ?>
                                <tr>
                                    <td><?= $order->order_id ?></td>
                                    <td><?= $order->order_title ?></td>
                                    <td><?= $order->client_name ?></td>
                                    <td><?= $order->completion_date ?></td>
                                    <td><?= "R$ $order->order_price" ?></td>
                                    <td><?= $order->payment_method ?></td>
                                    <td><?= $order->order_status ?></td>
                                    <td>
                                        <button class="btn bg-primary-subtle p-2 lh-1 rounded-5" type="button"
                                            onclick="window.location='<?= BASE_URL . '/order/edit/' . $order->order_id ?>'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path
                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Botão nova encomenda -->
        <div class="position-fixed bottom-0 end-0 m-4">
            <button
                class="btn bg-info-subtle text-info-emphasis rounded-5 p-3 shadow d-flex align-items-center justify-content-center"
                type="button" onclick="window.location='<?= BASE_URL . '/order/create' ?>'" alt="Nova encomenda"
                style="width: 4rem; height: 4rem;">
                <i class="bi bi-plus" style="font-size: 2rem;"></i>
            </button>
        </div>
        </sectio>
</main>