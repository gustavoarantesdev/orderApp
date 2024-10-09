<main style="margin-top: 100px">
    <section class="container">
        <div class="bg-body rounded-5 p-3 shadow border col-md-8 col-lg-6 mx-auto">

            <div class="d-flex flex-column align-items-center justify-content-center">
                <h1 class="text-danger" style="font-size: 5rem;"><strong>Oops!</strong></h1>
                <h4 class="text-danger-emphasis mt-3">500 - Error Interno.</h4>

                <!-- Botão retornar -->
                <div class="mt-3">
                    <button class="btn bg-body-secondary rounded-5 d-flex align-items-center justify-content-center"
                        type="button" style="width: 9rem;" onclick="window.location='<?= BASE_URL ?>'">
                        <p class="m-0"><strong>Retorne</strong></p>
                        <i class="bi bi-arrow-left ms-3" style="font-size: 1.5rem;"></i>
                    </button>
                </div>
            </div>

        </div>
    </section>
</main>