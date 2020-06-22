<?php

use App\Models\Core\Organization;
use App\Models\Management\Subscription;
use App\Models\Management\SubscriptionType;
use App\Models\Settings\Employee;
use App\Models\Support\City;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganizationAndOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city = City::latest()->first();
        $subs_type = SubscriptionType::create([
            'name' => 'Бесплатная',
            'price' => 0,
            'expiration_days'=>0,
            'employees_count'=>100,
        ]);

        $org = Organization::create([
            'name'=>'Aisadent',
            'address' => 'Кабанбай Батыра 146',
            'phone' =>'+77014318410',
            'city_id' => $city->id,
            'email' => 'aisadent@gmail.com',
        ]);
        Subscription::create([
            'actual_price' => 0,
            'start_date'=>\Carbon\Carbon::now(),
            'end_date'=>\Carbon\Carbon::now(),
            'subscription_type_id'=>$subs_type->id,
            'organization_id'=>$org->id,
        ]);
//        $owner = User::create([
//            'email' => 'aidyn@aisadent.kz',
//            'password' => bcrypt('password'),
//            'role_id' => \App\Models\Role::OWNER_ID
//        ]);
//        Employee::create([
//            'account_id'=>$owner->id,
//            'name'=>'Айдын',
//            'surname'=>'Аубакиров',
//            'patronymic'=>'Хасенович',
//            'phone'=>'+7(701)765-29-96',
//            'birth_date'=>'1973-01-01',
//            'gender'=>'Мужской',
//            'color'=>'#228B22',
//            'organization_id'=>$org->id
//        ]);
    }
}
