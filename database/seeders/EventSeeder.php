<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'organization_id' => 1,
            'event_category_id' => 1,
            'name' => 'Membersihkan Sampah disekitar Danau Sunter Barat',
            'date' => Carbon::now()->subDays(3),
            'start_time' => '08:00:00',
            'end_time' => '10:00:00',
            'image_url' => 'events/aksi1.jpg',
            'description' => 'Mari bergabung dalam kegiatan Bersih-Bersih Danau Sunter Barat yang akan diselenggarakan pada 7 Agustus 2025, pukul 08.00 hingga 10.00 pagi. Acara ini bertujuan untuk membersihkan area sekitar Danau Sunter Barat dari sampah plastik dan limbah lainnya, sekaligus meningkatkan kesadaran masyarakat akan pentingnya menjaga kebersihan lingkungan. Kegiatan ini terbuka untuk umum dan akan melibatkan berbagai komunitas serta relawan yang peduli terhadap lingkungan. Selain aksi bersih-bersih, peserta juga akan mendapatkan edukasi singkat mengenai dampak sampah terhadap ekosistem danau. Yuk, ambil bagian dalam aksi kecil yang membawa dampak besar bagi lingkungan!',
            'location' => 'Sunter',
            'city_id' => 1,
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'available_slot' => 15,
            'point' => 8,
            'state' => 'approved'
        ]);
        Event::create([
            'organization_id' => 1,
            'event_category_id' => 2,
            'name' => 'Penghijauan kembali kawasan hijau Angke Kapuk',
            'date' => Carbon::now()->addDays(3),
            'start_time' => '10:00:00',
            'end_time' => '11:30:00',
            'image_url' => 'events/aksi2.png',
            'description' => 'Ayo turut serta dalam kegiatan Penghijauan Kawasan Hijau Angke Kapuk yang akan dilaksanakan pada 8 Agustus 2025, pukul 10.00 hingga 11.30 WIB. Acara ini bertujuan untuk menanam pohon dan tanaman lokal sebagai upaya pelestarian ekosistem serta peningkatan kualitas udara di kawasan Angke Kapuk. Melalui kegiatan ini, para peserta diajak untuk lebih peduli terhadap pentingnya ruang hijau di tengah pesatnya urbanisasi. Dengan partisipasi aktif dari relawan, komunitas, dan masyarakat sekitar, kegiatan ini diharapkan dapat menjadi langkah nyata dalam menjaga keberlanjutan lingkungan hidup.',
            'location' => 'Pantai Indah Kapuk',
            'city_id' => 2,
            'latitude' => -6.9147,
            'longitude' => 107.6098,
            'available_slot' => 20,
            'point' => 7,
            'state' => 'approved'
        ]);
        Event::create([
            'organization_id' => 1,
            'event_category_id' => 3,
            'name' => 'Kerja Bakti membersihkan kawasan sekolah Santa Maria',
            'date' => Carbon::now()->subDays(1),
            'start_time' => '07:00:00',
            'end_time' => '08:00:00',
            'image_url' => 'events/aksi3.jpg',
            'description' => 'Mari bergotong royong dalam Kerja Bakti Bersama di Kawasan Sekolah Santa Maria yang akan dilaksanakan pada 3 September 2025, pukul 07.00 hingga 08.00 pagi. Kegiatan ini bertujuan untuk membersihkan lingkungan sekolah dan sekitarnya, menciptakan suasana yang lebih nyaman, sehat, dan mendukung proses belajar mengajar. Para siswa, guru, orang tua, dan masyarakat sekitar diundang untuk berpartisipasi aktif dalam aksi kebersamaan ini. Selain mempererat solidaritas antarwarga sekolah, kerja bakti ini juga menjadi wujud nyata kepedulian terhadap kebersihan dan kerapihan lingkungan.',
            'location' => 'Batu Tulis',
            'city_id' => 3,
            'latitude' => -7.2575,
            'longitude' => 112.7521,
            'available_slot' => 30,
            'point' => 7,
            'state' => 'reviewed'
        ]);

        Event::create([
            'organization_id' => 2,
            'event_category_id' => 4,
            'name' => 'Donasi pesantren Al Barokah',
            'date' => Carbon::now(),
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'image_url' => 'events/aksi4.jpeg',
            'description' => 'Mari berbagi kebaikan melalui kegiatan Donasi ke Pesantren Al Barokah yang akan diselenggarakan pada 10 September 2025, pukul 09.00 hingga 11.00 pagi. Acara ini merupakan bentuk kepedulian sosial terhadap kebutuhan para santri di Pesantren Al Barokah, yang mencakup pemberian bantuan berupa sembako, perlengkapan belajar, pakaian layak pakai, dan kebutuhan sehari-hari lainnya. Kegiatan ini terbuka bagi siapa saja yang ingin berkontribusi, baik secara langsung maupun melalui donasi barang. Bersama-sama, mari kita ringankan beban dan dukung semangat belajar para santri demi masa depan yang lebih cerah.',
            'location' => 'Kebon Jeruk',
            'city_id' => 4,
            'latitude' => 3.5952,
            'longitude' => 	98.6722,
            'available_slot' => 10,
            'point' => 10,
            'state' => 'approved'
        ]);
        Event::create([
            'organization_id' => 2,
            'event_category_id' => 5,
            'name' => 'Acara donor darah Puskesmas Citayem',
            'date' => Carbon::now()->addDays(1),
            'start_time' => '10:00:00',
            'end_time' => '13:00:00',
            'image_url' => 'events/aksi5.jpg',
            'description' => 'Ayo ikut berpartisipasi dalam kegiatan Aksi Donor Darah di Puskesmas Citayam yang akan dilaksanakan pada 1 Oktober 2025, pukul 11.00 hingga 13.00 WIB. Kegiatan ini bertujuan untuk membantu memenuhi kebutuhan stok darah nasional serta menyelamatkan nyawa mereka yang membutuhkan. Terbuka untuk umum, acara ini bekerja sama dengan PMI dan tim medis profesional untuk memastikan proses donor berlangsung aman dan nyaman. Setiap tetes darah yang Anda sumbangkan dapat menjadi harapan bagi banyak orang. Mari berbagi kehidupan melalui aksi nyata ini!',
            'location' => 'Citayem',
            'city_id' => 5,
            'latitude' => -5.1477,
            'longitude' => 119.4327,
            'available_slot' => 20,
            'point' => 9,
            'state' => 'approved'
        ]);
        Event::create([
            'organization_id' => 2,
            'event_category_id' => 1,
            'name' => 'Aksi layanan sehat pengobatan gratis RS Wahana',
            'date' => Carbon::now()->addDays(2),
            'start_time' => '08:00:00',
            'end_time' => '10:00:00',
            'image_url' => 'events/aksi6.webp',
            'description' => 'Ikuti kegiatan Aksi Layanan Sehat dan Pengobatan Gratis yang akan diadakan di RS Wahana pada 3 Oktober 2025, pukul 08.00 hingga 10.00 pagi. Acara ini menyediakan layanan pemeriksaan kesehatan umum, konsultasi medis, dan pengobatan gratis bagi masyarakat sekitar, khususnya bagi mereka yang membutuhkan. Didukung oleh tenaga medis profesional dari RS Wahana, kegiatan ini bertujuan untuk meningkatkan akses kesehatan dan mendorong kesadaran akan pentingnya pemeriksaan dini. Jangan lewatkan kesempatan ini untuk menjaga kesehatan Anda dan orang-orang tercinta secara gratis dan berkualitas!',
            'location' => 'Bogor',
            'city_id' => 6,
            'latitude' => -2.5337,
            'longitude' => 140.7181,
            'available_slot' => 30,
            'point' => 7,
            'state' => 'reviewed'
        ]);

        Event::create([
            'organization_id' => 3,
            'event_category_id' => 2,
            'name' => 'Kerja Bakti Posko Keadilan',
            'date' => Carbon::now()->addDays(3),
            'start_time' => '08:00:00',
            'end_time' => '10:00:00',
            'image_url' => 'events/aksi7.JPG',
            'description' => 'Yuk, bergabung dalam Kerja Bakti Posko Keadilan di Tamansari yang akan dilaksanakan pada 23 Oktober 2025, pukul 08.00 hingga 10.00 pagi. Kegiatan ini bertujuan untuk membersihkan dan merapikan area sekitar posko, sekaligus memperkuat semangat kebersamaan dan kepedulian sosial di lingkungan Tamansari. Seluruh warga, relawan, dan komunitas lokal diundang untuk ikut serta dalam aksi gotong royong ini demi menciptakan ruang bersama yang bersih, nyaman, dan fungsional. Mari kita rawat lingkungan kita dengan aksi nyata!',
            'location' => 'Taman Sari',
            'city_id' => 5,
            'latitude' => -5.1477,
            'longitude' => 119.4327,
            'available_slot' => 30,
            'point' => 5,
            'state' => 'approved'
        ]);
        Event::create([
            'organization_id' => 3,
            'event_category_id' => 3,
            'name' => 'Bakti sosial di GKPA Samanhudi',
            'date' => Carbon::now()->addDays(4),
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'image_url' => 'events/aksi8.JPG',
            'description' => 'Mari ambil bagian dalam Bakti Sosial GPKA Samanhudi yang akan diselenggarakan pada 30 Oktober 2025, pukul 09.00 hingga 11.00 pagi. Kegiatan ini merupakan wujud nyata kepedulian terhadap sesama melalui pembagian paket sembako, layanan kesehatan ringan, dan kegiatan interaksi sosial bersama warga sekitar. Melalui aksi ini, GPKA Samanhudi ingin menebarkan kasih dan semangat solidaritas kepada masyarakat yang membutuhkan. Ajak keluarga dan sahabat untuk turut serta dalam kegiatan penuh makna ini dan jadilah bagian dari perubahan positif di lingkungan kita.',
            'location' => 'Samanhudi Barat',
            'city_id' => 5,
            'latitude' => -5.1477,
            'longitude' => 119.4327,
            'available_slot' => 20,
            'point' => 5,
            'state' => 'reviewed'
        ]);
        Event::create([
            'organization_id' => 3,
            'event_category_id' => 4,
            'name' => 'Reboisasi Kawasan Hijau Menteng',
            'date' => Carbon::now()->addDays(5),
            'start_time' => '07:00:00',
            'end_time' => '10:00:00',
            'image_url' => 'events/aksi9.JPG',
            'description' => 'Ayo ikut serta dalam kegiatan Reboisasi Kawasan Hijau Menteng yang akan dilaksanakan pada 1 November 2025, pukul 07.00 hingga 10.00 pagi. Acara ini bertujuan untuk menanam kembali pohon-pohon di area hijau Menteng sebagai upaya pelestarian lingkungan dan peningkatan kualitas udara di tengah kota. Melalui kegiatan ini, masyarakat diajak untuk lebih peduli terhadap pentingnya ruang terbuka hijau sebagai paru-paru kota. Bersama relawan, komunitas pecinta lingkungan, dan warga sekitar, mari kita hijaukan kembali Menteng demi masa depan yang lebih sejuk dan berkelanjutan.',
            'location' => 'Menteng',
            'city_id' => 5,
            'latitude' => -5.1477,
            'longitude' => 119.4327,
            'available_slot' => 10,
            'point' => 8,
            'state' => 'reviewed'
        ]);

        
        Event::create([
            'organization_id' => 4,
            'event_category_id' => 5,
            'name' => 'Kerja Bakti pembersihan kawasan Ragunan',
            'date' => Carbon::now()->addDays(6),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'image_url' => 'events/aksi10.JPG',
            'description' => 'Mari bergabung dalam Kerja Bakti Pembersihan Kawasan Ragunan yang akan dilaksanakan pada 19 Oktober 2025, pukul 10.00 hingga 12.00 WIB. Kegiatan ini bertujuan untuk membersihkan area publik di sekitar Ragunan dari sampah dan kotoran, guna menciptakan lingkungan yang lebih bersih, nyaman, dan asri bagi pengunjung maupun satwa. Dukung aksi ini bersama komunitas, relawan, dan warga sekitar sebagai bentuk kepedulian kita terhadap ruang hijau dan fasilitas umum. Dengan semangat gotong royong, mari wujudkan Ragunan yang lebih bersih dan tertata!',
            'location' => 'Ragunan',
            'city_id' => 10,
            'latitude' => -5.1477,
            'longitude' => 119.4327,
            'available_slot' => 30,
            'point' => 5,
            'state' => 'approved'
        ]);
        Event::create([
            'organization_id' => 4,
            'event_category_id' => 1,
            'name' => 'Pembersihan Lingkungan Roxy dengan tim Jejak Baik',
            'date' => Carbon::now()->addDays(7),
            'start_time' => '14:00:00',
            'end_time' => '16:00:00',
            'image_url' => 'events/aksi11.JPG',
            'description' => 'Yuk, ikut serta dalam Kerja Bakti Lingkungan Roxy bersama Tim Jejak Baik yang akan diadakan pada 21 Oktober 2025, pukul 14.00 hingga 16.00 WIB. Kegiatan ini bertujuan untuk membersihkan dan merapikan area permukiman dan fasilitas umum di kawasan Roxy, sekaligus mengajak warga untuk lebih peduli terhadap kebersihan lingkungan sekitar. Dengan semangat kolaborasi bersama Tim Jejak Baik dan partisipasi masyarakat, mari kita ciptakan lingkungan yang lebih bersih, sehat, dan nyaman untuk semua. Aksi kecil kita hari ini, dampaknya besar untuk masa depan!',
            'location' => 'Roxy',
            'city_id' => 2,
            'latitude' => -5.1477,
            'longitude' => 119.4327,
            'available_slot' => 15,
            'point' => 8,
            'state' => 'reviewed'
        ]);
        Event::create([
            'organization_id' => 4,
            'event_category_id' => 2,
            'name' => 'Kerja Bakti daerah Pasar Baru dengan tim PMI',
            'date' => Carbon::now()->addDays(8),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'image_url' => 'events/aksi12.JPG',
            'description' => 'Ayo bergotong royong dalam Kerja Bakti di Daerah Pasar Baru bersama Tim PMI yang akan dilaksanakan pada 1 Desember 2025, pukul 10.00 hingga 12.00 WIB. Kegiatan ini bertujuan untuk membersihkan area pasar dan sekitarnya, menciptakan lingkungan yang lebih sehat, tertib, dan nyaman bagi para pedagang maupun pengunjung. Bersama Palang Merah Indonesia (PMI) dan warga sekitar, aksi ini juga menjadi bentuk kepedulian sosial serta upaya pencegahan penyebaran penyakit akibat lingkungan yang kurang bersih. Mari tunjukkan semangat gotong royong dan wujudkan Pasar Baru yang lebih bersih dan rapi!',
            'location' => 'Citayem',
            'city_id' => 3,
            'latitude' => -5.1477,
            'longitude' => 119.4327,
            'available_slot' => 20,
            'point' => 8,
            'state' => 'reviewed'
        ]);

        // dummy data for chart
        for ($i=5; $i>0; $i--)
        {
            for ($j=0; $j<rand(1, 50); $j++)
            {
                Event::create([
                    'organization_id' => 5,
                    'event_category_id' => rand(1, 5),
                    'name' => '',
                    'date' => Carbon::now()->subMonths($i),
                    'start_time' => '00:00:00',
                    'end_time' => '00:00:00',
                    'image_url' => '',
                    'description' => '',
                    'location' => '',
                    'city_id' => 1,
                    'latitude' => 1,
                    'longitude' => 1,
                    'available_slot' => 1,
                ]);
            }
        }
    }
}
