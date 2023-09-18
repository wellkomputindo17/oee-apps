<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DoModel;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DivisiSeeder::class,
            LevelAksesSeeder::class,
            LineSeeder::class,
            MesinSeeder::class,
            PlanDownTimeSeeder::class,
            UnplanDownTimeSeeder::class,
            SpeedLossesSeeder::class,
            QualityLossesSeeder::class
        ]);

        DoModel::insert([
            [
                'no_do' => '09150001',
                'name' => 'DO 1',
                'target'    => 9727
            ],
            [
                'no_do' => '09150002',
                'name' => 'DO 2',
                'target'    => 5637
            ],
            [
                'no_do' => '09150003',
                'name' => 'DO 3',
                'target'    => 8173
            ],
            [
                'no_do' => '09150004',
                'name' => 'DO 4',
                'target'    => 6932
            ],
            [
                'no_do' => '09150005',
                'name' => 'DO 5',
                'target'    => 10234
            ],
            [
                'no_do' => '09150006',
                'name' => 'DO 6',
                'target'    => 7238
            ],
            [
                'no_do' => '09150007',
                'name' => 'DO 7',
                'target'    => 9248
            ],
            [
                'no_do' => '09150008',
                'name' => 'DO 8',
                'target'    => 12994
            ],
            [
                'no_do' => '09150009',
                'name' => 'DO 9',
                'target'    => 4758
            ],
            [
                'no_do' => '09150010',
                'name' => 'DO 10',
                'target'    => 11578
            ],
            [
                'no_do' => '09150011',
                'name' => 'DO 11',
                'target'    => 9375
            ],
            [
                'no_do' => '09150012',
                'name' => 'DO 12',
                'target'    => 7495
            ],
        ]);

        User::insert([
            'name' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            "divisi_id" => 1,
            "level_akses_id" => 1,
        ]);
    }
}
