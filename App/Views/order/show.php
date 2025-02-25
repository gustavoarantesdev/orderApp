<?php

use App\Helpers\FlashMessage;

FlashMessage::render()

?>

<main style="margin-bottom: 7rem;">
    <section class="container">
        <!-- Título -->
        <h1 class="text-center" style="font-size: 1.8rem; margin-top: 1.5rem; margin-bottom: 3.5rem;">
            Todas Encomenda
        </h1>
        <div class="col mt-5 card p-3 rounded-5 shadow">
            <div class="card-body table-responsive">
                <table class="table align-middle text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Entrega</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Situação Pagamento</th>
                            <th scope="col">Forma Pagamento</th>
                            <th scope="col">Status</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Editar</th>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($viewData as $orderData) { ?>
                            <tr>
                                <td><?= htmlspecialchars($orderData->order_number) ?></td>
                                <td><?= htmlspecialchars($orderData->customer_name) ?></td>
                                <td><?= htmlspecialchars($orderData->completion_date) ?></td>
                                <td>R$ <?= htmlspecialchars($orderData->subtotal) ?></td>
                                <td><?= $orderData->payment_status ?></td>
                                <td><?= htmlspecialchars($orderData->payment_method) ?></td>
                                <td><?= $orderData->order_status ?></td>
                                <td><?= $orderData->order_situation ?></td>
                                <td>
                                    <button class="btn bg-body-secondary p-2 lh-1 rounded-5" type="button"
                                        title="Editar Encomenda"
                                        onclick="window.location='<?= BASE_URL . '/encomenda/editar/' . htmlspecialchars($orderData->id) ?>'">
                                        <i class="bi bi-three-dots-vertical" style="font-size: 1.3em;"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Botão nova encomenda -->
        <div class="position-fixed bottom-0 end-0 m-4">
            <button
                class="btn bg-success-subtle text-success-emphasis rounded-5 p-3 shadow d-flex align-items-center justify-content-center"
                type="button" title="Nova Encomenda"
                onclick="window.location='<?= BASE_URL . '/encomenda/cadastrar' ?>'" style="width: 4rem; height: 4rem;">
                <i class="bi bi-plus" style="font-size: 2rem;"></i>
            </button>
        </div>
    </section>
</main>