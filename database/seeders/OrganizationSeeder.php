<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::create([
            'user_id' => 6,
            'organization_category_id' => 1,
            'city_id' => 1,
            'description' => 'GoRelawan adalah platform sosial yang menghubungkan individu dengan berbagai kegiatan kerelawanan di seluruh Indonesia. Dengan pendekatan berbasis digital, GoRelawan memudahkan masyarakat untuk berkontribusi dalam aksi sosial, mulai dari bantuan bencana hingga program pendidikan dan kesehatan. Organisasi ini mendorong semangat gotong royong dengan menyediakan akses mudah bagi siapa pun yang ingin terlibat dalam perubahan positif di masyarakat.',
            'founded_at' => '2024-01-01',
            'instagram' => '@GoGoRelawan',
            'phone' => '0877132465',
            'state' => 'approved'
        ]);
        Organization::create([
            'user_id' => 7,
            'organization_category_id' => 2,
            'city_id' => 2,
            'description' => 'Cipta Semesta merupakan organisasi yang berfokus pada pengembangan komunitas berkelanjutan melalui pendekatan sosial dan lingkungan. Mereka menginisiasi berbagai program pemberdayaan masyarakat seperti pelatihan kewirausahaan sosial, edukasi berbasis komunitas, serta pembangunan ekosistem lokal yang tangguh dan inklusif. Visi mereka adalah menciptakan dunia yang lebih adil dan setara dengan melibatkan masyarakat sebagai agen perubahan.',
            'founded_at' => '2024-01-02',
            'instagram' => '@CiptaSemestaku',
            'phone' => '0818909808',
            'state' => 'approved'
        ]);
        Organization::create([
            'user_id' => 8,
            'organization_category_id' => 2,
            'city_id' => 4,
            'description' => 'Indonesia Hijau adalah organisasi yang bergerak dalam pelestarian lingkungan hidup dengan menitikberatkan pada aksi nyata dan edukasi publik. Kegiatan mereka meliputi penanaman pohon, kampanye pengurangan sampah, dan edukasi tentang perubahan iklim. Indonesia Hijau berupaya mengajak masyarakat untuk lebih peduli terhadap alam dan turut serta dalam menjaga keseimbangan ekosistem demi masa depan yang berkelanjutan.',
            'founded_at' => '2024-01-09',
            'instagram' => '@GreenIndonesia',
            'phone' => '0878654321',
            'state' => 'approved'
        ]);
        Organization::create([
            'user_id' => 9,
            'organization_category_id' => 2,
            'city_id' => 7,
            'description' => 'Peaceful World adalah organisasi yang mempromosikan nilai-nilai perdamaian melalui kegiatan lintas budaya dan generasi. Mereka mengadakan event sosial seperti dialog antaragama, workshop toleransi, dan pertukaran budaya untuk menumbuhkan rasa saling menghargai dan menghormati perbedaan. Peaceful World percaya bahwa perdamaian dimulai dari pemahaman dan kolaborasi, terutama di tengah masyarakat yang semakin beragam.',
            'founded_at' => '2024-01-12',
            'instagram' => '@Peacefulworldy',
            'phone' => '0812456109',
            'state' => 'approved'
        ]);
        Organization::create([
            'user_id' => 10,
            'organization_category_id' => 1,
            'city_id' => 3,
            'description' => 'Sikapi Indonesia adalah organisasi sosial yang berfokus pada peningkatan kesadaran masyarakat terhadap isu-isu kebangsaan, toleransi, dan tanggung jawab sosial melalui edukasi serta aksi nyata di lapangan. Melalui berbagai kegiatan seperti diskusi publik, kampanye sosial, hingga kerja bakti dan penggalangan bantuan, Sikapi Indonesia mendorong partisipasi aktif generasi muda dalam membangun masyarakat yang kritis, peduli, dan berdaya. Dengan semangat kolaborasi lintas komunitas, organisasi ini hadir sebagai ruang gerak bagi warga yang ingin turut andil dalam menciptakan Indonesia yang lebih adil, inklusif, dan berkelanjutan.',
            'founded_at' => '2024-01-12',
            'instagram' => '@sikapindonesia',
            'phone' => '0812213899',
            'state' => 'approved'
        ]);
    }
}
