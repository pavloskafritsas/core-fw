<div class="card">

    <div class="card-body">
        <h5 class="card-title">
            <i class="me-2 fa-solid <?= $user->role === 'citizen' ? 'fa-user' : 'fa-user-doctor' ?>"></i>
            <span>Στοιχεία χρήστη</span>
        </h5>

        <div class="row">
            <div class="col-6 text-end">
                Όνομα:
            </div>
            <div class="col-6">
                <span class="fw-bolder"><?= $user->first_name ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-6 text-end">
                Επίθετο:
            </div>
            <div class="col-6">
                <span class="fw-bolder"><?= $user->last_name ?></span>
            </div>
        </div>


        <div class="row">
            <div class="col-6 text-end">
                ΑΜΚΑ:
            </div>
            <div class="col-6">
                <span class="fw-bolder"><?= $user->amka ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-6 text-end">
                ΑΦΜ:
            </div>

            <div class="col-6">
                <span class="fw-bolder"><?= $user->afm ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-6 text-end">
                ΑΔΤ:
            </div>
            <div class="col-6">
                <span class="fw-bolder"><?= $user->adt ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-6 text-end">
                Ημ. γέννησης:
            </div>
            <div class="col-6">
                <span class="fw-bolder"><?= $user->dob->format('d/m/Y') ?></span>
            </div>
        </div>

        <?php if ($user->gender) { ?>
            <div class="row">
                <div class="col-6 text-end">
                    Φύλο:
                </div>
                <div class="col-6">
                    <span class="fw-bolder"><?= $user->gender === 'male' ? 'Άνδρας' : 'Γυναίκα' ?></span>
                </div>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-6 text-end">
                Τηλέφωνο:
            </div>
            <div class="col-6">
                <span class="fw-bolder"><?= $user->phone ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-6 text-end">
                Ρόλος:
            </div>
            <div class="col-6">
                <span class="fw-bolder"><?= $user->role === 'citizen' ? 'Πολίτης' : 'Γιατρός' ?></span>
            </div>
        </div>
    </div>

</div>