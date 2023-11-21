<?php

use Pk\Core\Helpers\Auth; ?>

<?php require 'partials/header.php'; ?>

<?php require 'partials/topbar.php'; ?>

<?php require 'partials/sidebar.php'; ?>

<!--Page content-->
<div class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php require 'partials/cards/user.php' ?>
            </div>
            <div class="col-12">
                <?php require 'partials/cards/appointment-' . Auth::user()->role . '.php' ?>
            </div>
        </div>
    </div>
</div>

<?php require 'partials/footer.php' ?>