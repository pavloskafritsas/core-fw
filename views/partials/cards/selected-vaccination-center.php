<div class="mb-3">
    <div class="row">
        <div class="col-6 text-end">
            Όνομα:
        </div>
        <div class="col-6">
            <span class="fw-bolder"><?= $vaccinationCenter->name ?></span>
        </div>
    </div>

    <div class="row">
        <div class="col-6 text-end">
            Διεύθυνση:
        </div>
        <div class="col-6">
            <span class="fw-bolder"><?= $vaccinationCenter->address ?></span>
        </div>
    </div>


    <div class="row">
        <div class="col-6 text-end">
            TK:
        </div>
        <div class="col-6">
            <span class="fw-bolder"><?= $vaccinationCenter->zip_code ?></span>
        </div>
    </div>

    <div class="row">
        <div class="col-6 text-end">
            Τηλέφωνο:
        </div>

        <div class="col-6">
            <a href="tel:<?= $vaccinationCenter->phone ?>" class="fw-bolder"><?= $vaccinationCenter->phone ?></a>
        </div>
    </div>
</div>