<!-- Pagina inicial com todos as encomendas disponíveis -->
<?php

use App\Helpers\FlashMessage;

FlashMessage::render();

?>

<main style="margin-bottom: 7rem;">
    <section class="container">
        <h1 class="my-4 text-center" style="font-size: 1.8rem;">Suas Encomendas</h1>
        <div class="row row-cols-sm-2 row-cols-md-3 g-3 d-flex">
            <?php foreach ($viewData as $orderData) { ?>
                <!-- Encomenda -->
                <div class="col mt-5" style="min-width: 22rem;">
                    <div class="bg-body position-relative rounded-5 p-3 border shadow">
                        <p hidden><?= htmlspecialchars($orderData->id) ?></p>

                        <!-- Número da encomenda -->
                        <div
                            class="badge bg-light-subtle border border-light-subtle text-light-emphasis rounded-pill position-absolute p-2 start-0 ms-3">
                            <?= "#$orderData->order_number" ?>
                        </div>

                        <!-- Icone da div -->
                        <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                            <div class="bg-info-subtle d-flex justify-content-center align-items-center shadow"
                                style="width: 4rem; height: 4rem; border-radius: 100%;">
                                <i class="bi bi-bag-heart text-info-emphasis" style="font-size: 1.8rem;"></i>
                            </div>
                        </div>

                        <!-- Alerta da encomenda -->
                        <div class="position-absolute end-0 top-0 mt-3 me-3">
                            <?= $orderData->order_status ?>
                        </div>

                        <div class="row text-center mt-4 mb-4">
                            <!-- Informações da encomenda -->
                            <div class="row">
                                <div class="col pe-0 mt-3">

                                    <!-- Itens da encomenda -->
                                    <h2 class="mb-1" style="font-size: 1.1rem;"><b>Encomenda</b></h2>
                                    <?php foreach ($orderData->items as $item) { ?>
                                        <p class="mb-1">
                                            <?= htmlspecialchars($item->quantity) . 'x ' . htmlspecialchars($item->product_name) ?>
                                        </p>
                                    <?php } ?>

                                    <hr class="px-5 w-75 mx-auto">

                                    <!-- Dados da entrega -->
                                    <h2 class="mb-1" style="font-size: 1.1rem;"><b>Entrega</b></h2>
                                    <p class="mb-3">
                                        <?= htmlspecialchars($orderData->completion_date) . ' às ' . htmlspecialchars($orderData->completion_time) ?>
                                    </p>

                                    <hr class="px-5 w-75 mx-auto">

                                    <!-- Dados do cliente -->
                                    <h2 class="mb-1" style="font-size: 1.1rem;"><b>Cliente</b></h2>
                                    <p class="mb-3">
                                        <?= htmlspecialchars($orderData->customer_name) ?>
                                    </p>

                                    <hr class="px-5 w-75 mx-auto">

                                    <!-- Informaões auxiliares -->
                                    <div class="mb-5">
                                        <span
                                            class="badge bg-info-subtle border border-info-subtle text-info-emphasis rounded-pill text-center">
                                            Total R$ <?= $orderData->subtotal ?>
                                        </span>
                                        <?= $orderData->payment_status ?>
                                        <?= $orderData->withdraw ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botao editar encomenda -->
                        <div class="position-absolute end-0 bottom-0 me-3 mb-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <button class="btn bg-body-secondary p-2 lh-1 rounded-5" type="button"
                                    title="Editar Encomenda"
                                    onclick="window.location='<?= BASE_URL . '/encomenda/editar/' . htmlspecialchars($orderData->id) ?>'"
                                    style="width: 3.5rem; height: 3.5rem;">
                                    <i class="bi bi-three-dots-vertical" style="font-size: 1.5em;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
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