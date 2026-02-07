<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\News;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::where('state', '=', 'reviewed')->get();

        News::create([
            'event_id' => $events[0]->id,
            'news_title' => 'Buang Sampah Bersama di Sunter',
            'image_url' => 'news/events/KXOy9hrxcKyDTEZQrGxynpW53DPhbJdPCFzZFH0b.jpg;news/events/YiXgSg1iveQECrGdhhQGXKUTOBriCw5qJK72P8TX.jpg;news/events/ztXGbN6kOYZAMhMENCDvBFPnNLG0r24JSnaXgttx.jpg',
            'desc' => 'Di tengah hiruk pikuk kota yang tak pernah tidur, seseorang berjalan perlahan sambil menatap langit senja yang mulai memudar. Angin sore membawa aroma hujan yang belum turun, membangkitkan kenangan lama yang samar namun hangat. Lampu-lampu jalan mulai menyala satu per satu, menandai datangnya malam yang penuh misteri. Dalam kesunyian yang ramai itu, ia tersenyum kecil—menyadari bahwa setiap langkah, sekecil apa pun, tetap berarti dalam perjalanan panjang kehidupan.'
        ]);
        News::create([
            'event_id' => $events[1]->id,
            'news_title' => 'Realisasi kerja bakti pembersihan kawasan sekolah Santa Maria',
            'image_url' => 'news/events/j76YaXLTPTaxJKJRMcfyuwxHGbPwutM9oeAgVYPj.jpg;news/events/Aer6K5CXCrjCxyPJeDueYzXEV44434nURa0y31Ny.jpg;news/events/D0kjeaGWweePqlaONZpiUum4MdKc3kLIS5Px4pHo.jpg',
            'desc' => 'Di tengah hiruk pikuk kota yang tak pernah tidur, seseorang berjalan perlahan sambil menatap langit senja yang mulai memudar. Angin sore membawa aroma hujan yang belum turun, membangkitkan kenangan lama yang samar namun hangat. Lampu-lampu jalan mulai menyala satu per satu, menandai datangnya malam yang penuh misteri. Dalam kesunyian yang ramai itu, ia tersenyum kecil—menyadari bahwa setiap langkah, sekecil apa pun, tetap berarti dalam perjalanan panjang kehidupan.'
        ]);
        News::create([
            'event_id' => $events[2]->id,
            'news_title' => 'Penyerahan hasil kumpulan donasi untuk pesantren Al Brokah',
            'image_url' => 'news/events/hnXkhzylpR5UWVworCpm5Z9h7tp5PL76vTG45C47.jpg;news/events/PLssmpVb3fhVCJbtQhl9uxmSkktHFaBcGNOJzjor.jpg',
            'desc' => 'Di tengah hiruk pikuk kota yang tak pernah tidur, seseorang berjalan perlahan sambil menatap langit senja yang mulai memudar. Angin sore membawa aroma hujan yang belum turun, membangkitkan kenangan lama yang samar namun hangat. Lampu-lampu jalan mulai menyala satu per satu, menandai datangnya malam yang penuh misteri. Dalam kesunyian yang ramai itu, ia tersenyum kecil—menyadari bahwa setiap langkah, sekecil apa pun, tetap berarti dalam perjalanan panjang kehidupan.'
        ]);
        News::create([
            'event_id' => $events[3]->id,
            'news_title' => 'Partisipasi warga sekitar dalam mendonorkan darah di Puskesmas Citayem',
            'image_url' => 'news/events/BbnBtfO50JsEc4jsr4Yh2mcUbF3EJBkt5uawfVOj.jpg;news/events/L82nPsqqsUZlbF7Vb2wUJ8GGmuzwuF0rzV8bYsR9.jpg',
            'desc' => 'Di tengah hiruk pikuk kota yang tak pernah tidur, seseorang berjalan perlahan sambil menatap langit senja yang mulai memudar. Angin sore membawa aroma hujan yang belum turun, membangkitkan kenangan lama yang samar namun hangat. Lampu-lampu jalan mulai menyala satu per satu, menandai datangnya malam yang penuh misteri. Dalam kesunyian yang ramai itu, ia tersenyum kecil—menyadari bahwa setiap langkah, sekecil apa pun, tetap berarti dalam perjalanan panjang kehidupan.'
        ]);
        News::create([
            'event_id' => $events[4]->id,
            'news_title' => 'Pengobatan gratis RS Wahana',
            'image_url' => 'news/events/RTzICRM7KW5OYr2e00XEM83zMUTF04bhDVstEwM7.jpg;news/events/zjFvz7l1HMH8LzB7xCxnq8dHMlrjDKxrMEFPw9Dh.jpg;news/events/D5oCoygDTv9OvDKKkaF1wGltIbq6z6WFu0XpCMci.jpg',
            'desc' => 'Di tengah hiruk pikuk kota yang tak pernah tidur, seseorang berjalan perlahan sambil menatap langit senja yang mulai memudar. Angin sore membawa aroma hujan yang belum turun, membangkitkan kenangan lama yang samar namun hangat. Lampu-lampu jalan mulai menyala satu per satu, menandai datangnya malam yang penuh misteri. Dalam kesunyian yang ramai itu, ia tersenyum kecil—menyadari bahwa setiap langkah, sekecil apa pun, tetap berarti dalam perjalanan panjang kehidupan.'
        ]);
        News::create([
            'event_id' => $events[5]->id,
            'news_title' => 'Realisasi Bakti sosial di GKPA Samanhudi',
            'image_url' => 'news/events/ksWFhOcuDMYVpYV8LHIvikbu5B7MQxZzRymv6hzs.png;news/events/0IQmPqAwnWs87onyi3lJX7caX7s5250LY7F7pyO0.jpg;news/events/7B2oa7k96f9P4Ly5CUgD0zxv3ONO1ivlZFoXDzk5.jpg',
            'desc' => 'Di tengah hiruk pikuk kota yang tak pernah tidur, seseorang berjalan perlahan sambil menatap langit senja yang mulai memudar. Angin sore membawa aroma hujan yang belum turun, membangkitkan kenangan lama yang samar namun hangat. Lampu-lampu jalan mulai menyala satu per satu, menandai datangnya malam yang penuh misteri. Dalam kesunyian yang ramai itu, ia tersenyum kecil—menyadari bahwa setiap langkah, sekecil apa pun, tetap berarti dalam perjalanan panjang kehidupan.'
        ]);
        
        // seeder for organization
        // for ($i=1; $i<=10; $i++)
        // {
        //     $user = User::create([
        //         'name' => 'test' . $i,
        //         'email'=> 'test' . $i . '@gmail.com',
        //         'email_verified_at' => Carbon::now(),
        //         'password' => 'test' . $i,
        //         'role' => 'organization'
        //     ]);
    
        //     $organization = Organization::create([
        //         'user_id' => $user->id,
        //         'organization_category_id' => 1,
        //         'city_id' => 1,
        //         'description' => 'Kami merupakan organisasi yang berfokus pada pengembangan komunitas berkelanjutan melalui pendekatan sosial dan lingkungan. Mereka menginisiasi berbagai program pemberdayaan masyarakat seperti pelatihan kewirausahaan sosial, edukasi berbasis komunitas, serta pembangunan ekosistem lokal yang tangguh dan inklusif. Visi mereka adalah menciptakan dunia yang lebih adil dan setara dengan melibatkan masyarakat sebagai agen perubahan.',
        //         'founded_at' => '2024-01-01',
        //         'instagram' => '@test' . $i,
        //         'phone' => '08123456',
        //         'state' => 'approved'
        //     ]);

        //     $organization->volunteers()->attach(1);
        //     $organization->volunteers()->attach(2);
        //     $organization->volunteers()->attach(3);
    
        //     $event = Event::create([
        //         'organization_id' => $organization->id,
        //         'event_category_id' => 1,
        //         'name' => 'Membersihkan Sampah disekitar Danau Sunter',
        //         'date' => Carbon::now()->subDays(3),
        //         'start_time' => '08:00:00',
        //         'end_time' => '10:00:00',
        //         'image_url' => 'events/aksi1.jpg',
        //         'description' => 'Mari bergabung dalam kegiatan Bersih-Bersih Danau Sunter yang akan diselenggarakan pada 7 Agustus 2025, pukul 08.00 hingga 10.00 pagi. Acara ini bertujuan untuk membersihkan area sekitar Danau Sunter dari sampah plastik dan limbah lainnya, sekaligus meningkatkan kesadaran masyarakat akan pentingnya menjaga kebersihan lingkungan. Kegiatan ini terbuka untuk umum dan akan melibatkan berbagai komunitas serta relawan yang peduli terhadap lingkungan. Selain aksi bersih-bersih, peserta juga akan mendapatkan edukasi singkat mengenai dampak sampah terhadap ekosistem danau. Yuk, ambil bagian dalam aksi kecil yang membawa dampak besar bagi lingkungan!',
        //         'location' => 'Sunter, Jakarta Utara, Daerah Khusus Ibukota Jakarta',
        //         'city_id' => 1,
        //         'latitude' => -6.1190347,
        //         'longitude' => 106.8962414,
        //         'available_slot' => 10,
        //         'point' => 7,
        //         'state' => 'approved'
        //     ]);

        //     $event->volunteers()->attach(1);
        //     $event->volunteers()->attach(2);
        //     $event->volunteers()->attach(3);
        // }
    }
}
