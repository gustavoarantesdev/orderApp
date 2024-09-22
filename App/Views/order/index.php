<!-- Pagina inicial com todos os pedios disponiveis -->
<main>
    <article>
        <div class="container mt-3 mb-3">
            <div class="p-3">
                <h4 class="card-title mb-4 text-center">Suas Encomendas</h4>
                <div class="row row-cols-1 row-cols-md-3 g-3">

                    <?php foreach ($data as $order) { ?>
                        <!-- Card encomenda -->
                        <div class="col ">
                            <div class="card rounded-5 shadow">
                                <div class="card-body text-center">
                                    <p hidden><?= $order->order_id ?></p>

                                    <div class="mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-bag-heart" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M14 14V5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1M8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132" />
                                        </svg>
                                    </div>

                                    <p class="card-title">ENCOMENDA</p>
                                    <p class="card-text"><strong><?= $order->order_title ?></strong></p>
                                    <hr>

                                    <p class="card-title">CLIENTE</p>
                                    <p class="card-text"><strong><?= $order->client_name ?></strong></p>
                                    <hr>

                                    <p class="card-title">ENTREGA</p>
                                    <p class="card-text"><strong><?= $order->completion_date ?></strong></p>
                                    <hr>

                                    <p class="card-title">PREÇO</p>
                                    <p class="card-text"><strong><?= 'R$ ' . $order->order_price ?></strong></p>
                                    <hr>

                                    <p class="card-title">PAGAMENTO</p>
                                    <p class="card-text"><strong><?= $order->payment_method ?></strong></p>
                                    <hr>

                                    <p class="card-text text-secondary"><small><?= $order->days_count ?></small></p>

                                    <!-- Botão editar encomenda -->
                                    <button class="btn bg-body-secondary p-3 lh-1 rounded-5" type="button" onclick="window.location='<?= BASE_URL . '/edit/' . $order->order_id?>'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="position-fixed bottom-0 end-0 m-5">
                <!-- Botão nova encomenda -->
                <button class="btn bg-info-subtle text-info-emphasis rounded-5 p-3 lh-1 shadow" type="button" onclick="window.location='/orderApp/create'" alt="Nova encomenda">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                    </svg>
                </button>
            </div>
    </article>
</main>