<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            <i class="fa-solid fa-calendar-day"></i>
            <span>Στοιχεία ραντεβού</span>
        </h5>

        <div class="row">
            <div class="col-12">
                <?php if (!$user->appointment()) {
                    echo '
                    <div class="text-center">
                        <p>Δεν υπάρχει προγραμματισμένο ραντεβού.</p>
                        <button onclick="canScheduleAppointment()" class="btn btn-primary">Κλείστε το ραντεβού σας</button>
                    </div>
                    ';
                } else {
                    echo "
                    <div class='text-center'>
                        <p>
                            Έχετε προγραμματίσει ραντεβού στις:
                            <br>
                            <b class='text-primary'>{$user->appointment()->date_time->format('d/m/Y H:i')}</b>
                        </p>
                        <button id='deleteConfirmationModal-activator-btn' class='btn btn-danger' type='button' data-bs-toggle='modal' data-bs-target='#deleteConfirmationModal'>
                            Ακύρωση ραντεβού
                        </button>
                    </div>
                    ";
                } ?>
            </div>
        </div>
    </div>
</div>

<button id="canScheduleAppointmentModal-activator-btn" type="button" class="d-none" data-bs-toggle="modal" data-bs-target="#canScheduleAppointmentModal"></button>

<!-- canScheduleAppointmentModal -->
<div class="modal fade" id="canScheduleAppointmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="canScheduleAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa-solid fa-triangle-exclamation me-3"></i>
                <h5 class="modal-title" id="canScheduleAppointmentModalLabel">Ειδοποίηση</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>
                    Δεν ανήκετε στην ηλικιακή ομάδα που εμβολιάζεται τη συγκεκριμένη περίοδο
                    επομένως δεν μπορείτε να προγραμματίσετε κάποιο ραντεβού.
                </span>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Κλείσιμο</button>
            </div>
        </div>
    </div>
</div>

<!-- deleteConfirmationModal -->
<div class="modal fade" id="deleteConfirmationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa-solid fa-question me-3"></i>
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Επιβεβαίωση</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>
                    Είστε σίγουροι ότι θέλετε να ακυρώσετε το προγραμματισμένο σας ραντεβού;
                </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Όχι</button>
                <button onclick="deleteAppointment()" type="button" class="btn btn-primary" data-bs-dismiss="modal">Ναι</button>
            </div>
        </div>
    </div>
</div>

<script lang="js">
    function deleteAppointment() {
        const xhttp = new XMLHttpRequest();

        xhttp.open('DELETE', '/me/appointment', true);
        xhttp.send();

        xhttp.onreadystatechange = function() {
            location.reload();
        };
    }

    function showConfirmationModal() {
        document.getElementById('deleteConfirmationModal-activator-btn').click();
    }

    function canScheduleAppointment() {
        const xhttp = new XMLHttpRequest();

        xhttp.open("GET", "/me/canScheduleAppointment", true);
        xhttp.send();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                const response = JSON.parse(this.response)

                if (!response.can_schedule_appointment) {
                    document.getElementById('canScheduleAppointmentModal-activator-btn').click();
                } else {
                    window.location.href = '/appointments';
                }
            }
        };
    }
</script>