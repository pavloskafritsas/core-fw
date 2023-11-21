<?php

namespace Pk\Core\Models;

use Pk\Core\Helpers\DB;

class VaccinationCenter extends Model
{
    protected static string $table = 'vaccination_centers';

    protected array $casts = [
        'id' => 'int',
    ];

    /**
     * Επιστροφή του μοντέλου appointment που αφορά το VaccinationCenter
     * 
     * @return array<null|Appointment>
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'vaccination_center_id');
    }

    /**
     * Συσχέτιση VaccinationCenter με User
     */
    public function attachUser(User $user)
    {
        $db = DB::getInstance();

        $stmt = $db->prepare(
            'INSERT into user_vaccination_center (user_id, vaccination_center_id) VALUES (:user_id,:vaccination_center_id)'
        );

        $stmt->execute([
            'user_id' => $user->getKey(),
            'vaccination_center_id' => $this->getKey(),
        ]);
    }
}
