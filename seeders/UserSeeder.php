<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to allow explicit IDs
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate(); // Clear existing users

        $users = [
            // id, username, name, email, password, role
            [
                'id' => 3, 
                'name' => 'Teena', // Defaulting username to name since name was empty in SQL
                'email' => 'Teena@gmail.com',
                'password' => '$2y$10$rh/.Qt.nq8xlndtqYBHULu7hDWISaCdEezd.BXrs/8zDCJw1jL1QK',
                'role' => 'user',
            ],
            [
                'id' => 4,
                'name' => 'Jennie',
                'email' => 'Jennie@gmail.com',
                'password' => '$2y$10$NVl49HBkVIOBAW4JDoYPBOJkUe8TSYOlfC/LBDSxjar944LaC.Isy',
                'role' => 'admin',
            ],
            [
                'id' => 6,
                'name' => 'leo',
                'email' => 'Leo@gmail.com',
                'password' => '$2y$10$WmS31mxG7XFm6K9JHsOGVuKQHu5fQCWw8r0LG/ii1EvWAuAUwAtRC',
                'role' => 'admin',
            ],
            [
                'id' => 7,
                'name' => 'Romeo',
                'email' => 'Romeo@gmail.com',
                'password' => '$2y$10$Mrzt/Mok3nEgemwun2MtI.3lDZIUZ8xzhQ5JClYJkSinul5anHu3G',
                'role' => 'admin',
            ],
            [
                'id' => 9,
                'name' => 'ninna',
                'email' => 'ninna@gmail.com',
                'password' => '$2y$10$YecC/1oxwd8XYGN4LuduXuFNIhlPumUCFKbvkCTPzegwTmJSr2wOC',
                'role' => 'user',
            ],
            [
                'id' => 11,
                'name' => 'leon',
                'email' => 'leon@gmail.com',
                'password' => '$2y$10$fNRenoOHBVLcH1ucI2uXF.XzUS8fr5/47nnqOQPUuGdxW87LkMEKC',
                'role' => 'admin',
            ],
            [
                'id' => 12,
                'name' => 'cc',
                'email' => 'cc@gamil.com', 
                'password' => '$2y$10$G0K.jGMUwC/adEpISq3M7OZPDLhgID16Wi60YUguIwAzkQPmaYUTa',
                'role' => 'user',
            ],
            [
                'id' => 17,
                'name' => 'kavi', // Name available in SQL
                'email' => 'kaveeshatrishan@gmail.com',
                'password' => '$2y$12$8cCVm96ti6ecOFIxHVRgeuZZOAlqiLGLvcgt7Di7SDCWfEZ9Pd.lm',
                'role' => 'user',
            ],
            [
                'id' => 18,
                'name' => 'Admin', // Name available in SQL
                'email' => 'admin@chanel.com',
                'password' => '$2y$12$uQwhgEJ15.7ZJ7/SMqWey.1MlrAFqg4Mvct6NgiFkD/IJhJnKh3lK',
                'role' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
