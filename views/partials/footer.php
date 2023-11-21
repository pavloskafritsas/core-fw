<?php

use Pk\Core\Helpers\Url; ?>

<footer class="border-solid-black bg-color">
    <!--δημιουργία συνδέσμου που ανοίγει αρχείο pdf, με target=_blank για να ανοίγει σε ξεχωριστή σελίδα-->
    <a href="<?= Url::asset('uploads\Όροι χρήσης διαδικτυακού τόπου.pdf') ?>" target="_blank">Όροι Χρήσης</a>
    <span class="px-2"> | </span>
    <a href="<?= Url::asset('uploads\Πολιτική προστασίας προσωπικών δεδομένων.pdf') ?>" target="_blank">Πολιτική Απορρήτου</a>
</footer>
</body>

</html>