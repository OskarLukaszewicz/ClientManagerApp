<?php

declare(strict_types=1);

namespace App\db;

class DataFixtures 
{

    private const NAMES = ["Alice", "Bob", "Charlie", "David", "Eva", "Frank", "Grace", "Henry", "Irene", "Jack",
    "Kate", "Liam", "Mia", "Noah", "Olivia", "Peter", "Quinn", "Rachel", "Sam", "Tina"];

    private const SURNAMES = ["Smith", "Johnson", "Brown", "Taylor", "Miller", "Wilson", "Moore", "Lee", "Anderson", "Thomas",
    "Jackson", "White", "Harris", "Martin", "Thompson", "Garcia", "Martinez", "Robinson", "Clark", "Rodriguez"];

    private const CITIES = ["Warszawa", "Kraków", "Łódź", "Wrocław", "Poznań", "Gdańsk", "Szczecin", "Bydgoszcz", "Lublin", "Białystok",
    "Katowice", "Gdynia", "Częstochowa", "Radom", "Sosnowiec", "Toruń", "Kielce", "Rzeszów", "Gliwice", "Zabrze"];

    private const COMPANY_NAMES = ["ABC Company", "XYZ Corporation", "Smith & Sons", "Johnson Enterprises", "Tech Innovators", "Global Solutions", "Pioneer Industries", 
    "Summit Group", "Elite Ventures", "Infinite Ideas", "Strategic Systems", "Dynamic Developments", "Apex Enterprises", "Supreme Solutions", "Empire Builders", "Innovative Insights", 
    "Unity Enterprises", "Phoenix Innovations", "Golden Gate Industries", "Frontier Technologies"];

    private const ADDRESSES = [ "123 Main Street", "456 Elm Avenue", "789 Oak Boulevard", "101 Pine Lane", "202 Maple Drive", "303 Cedar Street", 
    "404 Birch Avenue", "505 Spruce Boulevard", "606 Willow Lane", "707 Juniper Drive", "808 Pineapple Avenue", "909 Peach Street", 
    "210 Orange Lane", "320 Plum Drive", "430 Cherry Street", "540 Grape Avenue",  "650 Banana Boulevard", "760 Lemon Lane", "870 Apple Drive", 
    "980 Mango Street"];

    private const PACKAGE_TYPES = [
        'Basic' => [
            'price' => '600',
            'package_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed volutpat dolor, eu aliquet eros. Suspendisse tristique nulla vitae libero iaculis, vel cursus orci cursus. Integer euismod eros sit amet venenatis tempus. Integer et turpis eu nunc mattis ullamcorper. Sed sit amet tincidunt metus. Quisque efficitur, eros non vestibulum tincidunt, ex mauris dictum orci, eu sodales est purus at velit.',
            'features' => 'Fusce feugiat tristique justo, vel ultrices nisl dictum quis. Curabitur vel nunc vitae odio fringilla dignissim.'
        ],
        'Premium' => [
            'price' => '800',
            'package_description' => 'Pellentesque nec facilisis dui, vel rhoncus justo. In hac habitasse platea dictumst. Nulla ac fermentum metus. Aliquam auctor fringilla felis vel luctus. Vestibulum euismod justo a ligula scelerisque, non interdum nisi dapibus. Morbi non ex at elit volutpat congue. Nunc eu arcu id libero rhoncus rhoncus nec non lectus.',
            'features' => 'Nam volutpat, est ac venenatis volutpat, eros nisi efficitur metus, id luctus nulla felis non odio. Phasellus vitae bibendum libero.'
        ],
        'SuperPremium' => [
            'price' => '1000',
            'package_description' => 'Sed eu arcu semper, viverra nulla eu, egestas urna. Curabitur ac semper neque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In at neque eu arcu bibendum rhoncus. Quisque vel feugiat ipsum, sit amet blandit quam. Donec auctor, arcu nec euismod tincidunt, arcu arcu consequat felis, non pellentesque magna metus id lorem.',
            'features' => 'Vivamus tincidunt, justo a tincidunt semper, dolor mi pharetra orci, vel convallis dolor sapien eu mauris.'
        ],
    ];
    
    public static function populate($model): void
    {
        self::generatePackageTypes($model);
        $packageIds = self::generatePackages($model);
        $contactPersonIds = self::generateContactPersons($model);

        shuffle($packageIds);
        shuffle($contactPersonIds);

        self::generateClients($model, $packageIds, $contactPersonIds);
        self::generateEmployees($model);
    }

    private static function generateClients($model, array $packageIds, array $contactPersonIds): void
    {
        for ($i = 0; $i < 10; $i++) {

            $data = [
                'client_name' => self::COMPANY_NAMES[rand(0,19)],
                'NIP' => (string) rand(1000000000, 9999999999),
                'address' => self::ADDRESSES[rand(0,19)],
                'country' => "Poland",
                'city' => self::CITIES[rand(0,19)],
                'package_id' => $packageIds[$i],
                'contact_person_id' => $contactPersonIds[$i],
            ];

            $model->createClient($data);
        }
    }

    private static function generateEmployees($model): void
    {
        for ($i = 0; $i < 10; $i++) {

            $birthDate = rand(strtotime('1990-01-01'), strtotime('1999-12-31'));
            $date = date('Y-m-d', $birthDate);
            $name = self::NAMES[rand(0,19)];
            $surname = self::SURNAMES[rand(0,19)];

            $data = [
                'first_name' => $name,
                'last_name' => $surname,
                'date_of_birth' => $date,
                'gender' => rand(0,1) ? 'm' : 'k',
                'email' => $name . $surname . '@example.com',
            ];

            $model->createEmployee($data);
        }
    }

    private static function generateContactPersons($model): array
    {
        $contactPersonIds=[];

        for ($i = 0; $i < 10; $i++) {

            $name = self::NAMES[rand(0,19)];
            $surname = self::SURNAMES[rand(0,19)];


            $data = [
                'first_name' => $name,
                'last_name' => $surname,
                'email' => $name . $surname . '@example.com',
                'phone_number' => implode('-', [strval(rand(500, 999)), strval(rand(100, 999)), strval(rand(100, 999))]),
            ];

            $contactPersonIds[] = $model->createContactPerson($data);
        }

        return $contactPersonIds;
    }

    private static function generatePackages($model): array
    {
        $packageIds=[];

        for ($i = 0; $i < 10; $i++) {

            $startDate = rand((time() - 60*60*24*365), time());
            $endDate = $startDate + (60*60*24*365);

            $sDate = date('Y-m-d', $startDate);
            $eDate = date('Y-m-d', $endDate);

            $packageTypeId = (rand(1,3));

            $data = [
                'package_type_id' => $packageTypeId,
                'start_date' => $sDate,
                'end_date' => $eDate,
            ];

            $packageIds[] = $model->createPackage($data);
        }

        return $packageIds;
    }

    private static function generatePackageTypes($model): void
    {
        if ($model->getItems('package_type')) return;

        foreach (self::PACKAGE_TYPES as $key => $value) {
            $data = [
                'package_name' => $key,
                'price' => $value['price'],
                'package_description' => $value['package_description'],
                'features' => $value['features']
            ];

            $model->createPackageType($data);
        }
    }
}