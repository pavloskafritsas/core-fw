<?php

use Pk\Core\Helpers\View; ?>

<form action="/login" method="post">
    <div class="mb-3 row align-items-center justify-content-center">
        <!--ονομασία πεδίου, όπου το for παρέχει δυνατότητα για χρήση και απο Α.Μ.Ε.Α.-->
        <label for="login_amka" class="col-sm-2 col-form-label">
            Α.Μ.Κ.Α.
        </label>
        <!--πεδίο καταχώρησης στοιχείων-->
        <div class="col-12 col-sm-4">
            <input class="form-control" id="login_amka" name="amka" value="<?= View::old('amka') ?>" />
        </div>
    </div>

    <div class=" mb-3 row align-items-center justify-content-center">
        <label for="login_afm" class="col-sm-2 col-form-label">Α.Φ.Μ.</label>

        <div class="col-12 col-sm-4">
            <input class="form-control" id="login_afm" name="afm" value="<?= View::old('afm') ?>" />
        </div>
    </div>
    <!--κουμπί για είσοδο-->
    <div class="pb-2">
        <button class="btn btn-primary" type="submit">Είσοδος</button>
    </div>
</form>

<?php include 'errors.php';
