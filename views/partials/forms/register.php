<?php

use Pk\Core\Helpers\View; ?>

<form method="post" action="/users">
    <!--ευθυγράμμηση-->
    <div class="mb-3 row align-items-center justify-content-center">
        <!--χρήση text-danger για να γίνει κόκκινο το αστεράκι-->
        <label for="first_name" class="col-sm-2 col-form-label">
            Όνομα<span class="text-danger">*</span>
        </label>

        <div class="col-12 col-sm-4">
            <input required onkeyup="isValid('first_name', /^[\p{Letter},\s]{3,20}$/u)" class="form-control" id="first_name" name="first_name" value="<?= View::old('first_name') ?>" />
        </div>
    </div>

    <div class="mb-3 row align-items-center justify-content-center">
        <label for="last_name" class="col-sm-2 col-form-label">
            Επώνυμο<span class="text-danger">*</span>
        </label>

        <div class="col-12 col-sm-4">
            <input required onkeyup="isValid('last_name', /^[\p{Letter},\s]{3,20}$/u)" class="form-control" id="last_name" name="last_name" value="<?= View::old('last_name') ?>" />
        </div>
    </div>

    <div class="mb-3 row align-items-center justify-content-center">
        <label for="amka" class="col-sm-2 col-form-label">
            Α.Μ.Κ.Α.<span class="text-danger">*</span>
        </label>

        <div class="col-12 col-sm-4">
            <input required onkeyup="isValid('amka', /^\d{11}$/)" class="form-control" id="amka" name="amka" value="<?= View::old('amka') ?>" />
        </div>
    </div>

    <div class="mb-3 row align-items-center justify-content-center">
        <label for="afm" class="col-sm-2 col-form-label">
            Α.Φ.Μ.<span class="text-danger">*</span>
        </label>

        <div class="col-12 col-sm-4">
            <input required onkeyup="isValid('afm', /^\d{9}$/)" class="form-control" id="afm" name="afm" value="<?= View::old('afm') ?>" />
        </div>
    </div>

    <div class="mb-3 row align-items-center justify-content-center">
        <label for="adt" class="col-sm-2 col-form-label">
            Αριθμός Ταυτότητας<span class="text-danger">*</span>
        </label>

        <div class="col-12 col-sm-4">
            <input required onkeyup="isValid('adt', /^[Α-ωα-ω]{2}\d{6}$/u)" class="form-control" id="adt" name="adt" value="<?= View::old('adt') ?>" />
        </div>
    </div>

    <div class="mb-3 row align-items-center justify-content-center">
        <label for="dob" class="col-sm-2 col-form-label">
            Ημ/νια γέννησης<span class="text-danger">*</span>
        </label>

        <div class="col-12 col-sm-4">
            <input required onkeyup="isValid('dob', /^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/)" type="date" min="1900-01-01" max="" class="form-control" id="dob" name="dob" value="<?= View::old('dob') ?>" />
        </div>
    </div>

    <div class=" mb-3 row align-items-center justify-content-center">
        <label for="gender" class="col-sm-2 col-form-label">
            Φύλο
        </label>

        <div class="col-12 col-sm-4">
            <select oninput="isValid('gender', /^$|^NULL$|^male$|^female$/)" class="form-select form-select mb-3" name="gender" id="gender">
                <option <?= in_array(View::old('gender'), ['', null], true)  ? 'selected' : null ?>></option>
                <option <?= View::old('male') === 'male' ? 'selected' : null ?> value="male">Άνδρας</option>
                <option <?= View::old('female') === 'female' ? 'selected' : null ?> value="female">Γυναίκα</option>
            </select>
        </div>
    </div>

    <div class="mb-3 row align-items-center justify-content-center">
        <label for="email" class="col-sm-2 col-form-label">
            Email
        </label>

        <div class="col-12 col-sm-4">
            <input onkeyup='isValid("email", /^$|^NULL$|^(([^<>()[\]\\.,;:\s@" ]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)' type="email" class="form-control" id="email" name="email" value="<?= View::old('email') ?>" />
        </div>
    </div>

    <div class="mb-3 row align-items-center justify-content-center">
        <label for="phone" class="col-sm-2 col-form-label">
            Κινητό Τηλέφωνο<span class="text-danger">*</span>
        </label>

        <div class="col-12 col-sm-4">
            <input required onkeyup="isValid('phone', /^69\d{8}$/)" class="form-control" id="phone" name="phone" placeholder="π.χ. 6912345678" value="<?= View::old('phone') ?>" />
        </div>
    </div>

    <div class=" mb-3 row align-items-center justify-content-center">
        <label for="role" class="col-sm-2 col-form-label">
            Ρόλος<span class="text-danger">*</span>
        </label>

        <div class="col-12 col-sm-4">
            <select required oninput="isValid('role', /^citizen$|^doctor$/)" class="form-select form-select mb-3" name="role" id="role">
                <option value=""></option>
                <option <?= View::old('role') === 'citizen' ? 'selected' : null ?> value="citizen">Πολίτης</option>
                <option <?= View::old('role') === 'doctor' ? 'selected' : null ?> value="doctor">Γιατρός</option>
            </select>
        </div>
    </div>

    <!--κουμπί για υποβολή-->
    <div>
        <button class="btn btn-primary" disabled="disabled" type="submit" id="submit">Εγγραφή</button>
    </div>

    <?php include 'errors.php' ?>
</form>

<script lang="js">
    function setMaxDate() {
        const el = document.getElementById('dob');
        el.max = new Date().toISOString().split('T')[0];
    }

    function isValid(elementId, regex) {
        const el = document.getElementById(elementId);
        const value = el.value ?? ''

        if (value.match(regex)) {
            el.classList.remove('is-invalid')
            setSubmitButton()
        } else {
            el.classList.add('is-invalid');
            setSubmitButton('disabled')
        }
    }

    function setSubmitButton(disabled) {
        const submitBtn = document.getElementById('submit');

        if (disabled) {
            submitBtn.setAttribute('disabled', disabled)
        } else {
            for (const el of document.getElementsByTagName('input')) {
                if (
                    el.classList.contains('is-invalid') ||
                    el.hasAttribute('required') && !el.value
                ) {
                    submitBtn.setAttribute('disabled', 'disabled')

                    return;
                }
            };

            submitBtn.removeAttribute('disabled')
        }
    }

    setMaxDate()
</script>