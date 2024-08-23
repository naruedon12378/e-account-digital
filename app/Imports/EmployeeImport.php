<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;

use App\Models\Company;
use App\Models\Site;
use App\Models\CarType;
use App\Models\Car;
use App\Models\User;
use App\Models\UserPrefix;

class EmployeeImport implements ToCollection, WithStartRow
{
    use HasFactory;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // dd($row);
            $config = [
                'table' => 'users',
                'field' => 'user_code',
                'length' => 10,
                'prefix' => 'EM' . date('Y') . date('m'),
                'reset_on_prefix_change' => true,
            ];
            // now use it

            $user_code = IdGenerator::generate($config);

            $prefix = UserPrefix::where('name_th', $row[4])->first()->id;
            $company_id = Company::where('name', $row[25])->first()->id;
            $site_id = Site::where('name', $row[26])->first()->id;
            $car_id = Car::where('registration_number', $row[27])->first()->id;
            $contract = ($row[24] == 'รถบริษัท' ? 2 : ($row[24] == 'รถร่วม' ? 0 : 1));
            // dd($car_id);
            $gender = ($row[11] == 'ชาย' ? '0' : '1');
            $employee = User::create([
                'user_code' => $user_code,
                'citizen_id' => str_replace([' ', '-'], '', $row[3]),
                'first_name_th' => $row[5],
                'first_name_en' => $row[8],
                'middle_name_th' => $row[6],
                'middle_name_en' => $row[9],
                'last_name_th' => $row[7],
                'last_name_en' => $row[10],
                'house_number' => $row[16],
                'village_no' => $row[17],
                'alley' => $row[18],
                'road' => $row[19],
                'province' => $row[20],
                'district' => $row[21],
                'sub_district' => $row[22],
                'zipcode' => $row[23],
                'bank_name' => $row[14],
                'bank_number' => str_replace('-', '', $row[15]),
                'contract' => $contract,
                'gender' => $gender,
                'status' => 1,
                'registration_date' => Carbon::createFromFormat('d/m/Y', $row[28])->format('Y-m-d'),
                'email' => $row[2],
                'phone' => $row[12],
                'line_id' => $row[13],
                'username' => $user_code,
                'password' => bcrypt($user_code),
                'prefix_id' => $prefix,
                'company_id' => $company_id,
                'car_id' => $car_id,
                'status' => 1,
                'status_work' => User::STATUS_WORK_NORMAL,
                'ref1' => $row[0],
                'ref2' => $row[1],
            ]);
            $employee->assignRole(4);
            $employee->sites()->attach($site_id);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
