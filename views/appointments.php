<?php require 'partials/header.php'; ?>
<?php require 'partials/topbar.php'; ?>
<?php require 'partials/sidebar.php'; ?>

<!--Page content-->
<div class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Προγραμματισμός ραντεβού</h5>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating">
                                    <select onchange="getAppointments()" class="form-select" id="vaccination-center" name="vaccination_center" aria-label="Επιλέξτε εμβολιαστικό κέντρο">
                                        <option selected></option>
                                        <?php
                                        foreach ($vaccinationCenters as $vaccinationCenter) {
                                            echo "<option value='$vaccinationCenter->id'>{$vaccinationCenter->name}</option>";
                                        }
                                        ?>
                                    </select>

                                    <label for="vaccination-center">Επιλέξτε εμβολιαστικό κέντρο</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="card d-none" id="appointment-schedules">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="card border-0 text-center">
                                    <div class="card-body">
                                        <b>01/04/2022</b>
                                    </div>
                                </div>

                                <form method="POST" action="">
                                    <button>
                                        <div class="card my-2 text-center text-white bg-success">
                                            <div class="card-body">
                                                <b data-date="01/04/2022" data-time="08:00">08:00</b>
                                            </div>
                                        </div>
                                    </button>

                                    <input type="hidden" name="date_time" value="2022-04-01 08:00:00" />
                                </form>

                                <form method="POST" action="">
                                    <button>
                                        <div class="card my-2 text-center text-white bg-success">
                                            <div class="card-body">
                                                <b data-date="01/04/2022" data-time="09:00">09:00</b>
                                            </div>
                                        </div>
                                    </button>

                                    <input type="hidden" name="date_time" value="2022-04-01 09:00:00" />
                                </form>

                                <form method="POST" action="">
                                    <button>
                                        <div class="card my-2 text-center text-white bg-success">
                                            <div class="card-body">
                                                <b data-date="01/04/2022" data-time="10:00">10:00</b>
                                            </div>
                                        </div>
                                    </button>

                                    <input type="hidden" name="date_time" value="2022-04-01 10:00:00" />
                                </form>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="card border-0 text-center">
                                    <div class="card-body">
                                        <b>02/04/2022</b>
                                    </div>
                                </div>


                                <form method="POST" action="">
                                    <button>
                                        <div class="card my-2 text-center text-white bg-success">
                                            <div class="card-body">
                                                <b data-date="02/04/2022" data-time="08:00">08:00</b>
                                            </div>
                                        </div>
                                    </button>

                                    <input type="hidden" name="date_time" value="2022-04-02 08:00:00" />
                                </form>

                                <form method="POST" action="">
                                    <button>
                                        <div class="card my-2 text-center text-white bg-success">
                                            <div class="card-body">
                                                <b data-date="02/04/2022" data-time="09:00">09:00</b>
                                            </div>
                                        </div>

                                    </button>

                                    <input type="hidden" name="date_time" value="2022-04-02 09:00:00" />
                                </form>

                                <form method="POST" action="">
                                    <button>
                                        <div class=" card my-2 text-center text-white bg-success">
                                            <div class="card-body">
                                                <b data-date="02/04/2022" data-time="10:00">10:00</b>
                                            </div>
                                        </div>
                                    </button>

                                    <input type="hidden" name="date_time" value="2022-04-02 10:00:00" />
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <span class="me-1">
                            <i class="fa-solid fa-square text-success"></i>
                            <i>Διαθέσιμο ραντεβού</i>
                        </span>
                        <span class="ms-1">
                            <i class=" fa-solid fa-square text-secondary"></i>
                            <i>Μη διαθέσιμο ραντεβού</i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'partials/footer.php' ?>

<script lang="js">
    function init() {
        getAppointments()
    }

    function resetAppointments() {
        const els = document.getElementsByClassName('bg-secondary')

        for (let i = 0; i < els.length; i++) {
            els[i].classList.replace('bg-secondary', 'bg-success')
        }
    }

    function setAppointmentsVisibility(visibility) {
        visibility ?
            document.getElementById('appointment-schedules').classList.remove('d-none') :
            document.getElementById('appointment-schedules').classList.add('d-none')

    }

    function getSelectedVaccinationCenterId() {
        return document.getElementById('vaccination-center').value
    }

    function getAppointments() {
        setAppointmentsVisibility(false)

        const id = getSelectedVaccinationCenterId()

        if (!id) return

        resetAppointments()

        const xhttp = new XMLHttpRequest();

        xhttp.open("GET", `/vaccination_centers/${id}/appointments`, true);
        xhttp.send();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                const response = JSON.parse(this.response)

                if (response.length) {
                    response.forEach(appointment => {
                        const date = appointment.date
                        const time = appointment.time

                        const appointmentEl = document.querySelector(
                            `[data-date="${date}"][data-time="${time}"]`
                        );

                        const card = appointmentEl.parentElement.parentElement

                        card.classList.replace('bg-success', 'bg-secondary')
                        card.parentElement.setAttribute('disabled', 'disabled')
                    });
                }
            }
        };

        setFormsAction()
        setAppointmentsVisibility(true)
    }

    function setFormsAction() {
        const forms = document.getElementsByTagName('form')
        const action = '/vaccination_centers/' +
            getSelectedVaccinationCenterId() +
            '/appointments'

        for (let i = 0; i < forms.length; i++) {
            forms[i].setAttribute('action', action)
        }
    }

    init()
</script>

<style>
    button {
        display: contents;
    }
</style>