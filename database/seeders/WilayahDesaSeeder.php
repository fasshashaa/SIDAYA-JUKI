<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahDesaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Cilacap Tengah', 'Donan'], ['Cilacap Tengah', 'Gunungsimping'], ['Cilacap Tengah', 'Kutawaru'], ['Cilacap Tengah', 'Lomanis'], ['Cilacap Tengah', 'Sidanegara'],
            ['Cilacap Utara', 'Bangunkerto'], ['Cilacap Utara', 'Kebonmanis'], ['Cilacap Utara', 'Mertasinga'], ['Cilacap Utara', 'Trisula'], ['Cilacap Utara', 'Gumilir'],
            ['Cilacap Selatan', 'Cilacap'], ['Cilacap Selatan', 'Sidakaya'], ['Cilacap Selatan', 'Tambakreja'], ['Cilacap Selatan', 'Tegalkamulyan'], ['Cilacap Selatan', 'Sentolokawat'],
            ['Adipala', 'Adipala'], ['Adipala', 'Bunton'], ['Adipala', 'Glempangpasir'], ['Adipala', 'Gombolharjo'], ['Adipala', 'Karanganyar'], ['Adipala', 'Karangbenda'], ['Adipala', 'Karangreja'], ['Adipala', 'Pedasong'], ['Adipala', 'Penggalang'], ['Adipala', 'Pluneng'], ['Adipala', 'Wlahar'],
            ['Majenang', 'Bener'], ['Majenang', 'Boja'], ['Majenang', 'Cibeunying'], ['Majenang', 'Cilopadang'], ['Majenang', 'Jenang'], ['Majenang', 'Mulyadadi'], ['Majenang', 'Mulyasari'], ['Majenang', 'Padangjaya'], ['Majenang', 'Sindangsari'], ['Majenang', 'Ujungbarang'],
            ['Cimanggu', 'Bantarpanjang'], ['Cimanggu', 'Cibalung'], ['Cimanggu', 'Cilempuyang'], ['Cimanggu', 'Cimanggu'], ['Cimanggu', 'Cisumur'], ['Cimanggu', 'Karangreja'], ['Cimanggu', 'Mandala'], ['Cimanggu', 'Negarajati'], ['Cimanggu', 'Pesahangan'], ['Cimanggu', 'Rejodadi'],
            ['Bantarsari', 'Bantarsari'], ['Bantarsari', 'Binangun'], ['Bantarsari', 'Cikedondong'], ['Bantarsari', 'Kamulyan'], ['Bantarsari', 'Kedungwringin'], ['Bantarsari', 'Rawajaya'],
            ['Kedungreja', 'Bangunreja'], ['Kedungreja', 'Bojongsari'], ['Kedungreja', 'Ciklapa'], ['Kedungreja', 'Jatisari'], ['Kedungreja', 'Kaliwuri'], ['Kedungreja', 'Kedungreja'], ['Kedungreja', 'Rebamulya'], ['Kedungreja', 'Sidanegara'], ['Kedungreja', 'Tambakreja'],
            ['Kesugihan', 'Bulupayung'], ['Kesugihan', 'Ciwuni'], ['Kesugihan', 'Dengkeng'], ['Kesugihan', 'Karangjengkol'], ['Kesugihan', 'Karangkandri'], ['Kesugihan', 'Kesugihan'], ['Kesugihan', 'Kuris'], ['Kesugihan', 'Menganti'], ['Kesugihan', 'Slarang'],
            ['Binangun', 'Alangamba'], ['Binangun', 'Bangkal'], ['Binangun', 'Binangun'], ['Binangun', 'Karangnangka'], ['Binangun', 'Kepudang'], ['Binangun', 'Pasuruhan'], ['Binangun', 'Pekuncen'], ['Binangun', 'Sidayu'], ['Binangun', 'Widarapayung'],
            ['Nusawungu', 'Banjareja'], ['Nusawungu', 'Banjarwaru'], ['Nusawungu', 'Danasri'], ['Nusawungu', 'Jedug'], ['Nusawungu', 'Karangpakis'], ['Nusawungu', 'Karangsembung'], ['Nusawungu', 'Kedungbenda'], ['Nusawungu', 'Nusawungu'], ['Nusawungu', 'Purwosari'],
            ['Kroya', 'Bajing'], ['Kroya', 'Buntu'], ['Kroya', 'Karangmangu'], ['Kroya', 'Kroya'], ['Kroya', 'Merwung'], ['Kroya', 'Mujur'], ['Kroya', 'Pucungkidul'], ['Kroya', 'Pekuncen'], ['Kroya', 'Sikampuh'],
            ['Maos', 'Glempang'], ['Maos', 'Karangkemiri'], ['Maos', 'Klapagada'], ['Maos', 'Maos Kidul'], ['Maos', 'Maos Lor'], ['Maos', 'Mergangsan'], ['Maos', 'Panisian'], ['Maos', 'Punthuk'],
            ['Jeruklegi', 'Brebeg'], ['Jeruklegi', 'Cilibang'], ['Jeruklegi', 'Citepus'], ['Jeruklegi', 'Jambusari'], ['Jeruklegi', 'Jeruklegi Kulon'], ['Jeruklegi', 'Jeruklegi Wetan'], ['Jeruklegi', 'Prapagan'], ['Jeruklegi', 'Sumingkir'],
            ['Kawunganten', 'Babakan'], ['Kawunganten', 'Bo Bo'], ['Kawunganten', 'Boong'], ['Kawunganten', 'Glempang'], ['Kawunganten', 'Kalijeruk'], ['Kawunganten', 'Kawunganten'], ['Kawunganten', 'Mentasan'], ['Kawunganten', 'Sarwadadi'], ['Kawunganten', 'Ujungmanik'],
            ['Gandrungmangu', 'Bantarmangu'], ['Gandrungmangu', 'Cisumur'], ['Gandrungmangu', 'Gandrungmangu'], ['Gandrungmangu', 'Gandrungmanis'], ['Gandrungmangu', 'Karanganyar'], ['Gandrungmangu', 'Kertajaya'], ['Gandrungmangu', 'Layansari'], ['Gandrungmangu', 'Muktisari'],
            ['Sidareja', 'Gunungreja'], ['Sidareja', 'Kunci'], ['Sidareja', 'Margasari'], ['Sidareja', 'Penolih'], ['Sidareja', 'Sidamulya'], ['Sidareja', 'Sidareja'], ['Sidareja', 'Sudagaran'], ['Sidareja', 'Tinggarjaya'],
            ['Karangpucung', 'Bengbulang'], ['Karangpucung', 'Cidadap'], ['Karangpucung', 'Cipasung'], ['Karangpucung', 'Karangpucung'], ['Karangpucung', 'Tayem'], ['Karangpucung', 'Pangawaren'], ['Karangpucung', 'Surusunda'],
            ['Wanareja', 'Adimulya'], ['Wanareja', 'Bantar'], ['Wanareja', 'Cigintung'], ['Wanareja', 'Cilongkrang'], ['Wanareja', 'Jatisari'], ['Wanareja', 'Majingklak'], ['Wanareja', 'Malabar'], ['Wanareja', 'Palugon'], ['Wanareja', 'Wanareja'],
            ['Dayeuhluhur', 'Bingkeng'], ['Dayeuhluhur', 'Cigerendeng'], ['Dayeuhluhur', 'Cilumping'], ['Dayeuhluhur', 'Dayeuhluhur'], ['Dayeuhluhur', 'Hanum'], ['Dayeuhluhur', 'Kutaagung'], ['Dayeuhluhur', 'Matenggeng'], ['Dayeuhluhur', 'Samping'],
            ['Sampang', 'Karangtengah'], ['Sampang', 'Ketanggung'], ['Sampang', 'Nusajati'], ['Sampang', 'Pakuwon'], ['Sampang', 'Sampang'], ['Sampang', 'Sidasari'],
            ['Cipari', 'Caruy'], ['Cipari', 'Cipari'], ['Cipari', 'Cisuru'], ['Cipari', 'Karangreja'], ['Cipari', 'Kutasari'], ['Cipari', 'Mulyadadi'], ['Cipari', 'Pegadingan'], ['Cipari', 'Serang'],
            ['Patimuan', 'Bulupayung'], ['Patimuan', 'Cinyawang'], ['Patimuan', 'Patimuan'], ['Patimuan', 'Purwodadi'], ['Patimuan', 'Rawaapu'], ['Patimuan', 'Sidamukti'],
            ['Kampung Laut', 'Klaces'], ['Kampung Laut', 'Panikel'], ['Kampung Laut', 'Ujungalor'], ['Kampung Laut', 'Ujunggagak']
        ];

        foreach ($data as $item) {
            DB::table('wilayah_desas')->insert([
                'kecamatan_nama' => $item[0],
                'nama_desa' => $item[1],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}