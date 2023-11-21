<?php
if (
    isset($_SESSION['flash_data']) && isset($_SESSION['flash_data']['errors'])
) {
    echo '<div class="invalid-feedback d-block">';

    foreach ($_SESSION['flash_data']['errors'] as $error) {
        echo "<p>$error</p>";
    }

    echo '</div>';
}
