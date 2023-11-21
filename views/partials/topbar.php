<?php

use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Url;

?>

<!--Header content-->
<header class="border-solid-black bg-color">
    <!--container για την εικόνα, τον τίτλο και το κουμπί εισόδου/εγγραφής στην πλατφόρμα-->
    <!--χωρισμένο σε 3 στήλες-->
    <!--container-fluid για να διατηρεί τη μορφοποίηση όταν στο resize, με δεξί και αριστερό padding-->
    <div class="container-fluid">
        <!--μηδενικό gutter-->
        <div class="row align-items-center g-0">
            <!--λογότυπο-->
            <div class="col-4">
                <a href="/">
                    <img src="<?= Url::asset('img/logo.png') ?>" alt="logo" width="100%" height="auto" style="max-width: 320px" />
                </a>
            </div>
            <!--τίτλος πλατφόρμας-->
            <div class=" col-4">
                <!--Διατήρηση ύψους και ευθυγράμμιση στη μέση και στο κέντρο της στήλης-->
                <div class="fill-height text-center d-flex justify-content-center flex-column align-items-center">
                    <h4 class="font-weight-700">
                        <strong>Πλατφόρμα Εμβολιασμού</strong>
                    </h4>

                    <h5>Υπουργείο Υγείας</h5>
                </div>
            </div>
            <!--κουμπί εισόδου/εγγραφής-->

            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="btn btn-primary" href="<?= Auth::check() ? '/logout' : '/login' ?>">
                    <?= Auth::check() ? 'Αποσύνδεση' : 'Είσοδος / Εγγραφή' ?>
                </a>
            </div>


        </div>
    </div>
</header>