<?php

use App\Models\Settings\Service;
use App\Models\Settings\ServiceCategory;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = ServiceCategory::create([
            'name'=>'Общие виды работ'
        ])->id;


        Service::create([
            'name'=>'Консультация',
            'description'=>'Консультация (осмотр и прием пациента без лечения)',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'500',
            'max_price'=>'1000'
        ]);
        Service::create([
            'name'=>'Анестезия инфильтрационная',
            'description'=>'Анестезия инфильтрационная',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'1000',
            'max_price'=>'2000']);
        Service::create([
            'name'=>'Анестезия проводниковая',
            'description'=>'Анестезия проводниковая',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'1000',
            'max_price'=>'2000']);
        Service::create([
            'name'=>'Прицельный рентген-снимок зуба',
            'description'=>'Прицельный рентген-снимок зуба',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'1000',
            'max_price'=>'2000']);



        $id = ServiceCategory::create([
            'name'=>'Профилактика'
        ])->id;

        Service::create([
            'name'=>'Профессиональная чистка зубов',
            'description'=>'Профессиональная чистка зубов (в зависимости от сложности) профилактическое покрытие',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'9000',
            'max_price'=>'12000']);
        Service::create([
            'name'=>'Фторирование зуба',
            'description'=>'Фторирование зуба (-ов) в зависимости от количества',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'1000',
            'max_price'=>'3500']);
        Service::create([
            'name'=>'Иньекции Линкомицина',
            'description'=>'Иньекции Линкомицина',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'1200',
            'max_price'=>'1200']);
        Service::create([
            'name'=>'Процедура Plasmolifting',
            'description'=>'Процедура Plasmolifting (забор крови+центрифугирование+иньекции)',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'15000',
            'max_price'=>'15000']);
        Service::create([
            'name'=>'Фототерапия (курс 5 дней)',
            'description'=>'Фототерапия (курс 5 дней)',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'3000',
            'max_price'=>'3000']);

        $id = ServiceCategory::create([
            'name'=>'Терапевтическая стоматология'
        ])->id;

        Service::create([
            'name'=>'Лечение среднего кариеса (пломба хим. отверждения)',
            'description'=>'Лечение среднего кариеса (пломба химического отверждения)',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'3500',
            'max_price'=>'3500']);
        Service::create([
            'name'=>'Лечение среднего кариеса (пломба свет. отверждения)',
            'description'=>'Лечение среднего кариеса (пломба светового отверждения)',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'4500',
            'max_price'=>'4500']);
        Service::create([
            'name'=>'Лечение глубокого кариеса (пломба хим. отверждения)',
            'description'=>'Лечение глубокого кариеса (пломба химического отверждения)',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'4000',
            'max_price'=>'4000']);
        Service::create([
            'name'=>'Лечение глубокого кариеса (пломба свет. отверждения)',
            'description'=>'Лечение глубокого кариеса (пломба светового отверждения)',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'5000',
            'max_price'=>'5000']);
        Service::create([
            'name'=>'Лечение глубокого кариеса (пломба хим. отверждения)',
            'description'=>'Лечение глубокого кариеса (пломба химического отверждения)',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'4000',
            'max_price'=>'4000']);

        $id = ServiceCategory::create([
            'name'=>'Эстетическая стоматология'
        ])->id;
        Service::create([
            'name'=>'Худож. реставрация зубов',
            'description'=>'Художественная реставрация зубов в зависимости от сложности',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'8000',
            'max_price'=>'12000']);
        Service::create([
            'name'=>'Адгезивный мостик',
            'description'=>'Адгезивный мостик',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'10000',
            'max_price'=>'10000']);
        Service::create([
            'name'=>'Отбеливание зубов профессиональное',
            'description'=>'Отбеливание зубов профессиональное',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'30000',
            'max_price'=>'30000']);
        Service::create([
            'name'=>'Внутрипульпарное отбеливание (эндоотбеливание)',
            'description'=>'Внутрипульпарное отбеливание (эндоотбеливание)',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'3000',
            'max_price'=>'3000']);

        $id = ServiceCategory::create([
            'name'=>'Ортопедические стоматологические услуги'
        ])->id;

        Service::create([
            'name'=>'Стальная коронка',
            'description'=>'Стальная коронка',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'4000',
            'max_price'=>'4000']);
        Service::create([
            'name'=>'Литой зуб',
            'description'=>'Литой зуб',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'4000',
            'max_price'=>'4000']);
        Service::create([
            'name'=>'Фасетка',
            'description'=>'Фасетка',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'7000',
            'max_price'=>'7000']);
        Service::create([
            'name'=>'Пластмассовая коронка',
            'description'=>'Пластмассовая коронка',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'7000',
            'max_price'=>'7000']);

        $id = ServiceCategory::create([
            'name'=>'Съемное протезирование'
        ])->id;

        Service::create([
            'name'=>'Полный съемный протез',
            'description'=>'Полный съемный протез',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'23000',
            'max_price'=>'25000']);
        Service::create([
            'name'=>'Частичный съемный протез',
            'description'=>'Частичный съемный протез',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'23000',
            'max_price'=>'23000']);
        Service::create([
            'name'=>'Микропротез',
            'description'=>'Микропротез',
            'duration'=>'30',
            'category_id'=>$id,
            'price'=>'7000',
            'max_price'=>'7000']);

    }
}
