<?php

namespace Pk\Core\Models;

use Pk\Core\Helpers\DB;
use Pk\Core\Helpers\Report;
use Pk\Core\Helpers\Validator;
use Pk\Core\Helpers\Xml;

class User extends Model
{
    public const REPORT_FILENAME = '/xml/report.xml';

    protected static string $table = 'users';

    protected array $casts = [
        'id' => 'int',
        'dob' => \DateTime::class,
    ];

    /**
     * Επιστροφή του μοντέλου appointment που αφορά το User
     * 
     * @return null|Appointment
     */
    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'user_id');
    }

    /**
     * Επιστροφή του μοντέλου VaccinationCenter που αφορά το User
     * 
     * @return array<null|VaccinationCenter>
     */
    public function vaccinationCenters()
    {
        return DB::getInstance()->query("
            SELECT v.*
             FROM users u
             JOIN user_vaccination_center pivot ON u.id = pivot.user_id
             JOIN vaccination_centers v ON pivot.vaccination_center_id = v.id
             WHERE pivot.user_id = {$this->getKey()}
        ", \PDO::FETCH_CLASS, VaccinationCenter::class)->fetchAll() ?? [];
    }

    /**
     * Έλεγχος εάν ο χρήστης ανήκει στο ηλικιακό group εμβολιασμού
     * 
     * @return boolean
     */
    public function canScheduleAppointment()
    {
        $age = $this->dob->diff(new \DateTime())->y;

        if ($age >= 40 && $age <= 65) {
            return true;
        }

        return false;
    }

    /**
     * Έλεγχος εάν ο χρήστης μπορεί να επιλέξει εμβολιαστικό κέντρο
     * 
     * @return boolean
     */
    public function canSelectVaccinationCenter()
    {
        return count($this->vaccinationCenters()) === 0;
    }

    /**
     * Χρήση validator για τον έλεγχο ορθής καταχώρησης δεδομένων απο τον χρήστη στη φόρμα εγγραφής και επιστροφή σφαλματων
     * 
     * @return array<null|string>
     */
    public static function validate(array $values)
    {
        return array_filter([
            Validator::stringLengthBetween('Όνομα', $values['first_name'], 3, 20),
            Validator::stringLengthBetween('Επίθετο', $values['last_name'], 3, 20),
            Validator::stringLengthIs('AMKA', $values['amka'], 11),
            Validator::isNumber('AMKA', $values['amka']),
            Validator::unique('AMKA', $values['amka'], self::$table, 'amka'),
            Validator::stringLengthIs('ΑΦΜ', $values['afm'], 9),
            Validator::isNumber('ΑΦΜ', $values['afm']),
            Validator::unique('ΑΦΜ', $values['afm'], self::$table, 'afm'),
            Validator::regex('/^[Α-Ωα-ω]{2}\d{6}$/u', $values['adt'], 'Το πεδίο ΑΔΤ πρέπει να έχει την μορφή: AA123456.'),
            Validator::unique('ΑΔΤ', $values['adt'], self::$table, 'adt'),
            Validator::date('Ημ/νια γέννησης', $values['dob'], 'Y-m-d'),
            isset($values['gender']) ? Validator::inArray('Φύλο', $values['gender'], ['male', 'female']) : null,
            isset($values['email']) ? Validator::email('Email', $values['email']) : null,
            Validator::regex('/^69\d{8}$/', $values['phone'], 'Το πεδίο κινητό τηλέφωνο πρέπει να έχει την μορφή: 69XXXXXXXX.'),
            Validator::inArray('Ρόλος', $values['role'], ['citizen', 'doctor']),
        ]);
    }

    public function makeReport()
    {
        $vaccinationCenter = $this->vaccinationCenters()[0];

        $data = [
            'Doctor' => array_filter(
                array_filter($this->toArray()),
                function (string $key) {
                    return in_array($key, [
                        'first_name',
                        'last_name',
                        'adt',
                        'email',
                    ], true);
                },
                ARRAY_FILTER_USE_KEY
            ),
            'VaccinationCenter' => array_filter(
                $vaccinationCenter->toArray(),
                function ($key) {
                    return in_array($key, [
                        'address',
                        'zip_code',
                        'phone',
                    ], true);
                },
                ARRAY_FILTER_USE_KEY
            ),
            'Appointments' => array_map(
                function (Appointment $item) {
                    $user = $item->user()->toArray();

                    $user['age'] = date_diff(new \DateTime(), $user['dob'], true)->y;

                    return [
                        'Citizen' => array_filter($user, function (string $key) {
                            return in_array($key, [
                                'first_name',
                                'last_name',
                                'amka',
                                'age',
                            ], true);
                        }, ARRAY_FILTER_USE_KEY),
                    ] + array_filter($item->toArray(), function (string $key) {
                        return in_array($key, [
                            'date',
                            'time',
                            'status',
                        ], true);
                    }, ARRAY_FILTER_USE_KEY);
                },
                Appointment::whereEqual('vaccination_center_id', $vaccinationCenter->id)
                    ->orderBy('date_time')
                    ->get()
            )
        ];

        $xml = Xml::newDomDocument();

        $xmlRoot = $xml->createElement('list');

        Xml::arrayToXmlElement($xml, $xmlRoot, $data);

        $xml->appendChild($xmlRoot);

        $file = Xml::saveXMLFile($xml, self::REPORT_FILENAME);

        Report::addDtdToXmlFile($file);
    }
}
