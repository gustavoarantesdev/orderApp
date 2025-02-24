<?php

use App\Helpers\FlashMessage;

FlashMessage::render()

?>
<main style="margin-bottom: 7rem;">
    <section class="container">
        <!-- Título -->
        <h1 class="text-center" style="font-size: 1.8rem; margin-top: 1.5rem; margin-bottom: 3.5rem;">
            Todos Produtos
        </h1>
        <div class="col mt-5 card p-3 rounded-5 shadow">
            <div class="card-body table-responsive">
                <table class="table align-middle table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Preço de venda</th>
                            <th scope="col">Preço de custo</th>
                            <th scope="col">Status</th>
                            <th scope="col">Editar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($viewData as $data) { ?>
                            <tr>
                                <td><?= htmlspecialchars($data->id) ?></td>
                                <td><?= htmlspecialchars($data->name) ?></td>
                                <td><?= htmlspecialchars($data->sell_price) ?></td>
                                <td><?= htmlspecialchars($data->cost_price) ?></td>
                                <td><?= htmlspecialchars($data->status) ?></td>
                                <td>
                                    <button class="btn bg-body-secondary p-2 lh-1 rounded-5" type="button"
                                        onclick="window.location='<?= BASE_URL . '/produto/editar/' . htmlspecialchars($data->id) ?>'">
                                        <i class="bi bi-three-dots-vertical" style="font-size: 1.3em;"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Botão novo produto -->
        <div class="position-fixed bottom-0 end-0 m-4">
            <button
                class="btn bg-success-subtle text-success-emphasis rounded-5 p-3 shadow d-flex align-items-center justify-content-center"
                type="button" title="Novo Produto" onclick="window.location='<?= BASE_URL . '/produto/cadastrar' ?>'"
                style="width: 4rem; height: 4rem;">
                <i class="bi bi-plus" style="font-size: 2rem;"></i>
            </button>
        </div>
    </section>
</main>
