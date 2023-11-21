<?php

use Pk\Core\Helpers\Auth; ?>

<div class="sidebar">
    <a href="/">Αρχική Σελίδα</a>
    <a href="/vac_centers">Εμβολιαστικά Κέντρα</a>
    <a href="/vac_guide">Οδηγίες Εμβολιασμού</a>
    <a href="/signin">Οδηγίες εγγραφής / Εισόδου</a>
    <a href="/anakoinoseis">Ανακοινώσεις</a>
    <?php if (Auth::check()) {
        echo '<a href="/me">Το προφίλ μου</a>';
    } ?>
</div>