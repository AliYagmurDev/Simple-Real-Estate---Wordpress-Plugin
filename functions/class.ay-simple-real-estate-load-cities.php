<?php

if(!class_exists('AY_SRER_LoadCities')) {
    class AY_SRER_LoadCities{
        public function __construct() {

        }

        public function load_cyprus_cities_tr() {
            $cities = array(
                'Lefkoşa' => array(
                    'Akıncılar', 'Alayköy', 'Balıkesir', 'Batıkent', 'Beyköy', 
                    'Cihangir', 'Çağlayan', 'Çukurova', 'Değirmenlik', 'Demirhan',
                    'Dilekkaya', 'Dumlupınar', 'Düzova', 'Erdemli', 'Gaziköy',
                    'Gelibolu', 'Göçmenköy', 'Gökhan', 'Gönyeli', 
                    'Gürpınar', 'Hamitköy', 'Haspolat', 'Kalavaç', 'Kanlıköy',
                    'Kırklar', 'Kızılbaş', 'Köşklüçiftlik', 'Küçük Kaymaklı',
                    'Kumsal', 'Lefkoşa Surlariçi', 'Marmara', 'Meriç', 'Minareliköy', 
                    'Metehan', 'Ortaköy', 'Sanayi Bölgesi', 'Taşkınköy', 'Türkeli', 
                    'Yeniceköy', 'Yenikent', 'Yenişehir', 'Yılmazköy', 'Yiğitler'
                ),
                'Girne' => array(
                    'Ağırdağ', 'Akçiçek', 'Akdeniz', 'Alsancak', 'Alagadi', 
                    'Alemdağ', 'Arapköy', 'Aşağı Girne', 'Bahçeli', 'Bellapais',
                    'Beşparmak', 'Boğaz', 'Çamlıbel', 'Dikmen', 'Doğanköy',
                    'Çatalköy', 'Dağyolu', 'Edremit', 'Esentepe', 'Geçitköy',
                    'Girne Merkez', 'Göçeri', 'Hisarköy', 'Ilgaz', 'İncesu', 
                    'Karaağaç', 'Karakum', 'Karaoğlanoğlu', 'Karmi', 'Karşıyaka', 
                    'Kayalar', 'Kılıçarslan', 'Koruçam', 'Kozan', 'Kömürcü',
                    'Lapta', 'Malatya', 'Ozanköy', 'Pınarbaşı', 'Sadrazamköy', 
                    'Şirinevler', 'Taşkent', 'Tepebaşı', 'Türk Mahallesi', 
                    'Yeşiltepe', 'Yukarı Girne', 'Zeytinlik'
                ),
                'Gazimağusa' => array(
                    'Akdoğan', 'Akova', 'Alaniçi', 'Arıdamı', 'Aslanköy', 'Atlılar',
                    'Baykal', 'Beyarmudu', 'Çanakkale', 'Çayönü', 'Çınarlı', 
                    'Dörtyol', 'Dumlupınar', 'Geçitkale', 'Güvercinlik', 'Gönendere', 
                    'Gülseren', 'İnönü', 'Kaleiçi', 'Korkutepeli', 'Karakol',
                    'Köprülü', 'Kurudere', 'Kuzucuk', 'Küçük Erenköy', 'Maraş',
                    'Mağusa Merkez', 'Mallıdağ', 'Mormenekşe', 'Paşaköy', 'Salamis',
                    'Mutluyaka', 'Pınarlı', 'Nergisli', 'Tatlısu', 'Salamis', 'Sakarya', 
                    'Serdarlı', 'Sütlüce', 'Tirmen', 'Turunçlu', 'Tuzla',
                    'Türkmenköy', 'Ulukışla', 'Vadili', 'Yamaçköy', 'Yeni Boğaziçi', 'Yıldırım'
                ),
                'Güzelyurt' => array(
                    'Akçay', 'Aşağı Bostancı', 'Aydınköy', 'Güzelyurt Merkez',
                    'Kalkanlı', 'Serhatköy', 'Yayla', 'Yukarı Bostancı', 'Zümrütköy'
                ),
                'İskele' => array(
                    'Ağıllar', 'Altınova', 'Ardahan', 'Avtepe', 'Aygün',
                    'Bafra', 'Bahçeler', 'Balalan', 'Boğaz', 'Boğaziçi',
                    'Boğaztepe - Monarga', 'Boltaşlı', 'Büyükkonuk', 'Çayırova', 'Derince',
                    'Dipkarpaz', 'Ergazi', 'Esenköy', 'İskele Merkez', 'Kaleburnu',
                    'Kalecik', 'Kantara', 'Kaplıca', 'Kilitkaya', 'Kumyalı',
                    'Kurtuluş', 'Kuruova', 'Kuzucuk', 'Long Beach', 'Mehmetçik',
                    'Mersinlik', 'Ötüken', 'Pamuklu', 'Sazlıköy', 'Sınırüstü',
                    'Sipahi', 'Taşlıca', 'Topçuköy', 'Turnalar', 'Tuzluca',
                    'Yarköy', 'Yedikonuk', 'Yeni Erenköy', 'Yeşilköy', 'Ziyamet'
                ),
                'Lefke' => array(
                    'Bağlıköy', 'Lefke', 'Cengizköy', 'Doğancı', 'Gaziveren', 'Yedidalga', 
                    'Yeşilırmak', 'Yeşilyurt', 'Gemi Konağı'
                )
            );
            
            foreach ($cities as $city => $districts) {
                // Add the city as a parent term
                $parent_term = wp_insert_term(
                    $city,  // The term to add
                    'city'  // The taxonomy
                );

                // If there's an error in inserting, skip this term
                if (is_wp_error($parent_term)) {
                    continue;
                }

                // Add the districts as child terms
                foreach ($districts as $district) {
                    wp_insert_term(
                        $district,  // The term to add
                        'city',  // The taxonomy
                        array(
                            'parent' => $parent_term['term_id']  // Set the parent to the city
                        )
                    );
                }
            }
        }
    }
}