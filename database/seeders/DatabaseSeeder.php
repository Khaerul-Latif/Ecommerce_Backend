<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Alamat;
use App\Models\GambarProduk;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\User;
use App\Models\Variant;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call([
        //     KategoriSeeder::class,
        //     ProdukSeeder::class,
        //     VariantSeeder::class,
        //     GambarProdukSeeder::class,
        // ]);


        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);


        User::create([
            'name' => 'User',
            'email' => 'user@email.com',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);

        Alamat::create([
            'user_id' => 1,
            "alamat_lengkap" => "Jl. Raya Admin",
        ]);

        Alamat::create([
            'user_id' => 2,
            "alamat_lengkap" => "Jl. Raya User",
        ]);

        Kategori::create([
            'nama' => 'Sepatu',
            'slug' => 'sepatu',
        ]);

        Kategori::create([
            'nama' => 'Jaket',
            'slug' => 'jaket',
        ]);

        Kategori::create([
            'nama' => 'Tas',
            'slug' => 'tas',
        ]);

        Kategori::create([
            'nama' => 'Sarung Tangan',
            'slug' => 'sarung-tangan',
        ]);

        Kategori::create([
            'nama' => 'Kaos Kaki',
            'slug' => 'kaos-kaki',
        ]);

        Kategori::create([
            'nama' => 'Tenda',
            'slug' => 'tenda',
        ]);

        Kategori::create([
            'nama' => 'Matras',
            'slug' => 'matras',
        ]);


        $produk = Produk::create([
            'kategori_id' => 1,
            'nama' => 'MAMBA LOW',
            'slug' => 'mamba-low',
            "deskripsi" => "Sepatu low-cut Mamba hadir secara khusus untuk para penggiat hiking di alam terbuka. Dirancang dengan kombinasi material nubuck dan Cordura yang tahan lama dan lapisan dalam dengan membran waterproof. Bagian dalam sepatu didukung insole Ortholite yang memberikan bantalan, breathable (memiliki daya evaporasi tinggi yang mampu menguapkan kelembapan sehingga cepat kering), dan ringan untuk menjaga kaki tetap nyaman. Sepatu ini juga memiliki outsole Vibram untuk grip yang lebih baik. Material: Upper: Nubuck & Cordura Midsole: Phylon Outsole: Rubber Fitur: 1. Insole Ortholite 2. Midsole Vibram 3. Grip outsole Vibram untuk cengkraman yang lebih baik 4. Material nubuck dan Cordura waterproof",
            "dimension" => "12 X 25 X 36",
            "berat" => "800",
            "material" => "Upper: Nubuck & Cordura",
            "display" => true,
        ]);
        foreach (range(38, 45) as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Black",
                "ukuran" => $index,
                "harga" => 1219000,
                "stok" => 50,
            ]);
        }

        foreach (range(38, 45) as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Grey",
                "ukuran" => $index,
                "harga" => 1219000,
                "stok" => 50,
            ]);
        }
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910008241_Image1_1_455c.webp",
        ]);
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910008241_Image1_1_7a5a.webp",
        ]);
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910008241_ee13.webp",
        ]);
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910008241_0862.webp",
        ]);
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910008241_bbea.webp",
        ]);

        $produk = Produk::create([
            'kategori_id' => 2,
            'nama' => 'MS EQUATOR WINDPROOF JKT F1',
            'slug' => 'ms-equator-windproof-jkt-f1',
            "deskripsi" => "MS Equator Windproof JKT F1 melindungi Anda dari terpaan angin dan hujan ringan selama Anda bertualang berkat teknologi Tropic Windblock dan Tropic Repellent. Berkeringat saat gerah tak lagi menjadi masalah karena sistem ventilasi pada punggung mendukung Anda dengan sirkulasi udara yang lebih baik, sehingga Anda dapat menjelajah dengan lebih bebas.",
            "dimension" => "69X53X1",
            "berat" => "210",
            "material" => "Polyester",
            "display" => true,
        ]);


        $array_ukuran = ["S", "M", "L", "XL", "XXL"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Terracota",
                "ukuran" => $index,
                "harga" => 626050,
                "stok" => 50,
            ]);
        }

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Black",
                "ukuran" => $index,
                "harga" => 626050,
                "stok" => 50,
            ]);
        }

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/photo/5c005914-ac47-4fb3-9b2e-728f5e956729.jpg",
        ]);

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/photo/a20229c8-a1a8-424f-b209-d03e190a5562.jpg",
        ]);
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/a8a8d377-9e92-4ec4-85aa-2255e21e498e.jpg",
        ]);
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/adf955d2-8117-43e0-90c7-93b1a01e521d.jpg",
        ]);


        $produk = Produk::create([
            'kategori_id' => 3,
            'nama' => 'Z-LUCID 45',
            'slug' => 'z-lucid-45',
            "deskripsi" => "Z-Lucid 45 adalah carrier berkapasitas 45 liter yang dirancang untuk kegiatan hiking singkat, yakni 1-2 hari. Kompartemen utama tas ini dapat diakses dengan mudah melalui bukaan atas. Di dalam saku tutup atas, terdapat saku di bagian dalam untuk menyimpan barang-barang yang lebih kecil. Tas ini juga memiliki dua saku samping sebagai tempat penyimpanan tambahan. Teknologi Fit Light Hike Backsystem pada tas ini berfungsi untuk memberikan kenyamanan saat melakukan kegiatan hiking dengan menyediakan sirkulasi udara yang lebih baik. Tas ini dilengkapi juga dengan fitur-fitur lain untuk mendukung kegiatan hiking Anda seperti pengikat trekking pole, tali kompresi samping, hip belt, dan tali dada dengan peluit.",
            "dimension" => "67X31,500X22",
            "berat" => "1100",
            "material" => "Nylon, Polyester",
            "display" => true,
        ]);


        $array_ukuran = ["oranye", "black", "olive"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => $index,
                "ukuran" => "45L",
                "harga" => 729000,
                "stok" => 50,
            ]);
        }

        

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/5764ee81-1579-4b66-beb7-69522778b422.webp",
        ]);

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/35e63726-ab52-4746-af79-9eeb4eaaf6a5.webp",
        ]);
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/2f2e4b4f-283b-4032-a1de-8c9577e2a30f.webp",
        ]);
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/8adb5b3c-7d5f-4587-bfe2-25ee1bb30f8d.webp",
        ]);
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/3d57ab8b-835f-4599-9d3e-567af5822ff3.webp",
        ]);

        $produk = Produk::create([
            'kategori_id' => 4,
            'nama' => 'EIGER TRANSITION 1.0 GLOVES',
            'slug' => 'eiger-transition-1-0-gloves',
            "deskripsi" => "Transition 1,0 adalah sarung tangan yang dirancang untuk menjaga tangan Anda tetap hangat saat beraktivitas luar ruang seperti hiking.Bagian dalam sarung tangan ini dilapisi membran tahan air yang menahan kelembapan dan angin untuk menjaga tangan tetap kering dannyaman. Bagian ujung ibu jari dan telunjuk sarung tangan ini memungkinkan Anda menggunakan ponsel tanpa harus melepaskannya.Fitur:1. Tahan air dan menghangatkan2. Dilapisi membran di bagian dalam, menjaga tangan tetap kering dan nyaman3. Memungkinkan ibu jari dan jari telunjuk dapat menggunakan ponsel tanpa harus melepas sarung tangan4. Bagian lengan elastis5. Tropic technology",
            "dimension" => "6 X 20 X 25",
            "berat" => "500",
            "material" => "95% Polyester & 5% Polyurithane",
            "display" => true,
        ]);


        $array_ukuran = ["S", "M", "L", "XL"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Black",
                "ukuran" => $index,
                "harga" => 247200,
                "stok" => 50,
            ]);
        }
        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Grey",
                "ukuran" => $index,
                "harga" => 247200,
                "stok" => 50,
            ]);
        }

        

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910005456_02ef.webp",
        ]);

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910005456_BLACK_1_caa6.webp",
        ]);
        
        
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910005456_GREY_1_15d7.webp",
        ]);

        $produk = Produk::create([
            'kategori_id' => 5,
            'nama' => 'BALMY MID',
            'slug' => 'balmy-mid',
            "deskripsi" => "Nyaman, pas, dan tahan lama, kaus kaki Balmy Mid Socks mendukungmu saat hiking dan camping. Dengan teknologi THERMOLITE yang efektif untuk menghangatkan kakimu, bagian telapak kaki yang empuk, dan desain arch support yang terasa pas dan nyaman di lekukan kakimu, kaus kaki yang ringan ini memberimu kenyamanan maksimal sepanjang hari.",
            "dimension" => "18X19X20",
            "berat" => "60",
            "material" => "Polyester 56%, Cotton 28%, Nylon 13%, dan Elastane 3%",
            "display" => true,
        ]);


        $array_ukuran = ["S", "M", "L"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Red",
                "ukuran" => $index,
                "harga" => 247200,
                "stok" => 50,
            ]);
        }
        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Yellow",
                "ukuran" => $index,
                "harga" => 247200,
                "stok" => 50,
            ]);
        }

        

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/806db225-985f-4f07-bace-1d6c45010120.jpg",
        ]);

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/photo/f047e587-e922-4911-806a-543c2b923bfb.jpg",
        ]);
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/80ac5801-120a-4cb1-ae96-ea314d873b69.jpg",
        ]);
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/548fec1a-a1f6-47f0-a367-22d4fa34e5da.jpg",
        ]);
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/8d3f3c55-a256-43d9-9c33-cd616746ec98.jpg",
        ]);

        $produk = Produk::create([
            'kategori_id' => 6,
            'nama' => 'CREEK 5P TENT',
            'slug' => 'creek-5p-tent',
            "deskripsi" => "Creek adalah tenda kemah untuk kapasitas 5 orang yang cocok digunakan untuk kegiatan berkemah bersama keluarga di akhir pekan. Tenda ini memiliki jala di bagian atap dan dalam untuk ventilasi, teras di bagian depan, dan seam taped, yang berfungsi untuk mencegah masuknya air saat hujan. Ketika tidak dipakai, Anda bisa menyimpannya kembali di carry bag. Ukuran: 300x240x152 cmFitur:- Tiang rangka fiberglass- Jalan di bagian atap untuk ventilasi udara- Teras di bagian depan- Seam taped, berfungsi untuk menutupi jahitan pada tenda agar dapat menahan masuknya air saat hujan- Dilengkapi tas praktis untuk menyimpan produk ini saat dibawa berpergian",
            "dimension" => "152 X 240 X 300",
            "berat" => "5500",
            "material" => "Fly: Polyester 1000mm, Inner: Polyester 1000mm, Floor: PE Sheet, Pole: Fiber glass",
            "display" => true,
        ]);


        $array_ukuran = ["Single-Size"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Orange",
                "ukuran" => $index,
                "harga" => 2139000,
                "stok" => 50,
            ]);
        }
        

        

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003783_bcfe.webp",
        ]);

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003783_6967.webp",
        ]);
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003783_290d.webp",
        ]);
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003783_e79e.webp",
        ]);
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003783_61bb.webp",
        ]);

        $produk = Produk::create([
            'kategori_id' => 7,
            'nama' => 'MATRAS CACING',
            'slug' => 'matras-cacing',
            "deskripsi" => "Eiger Matras Cacing menjadi salah satu pilihan bagi Anda yang senang camping atau aktivitas outdoor lainnya. Dengan bahan yang nyaman dan design yang simple, dilengkapi dengan tali pengikat sehingga mudah dibawa. Ukuran (PxL) : 178x60cm.",
            "dimension" => "0 X 12 X 25",
            "berat" => "800",
            "material" => "Foam",
            "display" => true,
        ]);


        $array_ukuran = ["Single-Size"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Orange",
                "ukuran" => $index,
                "harga" => 119000,
                "stok" => 50,
            ]);
        }
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910002328_10d5.webp",
        ]);
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910002328_67ad.webp",
        ]);
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910002328_90c7.webp",
        ]);





        $produk = Produk::create([
            'kategori_id' => 1,
            'nama' => 'MAMBA MID',
            'slug' => 'mamba-mid',
            "deskripsi" => "Sepatu mid-cut Mamba hadir secara khusus untuk para penggiat hiking di alam terbuka. Dirancang dengan kombinasi material nubuck dan Cordura yang tahan lama dan lapisan dalam dengan membran waterproof. Bagian dalam sepatu didukung insole Ortholite yang memberikan bantalan, breathable (memiliki daya evaporasi tinggi yang mampu menguapkan kelembapan sehingga cepat kering), dan ringan untuk menjaga kaki tetap nyaman. Sepatu ini juga memiliki outsole Vibram untuk grip yang lebih baik. Material: Upper: Nubuck & Cordura Midsole: Phylon Outsole: Rubber Fitur: 1. Insole Ortholite 2. Midsole Vibram 3. Grip outsole Vibram untuk cengkraman yang lebih baik 4. Material nubuck dan Cordura waterproof",
            "dimension" => "12 X 29.500 X 34",
            "berat" => "980",
            "material" => "Upper: Nubuck & Cordura",
            "display" => true,
        ]);

        foreach (range(38, 45) as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Grey",
                "ukuran" => $index,
                "harga" => 1262550,
                "stok" => 50,
            ]);
        }

        foreach (range(38, 45) as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Navi",
                "ukuran" => $index,
                "harga" => 1329000,
                "stok" => 50,
            ]);
        }


        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910008377_d41a.webp",
        ]);

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910008377_Image1_1_1c58.webp",
        ]);
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910008377_b722.webp",
        ]);

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910008377_18bd.webp",
        ]);

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910008377_6123.webp",
        ]);

        $produk = Produk::create([
            'kategori_id' => 2,
            'nama' => 'CROCKER JACKET',
            'slug' => 'crocker-jacket',
            "deskripsi" => "Crocker Jacket hadir dengan tampilan yang tangguh untuk performa urban Anda. Dengan teknologi Tropic Repellent dan Tropic Windblock, bahannya yang nyaman juga dapat melindungi Anda dari paparan hujan ringan dan angin. Kenakan jaket ini dengan mudah dan pas dengan kancing snap di bagian depan dan tali yang dapat disesuaikan pada bagian ujung bawah jaket.",
            "dimension" => "68X54X1",
            "berat" => "230",
            "material" => "100% Polyester",
            "display" => true,
        ]);

        $array_ukuran = ["S", "M", "L", "XL", "XXL"];
        
        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Camuflage",
                "ukuran" => $index,
                "harga" => 540550,
                "stok" => 50,
            ]);
        }

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/da929510-78e3-49f4-9449-e2619947d011.webp",
        ]);

        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/a43f49ff-a750-41df-b319-269794daeee0.webp",
        ]);

        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/aba715f8-2206-421f-846a-31daed3b3b06.webp",
        ]);


        $produk = Produk::create([
            'kategori_id' => 3,
            'nama' => 'SIRRUS 44 F22',
            'slug' => 'sirrus-44-f22',
            "deskripsi" => "You take your hiking seriously, and like to stretch your day hikes into lightweight overnights more often than not. The Sirrus 44 is a full-featured women's-specific pack built for rugged trails, rain or shine, with serious features and a top-loading design so you can easily stuff and go. It's a technical pack with a cloud-like carry, thanks to its highly ventilated AirSpeed suspension system. Made with 100% recycled materials.",
            "dimension" => "29X37X69",
            "berat" => "1590",
            "material" => "Recycled Nylon",
            "display" => true,
        ]);

        

        Variant::create([
            "produk_id" => $produk->id,
            "warna" => "Dark Grey",
            "ukuran" => "44L",
            "harga" => 2999000,
            "stok" => 50,
        ]);

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/fbec9124-1ca0-472b-872e-6cd46e953e5a.webp",
        ]);

        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/ea353465-6ea5-4e82-b335-03cd838d4066.webp",
        ]);

        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/837003f6-5450-471d-8148-c104d1419c06.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/e12ba9f6-9b74-45d9-a9eb-5f4cadaec712.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/6876ea09-d2b6-41c6-80d8-2f4e30c6621d.webp",
        ]);


        $produk = Produk::create([
            'kategori_id' => 4,
            'nama' => 'SCALDINO 2.0',
            'slug' => 'scaldino-2-0',
            "deskripsi" => "Scaldino 2,0 adalah sarung tangan yang dirancang untuk menjaga tangan Anda tetap hangat saat beraktivitas luar ruang seperti hiking.Bagian ujung ibu jari dan telunjuk sarung tangan ini dapat dibuka sehingga memudahkan Anda untuk menggunakan ponseltanpa harusmelepaskannya.Fitur:- Teknologi: Tropic Warm- Memiliki bobot ringan- Bagian ujung ibu jari dan telunjuk dapat dibuka",
            "dimension" => "6 X 20 X 25",
            "berat" => "500",
            "material" => "100% Polyester Fleece",
            "display" => true,
        ]);

        $array_ukuran = ["S", "M", "L", "XL"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Black",
                "ukuran" => $index,
                "harga" => 129000,
                "stok" => 50,
            ]);
        }

        

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910005363_fe76.webp",
        ]);

        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910005363_BLACK_1_b835.webp",
        ]);

        $produk = Produk::create([
            'kategori_id' => 5,
            'nama' => 'HURRICANE SHORT',
            'slug' => 'hurricane-short',
            "deskripsi" => "Pastikan kakimu tetap nyaman saat hiking dan trekking menggunakan kaus kaki Hurricane Short. Nyaman dipakai seharian, kaus kaki pria dengan potongan mid cut dari EIGER Mountaineering ini dilengkapi dengan teknologi COOLMAX yang membuat kaus kaki lebih cepat kering dan memastikan kakimu tetap terasa sejuk. Selain itu, kaus kaki ini dirancang dengan airflow mesh di bagian punggung kaki untuk mendukung sirkulasi udara dan desain arch support yang mengikuti lengkungan pada telapak kaki untuk memberikan kenyamanan sepanjang aktivitasmu.",
            "dimension" => "6 X 20 X 25",
            "berat" => "500",
            "material" => "100% Polyester Fleece",
            "display" => true,
        ]);

        $array_ukuran = ["S", "M", "L"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Blue",
                "ukuran" => $index,
                "harga" => 69000,
                "stok" => 50,
            ]);
        }
        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Dark Grey",
                "ukuran" => $index,
                "harga" => 69000,
                "stok" => 50,
            ]);
        }

        

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/367621e2-0e21-40cb-ab71-bcd160b39a35.png",
        ]);

        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/367621e2-0e21-40cb-ab71-bcd160b39a35.png",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/aa9e818c-98f5-4c63-9f28-5d0df3653a23.png",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/04f85f59-48b6-499e-a151-b98ba67f966d.png",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/d7322978-3478-4d80-843e-2cf470b09c15.jpg",
        ]);

        $produk = Produk::create([
            'kategori_id' => 6,
            'nama' => 'PANGOLIN 4P',
            'slug' => 'pangolin-4p',
            "deskripsi" => "Tingkatkan kenyamanan petualangan camping Anda dengan Tenda Pangolin 4P, menawarkan ruang nyaman yang Anda butuhkan untuk kenyamanan maksimal saat beristirahat di luar ruang. Tenda dengan area vestibule yang luas ini dirancang untuk menyimpan semua perlengkapan Anda dan juga memberikan ventilasi, berkat desain dua pintu masuk yang membuatnya terasa seperti berada di rumah. Tenda ini juga dilengkapi dengan lapisan snow flap pada badan tenda ruang depan untuk mencegah air atau hujan ringan masuk ke dalam tenda. Saat tidak digunakan, simpan tenda ini di dalam tas jinjing untuk memudahkan penyimpanan. Dimension: Outer: 460x265x165 cm Inner: 210x240x145 cm Packed: 72x17x18 cm Material: Fly : Polyester PU3000 Mesh : Mesh Floor : PE PU3000 Pole : Fiberglass diameter 9.5mm Carry bag : 210D Oxford Fitur: Tenda tunnel dengan material waterproof polyester Dilengkapi akses dua pintu masuk dan area vestibule yang luas dilengkapi dengan footprint Dilengkapi saku pada bagian dalam tenda untuk menyimpan barang esensial secara rapi Pengait di bagian dalam tenda untuk mengaitkan lentera lampu atau senter Dilengkapi dengan 26 pasak utama dan 5 pasak tambahan Dilengkapi dengan 7 guylines utama dan 3 guylines tambahan Snow flap pada badan tenda ruang depan untuk mencegah air atau hujan ringan masuk ke dalam tenda Dilengkapi saku pada bagian setiap posisi guylines untuk memudahkan menyimpan guylines tanpa harus melepaskannya dari tenda Dilengkapi carry bag untuk memudahkan penyimpanan tenda saat di bawa berpergian",
            "dimension" => "460x265x165 cm",
            "berat" => "7650",
            "material" => "Polyester PU3000",
            "display" => true,
        ]);

        $array_ukuran = ["NOS"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Yellow",
                "ukuran" => $index,
                "harga" => 2549000,
                "stok" => 50,
            ]);
        }
        

        

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910009039_1dcb.webp",
        ]);

        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910009039_6d78.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910009039_d3bd.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910009039_eb1c.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910009039_eb1c.webp",
        ]);


        $produk = Produk::create([
            'kategori_id' => 7,
            'nama' => 'DREAMPAD MATTRESS',
            'slug' => 'dreampad-mattress',
            "deskripsi" => "Setelah lelah melakukan aktifitas outdoor seharian, beristirahatlah dengan nyaman menggunakan Dreampad. Praktis dan mudah digunakan, produk ini bisa mengembang sendiri, kecuali bagian bantal yang harus ditiup. Cocok digunakan untuk kegiatan hiking, kemping, traveling dan kegiatan outdoor lainnya. Ukuran: 185x60x2.5 cm",
            "dimension" => "0 X 12 X 25",
            "berat" => "1000",
            "material" => "Polyester",
            "display" => true,
        ]);

        $array_ukuran = ["Single-Size"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Blue",
                "ukuran" => $index,
                "harga" => 299000,
                "stok" => 50,
            ]);
        }
        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Red",
                "ukuran" => $index,
                "harga" => 299000,
                "stok" => 50,
            ]);
        }

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003153_4fe5.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910003153_RED_1_e513.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003153_346b.webp",
        ]);
        

        $produk = Produk::create([
            'kategori_id' => 1,
            'nama' => 'TARANTULA MC APPROACH SHOES',
            'slug' => 'tarantula-mc-approach-shoes',
            "deskripsi" => "Tarantula adalah mid-cut hybrid shoes yang dirancang untuk kegiatan hiking dan approach. Material utama sepatu ini adalah Nubuck leather yang tangguh dan nyaman dipakai. Sepatu ini menggunakan outsole Vibram",
            "dimension" => "12 X 29,500 X 34",
            "berat" => "800",
            "material" => "Upper: Nubuck Leather and Nylon, Midsole: EVA, Outsole: Vibram",
            "display" => true,
        ]);
        

        $array_ukuran = ["38", "39", "40", "41", "42", "43", "44", "45"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Brown",
                "ukuran" => $index,
                "harga" => 995000,
                "stok" => 50,
            ]);
        }
        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Gray",
                "ukuran" => $index,
                "harga" => 995000,
                "stok" => 50,
            ]);
        }
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003786_8e58.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910003786_GREY_1_dd08.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910003786_BROWN_1_68f8.webp",
        ]);


        $produk = Produk::create([
            'kategori_id' => 2,
            'nama' => 'MS FINDERS PRO INSULATE JKT',
            'slug' => 'ms-finders-pro-insulate-jkt',
            "deskripsi" => "MS Finders Pro Insulate JKT menyatukan kehangatan maksimal dan bahan yang ringan untuk mendukung Anda dalam setiap petualangan berkat insulasi PrimaLoft Gold Insulation Down Blend yang ringan, breathable, dan water-repellent dengan kehangatan yang sebanding dengan 750 fill bulu angsa. Ditenun dengan rapat dari benang daur ulang yang sangat halus menjadikan bahan Pertex Quantum yang digunakan sebagai shell ini lembut, windproof, dan down proof, sehingga membuat jaket dengan penutup kepala ini partner andalan Anda untuk mengeksplorasi alam dengan kenyamanan penuh.",
            "dimension" => "70X50X1",
            "berat" => "300",
            "material" => "100% Polyamide",
            "display" => true,
        ]);

        $array_ukuran = ["XS", "S", "M", "L", "XL", "XXL"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Grey",
                "ukuran" => $index,
                "harga" => $index !== "XXL" ? 3299000 : 2804150,
                "stok" => 50,
            ]);
        }
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/910008459_98ea.jpg",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/bf6c1899-bedc-4cdc-98fc-470e265bad39.jpg",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/89df7cdb-5bec-42af-9d98-0749b7868a9e.jpg",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/a133b18b-47cf-4027-ac67-cb0eb06cafb2.jpg",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/9c226ecb-e808-4433-a5ba-262d6f1a4523.jpg",
        ]);

        $produk = Produk::create([
            'kategori_id' => 3,
            'nama' => 'ARIEL 55 S21',
            'slug' => 'ariel-55-s21',
            "deskripsi" => "Untuk perjalanan backpacking, thru-hikes dan alpine, seri Ariel AG memiliki fitur yang takkan Anda temukan pada tas lainnya. Osprey menetapkan standar untuk tas backpack dengan menggabungkan teknologi Anti-Gravity dengan fitur-fitur yang inovatif dan dapat disesuaikan, seperti bagian atas tas yang konvertibel. Ariel AG 55 adalah tas ransel yang nyaman dan mampu membawa beban untuk perjalanan jarak jauh yang membutuhkan waktu berhari-hari. Teknologi Anti-Gravity memungkinkan Anda merasa lsquo;dipelukrsquo; oleh tas ini dan membuat Anda seperti membawa beban yang lebih ringan daripada beban yang sebenarnya. Bila Anda membutuhkan tas yang dapat membawa beban yang berat hingga 1 minggu, tidak ada pilhan yang lebih baik dari Ariel AG 55.nbsp;",
            "dimension" => "38 X 25 X 73",
            "berat" => "2100",
            "material" => "Nylon",
            "display" => true,
        ]);

        $array_ukuran = ["55L"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Black",
                "ukuran" => $index,
                "harga" => 3729000,
                "stok" => 50,
            ]);
        }

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Red",
                "ukuran" => $index,
                "harga" => 3729000,
                "stok" => 50,
            ]);
        }
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/940001096_BLACK_1_ef34.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/940001096_4b50.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/940001096_ca56.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/940001096_bb90.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/940001096_d0a5.webp",
        ]);

        $produk = Produk::create([
            'kategori_id' => 4,
            'nama' => 'VERTICAL',
            'slug' => 'vertical',
            "deskripsi" => "Vertical adalah sarung tangan yang dirancang untuk menjaga tangan Anda tetap hangat dan nyaman saat beraktivitas luar ruang seperti berkemah.Fitur:- Lining bagian dalam menggunakan bahan polyester (fleece) Thinsulate- Memiliki bobot ringan",
            "dimension" => "6 X 20 X 25",
            "berat" => "500",
            "material" => "50% Polyester 50% Acrylic, Lining: Thinsulate: 100",
            "display" => true,
        ]);

        $array_ukuran = ["M", "L", "XL"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Black",
                "ukuran" => $index,
                "harga" => 209300,
                "stok" => 50,
            ]);
        }

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910004590_1c3b.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910004590_4b1a.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910004590_0fc7.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910004590_BLACK_1_2869.webp",
        ]);

        $produk = Produk::create([
            'kategori_id' => 5,
            'nama' => 'ATACAMA HIGH',
            'slug' => 'atacama-high',
            "deskripsi" => "Kaos kaki Atacama High dirancang untuk mendukung kegiatan luar ruang Anda khususnya berkemah dan trekking. Kaos kaki ini dilengkapi teknologi THERMOLITE yang mampu menjaga kaki agar tetap hangat saat dipakai berkegiatan atau di camp.Detail : 1. Terbuat dari bahan THERMOLITE",
            "dimension" => "21,500 X 8 X 16,500",
            "berat" => "100",
            "material" => "65% acrylic, 25% wool, 8% polyester, 2% spandex",
            "display" => true,
        ]);

        $array_ukuran = ["M", "L"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Black",
                "ukuran" => $index,
                "harga" => 99000,
                "stok" => 50,
            ]);
        }

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910005141_564c.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910005141_BLACK_1_fce3.webp",
        ]);

        $produk = Produk::create([
            'kategori_id' => 6,
            'nama' => 'GUARDIAN 8P TENT',
            'slug' => 'guardian-8p-tent',
            "deskripsi" => "Guardian 8P adalah tenda kemah yang memiliki dua ruangan dengan sekat yang dapat diisi 8 orang. Tenda ini memiliki 2 buah pintu masuk dengan jala anti nyamuk untuk melindungi Anda dari gigitan serangga. Panel atap jala dan dua jendela besar berfungsi sebagai ventilasi. Selain itu, tenda ini juga dilengkapi seam taped yang berfungsi untuk mencegah masuknya air saat hujan. Ketika tidak dipakai, Anda bisa menyimpannya kembali di carry bag. Ukuran: 270x390x200 cmFitur:- Tiang rangka fiberglass dan baja- Panel atap jala- Jendela dengan bukaan resleting besar untuk ventilasi- Dua buah pintu masuk dengan mosquito net (jala untuk menahan nyamuk)- Dua buah ruangan untuk tidur dengan kapasitas maksimum hingga 8 orang- Seam taped, berfungsi untuk menutupi jahitan pada tenda agar dapat menahan masuknya air saat hujan- Dilengkapi tas praktis untuk menyimpan produk ini saat dibawa berpergian",
            "dimension" => "200 X 390 X 270",
            "berat" => "12600",
            "material" => "Fly: Polyester 2000mm, Inner: Polyester 2000mm, Floor: PE Sheet, Pole: Fiber glass + Steel Pole",
            "display" => true,
        ]);

        $array_ukuran = ["single-size"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Grey",
                "ukuran" => $index,
                "harga" => 3849000,
                "stok" => 50,
            ]);
        }

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003785_2456.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003785_252e.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003785_a457.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003785_9fa2.webp",
        ]);

        $produk = Produk::create([
            'kategori_id' => 7,
            'nama' => 'SLEEP SACK 600',
            'slug' => 'sleep-sack-600',
            "deskripsi" => "Bagi Anda penggemar kegiatan outdoor, kantong tidur (sleeping bag) adalah salah satu kebutuhan utama yang tidak boleh dilewatkan. Maka dari itu, Eiger menghadirkan produk Sleep Sack 600 untuk kenyamanan dan keamanan saat tidur di alam terbuka. Terbuat dari bahan polyester, produk ini memiliki daya tahan yang kuat namun tetap ringan ketika dibawa.Dilengkapi dengan teknologi Tropic Insulation, produk ini dapat menjaga tubuh tetap hangat ketika suhu menjadi dingin terutama ketika Anda sedang berada di alam terbuka, khususnya di daerah tropis dengan suhu 15 sehingga Anda bisa tetap merasa aman dan nyaman pada saat tidur. Kantong tidur ini dilengkapi dengan tas praktis yang memudahkan Anda untuk membawanya saat berpergian. Ukuran: 215x75cmFitur:- Dilengkapi insulasi yang efektif menjaga suhu tubuh tetap hangat- Ringan- Dilengkapi resleting dua arah yang menambah kenyamanan- Dapat digunakan untuk Anda yang memiliki tinggi badan maksimal 180 cm.- Nyaman digunakan di suhu 15C, namun dapat digunakan juga pada suhu 10C, dan paling ekstrem hingga 5C- Ringkas dan tidak memakan banyak tempat- Saku dalam untuk menyimpan perlengkapan ringan- Dapat menahan angin agar tidak mudah masuk untuk menjaga kehangatan- Dilengkapi tas praktis untuk memudahkan dibawa kemana pun- Teknologi: Tropic Lite, Tropic Insulation",
            "dimension" => "30 X 75 X 220",
            "berat" => "1200",
            "material" => "Polyester",
            "display" => true,
        ]);

        $array_ukuran = ["single-size"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Navy",
                "ukuran" => $index,
                "harga" => 551650,
                "stok" => 50,
            ]);
        }

        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003700_6925.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003700_4b5a.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003700_a399.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910003700_9228.webp",
        ]);


        $produk = Produk::create([
            'kategori_id' => 1,
            'nama' => 'POLLOCK 2.0',
            'slug' => 'pollock-2-0',
            "deskripsi" => "Sepatu Pollock 2.0 adalah sepatu mid-cut yang dirancang untuk kegiatan hiking. Gusset construction pada sepatu mid-cut ini berfungsi untuk mencegah langsung masuknya air dari bagian atas sepatu. Sementara itu, teknologi heel support system dapat menyangga pergelangan kaki pada saat melakukan pendakian guna menunjang kaki agar tetap stabil. Sepatu ini juga didukung outsole Vibram untuk cengkraman yang lebih baik dan insole Ortholite yang memberikan bantalan, breathable (memiliki daya evaporasi tinggi yang mampu menguapkan kelembapan sehingga mudah kering), dan ringan untuk menjaga kaki tetap nyaman. Material:Upper: NubuckOutsole: Vibram Grivola Q757 Rubber Compound Features:Konstruksi gusset dengan waterproof membrane untuk mencegah langsung masuknya air.Teknologi heel support system, yang berfungsi untuk menyangga pergelangan kaki pada saat melakukan pendakian guna menunjang kaki agar tetap stabil di berbagai kondisi medan.Konstruksi PE shank di bagian midsole agar bagian outsole lebih kaku dan kokohOutsole Vibram GrivolaInsole OrtholiteBerfungsi untuk memastikan perlindungan pada kaki bagian depan dari benturan kerasTropic technology: Tropic Waterproof",
            "dimension" => "34 X 29,500 X 12",
            "berat" => "800",
            "material" => "Vibram Grivola Q757 Rubber Compound",
            "display" => true,
        ]);

        $array_ukuran = [ "39", "40", "41", "42", "43", "44", "45"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Brown",
                "ukuran" => $index,
                "harga" => 1339000,
                "stok" => 50,
            ]);
        }
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910007232_04ea.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910007232_058d.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910007232_a59f.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910007232_BROWN_1_8934.webp",
        ]);


        $produk = Produk::create([
            'kategori_id' => 2,
            'nama' => 'CLIMB LIGHT 1.1 HOODY-JACKET',
            'slug' => 'climb-light-1-1-hoody-jacket',
            "deskripsi" => "Climb Light 1,1 adalah jaket hardshell 2,5 layer yang dirancang dengan fitur-fitur fungsional untuk kegiatan summit attack, hiking, dan trekking. Teknik seam seal pada jaket berfungsi sebagai perlindungan waterproof, yakni untuk menjaga agar air tidak masuk ke bagian dalam jaket melalui jahitan, sehingga Anda bisa tetap merasa kering dan nyaman saat melakukan penjelajahan. Jaket ini juga dilengkapi beberapa fitur lainnya seperti helmet compatible hood (hood didesain untuk dapat menutupi kepala dengan baik meskipun mengenakan helm), saku untuk menghangatkan tangan, dan ujung kerah lengan yang dapat disesuaikan.Features:- Material polyester 2,5 layer yang berbobot ringan- Menjaga jaket agar air tidak masuk melalui jahitan- Penutup (hood) didesain untuk dapat menutupi kepala dengan baik meskipun mengenakan helm- Dua saku samping dengan ritsleting tahan air- Ujung kerah lengan yang dapat disesuaikan- Tali di bagian bawah jaket yang dapat disesuaikan- Teknologi: Tropic Waterproof, Tropic Windblock, Tropic Repellent",
            "dimension" => "4 X 30 X 34",
            "berat" => "500",
            "material" => "Shell: 100% Polyester, Waterproofness: 5000 mm",
            "display" => true,
        ]);

        $array_ukuran = [ "S", "M", "L", "XL", "XXL"];

        foreach ($array_ukuran as $index) {
            Variant::create([
                "produk_id" => $produk->id,
                "warna" => "Grey",
                "ukuran" => $index,
                "harga" => $index !== "XXL" ? 1250000 : 1350000,
                "stok" => 50,
            ]);
        }
        
        GambarProduk::create ([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/media/web/910004142_3b70.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910004142_BLACK_1_cdbd.webp",
        ]);
        GambarProduk::create([
            "produk_id" => $produk->id,
            "url" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/910004142_BLUE_1_eb50.webp",
        ]);
    }
}
