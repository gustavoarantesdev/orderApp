<nav class="navbar bg-body">
    <div class="container">
        <?php if (isset($_SESSION['user_id'])) { ?>
            <!-- Logo a esquerda -->
            <a class="navbar-brand text-info-emphasis d-flex align-items-center" href="<?= BASE_URL . '/encomenda/home' ?>">
                <i class="bi bi-bag-heart-fill" style="font-size: 2rem;"></i>
                <h1 class="ms-2 m-0 mt-1 fs-5">OrderApp</h1>
            </a>

            <!-- Botão de abrir o menu -->
            <button class="btn text-info-emphasis border-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Abrir menu">
                <i class="bi bi-list" style="font-size: 2rem;"></i>
            </button>

            <!-- Conteúdo do menu -->
            <div class="offcanvas offcanvas-end p-2" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

                <!-- Logo do menu -->
                <div class="offcanvas-header text-info-emphasis pb-0">
                        <i class="bi bi-bag-heart-fill" style="font-size: 2rem;"></i>
                        <h1 class="offcanvas-title ms-2 mt-1 fs-5" id="offcanvasNavbarLabel">OrderApp</h1>

                    <!-- Botão de fechar o menu -->
                    <button type="button" class="position-absolute text-info-emphasis end-0 me-3 btn p-0 border-0 d-flex align-items-center justify-content-center" data-bs-dismiss="offcanvas" aria-label="Fechar menu" style="width: 2rem; height: 2rem; border-radius: 50%;">
                        <i class="bi bi-x" style="font-size: 2.3rem;"></i>
                    </button>
                </div>

                <!-- Elementos do menu -->
                <div class="offcanvas-body pt-0">
                    <hr class="w-100 mx-auto">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                        <!-- Encomendas -->
                        <h2 class="fs-5 fw-bold">Encomendas</h2>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="<?= BASE_URL . '/encomenda/home' ?>">
                                <i class="bi bi-bag-heart"></i>
                                Suas encomendas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="<?= BASE_URL . '/encomenda/cadastrar' ?>">
                                <i class="bi bi-bag-plus"></i>
                                Cadastrar encomenda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="<?= BASE_URL . '/encomenda/todas' ?>">
                                <i class="bi bi-bag"></i>
                                Todas encomendas
                            </a>
                        </li>

                        <hr class="w-100 mx-auto">

                        <!-- Clientes -->
                        <h2 class="fs-5 fw-bold">Clientes</h2>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="<?= BASE_URL . '/cliente/cadastrar' ?>">
                                <i class="bi bi-person-plus"></i>
                                Cadastrar cliente
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="<?= BASE_URL . '/cliente/todos' ?>">
                                <i class="bi bi-people"></i>
                                Todos clientes
                            </a>
                        </li>

                        <hr class="w-100 mx-auto">

                        <!-- Produtos -->
                        <h2 class="fs-5 fw-bold">Produtos</h2>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="<?= BASE_URL . '/produto/cadastrar' ?>">
                                <i class="bi bi-tag"></i>
                                Cadastrar produto
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="<?= BASE_URL . '/produto/todos' ?>">
                                <i class="bi bi-box"></i>
                                Todos produtos 
                            </a>
                        </li>

                        <hr class="w-100 mx-auto">

                        <h2 class="fs-5 fw-bold">Conta</h2>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="<?= BASE_URL . "/usuario/editar/{$_SESSION['user_id']}" ?>">
                                <i class="bi bi-person-circle"></i>
                                Editar conta
                            </a>
                        </li

                        <li class="nav-item">
                            <a class="nav-link text-danger fs-5" href="<?= BASE_URL . '/logout' ?>">
                                <i class="bi bi-box-arrow-in-left"></i>
                                Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </div
        <?php } else { ?>
            <a class="navbar-brand text-info-emphasis d-flex align-items-center" href="<?= BASE_URL ?>">
                <i class="bi bi-bag-heart-fill" style="font-size: 2rem;"></i>
                <h1 class="ms-2 m-0 mt-1 fs-5">OrderApp</h1>
            </a>
        <?php } ?>
    </div>
</nav>