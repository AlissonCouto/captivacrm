<?php

namespace Database\Seeders;

use App\Models\Company;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $company = new Company();
        $company->name = 'Universesites';
        $company->slug = Str::slug($company->name);
        $company->userId = 1;
        $company->save();
    }
}
