<?php include 'partials/header.php'; ?>
<?php include 'partials/topbar.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<!--Page content-->
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="pb-5">
                    <h1 class="text-center">Εγγραφή Χρήστη</h1>
                    <span>
                        Παρακαλώ εισάγετε όλα τα υποχρεωτικά πεδία (*) και πατήστε το
                        κουμπί "Εγγραφή"
                    </span>
                </div>
                <?php include 'partials/forms/register.php' ?>

                <a href="/login" class="d-block my-2">Αν έχετε ήδη λογαριασμό, πατήστε εδώ για να συνδεθείτε</a>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php' ?>