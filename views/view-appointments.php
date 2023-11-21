<?php require 'partials/header.php'; ?>

<?php require 'partials/topbar.php'; ?>

<?php require 'partials/sidebar.php'; ?>

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col cols-12">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="me-2 fa-solid fa-calendar-days"></i>
                            <span>Προγραμματισμένα ραντεβού</span>
                        </h5>


                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ημερομηνία</th>
                                    <th scope="col">Όνομα πολίτη</th>
                                    <th scope="col">Επίθετο πολίτη</th>
                                    <th scope="col">ΑΜΚΑ πολίτη</th>
                                    <th scope="col">Κατάσταση</th>
                                    <th scope="col">Ενέργειες</th>
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

                                    if (!$appointment->isCompleted()) {
                                        echo "
                                                <td>
                                                    <a class='btn btn-success' href='/appointments/$appointment->id/complete'>
                                                        <i class='fa-solid fa-check'></i>
                                                    </a>
                                                </td>
                                            ";
                                    } else {
                                        echo '<td></td>';
                                    }

                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'partials/footer.php'; ?>