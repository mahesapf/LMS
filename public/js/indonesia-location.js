if (typeof locationData === 'undefined') {
    var locationData = {
        'Jawa Barat': {
        // 9 Kota
        'Kota Bandung': ['Andir', 'Antapani', 'Arcamanik', 'Astana Anyar', 'Babakan Ciparay', 'Bandung Kidul', 'Bandung Kulon', 'Bandung Wetan', 'Batununggal', 'Bojongloa Kaler', 'Bojongloa Kidul', 'Buahbatu', 'Cibeunying Kaler', 'Cibeunying Kidul', 'Cibiru', 'Cicendo', 'Cidadap', 'Cinambo', 'Coblong', 'Gedebage', 'Kiaracondong', 'Lengkong', 'Mandalajati', 'Panyileukan', 'Rancasari', 'Regol', 'Sukajadi', 'Sukasari', 'Sumur Bandung', 'Ujungberung'],
        'Kota Bekasi': ['Bantar Gebang', 'Bekasi Barat', 'Bekasi Selatan', 'Bekasi Timur', 'Bekasi Utara', 'Jatiasih', 'Jatisampurna', 'Medan Satria', 'Mustika Jaya', 'Pondok Gede', 'Pondok Melati', 'Rawalumbu'],
        'Kota Bogor': ['Bogor Barat', 'Bogor Selatan', 'Bogor Tengah', 'Bogor Timur', 'Bogor Utara', 'Tanah Sareal'],
        'Kota Cirebon': ['Harjamukti', 'Kejaksan', 'Kesambi', 'Lemahwungkuk', 'Pekalipan'],
        'Kota Depok': ['Beji', 'Bojongsari', 'Cilodong', 'Cimanggis', 'Cinere', 'Cipayung', 'Limo', 'Pancoran Mas', 'Sawangan', 'Sukmajaya', 'Tapos'],
        'Kota Sukabumi': ['Baros', 'Cibeureum', 'Cikole', 'Citamiang', 'Gunung Puyuh', 'Lembursitu', 'Warudoyong'],
        'Kota Tasikmalaya': ['Bungursari', 'Cibeureum', 'Cihideung', 'Cipedes', 'Indihiang', 'Kawalu', 'Mangkubumi', 'Purbaratu', 'Tawang', 'Tamansari'],
        'Kota Cimahi': ['Cimahi Selatan', 'Cimahi Tengah', 'Cimahi Utara'],
        'Kota Banjar': ['Banjar', 'Langensari', 'Pataruman', 'Purwaharja'],

        // 18 Kabupaten
        'Kabupaten Bandung': ['Arjasari', 'Baleendah', 'Banjaran', 'Bojongsoang', 'Cangkuang', 'Cicalengka', 'Cikancung', 'Cilengkrang', 'Cileunyi', 'Cimaung', 'Cimenyan', 'Ciparay', 'Ciwidey', 'Dayeuhkolot', 'Ibun', 'Katapang', 'Kertasari', 'Kutawaringin', 'Majalaya', 'Margaasih', 'Margahayu', 'Nagreg', 'Pacet', 'Pameungpeuk', 'Pangalengan', 'Paseh', 'Pasirjambu', 'Rancabali', 'Rancaekek', 'Solokanjeruk', 'Soreang'],
        'Kabupaten Bandung Barat': ['Batujajar', 'Cihampelas', 'Cikalong Wetan', 'Cilengkrang', 'Cililin', 'Cipatat', 'Cipeundeuy', 'Cipongkor', 'Cisarua', 'Gununghalu', 'Lembang', 'Ngamprah', 'Padalarang', 'Parongpong', 'Rongga', 'Sindangkerta'],
        'Kabupaten Bekasi': ['Babelan', 'Bojongmangu', 'Cabangbungin', 'Cibarusah', 'Cibitung', 'Cikarang Barat', 'Cikarang Pusat', 'Cikarang Selatan', 'Cikarang Timur', 'Cikarang Utara', 'Karangbahagia', 'Kedungwaringin', 'Muara Gembong', 'Pebayuran', 'Serang Baru', 'Setu', 'Sukakarya', 'Sukatani', 'Sukawangi', 'Tambelang', 'Tambun Selatan', 'Tambun Utara', 'Tarumajaya'],
        'Kabupaten Bogor': ['Babakan Madang', 'Bojonggede', 'Caringin', 'Cariu', 'Ciampea', 'Ciawi', 'Cibinong', 'Cibungbulang', 'Cigombong', 'Cigudeg', 'Cijeruk', 'Cileungsi', 'Ciomas', 'Cisarua', 'Ciseeng', 'Citeureup', 'Dramaga', 'Gunung Putri', 'Gunung Sindur', 'Jasinga', 'Jonggol', 'Kemang', 'Kelapa Nunggal', 'Leuwiliang', 'Leuwisadeng', 'Megamendung', 'Nanggung', 'Pamijahan', 'Parung', 'Parung Panjang', 'Ranca Bungur', 'Rumpin', 'Sukajaya', 'Sukamakmur', 'Sukaraja', 'Tajur Halang', 'Tamansari', 'Tanjungsari', 'Tenjo', 'Tenjolaya'],
        'Kabupaten Ciamis': ['Banjaranyar', 'Banjarsari', 'Baregbeg', 'Ciamis', 'Cijulang', 'Cihaurbeuti', 'Cijeungjing', 'Cikoneng', 'Cimaragas', 'Cipaku', 'Cisaga', 'Jatinagara', 'Kawali', 'Lakbok', 'Lumbung', 'Mangunjaya', 'Padaherang', 'Pamarican', 'Panawangan', 'Panjalu', 'Panumbangan', 'Purwadadi', 'Rajadesa', 'Rancah', 'Sadananya', 'Sindangkasih', 'Sukadana', 'Tambaksari'],
        'Kabupaten Cianjur': ['Agrabinta', 'Bojongpicung', 'Campaka', 'Campaka Mulya', 'Cidaun', 'Cikadu', 'Cikalongkulon', 'Cilaku', 'Cianjur', 'Ciranjang', 'Cijati', 'Cibeber', 'Cibinong', 'Cipanas', 'Cugenang', 'Gekbrong', 'Haurwangi', 'Kadupandak', 'Karangtengah', 'Leles', 'Mande', 'Naringgul', 'Pacet', 'Pagelaran', 'Pasirkuda', 'Sindangbarang', 'Sukaluyu', 'Sukanagara', 'Sukaresmi', 'Takokak', 'Tanggeung', 'Warungkondang'],
        'Kabupaten Cirebon': ['Arjawinangun', 'Astanajapura', 'Babakan', 'Beber', 'Ciledug', 'Ciwaringin', 'Depok', 'Dukupuntang', 'Gebang', 'Gegunung', 'Gegesik', 'Greged', 'Jamblang', 'Kaliwedi', 'Kapetakan', 'Karangsembung', 'Karangwareng', 'Kedawung', 'Klangenan', 'Lemahabang', 'Losari', 'Mundu', 'Pabedilan', 'Palimanan', 'Pangenan', 'Pasaleman', 'Plered', 'Plumbon', 'Sedong', 'Sumber', 'Susukanlebak', 'Susukan', 'Talun', 'Tengah Tani', 'Waled', 'Weru', 'Panguragan', 'Panguragan Barat', 'Suranenggala', 'Tengahtani'],
        'Kabupaten Garut': ['Banjarwangi', 'Banyuresmi', 'Bayongbong', 'Blubur Limbangan', 'Balubur Limbangan', 'Bungbulang', 'Caringin', 'Cibatu', 'Cibalong', 'Cikajang', 'Cikelet', 'Cilawu', 'Cigedug', 'Cisewu', 'Cisurupan', 'Cisompet', 'Garut Kota', 'Kadungora', 'Karangpawitan', 'Karangtengah', 'Kersamanah', 'Leles', 'Leuwigoong', 'Malangbong', 'Mekarmukti', 'Pakenjeng', 'Pameungpeuk', 'Pamulihan', 'Pasirwangi', 'Peundeuy', 'Samarang', 'Selaawi', 'Singajaya', 'Sucinaraja', 'Sukaresmi', 'Sukawening', 'Talegong', 'Tarogong Kaler', 'Tarogong Kidul', 'Wanaraja'],
        'Kabupaten Indramayu': ['Anjatan', 'Arahan', 'Balongan', 'Bangodua', 'Bongas', 'Cantigi', 'Cikedung', 'Gabuswetan', 'Gantar', 'Haurgeulis', 'Indramayu', 'Jatibarang', 'Juntinyuat', 'Kandanghaur', 'Karangampel', 'Kedokan Bunder', 'Kertasemaya', 'Krangkeng', 'Kroya', 'Lelea', 'Lohbener', 'Losarang', 'Pasekan', 'Patrol', 'Sindang', 'Sliyeg', 'Sukagumiwang', 'Sukra', 'Terisi', 'Tukdana', 'Widasari'],
        'Kabupaten Karawang': ['Banyusari', 'Batujaya', 'Ciampel', 'Cibuaya', 'Cikampek', 'Cilamaya Kulon', 'Cilamaya Wetan', 'Cilebar', 'Jatisari', 'Jayakerta', 'Karawang Barat', 'Karawang Timur', 'Klari', 'Kotabaru', 'Kutawaluya', 'Lemahabang', 'Majalaya', 'Pangkalan', 'Pedes', 'Purwasari', 'Rawamerta', 'Rengasdengklok', 'Tegalwaru', 'Telagasari', 'Telukjambe Barat', 'Telukjambe Timur', 'Tempuran', 'Tirtajaya', 'Tirtamulya'],
        'Kabupaten Kuningan': ['Ciawigebang', 'Cibeureum', 'Cibingbin', 'Cidahu', 'Cilebak', 'Cilimus', 'Cimahi', 'Ciniru', 'Cipicung', 'Ciwaru', 'Darma', 'Garawangi', 'Hantara', 'Jalaksana', 'Japara', 'Kadugede', 'Kalimanggis', 'Karangkancana', 'Kramatmulya', 'Kuningan', 'Lebakwangi', 'Luragung', 'Maleber', 'Mandirancan', 'Nusaherang', 'Pancalang', 'Pasawahan', 'Selajambe', 'Subang'],
        'Kabupaten Majalengka': ['Argapura', 'Banjaran', 'Bantarujeg', 'Cikijing', 'Cingambul', 'Dawuan', 'Jatitujuh', 'Jatiwangi', 'Kadipaten', 'Kasokandel', 'Kertajati', 'Leuwimunding', 'Lemahsugih', 'Maja', 'Majalengka', 'Malausma', 'Palasah', 'Panyingkiran', 'Rajagaluh', 'Sindang', 'Sindangwangi', 'Sukahaji', 'Sumberjaya', 'Talaga'],
        'Kabupaten Pangandaran': ['Cijulang', 'Cigugur', 'Cimerak', 'Kalipucang', 'Langkaplancar', 'Mangunjaya', 'Padaherang', 'Pangandaran', 'Parigi', 'Sidamulih'],
        'Kabupaten Purwakarta': ['Babakancikao', 'Bojong', 'Bungursari', 'Campaka', 'Cibatu', 'Darangdan', 'Jatiluhur', 'Kiarapedes', 'Maniis', 'Pasawahan', 'Plered', 'Pondoksalam', 'Purwakarta', 'Sukasari', 'Sukatani', 'Tegalwaru', 'Wanayasa'],
        'Kabupaten Subang': ['Binong', 'Blanakan', 'Ciasem', 'Ciater', 'Cibogo', 'Cicadas', 'Cikaum', 'Cipunagara', 'Cisalak', 'Cisubang', 'Compreng', 'Dawuan', 'Jalan Cagak', 'Kalijati', 'Kasomalang', 'Legon Kulon', 'Pagaden', 'Pagaden Barat', 'Pabuaran', 'Pamanukan', 'Patok Beusi', 'Purwadadi', 'Pusakajaya', 'Pusakanagara', 'Sagalaherang', 'Serang Panjang', 'Subang', 'Sukasari', 'Tanjungsiang'],
        'Kabupaten Sukabumi': ['Bantargadung', 'Bojonggenteng', 'Caringin', 'Cicantayan', 'Cicurug', 'Cidadap', 'Cidahu', 'Cidolog', 'Ciemas', 'Cikakak', 'Cikembar', 'Cikidang', 'Cimanggu', 'Ciracap', 'Cireunghas', 'Cisaat', 'Cibadak', 'Gunungguruh', 'Jampangkulon', 'Jampangtengah', 'Kabandungan', 'Kadudampit', 'Kalapa Nunggal', 'Kebonpedes', 'Lengkong', 'Nagrak', 'Nyalindung', 'Pabuaran', 'Parakan Salak', 'Parungkuda', 'Pelabuhan Ratu', 'Purabaya', 'Sagaranten', 'Simpenan', 'Sukabumi', 'Sukalarang', 'Sukaraja', 'Surade', 'Tegal Buleud', 'Warung Kiara', 'Waluran'],
        'Kabupaten Sumedang': ['Buahdua', 'Cibugel', 'Cimalaka', 'Cisarua', 'Cisitu', 'Conggeang', 'Darmaraja', 'Ganeas', 'Jatigede', 'Jatinunggal', 'Jatinangor', 'Pamulihan', 'Paseh', 'Rancakalong', 'Situraja', 'Sukasari', 'Sumedang Selatan', 'Sumedang Utara', 'Surian', 'Tanjungkerta', 'Tanjungmedar', 'Tanjungsari', 'Tomo', 'Ujung Jaya', 'Wado'],
        'Kabupaten Tasikmalaya': ['Bantarkalong', 'Bojong Asih', 'Bojonggambir', 'Ciawi', 'Cibalong', 'Cikalong', 'Cikatomas', 'Cikhurip', 'Cineam', 'Cipatujah', 'Cisayong', 'Culamega', 'Cigalontang', 'Gunung Tanjung', 'Jatiwaras', 'Kadipaten', 'Karang Jaya', 'Karangnunggal', 'Leuwisari', 'Mangunreja', 'Manonjaya', 'Padakembang', 'Pagerageung', 'Pancatengah', 'Parungponteng', 'Puspahiang', 'Rajapolah', 'Salawu', 'Salopa', 'Sariwangi', 'Singaparna', 'Sodonghilir', 'Sukaraja', 'Sukarame', 'Sukaratu', 'Sukahening', 'Tanjungjaya', 'Taraju', 'Tengah']
    },
    'Bengkulu': {
        // 1 Kota
        'Kota Bengkulu': ['Gading Cempaka', 'Kampung Melayu', 'Muara Bangkahulu', 'Ratu Agung', 'Ratu Samban', 'Selebar', 'Singaran Pati', 'Sungai Serut', 'Teluk Segara'],

        // 9 Kabupaten
        'Kabupaten Bengkulu Selatan': ['Air Nipis', 'Bunga Mas', 'Kedurang', 'Kedurang Ilir', 'Kota Manna', 'Manna', 'Pasar Manna', 'Pino', 'Pino Raya', 'Seginim', 'Ulu Manna'],
        'Kabupaten Bengkulu Tengah': ['Bang Haji', 'Karang Tinggi', 'Merigi Kelindang', 'Merigi Sakti', 'Pagar Jati', 'Pematang Tiga', 'Pondok Kelapa', 'Pondok Kubang', 'Semidang Lagan', 'Talang Empat', 'Taba Penanjung'],
        'Kabupaten Bengkulu Utara': ['Air Besi', 'Air Napal', 'Air Padang', 'Arga Makmur', 'Arma Jaya', 'Batik Nau', 'Enggano', 'Giri Mulya', 'Hulu Palik', 'Ketahun', 'Kerkap', 'Lais', 'Napal Putih', 'Padang Jaya', 'Pinang Raya', 'Putri Hijau', 'Tanjung Agung Palik', 'Ulok Kupai'],
        'Kabupaten Kaur': ['Kaur Selatan', 'Kaur Tengah', 'Kaur Utara', 'Kelam Tengah', 'Kinal', 'Lungkang Kule', 'Luas', 'Maje', 'Muara Sahung', 'Nasal', 'Padang Guci Hilir', 'Padang Guci Hulu', 'Semidang Gumay', 'Tanjung Kemuning', 'Tetap'],
        'Kabupaten Kepahiang': ['Bermani Ilir', 'Kabawetan', 'Kepahiang', 'Merigi', 'Muara Kemumu', 'Seberang Musi', 'Tebat Karai', 'Ujan Mas'],
        'Kabupaten Lebong': ['Amen', 'Bingin Kuning', 'Lebong Atas', 'Lebong Sakti', 'Lebong Selatan', 'Lebong Tengah', 'Lebong Utara', 'Pinang Belapis', 'Rimbo Pengadang', 'Topos', 'Tubei', 'Uram Jaya'],
        'Kabupaten Mukomuko': ['Air Dikit', 'Air Majunto', 'Air Rami', 'Ipuh', 'Lubuk Pinang', 'Malin Deman', 'Pondok Suguh', 'Penarik', 'Selagan Raya', 'Sungai Rumbai', 'Teramang Jaya', 'Teras Terunjam', 'Ulu Talo', 'V Koto'],
        'Kabupaten Rejang Lebong': ['Bermani Ilir', 'Binduriang', 'Curup', 'Curup Selatan', 'Curup Tengah', 'Curup Timur', 'Curup Utara', 'Kota Padang', 'Padang Ulak Tanding', 'Selupu Rejang', 'Sindang Beliti Ilir', 'Sindang Beliti Ulu', 'Sindang Dataran', 'Sindang Kelingi', 'Talang Ubi Utara'],
        'Kabupaten Seluma': ['Air Periukan', 'Ilir Talo', 'Lubuk Sandi', 'Seluma', 'Seluma Barat', 'Seluma Selatan', 'Seluma Timur', 'Seluma Utara', 'Semidang Alas', 'Semidang Alas Maras', 'Sukaraja', 'Talo', 'Talo Kecil', 'Ulu Talo']
    },
    'Lampung': {
        // 2 Kota
        'Kota Bandar Lampung': ['Bumi Waras', 'Enggal', 'Kemiling', 'Kedamaian', 'Kedaton', 'Labuhan Ratu', 'Langkapura', 'Panjang', 'Rajabasa', 'Sukarame', 'Sukabumi', 'Tanjung Karang Barat', 'Tanjung Karang Pusat', 'Tanjung Karang Timur', 'Tanjung Seneng', 'Teluk Betung Barat', 'Teluk Betung Selatan', 'Teluk Betung Timur', 'Teluk Betung Utara', 'Way Halim'],
        'Kota Metro': ['Metro Barat', 'Metro Pusat', 'Metro Selatan', 'Metro Timur', 'Metro Utara'],

        // 13 Kabupaten
        'Kabupaten Lampung Barat': ['Air Hitam', 'Balik Bukit', 'Bandar Negeri Suoh', 'Batu Brak', 'Batu Ketulis', 'Belalau', 'Gedung Surian', 'Kebun Tebu', 'Lumbok Seminung', 'Pagar Dewa', 'Sekincau', 'Sukau', 'Suoh', 'Sumber Jaya', 'Way Tenong'],
        'Kabupaten Lampung Selatan': ['Bakauheni', 'Candipuro', 'Jati Agung', 'Kalianda', 'Katibung', 'Ketapang', 'Merbau Mataram', 'Natar', 'Palas', 'Penengahan', 'Raja Basa', 'Sidomulyo', 'Sragi', 'Tanjung Bintang', 'Tanjung Sari', 'Way Panji', 'Way Sulan'],
        'Kabupaten Lampung Tengah': ['Anak Ratu Aji', 'Anak Tuha', 'Bandar Mataram', 'Bandar Surabaya', 'Bekri', 'Bumi Nabung', 'Bumi Ratu Nuban', 'Gunung Sugih', 'Kalirejo', 'Kota Gajah', 'Padang Ratu', 'Pubian', 'Punggur', 'Putra Rumbia', 'Rumbia', 'Selagai Lingga', 'Sendang Agung', 'Seputih Agung', 'Seputih Banyak', 'Seputih Mataram', 'Seputih Raman', 'Seputih Surabaya', 'Terbanggi Besar', 'Terusan Nunyai', 'Trimurjo', 'Way Pengubuan', 'Way Seputih'],
        'Kabupaten Lampung Timur': ['Batanghari', 'Batanghari Nuban', 'Braja Slebah', 'Gunung Pelindung', 'Jabung', 'Labuhan Maringgai', 'Labuhan Ratu', 'Marga Sekampung', 'Marga Tiga', 'Mataram Baru', 'Melinting', 'Metro Kibang', 'Pasir Sakti', 'Pekalongan', 'Purbolinggo', 'Raman Utara', 'Sekampung', 'Sekampung Udik', 'Sukadana', 'Waway Karya', 'Way Bungur', 'Way Jepara'],
        'Kabupaten Lampung Utara': ['Abung Barat', 'Abung Kunang', 'Abung Pekurun', 'Abung Selatan', 'Abung Semuli', 'Abung Surakarta', 'Abung Tengah', 'Abung Timur', 'Abung Tinggi', 'Blambangan Pagar', 'Bukit Kemuning', 'Bunga Mayang', 'Hulu Sungkai', 'Kotabumi', 'Kotabumi Selatan', 'Kotabumi Utara', 'Muara Sungkai', 'Sungkai Barat', 'Sungkai Jaya', 'Sungkai Selatan', 'Sungkai Tengah', 'Sungkai Utara', 'Tanjung Raja'],
        'Kabupaten Mesuji': ['Mesuji', 'Mesuji Timur', 'Panca Jaya', 'Rawajitu Selatan', 'Rawa Jitu Utara', 'Simpang Pematang', 'Tanjung Raya'],
        'Kabupaten Pesawaran': ['Gedong Tataan', 'Kedondong', 'Marga Punduh', 'Negeri Katon', 'Padang Cermin', 'Punduh Pidada', 'Tegineneng', 'Teluk Pandan', 'Way Khilau', 'Way Lima', 'Way Ratai'],
        'Kabupaten Pesisir Barat': ['Bangkunat', 'Bangkunat Belimbing', 'Karya Penggawa', 'Krui Selatan', 'Lemong', 'Ngambur', 'Pesisir Selatan', 'Pesisir Tengah', 'Pesisir Utara', 'Pulau Pisang', 'Way Krui'],
        'Kabupaten Pringsewu': ['Adiluwih', 'Ambarawa', 'Banyumas', 'Gadingrejo', 'Pagelaran', 'Pagelaran Utara', 'Pardasuka', 'Pringsewu', 'Sukoharjo'],
        'Kabupaten Tanggamus': ['Air Naningan', 'Bandar Negeri Semuong', 'Bulok', 'Cukuh Balak', 'Gisting', 'Gunung Alip', 'Kelumbayan', 'Kelumbayan Barat', 'Kota Agung', 'Kota Agung Barat', 'Kota Agung Timur', 'Limau', 'Pematang Sawa', 'Pugung', 'Pulau Panggung', 'Semaka', 'Sumberejo', 'Talang Padang', 'Ulubelu', 'Wonosobo'],
        'Kabupaten Tulang Bawang': ['Banjar Agung', 'Banjar Baru', 'Banjar Margo', 'Dente Teladas', 'Gedung Aji', 'Gedung Aji Baru', 'Gedung Meneng', 'Menggala', 'Menggala Timur', 'Meraksa Aji', 'Penawar Aji', 'Penawar Tama', 'Rawa Jitu Timur', 'Rawa Pitu'],
        'Kabupaten Tulang Bawang Barat': ['Batu Putih', 'Gunung Terang', 'Lambu Kibang', 'Pagar Dewa', 'Tulang Bawang Tengah', 'Tulang Bawang Udik', 'Tumijajar', 'Way Kenanga'],
        'Kabupaten Way Kanan': ['Bahuga', 'Baradatu', 'Banjit', 'Blambangan Umpu', 'Buay Bahuga', 'Bumi Agung', 'Gunung Labuhan', 'Kasui', 'Negara Batin', 'Negeri Agung', 'Negeri Besar', 'Pakuan Ratu', 'Rebang Tangkas', 'Way Tuba']
    }
};

function updateCities(provinceSelect, citySelect, districtSelect) {
    const province = provinceSelect.value;
    citySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

    if (province && locationData[province]) {
        Object.keys(locationData[province]).sort().forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        });
    }
}

function updateDistricts(provinceSelect, citySelect, districtSelect) {
    const province = provinceSelect.value;
    const city = citySelect.value;
    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

    if (province && city && locationData[province] && locationData[province][city]) {
        locationData[province][city].sort().forEach(district => {
            const option = document.createElement('option');
            option.value = district;
            option.textContent = district;
            districtSelect.appendChild(option);
        });
    }
}
}
