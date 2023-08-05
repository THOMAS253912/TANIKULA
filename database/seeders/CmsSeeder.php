<?php

namespace Database\Seeders;

use App\Models\Cms;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cms = [
            [
                'cms_name' => 'Nama Aplikasi',
                'alias' => 'app_name',
                'is_image' => false,
                'is_multiple' => false,
                'content' => 'Company Profile'
            ],
            [
                'cms_name' => 'Logo Aplikasi',
                'alias' => 'app_logo',
                'is_image' => true,
                'is_multiple' => false,
                'content' => 'logo.svg'
            ],
            [
                'cms_name' => 'Slider Aplikasi',
                'alias' => 'app_slider',
                'is_image' => true,
                'is_multiple' => true,
                'content' => json_encode(['slider1.jpg', 'slider2.jpg', 'slider3.jpg'])
            ],
            [
                'cms_name' => 'Tentang Aplikasi',
                'alias' => 'app_about',
                'is_image' => false,
                'is_multiple' => false,
                'content' => "<b>Sri Makmur</b><br><p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus vero dolores in velit beatae temporibus omnis, autem labore delectus reprehenderit, nulla nesciunt minus nisi exercitationem?</p>"
            ],
            [
                'cms_name' => 'Lokasi Aplikasi',
                'alias' => 'app_map',
                'is_image' => false,
                'is_multiple' => false,
                'content' => "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31733.89091710476!2d106.82963755!3d-6.1660489499999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1690201401817!5m2!1sid!2sid"
            ],
            [
                'cms_name' => 'Alamat Aplikasi',
                'alias' => 'app_address',
                'is_image' => false,
                'is_multiple' => false,
                'content' => "Jl Krekot Bunder Raya"
            ],
            [
                'cms_name' => 'Telepon Aplikasi',
                'alias' => 'app_phone',
                'is_image' => false,
                'is_multiple' => false,
                'content' => "081947193543"
            ],
            [
                'cms_name' => 'Email Aplikasi',
                'alias' => 'app_email',
                'is_image' => false,
                'is_multiple' => false,
                'content' => "poktan@mail.com"
            ],
            [
                'cms_name' => 'Slogan Aplikasi',
                'alias' => 'app_slogan',
                'is_image' => false,
                'is_multiple' => false,
                'content' => "Bersama Kami Penuh Misteri"
            ],
            [
                'cms_name' => 'Banner Aplikasi',
                'alias' => 'app_banner',
                'is_image' => true,
                'is_multiple' => true,
                'content' => "banner.svg"
            ],
        ];

        Cms::insert($cms);
    }
}
