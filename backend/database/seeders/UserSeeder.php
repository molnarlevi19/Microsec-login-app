<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'email' => 'pelda@pelda.com',
                'nickname' => 'pelda',
                'birthdate' => '1990-01-01',
                'password' => Hash::make('password123'),
            ],
            [
                'email' => 'pelda2@pelda2.com',
                'nickname' => 'pelda2',
                'birthdate' => '1995-05-05',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $data) {
            User::create($data);

            $this->appendToCsv($data);
        }
    }

    private function appendToCsv(array $data)
    {
        $userFilePath = storage_path('app/private/users/users.csv');

        try {
            if (!file_exists(dirname($userFilePath))) {
                mkdir(dirname($userFilePath), 0755, true);
            }

            $fileHandle = fopen($userFilePath, 'a');

            if ($fileHandle) {
                if (filesize($userFilePath) === 0) {
                    fputcsv($fileHandle, ['email', 'nickname', 'birthdate', 'password']);
                }

                fputcsv($fileHandle, [
                    $data['email'],
                    $data['nickname'],
                    $data['birthdate'],
                    $data['password'],
                ]);
                fclose($fileHandle);
                Log::info('User data appended to users.csv');
            } else {
                Log::error('Failed to open users.csv for writing.');
            }
        } catch (\Exception $e) {
            Log::error('Error appending user data: ' . $e->getMessage());
        }
    }
}
