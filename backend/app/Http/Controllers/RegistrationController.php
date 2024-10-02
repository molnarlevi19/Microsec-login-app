<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'nickname' => 'required|string|max:255',
            'birthdate' => 'required|date|before:today',
            'password' => 'required|min:8',
        ]);

        $data = [
            'email' => $validatedData['email'],
            'nickname' => $validatedData['nickname'],
            'birthdate' => $validatedData['birthdate'],
            'password' => Hash::make($validatedData['password']),
        ];

        $user = User::create($data);

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

                fputcsv($fileHandle, $data); 
                fclose($fileHandle);
                Log::info('User data appended to users.csv');
            } else {
                Log::error('Failed to open users.csv for writing.');
            }
        } catch (\Exception $e) {
            Log::error('Error appending user data: ' . $e->getMessage());
        }

        return response()->json(['message' => 'Registration successful', 'user' => $user], 201);
    }

    public function retrieveData()
    {
        $source = rand(0, 1) ? 'database' : 'file';
        
        if ($source === 'database') {
            $users = User::all();
        } else {
            $userFilePath = storage_path('app/private/users/users.csv');
        
            $users = [];

            if (file_exists($userFilePath)) {
                if (($handle = fopen($userFilePath, 'r')) !== false) {
                    fgetcsv($handle);
                
                    while (($data = fgetcsv($handle)) !== false) {
                        $users[] = [
                            'email' => $data[0],
                            'nickname' => $data[1],
                            'birthdate' => $data[2],
                            'password' => $data[3],
                        ];
                    }
                    fclose($handle);
                } else {
                    Log::error('Failed to open users.csv for reading.');
                }
            } else {
                Log::warning('users.csv file does not exist.');
            }
        }
    
        return response()->json(['source' => $source, 'users' => $users]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'nickname' => 'sometimes|string|max:255',
            'birthdate' => 'sometimes|date|before:today',
            'password' => 'sometimes|min:8',
        ]);

        if (isset($validatedData['nickname'])) {
            $user->nickname = $validatedData['nickname'];
        }
        if (isset($validatedData['birthdate'])) {
            $user->birthdate = $validatedData['birthdate'];
        }
        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        $userFilePath = storage_path('app/private/users/users.csv');
        if (file_exists($userFilePath)) {
            $users = [];
            if (($handle = fopen($userFilePath, 'r')) !== false) {
                $header = fgetcsv($handle);
                while (($data = fgetcsv($handle)) !== false) {

                    if ($data[0] == $user->email) {
                        $data[1] = $user->nickname;
                        $data[2] = $user->birthdate;
                        $data[3] = $user->password;
                    }
                    $users[] = $data;
                }
                fclose($handle);
            }

            $handle = fopen($userFilePath, 'w');
            fputcsv($handle, ['email', 'nickname', 'birthdate', 'password']);
            foreach ($users as $userData) {
                fputcsv($handle, $userData);
            }
            fclose($handle);
        }

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
    }
    
}
