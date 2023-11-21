<?php

use Pk\Core\Helpers\View; ?>

<?php require 'partials/header.php'; ?>

<?php require 'partials/topbar.php'; ?>

<!--sidebar με μορφοποίηση απο css-->
<?php require 'partials/sidebar.php'; ?>

<!--Page content-->
<div class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form method="POST" action="/me/vaccination_centers">
                    <div class="col col-12">
                        <select required class="form-select form-select mb-3" name="vaccination_center_id" id="vaccination_center_id">
                            <option value="">Επιλέξτε εμβολιαστικό κέντρο</option>

                            <?php foreach ($vaccinationCenters as $vaccinationCenter) {
                                if (View::old('vaccination_center_id') === $vaccinationCenter->id) {
                                    echo "<option value='{$vaccinationCenter->id}' selected>{$vaccinationCenter->name}</option>";
                                } else {
                                    echo "<option value='{$vaccinationCenter->id}'>{$vaccinationCenter->name}</option>";
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">Αποθήκευση</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'partials/footer.php' ?>