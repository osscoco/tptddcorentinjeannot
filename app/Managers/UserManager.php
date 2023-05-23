<?php


namespace App\Managers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserManager
{
    public function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'dateOfBirth' => $data['dateOfBirth'],
            'email_verified_at' => Carbon::now(),
            'genderId' => $data['genderId'],
            'rightId' => $data['rightId']
        ]);

        $user->save();

        return $user;
    }

    public function update(User $user, array $data)
    {
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->dateOfBirth = $data['dateOfBirth'];
        $user->genderId = $data['genderId'];
        $user->rightId = $data['rightId'];
        $user->save();

        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}
