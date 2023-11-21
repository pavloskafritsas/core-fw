<?php require 'partials/header.php'; ?>

<?php require 'partials/topbar.php'; ?>

<!--sidebar με μορφοποίηση απο css-->
<?php require 'partials/sidebar.php'; ?>

<!--Page content-->
<div class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <span>
                                Στατιστικά
                            </span>
                        </h5>
                    </div>

                    <div class="card-body">
                        <span>
                            Προγραμματισμένα ραντεβού:
                        </span>

                        <span class="text-primary">
                            <?= $appointmentsCount ?>
                        </span>

                    </div>

                    <div class="card-body">
                        <span>
                            Ποσοστό ολοκληρωμένων ραντεβού:
                        </span>
                        <span class="text-primary">
                            <?= $completionPercentage ?> %
                        </span>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ημερομηνία</th>
                                    <th scope="col">Όνομα πολίτη</th>
                                    <th scope="col">Επίθετο πολίτη</th>
                                    <th scope="col">ΑΜΚΑ πολίτη</th>
                                    <th scope="col">Κατάσταση</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($appointments); $i++) {
                                    $user = $appointments[$i]->user();
                                    $appointment = $appointments[$i];

                                    if ($appointment->isCompleted()) {
                                        echo '<tr class="table-success">';
                                    } else {
                                        echo '<tr>';
                                    }

                                    echo '<th>' . (1 + $i) . '</th>';
                                    echo '<td>' . $appointment->date_time->format('d/m/Y H:i:s') . '</td>';
                                    echo '<td>' . $user->first_name . '</td>';
                                    echo '<td>' . $user->last_name . '</td>';
                                    echo '<td>' . $user->amka . '</td>';
                                    echo '<td>' . $appointment->status . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body">
                        <a class="px-2" href="/me/appointments/report/view" target="_blank">
                            <i class="fa-solid fa-eye"></i>

                            <span>
                                Προβολή αρχείου xml
                            </span>
                        </a>

                        <a class="px-2" href="/me/appointments/report/download" target="_blank">
                            <i class="fa-solid fa-download"></i>

                            <span>
                                Κατέβασμα αρχείου xml
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php' ?>