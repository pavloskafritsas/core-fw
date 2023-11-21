<?php

namespace Pk\Core\Models;

use DateTime;
use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\DB;
use Pk\Core\Helpers\Validator;

class Appointment extends Model
{
    protected static string $table = 'appointments';

    protected array $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'vaccination_center_id' => 'int',
        'date_time' => DateTime::class,
    ];

    /**
     * Override την Προβολή μοντέλου σε μορφή array
     */
    public function toArray()
    {
        $attributes = parent::toArray();

        $dateTime = $attributes['date_time'] ?? null;

        if ($dateTime instanceof DateTime) {
            $attributes['date'] = $dateTime->format('d/m/Y');
            $attributes['time'] = $dateTime->format('H:i');

            unset($attributes['date_time']);
        }

        return $attributes;
    }

    /**
     * Επιστροφή VaccinationCenter όπου ανήκει το Appointment
     */
    public function vaccinationCenter()
    {
        return $this->belongsTo(VaccinationCenter::class, 'vaccination_center_id');
    }

    /**
     * Ελέγχει εάν το Appointment είναι ολοκληρωμένο
     * 
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === 'Ολοκληρωμένο';
    }

    /**
     * αλλαγή status του Appointment σε Ολοκληρωμένο
     */
    public function complete()
    {
        if ($this->isCompleted()) {
            return;
        }

        $status = 'Ολοκληρωμένο';

        $db = DB::getInstance();

        $stmt = $db->prepare(
            'UPDATE ' . self::$table . " SET status=:status WHERE " . self::$key . '=:' . self::$key
        );

        if ($stmt->execute([
            'status' => $status,
            self::$key => $this->getKey()
        ])) {
            $this->status = $status;
        }
    }

    /**
     * Χρήση validator για τον έλεγχο ορθής καταχώρησης δεδομένων απο τον χρήστη στη φόρμα κλεισίματος ραντεβού και επιστροφή σφαλματων
     * 
     * @return array<null|string>
     */
    public static function validate(array $values)
    {
        return array_filter([
            Validator::date('Ημερομηνία', $values['date_time'], 'Y-m-d H:i:s'),
        ]);
    }

    /**
     * Override Δημιουργίας μοντέλου στη ΒΔ και επιστροφή
     * 
     * @return static
     */
    public static function create(array $attributes)
    {
        $attributes['user_id'] = Auth::id();

        return parent::create($attributes);
    }

    /**
     * Επιστρέφει το χρήστη που του ανήκει το Appointment
     * 
     * @return null|User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
