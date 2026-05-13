<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Room;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    

    public function run()
    {
        for ($i = 1; $i <= 2; $i++) {

            $hotel = Hotel::create([
                'nom' => 'Hotel '.$i,
                'localisation' => 'Ville '.$i,
                'pays' => 'Mali'
            ]);

            for ($j = 1; $j <= 5; $j++) {
                Room::create([
                    'hotel_id' => $hotel->id,
                    $type = ['simple', 'double', 'suite'],
                    'type' => $type[array_rand($type)],
                    'prix' => rand(10000, 50000),
                    'capacite' => rand(1, 4)
                ]);
            }
        }
    }
}
