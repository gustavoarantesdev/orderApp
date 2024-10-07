<nav class="navbar  bg-body">
    <div class="container">
        <?php if (isset($_SESSION['user_id'])) { ?>
            <a class="navbar-brand text-info-emphasis d-flex align-items-center" href="<?= BASE_URL . '/order/home' ?>">
                <i class="bi bi-bag-heart-fill" style="font-size: 2rem;"></i>
                <h5 class="ms-2 m-0 mt-1">OrderApp</h5>
            </a>

            <button class="btn text-info-emphasis border-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Abrir menu">
                <i class="bi bi-list" style="font-size: 2rem;"></i>
            </button>

            <div class="offcanvas offcanvas-end p-2" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

                <div class="offcanvas-header text-info-emphasis pb-0">
                        <i class="bi bi-bag-heart-fill" style="font-size: 2rem;"></i>
                        <h4 class="offcanvas-title ms-2 mt-1" id="offcanvasNavbarLabel">OrderApp</h4>
                    <button type="button" class="position-absolute text-info-emphasis end-0 me-3 btn p-0 border-0 d-flex align-items-center justify-content-center" data-bs-dismiss="offcanvas" aria-label="Fechar menu" style="width: 2rem; height: 2rem; border-radius: 50%;">
                        <i class="bi bi-x" style="font-size: 2.3rem;"></i>
                    </button>
                </div>

                <div class="offcanvas-body pt-0">
                <hr>
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active fs-5" href="<?= BASE_URL . '/order/home' ?>">
                                <i class="bi bi-bag-heart"></i>
                                Suas encomendas
                            </a>
                        </li>
                        <li class="nav-item pt-2">
                            <a class="nav-link active fs-5" href="<?= BASE_URL . '/order/create' ?>">
                                <i class="bi bi-bag-plus"></i>
                                Cadastrar encomenda
                            </a>
                        </li>
                        <li class="nav-item pt-2">
                            <a class="nav-link active fs-5" href="<?= BASE_URL . '/order/show' ?>">
                                <i class="bi bi-bag"></i>
                                Todas encomendas
                            </a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link text-danger active fs-5" href="<?= BASE_URL . '/logout' ?>">
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
                <h5 class="ms-2 m-0 mt-1">OrderApp</h5>
            </a>
        <?php } ?>
    </div>
</nav>