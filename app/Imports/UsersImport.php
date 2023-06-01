<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow {
    public $saved_count = 0;
    public $total_row_count = 0;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'email' => [
                'required',
            ],
            'password' => [
                'required',
            ],
        ];
    }

    public function getTotalSavedCount() {
        return $this->saved_count;
    }

    public function getTotalRowCount() {
        return $this->total_row_count;
    }

    public function collection(Collection $rows) {
        foreach ($rows as $index => $row) {
            if ($row->filter()->isNotEmpty()) {
                $this->total_row_count += 1;

                $userName = trim(preg_replace("/[']/","",$row["name"]));
                $email = trim(preg_replace("/[']/","",$row["email"]));
                $password = trim(preg_replace("/[']/","",$row["password"]));
//                $hashedPassword = Hash::make($password);

                $checkUser = User::where('email',$email)->first();

                $role = 'student';

                if(!$checkUser){
                    $newUser = new User();
                    $newUser->name = $userName;
                    $newUser->email = $email;
                    $newUser->password = $password;
                    $newUser->email_verified_at = now();
                    if ($newUser->save()) {
                        $newUser->assignRole($role);
                        $this->saved_count += 1;
                    }
                }
            }
        }
    }
}

