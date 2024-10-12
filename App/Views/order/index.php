<!-- Pagina inicial com todos as encomendas disponíveis -->
<?php

use App\Helpers\FlashMessage;

FlashMessage::render();

?>

<main style="margin-bottom: 7rem;">
    <section class="container my-3">
        <h1 class="my-4 text-center" style="font-size: 1.8rem;">Suas Encomendas</h1>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 d-flex justify-content-center">
            <?php foreach ($ordersData as $orderData) { ?>
                <!-- Encomenda -->
                <div class="col mt-5" style="min-width: 22rem;">
                    <div class="position-relative rounded-5 p-3 border shadow">
                        <p hidden><?= $orderData->order_id ?></p>

                        <!-- Icone da div -->
                        <div class="d-flex justify-content-center" style="margin: -50px auto 10px;">
                            <div class="bg-info-subtle d-flex justify-content-center align-items-center shadow"
                                style="width: 4rem; height: 4rem; border-radius: 100%;">
                                <i class="bi bi-bag-heart text-info-emphasis" style="font-size: 1.8rem;"></i>
                            </div>
                        </div>

                        <!-- Alerta da encomenda -->
                        <div class="position-absolute end-0 top-0 mt-3 me-3">
                            <div class="bg-danger-subtle text-danger border border-danger-subtle rounded-5 text-center py-2"
                                style="width: 7rem; height: 2.rem;">
                                <span><strong>Atrasada!</strong></span>
                            </div>
                        </div>

                        <div class="row text-center mt-4 mb-4">
                            <!-- Informações da encomenda -->
                            <div class="row">
                                <div class="col pe-0 mt-3">

                                    <p class="mb-1" style="font-size: 1.1rem;"><strong>Encomenda</strong></p>
                                    <p class="mb-3"><?= $orderData->order_title ?></p>

                                    <div class="px-5">
                                        <hr>
                                    </div>

                                    <p class="mb-1" style="font-size: 1.1rem;"><strong>Entrega</strong></p>
                                    <p class="mb-3"><?= $orderData->completion_date ?></p>

                                    <div class="px-5">
                                        <hr>
                                    </div>

                                    <p class="mb-1" style="font-size: 1.1rem;"><strong>Cliente</strong></p>
                                    <p class="mb-3"><?= $orderData->client_name ?></p>

                                </div>
                            </div>
                        </div>

                        <!-- Botao editar encomenda -->
                        <div class="position-absolute end-0 bottom-0 me-3 mb-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <button class="btn bg-body-secondary p-2 lh-1 rounded-5" type="button"
                                    title="Editar Encomenda"
                                    onclick="window.location='<?= BASE_URL . '/order/edit/' . $orderData->order_id ?>'"
                                    style="width: 3.5rem; height: 3.5rem;">
                                    <i class="bi bi-three-dots-vertical" style="font-size: 1.3em;"></i>
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
                type="button" title="Nova Encomenda" onclick="window.location='<?= BASE_URL . '/order/create' ?>'"
                style="width: 4rem; height: 4rem;">
                <i class="bi bi-plus" style="font-size: 2rem;"></i>
            </button>
        </div>
    </section>
</main>