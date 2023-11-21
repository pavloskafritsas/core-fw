<?php include 'partials/header.php'; ?>
<?php include 'partials/topbar.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<!--Page content-->
<div class="main">
  <!--φτιάχνουμε ένα container με δύο στήλες και μία γραμμή-->
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <div class="pb-5">
          <h1 class="text-center">Είσοδος Χρήστη</h1>
          <span>
            Παρακαλώ εισάγετε τον Α.Μ.Κ.Α. και τον Α.Φ.Μ. που δηλώσατε κατά
            την εγγραφή σας και πατήστε το κουμπί "Είσοδος"
          </span>
        </div>

        <!--δημιουργία φόρμας για καταχώρηση απαιτούμενων στοιχείων εισόδου-->
        <?php include 'partials/forms/login.php' ?>

        <span class="d-block my-2">
          Για την είσοδό σας θα πρέπει να έχει προηγηθεί η εγγραφή στην
          πλατφόρμα.
        </span>

        <a href=" /register" class="my-2 d-block">Πατήστε εδώ για εγγραφή</a>
      </div>
    </div>
  </div>
</div>

<?php include 'partials/footer.php' ?>