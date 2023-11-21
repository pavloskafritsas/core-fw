<?php $errors = $_SESSION['flash_data']['errors'] ?? []; ?>

<div class="card my-2">
    <div class="card-body">
        <h5 class="card-title">
            <i class="me-2 fa-solid fa-building"></i>
            <span>Εμβολιαστικό κέντρο</span>
        </h5>

        <div class="row">
            <div class="col-12">

                <?php if ($vaccinationCenter) {
                    require 'selected-vaccination-center.php';
                } else {
                    echo '
                        <div class="text-center">
                            <p>Δεν έχετε επιλέξει εμβολιαστικό κέντρο.</p>
                        </div>';
                } ?>

                <div class="text-center">
                    <button onclick="selectVaccinationCenter()" class="btn btn-primary">Επιλογή εμβολιαστικού κέντρου</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card my-2">
    <div class="card-body">
        <h5 class="card-title">
            <i class="me-2 fa-solid fa-calendar-days"></i>
            <span>Προγραμματισμένα ραντεβού</span>
        </h5>

        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <a class="btn btn-primary" href="/me/appointments">Προβολή</a>
                    <a class="btn btn-primary" href="/me/appointments/report">Στατιστικά</a>
                </div>
            </div>
        </div>
    </div>
</div>

<button id="modal-activator-btn" type="button" class="d-none" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa-solid fa-triangle-exclamation me-1"></i>
                <h5 class="modal-title" id="staticBackdropLabel">Ειδοποίηση</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>
                    Η δήλωση Εμβολιαστικού Κέντρου έχει ήδη πραγματοποιηθεί.
                </span>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Κλείσιμο</button>
            </div>
        </div>
    </div>
</div>

<div class="text-center">
    <!-- Modal - error -->
    <?php require __DIR__ . './../forms/errors.php'; ?>
</div>

<script lang="js">
    function selectVaccinationCenter() {
        const xhttp = new XMLHttpRequest();

        xhttp.open("GET", "/me/canSelectVaccinationCenter", true);
        xhttp.send();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                const res = JSON.parse(this.response);

                if (!res.can_select_vaccination_center) {
                    document.getElementById('modal-activator-btn').click();
                } else {
                    window.location.href = '/me/vaccination_centers';
                }

            }
        };
    }
</script>