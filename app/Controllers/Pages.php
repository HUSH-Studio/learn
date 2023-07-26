<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        // $faker = \Faker\Factory::create();
        // dd($faker->name);
        //menggunakan tamplate renderSection
        $data = [
            'title' => 'Home | Learn CI',
            'tes' => ['satu', 'dua', 'tiga']
        ];
        // echo view('layout/head', $data);
        return view('pages/home', $data);
        // echo view('layout/footer');
    }
    public function about()
    {
        $data = [
            'title' => 'About Me | Learn CI'
        ];
        return view('pages/about', $data);
    }
    public function contact()
    {
        $data = [
            'title' => 'Contact | Learn CI',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'JL. Abc No.123',
                    'kota' => 'Bandung'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'JL. Xyz No.123',
                    'kota' => 'Jakarta'
                ],
            ]
        ];
        return view('pages/contact', $data);
    }
}
