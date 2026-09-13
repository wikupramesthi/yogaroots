-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2026 at 02:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yogaroots`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `uuid` char(36) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `category_uuid` char(36) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `tagging` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','scheduled') NOT NULL DEFAULT 'draft',
  `search_engine` enum('index','noindex') NOT NULL DEFAULT 'index',
  `link` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`uuid`, `user_uuid`, `category_uuid`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `scheduled_at`, `views`, `tagging`, `status`, `search_engine`, `link`, `video`, `created_at`, `updated_at`, `deleted_at`) VALUES
('63829ea9-8a32-4f82-94e1-7299120f822c', '787b72ea-59d0-4d54-848b-c200bddafdd2', '2162d145-9ef3-4e2f-8c55-81971a015bc5', 'Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?', 'pilates-vs-yoga-apa-bedanya-dan-mana-yang-cocok-untuk-anda', 'Pilates dan yoga sama-sama populer sebagai olahraga yang membantu meningkatkan kebugaran tubuh sekaligus memberikan manfaat bagi pikiran. Keduanya juga dapat dilakukan oleh pemula dan tidak selalu membutuhkan peralatan yang rumit.', '<p><strong>Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?</strong></p>\r\n\r\n<p>Pilates dan yoga sama-sama populer sebagai olahraga yang membantu meningkatkan kebugaran tubuh sekaligus memberikan manfaat bagi pikiran. Keduanya juga dapat dilakukan oleh pemula dan tidak selalu membutuhkan peralatan yang rumit.</p>\r\n\r\n<p>Namun, <strong>Pilates dan yoga memiliki beberapa perbedaan</strong>, mulai dari tujuan latihan, teknik gerakan, fokus tubuh, hingga pendekatan terhadap pernapasan. Lalu, mana yang lebih cocok untuk Anda?</p>\r\n\r\n<p>Berikut pembahasan lengkap mengenai perbedaan Pilates dan yoga agar Anda dapat menentukan jenis latihan yang sesuai dengan kebutuhan dan tujuan kebugaran Anda.</p>\r\n\r\n<p><strong>Apa Itu Yoga?</strong></p>\r\n\r\n<p>Yoga adalah latihan yang menggabungkan gerakan tubuh, pengaturan pernapasan, konsentrasi, dan relaksasi. Yoga memiliki berbagai jenis dan tingkat intensitas, mulai dari latihan yang lembut hingga latihan yang cukup dinamis.</p>\r\n\r\n<p>Selain membantu menjaga kebugaran tubuh, yoga dapat membantu meningkatkan fleksibilitas, keseimbangan, mobilitas, serta membantu tubuh menjadi lebih rileks.</p>\r\n\r\n<p>Beberapa jenis yoga yang populer antara lain:</p>\r\n\r\n<ul>\r\n    <li><strong>Hatha Yoga</strong>, dengan gerakan yang relatif terstruktur dan cocok untuk mengenal dasar-dasar yoga.</li>\r\n    <li><strong>Vinyasa Yoga</strong>, yang menghubungkan gerakan dengan ritme pernapasan secara lebih dinamis.</li>\r\n    <li><strong>Yin Yoga</strong>, yang menggunakan posisi tertentu dalam durasi lebih lama untuk melatih fleksibilitas.</li>\r\n    <li><strong>Restorative Yoga</strong>, yang berfokus pada relaksasi dengan gerakan yang lebih lembut.</li>\r\n</ul>\r\n\r\n<p><strong>Apa Itu Pilates?</strong></p>\r\n\r\n<p>Pilates merupakan latihan yang berfokus pada kontrol gerakan, stabilitas tubuh, kekuatan otot inti atau <strong>core</strong>, serta postur.</p>\r\n\r\n<p>Gerakan Pilates biasanya dilakukan secara terkontrol dan membutuhkan konsentrasi terhadap posisi tubuh serta teknik pernapasan.</p>\r\n\r\n<p>Pilates dapat dilakukan menggunakan matras maupun peralatan tertentu. Mat Pilates, misalnya, dapat dilakukan tanpa peralatan besar sehingga relatif mudah dimasukkan ke dalam rutinitas olahraga.</p>\r\n\r\n<p>Latihan Pilates banyak menekankan penggunaan otot core sehingga dapat membantu membangun kesadaran terhadap postur dan kontrol tubuh.</p>\r\n\r\n<p><strong>Perbedaan Yoga dan Pilates</strong></p>\r\n\r\n<p>Meskipun terlihat mirip, yoga dan Pilates memiliki fokus latihan yang berbeda. Berikut beberapa perbedaan utamanya.</p>\r\n\r\n<p><strong>1. Fokus Latihan</strong></p>\r\n\r\n<p>Yoga memiliki pendekatan yang lebih luas dengan menggabungkan latihan fisik, pernapasan, konsentrasi, relaksasi, dan kesadaran tubuh.</p>\r\n\r\n<p>Sementara itu, Pilates lebih menitikberatkan pada kontrol gerakan, stabilitas, kekuatan core, dan postur tubuh.</p>\r\n\r\n<p><strong>2. Fleksibilitas</strong></p>\r\n\r\n<p>Yoga umumnya sangat erat kaitannya dengan latihan fleksibilitas. Berbagai posisi yoga dapat membantu tubuh bergerak melalui rentang gerak yang lebih luas secara bertahap.</p>\r\n\r\n<p>Pilates juga melibatkan gerakan yang dapat membantu mobilitas dan fleksibilitas, tetapi fokus utamanya bukan hanya pada kelenturan tubuh.</p>\r\n\r\n<p><strong>3. Kekuatan Core</strong></p>\r\n\r\n<p>Pilates sangat dikenal dengan latihan yang melibatkan otot core. Banyak gerakannya membutuhkan stabilisasi bagian tengah tubuh agar gerakan dapat dilakukan dengan tepat.</p>\r\n\r\n<p>Yoga juga melatih core, terutama pada berbagai pose yang membutuhkan keseimbangan dan stabilitas. Namun, fokusnya dapat berbeda tergantung jenis yoga yang dilakukan.</p>\r\n\r\n<p><strong>4. Pernapasan</strong></p>\r\n\r\n<p>Pernapasan merupakan bagian penting dalam yoga. Pengaturan napas digunakan untuk membantu konsentrasi, mengontrol gerakan, dan menciptakan kondisi tubuh yang lebih rileks.</p>\r\n\r\n<p>Dalam Pilates, pernapasan juga penting dan digunakan untuk membantu kontrol serta koordinasi gerakan.</p>\r\n\r\n<p><strong>5. Relaksasi</strong></p>\r\n\r\n<p>Yoga umumnya memberikan perhatian lebih besar terhadap relaksasi, meditasi, dan kesadaran tubuh.</p>\r\n\r\n<p>Pilates lebih berorientasi pada latihan fisik dan kontrol gerakan, meskipun latihan yang dilakukan dengan fokus dan teratur juga dapat membantu tubuh terasa lebih rileks setelah berolahraga.</p>\r\n\r\n<p><strong>Pilates vs Yoga: Mana yang Lebih Baik?</strong></p>\r\n\r\n<p>Tidak ada jawaban bahwa Pilates selalu lebih baik daripada yoga, atau sebaliknya. Pilihan terbaik bergantung pada tujuan, preferensi, dan kebutuhan masing-masing orang.</p>\r\n\r\n<p>Jika Anda ingin meningkatkan fleksibilitas, melatih keseimbangan, sekaligus mendapatkan latihan yang menggabungkan gerakan dan relaksasi, <strong>yoga dapat menjadi pilihan yang menarik</strong>.</p>\r\n\r\n<p>Jika tujuan utama Anda adalah meningkatkan kekuatan core, kontrol tubuh, dan kesadaran terhadap postur, <strong>Pilates dapat menjadi pilihan yang sesuai</strong>.</p>\r\n\r\n<p>Namun, keduanya juga dapat dikombinasikan. Yoga dan Pilates memiliki karakteristik latihan yang berbeda sehingga dapat saling melengkapi dalam rutinitas kebugaran.</p>\r\n\r\n<p><strong>Yoga Cocok untuk Siapa?</strong></p>\r\n\r\n<p>Yoga dapat menjadi pilihan bagi Anda yang ingin:</p>\r\n\r\n<ul>\r\n    <li>Meningkatkan fleksibilitas tubuh.</li>\r\n    <li>Melatih keseimbangan dan mobilitas.</li>\r\n    <li>Meningkatkan kesadaran terhadap tubuh dan pernapasan.</li>\r\n    <li>Melakukan aktivitas fisik dengan intensitas yang dapat disesuaikan.</li>\r\n    <li>Menambahkan latihan relaksasi dalam rutinitas harian.</li>\r\n    <li>Memulai aktivitas olahraga secara bertahap.</li>\r\n</ul>\r\n\r\n<p><strong>Pilates Cocok untuk Siapa?</strong></p>\r\n\r\n<p>Pilates dapat menjadi pilihan bagi Anda yang ingin:</p>\r\n\r\n<ul>\r\n    <li>Melatih kekuatan otot core.</li>\r\n    <li>Meningkatkan kontrol gerakan.</li>\r\n    <li>Meningkatkan kesadaran terhadap postur tubuh.</li>\r\n    <li>Melatih stabilitas dan koordinasi.</li>\r\n    <li>Melakukan latihan dengan gerakan yang terkontrol.</li>\r\n</ul>\r\n\r\n<p><strong>Apakah Yoga dan Pilates Bisa Dilakukan Bersamaan?</strong></p>\r\n\r\n<p>Tentu saja. Yoga dan Pilates dapat menjadi kombinasi latihan yang menarik.</p>\r\n\r\n<p>Pilates dapat membantu melatih kekuatan dan stabilitas tubuh, sedangkan yoga dapat memberikan latihan fleksibilitas, keseimbangan, mobilitas, serta relaksasi.</p>\r\n\r\n<p>Anda dapat melakukan Pilates pada beberapa hari dalam seminggu dan menambahkan sesi yoga pada hari lainnya. Frekuensi dan intensitas latihan sebaiknya disesuaikan dengan kemampuan tubuh dan rutinitas masing-masing.</p>\r\n\r\n<p><strong>Tips Memilih Yoga atau Pilates</strong></p>\r\n\r\n<p>Sebelum memilih, coba tentukan tujuan utama Anda.</p>\r\n\r\n<p><strong>Pilih yoga jika Anda lebih tertarik pada:</strong></p>\r\n\r\n<ul>\r\n    <li>Fleksibilitas.</li>\r\n    <li>Keseimbangan.</li>\r\n    <li>Mobilitas.</li>\r\n    <li>Pernapasan.</li>\r\n    <li>Relaksasi dan mindfulness.</li>\r\n</ul>\r\n\r\n<p><strong>Pertimbangkan Pilates jika Anda lebih tertarik pada:</strong></p>\r\n\r\n<ul>\r\n    <li>Kekuatan core.</li>\r\n    <li>Stabilitas tubuh.</li>\r\n    <li>Kontrol gerakan.</li>\r\n    <li>Postur.</li>\r\n    <li>Latihan fisik yang terstruktur.</li>\r\n</ul>\r\n\r\n<p>Jika masih bingung, tidak ada salahnya mencoba keduanya. Pengalaman langsung dapat membantu Anda mengetahui latihan mana yang paling nyaman dan sesuai dengan kebutuhan Anda.</p>\r\n\r\n<p><strong>Kesimpulan</strong></p>\r\n\r\n<p>Jadi, <strong>apa perbedaan Pilates dan yoga?</strong> Secara sederhana, yoga memiliki pendekatan yang lebih luas dengan menggabungkan gerakan, pernapasan, keseimbangan, fleksibilitas, dan relaksasi. Sementara itu, Pilates lebih berfokus pada kontrol gerakan, stabilitas, kekuatan core, dan postur.</p>\r\n\r\n<p>Keduanya sama-sama dapat menjadi bagian dari gaya hidup aktif. Yang terpenting adalah memilih latihan yang sesuai dengan tujuan dan dapat dilakukan secara konsisten.</p>\r\n\r\n<p>Jika Anda ingin mencoba yoga, mulailah dari kelas yang sesuai dengan tingkat kemampuan Anda. Dengan instruktur yang tepat, Anda dapat mempelajari teknik dasar dengan lebih nyaman dan membangun kebiasaan latihan secara bertahap.</p>\r\n\r\n<p><strong>Siap Mencoba Yoga?</strong></p>\r\n\r\n<p>Temukan kelas yoga yang sesuai dengan kebutuhan dan tingkat kemampuan Anda. Mulai perjalanan menuju tubuh yang lebih aktif, fleksibel, dan seimbang bersama kelas yoga yang tepat.</p>', 'images/Q21BSTPfei8FVhkubCnpiCxQYWcL7P6XigMY6gBq.jpg', '2026-08-26 17:00:00', 38, 'yoga, tips yogaaa', 'published', 'index', NULL, NULL, '2026-08-27 04:59:46', '2026-09-10 20:03:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `uuid` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `posisi` enum('slider','pengumuman','infografis','galeri','popup','mitra','lainnya') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`uuid`, `nama`, `deskripsi`, `link`, `gambar`, `posisi`, `status`, `created_at`, `updated_at`) VALUES
('06c5d7af-ea7a-490a-8908-5aac3b6e20c1', 'Galeri 5', NULL, NULL, 'banners/l2ZIgA9SVhyhxnkTNdy8ljwvLVtmnJHouXmhekyg.jpg', 'galeri', 'active', '2026-09-11 00:06:22', '2026-09-11 00:06:22'),
('47618df4-1983-4686-b9fd-f67aa7fae89f', 'galeri 6', NULL, NULL, 'banners/LmAdqgq38oIHGL7svW6sb4int8WW0v1b4pXoXO28.jpg', 'galeri', 'active', '2026-09-11 00:06:39', '2026-09-11 00:06:39'),
('8da02e21-bc7f-4816-ac56-1d762d11a546', 'Galeri 4', NULL, NULL, 'banners/HPy5cA2nP4JOTZy02wkMUToZoNPHKcfD4277jlfg.jpg', 'galeri', 'active', '2026-09-11 00:06:01', '2026-09-11 00:06:01'),
('9946050a-6755-4580-a102-d33fe42cea1b', 'galeri 7', NULL, NULL, 'banners/QTkrOknw5o4OcAQK3AdkDxPwZOX0TUlg37oENXGY.jpg', 'galeri', 'active', '2026-09-11 00:06:58', '2026-09-11 00:06:58'),
('c72bd89f-0849-40a1-927c-b9774e84bd2b', 'galeri 3', NULL, NULL, 'banners/3Uiy3wdss9hUamammpQfS97jQiKZD3EQ0o9V8mS3.jpg', 'galeri', 'active', '2026-09-11 00:05:33', '2026-09-11 00:05:33'),
('cd8f1370-54be-44de-94df-e0114b7d2f84', 'Banner slider', 'Find Balance in Every Breath', NULL, 'banners/ytsvrxIYf473coMMgB5x4Fl7xJhlTLskGuDuwvJ1.jpg', 'slider', 'active', '2026-09-12 02:13:04', '2026-09-12 02:13:04'),
('f7bd2370-bdad-42dc-909b-1239c040d0d3', 'galeri 2', 'Galeri 2', NULL, 'banners/oAwFgPkCIzLItkoQcSMMBRrtz9whT5LKk4gicW39.jpg', 'galeri', 'active', '2026-08-27 07:30:55', '2026-09-11 00:05:13');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('contact_captcha_00a4e0c9-7a68-46bb-8abd-565f84b3d8b4', 'i:13;', 1787907197),
('contact_captcha_014ef15c-1f57-4211-8768-cec662644d56', 'i:3;', 1787906060),
('contact_captcha_01636375-9e8d-49a8-9f39-d02091077974', 'i:11;', 1787905160),
('contact_captcha_01a883e5-667f-4742-8c95-6e4b4a5c1c0c', 'i:13;', 1787906301),
('contact_captcha_0466e063-e584-4544-8b6c-eaa65fbd00f3', 'i:11;', 1789108134),
('contact_captcha_04bfa788-8780-407a-810f-7fe014dbc05c', 'i:8;', 1787908679),
('contact_captcha_069b30e2-2bd7-4d46-9ae1-250c70d7168e', 'i:4;', 1789108127),
('contact_captcha_0c75fde7-c774-4f36-a929-00fdb67ccbe8', 'i:18;', 1789102137),
('contact_captcha_0e678328-766a-46d9-b4b7-09abaa6f413b', 'i:15;', 1787908003),
('contact_captcha_1135955f-4118-4386-a760-672633bf659e', 'i:4;', 1789106556),
('contact_captcha_145f68e2-4302-470c-8b2e-e97107abcdcb', 'i:6;', 1787905809),
('contact_captcha_14b0174b-d935-4015-bdda-36cb9eb5c954', 'i:13;', 1787908009),
('contact_captcha_155d0b88-a534-44d6-8752-7170cb5a962b', 'i:15;', 1789095764),
('contact_captcha_1657f8c9-43ae-44af-8114-2470cb67183c', 'i:8;', 1787905530),
('contact_captcha_19a6661c-bbaa-4120-86a8-97aa51113af9', 'i:5;', 1789096409),
('contact_captcha_1ac0546a-5062-48ff-bc8e-d8a04f240790', 'i:12;', 1787906051),
('contact_captcha_2016209a-f0e4-4497-bb2b-bdb32ebb4d43', 'i:13;', 1787908431),
('contact_captcha_215c87ff-aeee-4d21-9316-aa83f735ca8d', 'i:11;', 1789107127),
('contact_captcha_26a02495-c8f6-4593-a622-d67e4ff7f8ca', 'i:7;', 1787906669),
('contact_captcha_27ccb400-e616-483f-b018-1f47ca3f63be', 'i:14;', 1787905831),
('contact_captcha_27dd7222-4437-49db-b966-f0a79c92e47f', 'i:11;', 1787905642),
('contact_captcha_29377d09-d0fe-488f-b7b8-0c8d6e3b3ddc', 'i:10;', 1787907501),
('contact_captcha_29e14e57-9cb2-40ec-9eed-6d4b464933e5', 'i:5;', 1788151098),
('contact_captcha_317ececf-6fcb-4edb-8480-eaf8fff1ce28', 'i:14;', 1789108574),
('contact_captcha_323babac-df26-4afa-aeb6-7502170c7e4c', 'i:8;', 1787906124),
('contact_captcha_3344be3c-2382-4d5f-80ba-85ce00e7c1b9', 'i:14;', 1787907652),
('contact_captcha_340232cd-a177-42d2-a6a2-f43c6f7ed037', 'i:11;', 1789108522),
('contact_captcha_38647fb7-0cad-4ff1-b586-09d23b9c1ced', 'i:12;', 1789106605),
('contact_captcha_3cd879c2-f953-432b-8a60-da8b536293cb', 'i:10;', 1789102217),
('contact_captcha_3cee1c22-da17-4d4d-9f53-bfab6a056d79', 'i:15;', 1789085812),
('contact_captcha_3d2adb9c-3a23-48a8-bd3d-a85f40503038', 'i:10;', 1789108214),
('contact_captcha_3e0e851d-842b-4e82-9e1a-9031b061163a', 'i:7;', 1789107531),
('contact_captcha_40115158-d8a2-4ed5-9bfe-9c07ecf9e04a', 'i:13;', 1789108682),
('contact_captcha_40f7f294-6d3c-4013-9183-7e91caa369d6', 'i:7;', 1789091797),
('contact_captcha_44815260-dadf-4407-84ed-cd1643699dab', 'i:6;', 1788230642),
('contact_captcha_46c49dd2-0e53-448e-9086-6fad5514dff8', 'i:12;', 1789092541),
('contact_captcha_486d66ef-0597-45c4-8c72-c2e8c74b90cc', 'i:12;', 1787908145),
('contact_captcha_49b146e6-63b5-4c8a-b7b4-7917a3a1199e', 'i:9;', 1789285128),
('contact_captcha_4cee10bb-7b3e-4252-9140-acc929083d06', 'i:6;', 1787906133),
('contact_captcha_4f177724-b77d-419c-9c43-136fb1324db3', 'i:5;', 1789108755),
('contact_captcha_538c3b0e-99b8-4db0-a7d8-99fede766012', 'i:11;', 1787909427),
('contact_captcha_53c93b02-7dce-437c-bbd7-9950f8a1a653', 'i:9;', 1787908013),
('contact_captcha_5ae42b93-8e7b-4e7f-9264-cfb44c0ada2c', 'i:3;', 1789102092),
('contact_captcha_5d1b7b35-2557-4401-83f7-748900b25f7c', 'i:10;', 1789108587),
('contact_captcha_61481d4a-377f-4825-b644-732777413cc7', 'i:7;', 1789085792),
('contact_captcha_633cc133-187d-4a23-9af0-cc020a894c0a', 'i:16;', 1789107424),
('contact_captcha_6768de24-f95f-4397-b75d-5ac7c8234713', 'i:3;', 1789107520),
('contact_captcha_6932aa2b-c5b1-406a-a918-bade253ccf68', 'i:13;', 1789094954),
('contact_captcha_697b5021-56b0-48d0-a0aa-fa7bc997218d', 'i:6;', 1787906479),
('contact_captcha_69a415e1-1371-4a32-98f3-a98ae5209362', 'i:5;', 1787907056),
('contact_captcha_748f4b15-f5b5-4c90-b1fa-e73c7b029b91', 'i:10;', 1789107408),
('contact_captcha_75abd082-a77a-4035-bcfb-26eaf98f51a9', 'i:6;', 1787905802),
('contact_captcha_7ab7ed39-99df-47c1-897c-ab3f89577d15', 'i:14;', 1787907703),
('contact_captcha_7ba19807-07fd-4d15-b9c1-2a29763bacb3', 'i:14;', 1789107196),
('contact_captcha_7bcee500-576f-4118-8b79-a66ee23e068f', 'i:13;', 1787906907),
('contact_captcha_7bf99341-3026-46cf-b243-5bc5ba0aa556', 'i:6;', 1789107497),
('contact_captcha_7d5cf84b-c466-41c5-b8ac-fefbe540440b', 'i:11;', 1789108460),
('contact_captcha_807cee1e-2532-472c-84f0-61cf3ae453fb', 'i:3;', 1789108534),
('contact_captcha_80b7f312-8ea3-42a4-915d-15e2a0dc5bc2', 'i:15;', 1789100431),
('contact_captcha_83870c33-693c-4527-8349-b20694519b2e', 'i:9;', 1789108625),
('contact_captcha_852ee308-ccff-4696-b0d8-936f9326dafd', 'i:13;', 1787906072),
('contact_captcha_8589a410-0953-4423-96c1-3e4bb23f40a5', 'i:11;', 1789108711),
('contact_captcha_858feebf-3da6-4e32-95d7-84011683c296', 'i:9;', 1788257525),
('contact_captcha_86a15006-c41f-4c21-bd49-7b3e8257896f', 'i:14;', 1789108348),
('contact_captcha_883de22c-be6b-4b65-924d-6e4090e9509a', 'i:10;', 1789108632),
('contact_captcha_88e4616e-556f-486e-9fc5-3ec5773d51ad', 'i:7;', 1787908052),
('contact_captcha_8f1f6892-2f36-4eb6-8037-3d28de3bf57b', 'i:10;', 1788628502),
('contact_captcha_90fa29a3-7253-4763-b570-f9e3dabf7d48', 'i:11;', 1789111166),
('contact_captcha_92714f45-4908-4178-9201-46fa62fb5f23', 'i:15;', 1787906680),
('contact_captcha_94ea3740-c018-4f67-ab62-e1028af9ad46', 'i:13;', 1789112158),
('contact_captcha_962fb69c-4297-4c46-bd85-84a23b0cdd84', 'i:13;', 1789108563),
('contact_captcha_963d9a6e-c61c-45a7-bcdb-27c9c5de3e7a', 'i:18;', 1787907074),
('contact_captcha_9b1607a6-b7ff-438c-a124-2be846023fe8', 'i:3;', 1789102189),
('contact_captcha_9c2c24a7-0e67-403d-9a33-7da126a09e92', 'i:9;', 1787905028),
('contact_captcha_9c4df6d0-38e1-4621-9ed8-fd9ec65a3f6b', 'i:7;', 1788628568),
('contact_captcha_9f57162b-eed7-48b5-80eb-84d861f9c216', 'i:17;', 1789111269),
('contact_captcha_a08f2e20-c1f8-466c-b595-cc165a1df0a4', 'i:10;', 1789107178),
('contact_captcha_a38f5c01-1bb9-4052-8b74-066d8db3eaa5', 'i:2;', 1789090328),
('contact_captcha_a64a8c56-d481-44f8-b3c3-c70a07f96798', 'i:12;', 1787906917),
('contact_captcha_a9ebeb59-4444-4abd-98a9-7bb713ccbb26', 'i:8;', 1787906290),
('contact_captcha_ae3b5c33-092f-4536-89be-451e67663d67', 'i:18;', 1789090655),
('contact_captcha_b0064f18-ffb8-4cc4-8229-6b0988a3e84d', 'i:5;', 1788140990),
('contact_captcha_b1c62ba0-6d07-4693-949a-45504bb9c583', 'i:6;', 1789107692),
('contact_captcha_b57c73fd-311e-426e-841f-36a77c59de33', 'i:6;', 1787910304),
('contact_captcha_b834817d-7fed-418e-94ca-195e6da43d92', 'i:14;', 1787907510),
('contact_captcha_b9c68368-11a8-4041-8b1d-21f451fcca59', 'i:11;', 1789102042),
('contact_captcha_bc693b13-1bb2-468d-8a43-efb731e61959', 'i:7;', 1788140618),
('contact_captcha_bd3f1aa3-62b4-4b8b-89ca-50ba72dcac18', 'i:14;', 1788233761),
('contact_captcha_bdfb783a-e545-4b03-8600-370328bcfec7', 'i:8;', 1787908048),
('contact_captcha_be404286-3e71-4587-ba55-7876a0e98a3f', 'i:9;', 1787907417),
('contact_captcha_c04243ff-6ddf-4da1-8263-c7d221e76018', 'i:9;', 1789108205),
('contact_captcha_c0e1f0dd-a478-4947-8a5d-feb2a17042e2', 'i:10;', 1787906661),
('contact_captcha_c24bdd35-edef-4972-8d80-efd649f185ad', 'i:10;', 1789096498),
('contact_captcha_c3a906fb-e83d-40e7-a74d-a55af18cdcf9', 'i:14;', 1787906280),
('contact_captcha_c74f2373-3f8d-434f-b77e-0dc49ed8701d', 'i:6;', 1787907857),
('contact_captcha_d21c3925-4582-493d-9dc5-a1dab0948b4d', 'i:14;', 1789108550),
('contact_captcha_d3315141-43e1-462a-9dc4-9c4e9272d176', 'i:10;', 1789108093),
('contact_captcha_dbbca7ba-f20b-49e1-83b2-738bab1350e8', 'i:12;', 1789106581),
('contact_captcha_dcdd67a7-1ff1-4319-b291-3752772c8ee8', 'i:4;', 1789272682),
('contact_captcha_dd01883b-2ff4-426e-a602-44f2fb5c6131', 'i:10;', 1789090145),
('contact_captcha_e0c95fe2-fcd6-4047-89a1-aead1cb1586b', 'i:15;', 1787905163),
('contact_captcha_e804746f-e595-4e31-8ba6-9456aaf89ff2', 'i:8;', 1789107113),
('contact_captcha_e9984b04-0531-44e3-8774-35d24eb9f898', 'i:6;', 1788142578),
('contact_captcha_eb629b08-ba43-42e6-ad46-7f99413b7cb0', 'i:10;', 1787907395),
('contact_captcha_eb84ec2e-de7c-45e2-8458-39ef8143f8aa', 'i:14;', 1789111049),
('contact_captcha_f17ee4b8-2241-44cc-a1fd-0fae5e1eb67c', 'i:4;', 1789108084),
('contact_captcha_f1e10ca3-4310-48d5-b4e4-67756ec3c572', 'i:13;', 1787906646),
('contact_captcha_f1e9b783-cfd9-4620-860b-9623eab7280c', 'i:10;', 1787906469),
('contact_captcha_f249ce9a-1379-4f51-85fe-38ef9e12ec91', 'i:9;', 1787907205),
('contact_captcha_f479c0f5-45ba-46da-9e41-3b84468ea0f3', 'i:9;', 1788233777),
('contact_captcha_f9ab098a-db6c-4013-a9fe-c228b880d5ac', 'i:4;', 1787905818),
('contact_captcha_fa971475-fd33-42c3-b2e0-fbf825054a39', 'i:8;', 1789108371),
('contact_captcha_fb670dbb-7ed4-4313-a201-72cc2e278545', 'i:5;', 1788231829),
('contact_captcha_ff7714a8-919e-48d3-bc83-0ebdf9560beb', 'i:3;', 1789107916),
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:114:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"menu.main-menu\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:20:\"menu.role-permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:22:\"menu.access-management\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"dashboard.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"user.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:10:\"user.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:11:\"user.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"user.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"menu-group.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:16:\"menu-group.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:17:\"menu-group.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:18:\"menu-group.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:15:\"menu-item.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:15:\"menu-item.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:16:\"menu-item.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:17:\"menu-item.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:11:\"route.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:11:\"route.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:12:\"route.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:13:\"route.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:10:\"role.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:10:\"role.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:11:\"role.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"role.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:16:\"permission.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:16:\"permission.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:17:\"permission.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:18:\"permission.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:11:\"faq.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:9:\"faq.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:9:\"faq.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:10:\"faq.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:20:\"menu.main-portofolio\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:33;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:13:\"company.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:13:\"company.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"company.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:18:\"categories.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:37;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:16:\"categories.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:38;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:16:\"categories.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:39;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:17:\"categories.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:40;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:14:\"banner.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:41;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:12:\"banner.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:42;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:12:\"banner.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:43;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:13:\"banner.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:44;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:16:\"articles.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:45;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:15:\"articles.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:46;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:14:\"articles.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:47;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:14:\"articles.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:48;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:15:\"articles.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:49;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:14:\"dashboard.form\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:50;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:12:\"poll.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:51;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:10:\"poll.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:52;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:10:\"poll.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:53;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:11:\"poll.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:54;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:13:\"account.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:55;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:14:\"account.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:56;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:15:\"program.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:57;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:14:\"program.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:58;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:13:\"program.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:59;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:13:\"program.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:60;a:4:{s:1:\"a\";i:120;s:1:\"b\";s:14:\"program.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:61;a:4:{s:1:\"a\";i:125;s:1:\"b\";s:20:\"filedownload.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:62;a:4:{s:1:\"a\";i:130;s:1:\"b\";s:18:\"filedownload.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:63;a:4:{s:1:\"a\";i:135;s:1:\"b\";s:18:\"filedownload.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:64;a:4:{s:1:\"a\";i:140;s:1:\"b\";s:19:\"filedownload.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:65;a:4:{s:1:\"a\";i:145;s:1:\"b\";s:14:\"layanan.kontak\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:66;a:4:{s:1:\"a\";i:146;s:1:\"b\";s:16:\"instruktur.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:67;a:4:{s:1:\"a\";i:147;s:1:\"b\";s:12:\"pages.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:68;a:4:{s:1:\"a\";i:148;s:1:\"b\";s:13:\"pages.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:69;a:4:{s:1:\"a\";i:149;s:1:\"b\";s:11:\"pages.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:70;a:4:{s:1:\"a\";i:150;s:1:\"b\";s:11:\"pages.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:71;a:4:{s:1:\"a\";i:151;s:1:\"b\";s:12:\"pages.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:72;a:4:{s:1:\"a\";i:152;s:1:\"b\";s:18:\"instruktur.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:73;a:4:{s:1:\"a\";i:153;s:1:\"b\";s:16:\"instruktur.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:74;a:4:{s:1:\"a\";i:154;s:1:\"b\";s:17:\"instruktur.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:75;a:4:{s:1:\"a\";i:155;s:1:\"b\";s:19:\"testimonial.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:76;a:4:{s:1:\"a\";i:156;s:1:\"b\";s:17:\"testimonial.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:77;a:4:{s:1:\"a\";i:157;s:1:\"b\";s:18:\"testimonial.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:78;a:4:{s:1:\"a\";i:158;s:1:\"b\";s:17:\"testimonial.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:79;a:4:{s:1:\"a\";i:159;s:1:\"b\";s:12:\"events.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:80;a:4:{s:1:\"a\";i:160;s:1:\"b\";s:14:\"events.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:81;a:4:{s:1:\"a\";i:161;s:1:\"b\";s:12:\"events.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:82;a:4:{s:1:\"a\";i:162;s:1:\"b\";s:13:\"events.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:83;a:4:{s:1:\"a\";i:163;s:1:\"b\";s:21:\"specializations.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:84;a:4:{s:1:\"a\";i:164;s:1:\"b\";s:23:\"specializations.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:85;a:4:{s:1:\"a\";i:165;s:1:\"b\";s:22:\"specializations.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:86;a:4:{s:1:\"a\";i:166;s:1:\"b\";s:21:\"specializations.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:87;a:4:{s:1:\"a\";i:167;s:1:\"b\";s:15:\"package.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:88;a:4:{s:1:\"a\";i:168;s:1:\"b\";s:13:\"package.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:89;a:4:{s:1:\"a\";i:169;s:1:\"b\";s:14:\"package.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:90;a:4:{s:1:\"a\";i:170;s:1:\"b\";s:13:\"package.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:91;a:4:{s:1:\"a\";i:171;s:1:\"b\";s:14:\"package.member\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:92;a:4:{s:1:\"a\";i:172;s:1:\"b\";s:15:\"classes.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:93;a:4:{s:1:\"a\";i:173;s:1:\"b\";s:13:\"classes.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:94;a:4:{s:1:\"a\";i:174;s:1:\"b\";s:13:\"classes.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:95;a:4:{s:1:\"a\";i:175;s:1:\"b\";s:14:\"classes.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:96;a:4:{s:1:\"a\";i:176;s:1:\"b\";s:22:\"dashboard.submitSumber\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:97;a:4:{s:1:\"a\";i:177;s:1:\"b\";s:14:\"classes.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:98;a:4:{s:1:\"a\";i:178;s:1:\"b\";s:12:\"classes.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:99;a:4:{s:1:\"a\";i:179;s:1:\"b\";s:20:\"classes.change-level\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:100;a:4:{s:1:\"a\";i:180;s:1:\"b\";s:23:\"class-schedules.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:101;a:4:{s:1:\"a\";i:181;s:1:\"b\";s:21:\"class-schedules.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:102;a:4:{s:1:\"a\";i:182;s:1:\"b\";s:21:\"class-schedules.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:103;a:4:{s:1:\"a\";i:183;s:1:\"b\";s:22:\"class-schedules.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:104;a:4:{s:1:\"a\";i:184;s:1:\"b\";s:21:\"class-schedules.print\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:105;a:4:{s:1:\"a\";i:185;s:1:\"b\";s:14:\"pengguna.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:106;a:4:{s:1:\"a\";i:186;s:1:\"b\";s:15:\"pengguna.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:107;a:4:{s:1:\"a\";i:187;s:1:\"b\";s:13:\"studios.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:108;a:4:{s:1:\"a\";i:188;s:1:\"b\";s:15:\"studios.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:109;a:4:{s:1:\"a\";i:189;s:1:\"b\";s:14:\"studios.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:110;a:4:{s:1:\"a\";i:190;s:1:\"b\";s:13:\"studios.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:111;a:4:{s:1:\"a\";i:191;s:1:\"b\";s:14:\"studios.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:112;a:4:{s:1:\"a\";i:192;s:1:\"b\";s:17:\"instruktur.mobile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:113;a:4:{s:1:\"a\";i:193;s:1:\"b\";s:16:\"checkout.package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super-admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:4:\"user\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"instruktur\";s:1:\"c\";s:3:\"web\";}}}', 1789313984),
('wikupb@gmail.com|192.168.1.34', 'i:1;', 1789137612),
('wikupb@gmail.com|192.168.1.34:timer', 'i:1789137612;', 1789137612);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`uuid`, `name`, `slug`, `description`, `icon`, `created_at`, `updated_at`) VALUES
('2162d145-9ef3-4e2f-8c55-81971a015bc5', 'Yoga', 'yoga', 'Tips, teknik, pose, dan latihan yoga untuk meningkatkan kesehatan dan keseimbangan tubuh.', 'fa-spa', '2025-09-16 01:03:22', '2026-08-27 04:17:14'),
('34103609-8116-4baf-bd17-557fc6989e8e', 'Wellness', 'wellness', 'Informasi seputar kesehatan, kebugaran, nutrisi, dan gaya hidup sehat.', 'fa-heart-pulse', '2025-09-16 01:03:16', '2026-08-27 04:17:35'),
('72561291-cdcb-484b-a556-0400fbd53c3d', 'Mindfulness', 'mindfulness', 'Panduan meditasi, ketenangan pikiran, kesadaran diri, dan keseimbangan mental.', 'fa-brain', '2025-10-31 03:07:08', '2026-08-27 04:17:57'),
('a58f5ebc-c8ec-48da-b6f9-a80b05ca40a0', 'Kegiatan', 'kegiatan', 'Informasi event, workshop, retreat, dan berbagai kegiatan YogaRoots.', 'fa-calendar-days', '2026-06-20 12:47:44', '2026-08-27 04:18:24'),
('bb006a6e-36bc-48cb-a84f-2a562489bb54', 'Berita', 'berita', 'Informasi dan kabar terbaru seputar YogaRoots, kelas, program, dan studio.', 'fa-newspaper', '2025-09-16 01:03:27', '2026-08-27 04:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `quota_cost` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `instructor_uuid` char(36) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `level` enum('foundation','intermediate','advance') NOT NULL,
  `duration` mediumint(10) DEFAULT NULL,
  `is_active` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`uuid`, `name`, `slug`, `description`, `price`, `quota_cost`, `instructor_uuid`, `image`, `level`, `duration`, `is_active`, `created_at`, `updated_at`) VALUES
('01a07699-0698-73e1-8251-7afede34bbb1', 'Wiku Pramesthi', 'wiku-pramesthi', 'dsada dasdas dasd', 1.00, 1, '95294c43-b3d8-4b46-b938-e4eea1f3a359', 'classes/XrR7ox1BqBNUKzCmgh6WEhsjbkT50AMjYQ3uiJYh.jpg', 'foundation', 60, 'active', '2026-09-06 05:02:15', '2026-09-06 05:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `class_bookings`
--

CREATE TABLE `class_bookings` (
  `uuid` char(36) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `class_schedule_uuid` char(36) NOT NULL,
  `booking_type` enum('membership','direct') NOT NULL,
  `quota_used` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('booked','attended','cancelled','no_show') NOT NULL DEFAULT 'booked',
  `booked_at` timestamp NULL DEFAULT NULL,
  `attended_at` timestamp NULL DEFAULT NULL,
  `package_uuid` char(36) DEFAULT NULL,
  `order_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_schedules`
--

CREATE TABLE `class_schedules` (
  `uuid` char(36) NOT NULL,
  `class_uuid` char(36) NOT NULL,
  `studio_uuid` char(36) DEFAULT NULL,
  `day` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time DEFAULT NULL,
  `capacity` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_schedules`
--

INSERT INTO `class_schedules` (`uuid`, `class_uuid`, `studio_uuid`, `day`, `start_time`, `end_time`, `capacity`, `status`, `created_at`, `updated_at`) VALUES
('01a07699-68e3-71cc-892a-e0557ae317ee', '01a07699-0698-73e1-8251-7afede34bbb1', NULL, 'tuesday', '19:02:00', '19:05:00', 20, 'active', '2026-09-06 05:02:40', '2026-09-06 05:02:40'),
('01a07aba-eb15-700e-9ceb-7d37f2772c7e', '01a07699-0698-73e1-8251-7afede34bbb1', NULL, 'monday', '14:19:00', '14:20:00', 1, 'active', '2026-09-07 00:17:45', '2026-09-07 00:17:45'),
('01a09092-6304-73de-bacb-ead567c883b5', '01a07699-0698-73e1-8251-7afede34bbb1', '363f49dc-b34f-4ac2-ad18-95b140c6335e', 'saturday', '20:04:00', '20:08:00', 10, 'inactive', '2026-09-11 06:05:07', '2026-09-11 06:15:47'),
('01a092b9-6448-7308-9328-96caf2fc5466', '01a07699-0698-73e1-8251-7afede34bbb1', '363f49dc-b34f-4ac2-ad18-95b140c6335e', 'saturday', '11:06:00', '11:18:00', 1, 'inactive', '2026-09-11 16:06:58', '2026-09-12 01:11:47');

-- --------------------------------------------------------

--
-- Table structure for table `disabilities`
--

CREATE TABLE `disabilities` (
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disabilities`
--

INSERT INTO `disabilities` (`uuid`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
('486f36ec-f749-463e-ab20-d06b1d28bf8e', 'Autis', 'autis', 'Gangguan Spektrum Autisme adalah kondisi perkembangan saraf yang memengaruhuhi komunikasi, interaksi sosial dan perilaku.', '2025-11-21 04:17:52', '2025-11-21 04:22:52'),
('538deecf-f902-4394-bb11-ed55207e912e', 'Tunanetra (A)', 'tunanetra-a', 'Tunanetra adalah seseorang yang memiliki gangguan penglihatan, baik sebagian maupun total, yang menghabat aktivitas sehari-hari dengan tingkat gangguan totally blind yang tidak bisa melihat sama sekali dan low vision yang masih bisa  melihat sebagian baik dan ataupun tanpa alat bantu.', '2025-11-11 06:12:12', '2025-11-21 02:35:57'),
('7ae1645d-d10d-44e0-86be-22e44b1db039', 'Tunadaksa (D, D1)', 'tunadaksa-d-d1', 'Tunadaksa adalah kondisi fisik yang menyebabkan keterbatasan dalam mengendalikan gerakan tubuh akibat kelainan pada sistem otot, tulang atau saraf.', '2025-11-21 04:32:42', '2025-11-21 04:33:12'),
('e35fed39-3a2f-4a33-80f6-5820c71a7fd6', 'Tunagrahita (C, C1)', 'tunagrahita-c-c1', 'Tunagrahita adalah kondisi gangguan perkembangan intelektual yang mempengaruhi kemampuan belajar dan menyesuaikan diri.', '2025-11-21 04:16:12', '2025-11-21 04:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `ebooks`
--

CREATE TABLE `ebooks` (
  `uuid` char(36) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` enum('Buku Pelajaran','Buku Cerita Anak','Modul Guru','Panduan Orang Tua','Majalah Sekolah','Keterampilan & Kreativitas','Kesehatan & Terapi','Agama','Umum') DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `uuid` char(36) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` longtext DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `status` enum('draft','published','cancelled','completed') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`uuid`, `judul`, `slug`, `deskripsi`, `gambar`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `lokasi`, `kapasitas`, `status`, `created_at`, `updated_at`) VALUES
('02471b9c-9346-409c-b9b0-5331d91456ed', 'Growing Together in Nature', 'growing-together-in-nature', '<p><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">A special morning created for mama-to-be.</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">Move gently, breathe deeply, connect with your little one, and enjoy a peaceful morning in nature. 🤍</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">📅 Sunday, 13 September 2026</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">⏰ 07.30–10.00 AM</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">📍 Kebun Raya Bogor – Taman Melchior</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">💗 150K / pax</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">Includes Prenatal Yoga, Pregnancy Talk, Mini MCU, Garden Picnic, Goodies &amp; Giveaways! ✨</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">🎟️ Register Now:</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">https://bit.ly/PrenatalGentleYogaatKebunRaya</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">Come grow, breathe &amp; connect with us. 🌿</span></p>', 'events/NLg7WQHCoKb9lC1eYoe4r8Ca1tUW2sDfOdFrdj3l.jpg', '2026-09-13', '07:30:00', '10:00:00', 'Kebun Raya Bogor – Taman Melchior', 35, 'published', '2026-08-31 18:39:08', '2026-09-01 03:02:52'),
('3191142d-9185-421c-be1d-791c843f6161', 'Yoga Night at the Museum is calling', 'yoga-night-at-the-museum-is-calling', '<p><div class=\"html-div x14z9mp x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x9f619 xjbqb8w x78zum5 x15mokao x1ga7v0g x16uus16 xbiv7yw x1xmf6yo x12nagc x1n2onr6 x1plvlek xryxfnj x1c4vz4f x2lah0s xdt5ytf xqjyukv x1qjc9v5 x1oa3qoh x1nhvcw1\" style=\"margin-inline: 0px; border-start-start-radius: 0px; border-end-end-radius: 0px; padding-inline: 0px; flex-grow: 0; border-start-end-radius: 0px; position: relative; place-content: stretch flex-start; align-self: auto; align-items: stretch; flex-shrink: 0; display: flex; box-sizing: border-box; border-end-start-radius: 0px; flex-direction: column; background-color: rgb(255, 255, 255); margin-bottom: 4px; padding-bottom: 0px; overflow: visible; margin-top: 8px; padding-top: 0px; color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"></div></p><div class=\"xt0psk2\" style=\"display: inline; color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><h1 class=\"_ap3a _aaco _aacu _aacx _aad7 _aade\" dir=\"auto\" style=\"color: rgb(12, 16, 20); font-size: 14px; font-weight: 400; margin: 0px !important; padding: 0px; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; line-height: 18px; display: inline !important;\">Rasakan sensasi ketenangan malam dan keseimbangan jiwa dalam perayaan Anniversary Yoga Roots yang ke 3 tahun🌿<br><br>📅 Jumat, 18 September 2026<br>⏰ 18.30-19.30 WIB<br>📍 Taman Arca, Museum Nasional Indonesia<br>🎟️ IDR 150K — sudah termasuk tiket masuk museum<br><br>Jangan lupa bawa yoga mat &amp; botol minum pribadi.<br><br>Yuk, luangkan waktu untuk move, breathe, and reconnect di malam yang spesial🤍</h1></div>', 'events/7k4NwTxmHUtn6jbXllpKeB3m6jxe35KGp4shy3Zn.jpg', '2026-09-18', '18:30:00', '19:30:00', 'Taman Arca, Museum Nasional Indonesia', 50, 'published', '2026-09-11 06:50:04', '2026-09-11 07:28:46'),
('64e369a4-ed0f-4009-996e-362f879a681e', 'Sunset Serenity', 'sunset-serenity', '<p><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">Take a moment to slow down, breathe deeply, and reconnect with yourself as the sunsets.</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">Join us for a relaxing Sunset Yoga Session with Coach Mega at Balcony Skechers, Senayan Park.</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">📅 20 September 2026</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">📍 Balcony Skechers, Senayan Park</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">🕟 4:30 PM</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">🧘‍♀️ Beginner Friendly</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">💫 Only IDR 65,000</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">🎁 Includes Goodie Bag</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">Come as you are, flow at your own pace, and end the day feeling refreshed.</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">Save your spot and let the sunset be your reset.</span></p>', 'events/duaDypZpAvPRHnf5Wdry1rNUMXK7S4vZPbxxInbq.webp', '2026-09-20', '16:30:00', '16:30:00', 'Balcony Skechers, Senayan Park', 50, 'published', '2026-09-11 07:28:06', '2026-09-11 07:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `uuid` char(36) NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `jawaban` text NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`uuid`, `pertanyaan`, `jawaban`, `urutan`, `status`, `created_at`, `updated_at`) VALUES
('4b9411a3-ccc5-44fd-bc24-e8dc7065773c', 'What should I bring to class?', 'Wear comfortable clothes that allow you to move freely. Bring a water bottle and your own yoga mat if needed.', 2, 'active', '2025-09-17 20:19:23', '2026-09-10 17:00:55'),
('6bb623f8-916a-436b-85b3-a57035fe5ac5', 'How often should I practice yoga?', 'It depends on your goals and routine. For most people, practicing 2–3 times a week is a great way to build consistency while giving your body enough time to rest.', 4, 'active', '2025-09-17 20:20:44', '2026-09-10 17:01:41'),
('95b200f1-69c7-4f1b-a76b-172bcf5fcc55', 'How long is each class?', 'Most Yoga Roots classes run for 60–90 minutes, depending on the type of class. Each session gives you time to move, breathe, and slow down.', 5, 'active', '2025-09-17 20:21:00', '2026-09-10 17:02:03'),
('9f25d34e-2a60-42cf-8379-ed069dc50ac0', 'How can I join Yoga Roots?', 'Choose the class that feels right for you, select your preferred schedule, and register through our website. We’ll be happy to have you join us.', 6, 'active', '2026-09-10 17:02:30', '2026-09-10 17:02:30'),
('fa2b17f9-f0d4-4849-8373-8d787b80113e', 'Is Yoga Roots suitable for beginners?', 'Absolutely. Yoga Roots welcomes everyone, whether you’re completely new to yoga or have been practicing for years. Our classes are designed to help you feel comfortable and progress at your own pace.', 1, 'active', '2025-09-17 20:13:33', '2026-09-10 17:00:36'),
('fd90f57c-53aa-4b5d-8e11-faea4808686d', 'Do I need to be flexible to practice yoga?', 'Not at all. You don’t need to be flexible to start yoga. With regular practice, you’ll gradually build flexibility, strength, balance, and a better connection with your body.', 3, 'active', '2025-09-17 20:20:22', '2026-09-10 17:01:17');

-- --------------------------------------------------------

--
-- Table structure for table `file_downloads`
--

CREATE TABLE `file_downloads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `kategori` enum('akademik','informasi','laporan','edaran') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kecamatans`
--

CREATE TABLE `kecamatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kecamatans`
--

INSERT INTO `kecamatans` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Bantar Gebang', NULL, NULL),
(2, 'Bekasi Barat', NULL, NULL),
(3, 'Bekasi Selatan', NULL, NULL),
(4, 'Bekasi Timur', NULL, NULL),
(5, 'Bekasi Utara', NULL, NULL),
(6, 'Jatiasih', NULL, NULL),
(7, 'Jatisampurna', NULL, NULL),
(8, 'Medan Satria', NULL, NULL),
(9, 'Mustika Jaya', NULL, NULL),
(10, 'Pondok Gede', NULL, NULL),
(11, 'Pondok Melati', NULL, NULL),
(12, 'Rawalumbu', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kelurahans`
--

CREATE TABLE `kelurahans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kecamatan_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kodepos` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelurahans`
--

INSERT INTO `kelurahans` (`id`, `kecamatan_id`, `nama`, `kodepos`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bantargebang', 17151, NULL, NULL),
(2, 1, 'Ciketing Udik', 17153, NULL, NULL),
(3, 1, 'Cikiwul', 17152, NULL, NULL),
(4, 1, 'Sumur Batu', 17154, NULL, NULL),
(5, 2, 'Bintara', 17134, NULL, NULL),
(6, 2, 'Bintara Jaya', 17136, NULL, NULL),
(7, 2, 'Jakasampurna', 17145, NULL, NULL),
(8, 2, 'Kota Baru', 17133, NULL, NULL),
(9, 2, 'Kranji', 17135, NULL, NULL),
(10, 3, 'Jakamulya', 17146, NULL, NULL),
(11, 3, 'Jakasetia', 17147, NULL, NULL),
(12, 3, 'Kayuringin Jaya', 17144, NULL, NULL),
(13, 3, 'Marga Jaya', 17141, NULL, NULL),
(14, 3, 'Pekayon Jaya', 17148, NULL, NULL),
(15, 4, 'Aren Jaya', 17111, NULL, NULL),
(16, 4, 'Bekasi Jaya', 17112, NULL, NULL),
(17, 4, 'Duren Jaya', 17111, NULL, NULL),
(18, 4, 'Margahayu', 17113, NULL, NULL),
(19, 5, 'Harapan Baru', 17123, NULL, NULL),
(20, 5, 'Harapan Jaya', 17124, NULL, NULL),
(21, 5, 'Kaliabang Tengah', 17125, NULL, NULL),
(22, 5, 'Marga Mulya', 17142, NULL, NULL),
(23, 5, 'Perwira', 17122, NULL, NULL),
(24, 5, 'Teluk Pucung', 17121, NULL, NULL),
(25, 6, 'Jatiasih', 17423, NULL, NULL),
(26, 6, 'Jatikramat', 17421, NULL, NULL),
(27, 6, 'Jatiluhur', 17425, NULL, NULL),
(28, 6, 'Jatimekar', 17422, NULL, NULL),
(29, 6, 'Jatirasa', 17424, NULL, NULL),
(30, 6, 'Jatisari', 17426, NULL, NULL),
(31, 7, 'Jatikarya', 17435, NULL, NULL),
(32, 7, 'Jatiraden', 17433, NULL, NULL),
(33, 7, 'Jatirangga', 17434, NULL, NULL),
(34, 7, 'Jatiranggon', 17432, NULL, NULL),
(35, 7, 'Jatisampurna', 17433, NULL, NULL),
(36, 8, 'Harapan Mulya', 17143, NULL, NULL),
(37, 8, 'Kali Baru', 17133, NULL, NULL),
(38, 8, 'Medan Satria', 17132, NULL, NULL),
(39, 8, 'Pejuang', 17131, NULL, NULL),
(40, 9, 'Cimuning', 17155, NULL, NULL),
(41, 9, 'Mustikajaya', 17158, NULL, NULL),
(42, 9, 'Mustikasari', 17157, NULL, NULL),
(43, 9, 'Padurenan', 17156, NULL, NULL),
(44, 10, 'Jatibening', 17412, NULL, NULL),
(45, 10, 'Jatibening Baru', 17412, NULL, NULL),
(46, 10, 'Jaticempaka', 17411, NULL, NULL),
(47, 10, 'Jatimakmur', 17413, NULL, NULL),
(48, 10, 'Jatiwaringin', 17411, NULL, NULL),
(49, 11, 'Jatimelati', 17414, NULL, NULL),
(50, 11, 'Jatimurni', 17431, NULL, NULL),
(51, 11, 'Jatirahayu', 17414, NULL, NULL),
(52, 11, 'Jatiwarna', 17415, NULL, NULL),
(53, 12, 'Bojong Menteng', 17117, NULL, NULL),
(54, 12, 'Bojong Rawalumbu', 17116, NULL, NULL),
(55, 12, 'Pengasinan', 17115, NULL, NULL),
(56, 12, 'Sepanjang Jaya', 17114, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `uuid` char(36) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `respon` text DEFAULT NULL,
  `status` enum('open','in_progress','resolved','closed','rejected') NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_groups`
--

CREATE TABLE `menu_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `permission_name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_groups`
--

INSERT INTO `menu_groups` (`id`, `name`, `status`, `permission_name`, `icon`, `position`, `created_at`, `updated_at`) VALUES
(2, 'Role dan Akses', 1, 'menu.role-permission', 'bx-shield-quarter', 10, '2024-09-26 23:27:05', '2024-09-26 23:56:50'),
(3, 'Settings', 1, 'menu-item.index', 'bx-cog', 11, '2024-09-26 23:27:05', '2026-09-06 19:40:05'),
(4, 'Order History', 1, 'filedownload.index', 'bx-money', 3, '2024-09-26 23:35:30', '2026-09-11 00:31:59'),
(7, 'Content', 1, 'articles.index', 'bxs-file', 7, '2024-09-29 12:37:06', '2026-09-07 20:02:14'),
(8, 'Media Library', 1, 'banner.index', 'bx-camera', 8, '2024-10-13 22:33:06', '2026-09-06 21:51:58'),
(9, 'Master Data', 1, 'testimonial.index', 'bx-folder-open', 9, '2025-07-21 17:56:19', '2026-08-30 19:07:27'),
(10, 'Instructors', 1, 'instruktur.index', 'bx-user', 6, '2025-07-23 22:38:22', '2026-09-03 17:38:48'),
(11, 'Events', 1, 'events.index', 'bxs-calendar', 4, '2025-07-25 16:53:44', '2026-09-11 00:30:47'),
(12, 'Packages', 1, 'package.member', 'bx-package', 1, '2025-09-14 12:05:35', '2026-09-07 20:00:15'),
(22, 'Classes', 1, 'class-schedules.index', 'bx-book', 2, '2026-09-02 15:16:09', '2026-09-06 03:39:03'),
(23, 'Studios', 1, 'studios.index', 'bx-camera-home', 5, '2026-09-08 06:44:24', '2026-09-08 06:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `route` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `permission_name` varchar(255) NOT NULL,
  `menu_group_id` bigint(20) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `icon`, `route`, `status`, `permission_name`, `menu_group_id`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Informasi Umum', NULL, 'company.index', 1, 'company.index', 1, 1, '2024-09-26 23:27:05', '2024-09-27 01:56:11'),
(2, 'Module Role', NULL, 'permission.index', 1, 'permission.index', 2, 1, '2024-09-26 23:27:05', '2024-09-26 23:58:37'),
(3, 'Master Role', NULL, 'role.index', 1, 'role.index', 2, 2, '2024-09-26 23:27:05', '2024-09-26 23:58:15'),
(4, 'Daftar Pengguna', NULL, 'user.index', 1, 'user.index', 3, 1, '2024-09-26 23:27:05', '2024-09-26 23:39:25'),
(5, 'Module Aplikasi', NULL, 'route.index', 1, 'route.index', 3, 2, '2024-09-26 23:27:05', '2024-09-26 23:44:54'),
(6, 'Menu Manager', NULL, 'menu.index', 1, 'menu-group.index', 3, 3, '2024-09-26 23:27:05', '2024-09-26 23:44:09'),
(8, 'Category', NULL, 'categories.index', 1, 'categories.index', 7, 3, '2024-09-29 12:39:24', '2026-09-07 20:01:25'),
(9, 'Articles', NULL, 'articles.index', 1, 'articles.index', 7, 1, '2024-09-30 12:08:38', '2026-09-07 20:04:28'),
(10, 'All Media', NULL, 'banner.index', 1, 'banner.index', 8, 1, '2024-10-13 22:38:24', '2026-09-06 21:52:06'),
(12, 'Add Articles', NULL, 'articles.create', 1, 'articles.create', 7, 2, '2025-07-22 12:59:27', '2026-09-07 20:04:20'),
(13, 'Specialization', NULL, 'specializations.index', 1, 'specializations.index', 10, 1, '2025-07-23 23:12:46', '2026-09-03 15:02:16'),
(14, 'All Events', NULL, 'events.index', 1, 'events.index', 11, 1, '2025-07-25 16:55:36', '2026-09-03 05:05:58'),
(40, 'Static Pages', NULL, 'pages.index', 1, 'pages.index', 9, 3, '2025-10-21 03:46:02', '2026-09-03 15:13:56'),
(41, 'All Instructors', NULL, 'instruktur.index', 1, 'program.index', 10, 2, '2025-11-12 04:02:59', '2026-09-03 17:40:35'),
(44, 'Packages', NULL, 'packages.index', 1, 'package.index', 12, 1, '2026-09-02 04:59:49', '2026-09-02 04:59:49'),
(45, 'Browse Packages', NULL, 'packages.member', 1, 'package.member', 12, 2, '2026-09-02 05:52:23', '2026-09-07 20:00:31'),
(46, 'Class List', NULL, 'classes.index', 1, 'classes.index', 22, 1, '2026-09-02 15:18:03', '2026-09-02 15:18:03'),
(47, 'Schedule', NULL, 'class-schedules.index', 1, 'class-schedules.index', 22, 2, '2026-09-06 03:39:53', '2026-09-06 03:39:53'),
(48, 'Messages', NULL, 'layanan.kontak', 1, 'layanan.kontak', 3, 4, '2026-09-06 19:44:23', '2026-09-06 19:44:23'),
(49, 'All Members', NULL, 'pengguna.index', 1, 'pengguna.index', 3, 5, '2026-09-06 20:40:53', '2026-09-06 20:40:53'),
(50, 'Testimonials', NULL, 'testimonial.index', 1, 'testimonial.index', 9, 4, '2026-09-07 23:00:45', '2026-09-07 23:00:45'),
(51, 'Faq & Answer', NULL, 'faq.index', 1, 'faq.index', 9, 5, '2026-09-07 23:04:55', '2026-09-07 23:04:55'),
(52, 'All Studios', NULL, 'studios.index', 1, 'studios.index', 23, 1, '2026-09-08 07:14:52', '2026-09-08 07:14:52'),
(53, 'Add Studio', NULL, 'studios.create', 1, 'studios.create', 23, 2, '2026-09-08 07:15:14', '2026-09-08 07:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_07_25_034354_create_permission_tables', 1),
(7, '2024_07_25_045022_create_routes_table', 1),
(8, '2024_07_26_043548_create_menu_groups_table', 1),
(9, '2024_07_31_012301_create_banners_table', 1),
(10, '2024_07_31_033121_create_kontaks_table', 1),
(11, '2024_08_26_084211_create_menu_items_table', 1),
(12, '2024_10_15_032323_create_categories_table', 1),
(13, '2024_10_16_032117_create_articles_table', 1),
(14, '2024_10_16_032437_create_seo_table', 1),
(15, '2025_07_21_125740_add_google_id_column', 1),
(16, '2025_07_22_061051_create_ebooks_table', 1),
(17, '2025_07_24_021857_create_kecamatans_table', 1),
(18, '2025_07_24_021932_create_kelurahans_table', 1),
(19, '2025_07_24_071157_add_profile_fields_to_users_table', 1),
(20, '2025_07_25_120837_create_file_downloads_table', 1),
(21, '2025_07_30_070942_create_programs_table', 1),
(22, '2025_08_06_040605_create_pages_table', 1),
(23, '2025_08_08_023001_change_model_id_to_uuid_in_seo_table', 1),
(24, '2025_08_15_025639_add_tagging_status_searchengine_to_articles_table', 1),
(25, '2025_09_16_021217_create_notifications_table', 1),
(26, '2025_09_16_023931_alter_notifications_table_for_uuid', 1),
(27, '2025_09_16_061424_create_faqs_table', 1),
(28, '2025_09_16_061553_create_testimonials_table', 1),
(29, '2025_09_16_063145_create_polls_table', 1),
(30, '2025_09_16_074843_create_poll_votes_table', 1),
(31, '2025_09_22_030137_add_deleted_at_to_users_table', 2),
(32, '2025_10_03_015100_add_socials_and_biografi_to_users_table', 3),
(33, '2024_10_16_012301_create_banners_table', 4),
(34, '2025_10_20_120827_create_services_table', 5),
(35, '2025_10_19_120827_create_services_table', 6),
(36, '2025_10_21_120827_create_services_table', 7),
(37, '2025_11_11_033008_create_disabilities_table', 8),
(38, '2025_11_11_070942_create_programs_table', 9),
(39, '2026_08_28_033008_create_specializations_table', 10),
(40, '2026_08_31_120827_create_events_table', 11),
(41, '2026_08_31_125113_create_user_specialization_table', 12),
(42, '2026_09_02_073504_create_packages_table', 13),
(43, '2026_09_02_073857_create_package_features_table', 13),
(44, '2026_09_02_073943_create_classes_table', 13),
(45, '2026_09_02_074219_create_class_schedules_table', 13),
(46, '2026_09_02_074643_add_membership_fields_to_users_table', 13),
(47, '2026_09_02_074803_create_orders_table', 13),
(48, '2026_09_02_074832_create_payments_table', 13),
(49, '2026_09_02_074849_create_class_bookings_table', 13),
(50, '2026_09_06_222620_create_user_packages_table', 14),
(51, '2026_09_08_131616_create_user_studios_table', 15),
(52, '2026_09_08_131617_create_studios_table', 16),
(53, '2026_09_12_195535_create_package_options_table', 17),
(54, '2026_09_12_195536_create_package_options_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', '3099cb1c-6c37-4e5a-bbb5-d11615a1b0ff'),
(1, 'App\\Models\\User', '5e21baa9-0ca0-4c94-9939-85068e363f57'),
(1, 'App\\Models\\User', '787b72ea-59d0-4d54-848b-c200bddafdd2'),
(2, 'App\\Models\\User', '0dd616be-4e66-463c-9b42-6529b1c7cb4f'),
(2, 'App\\Models\\User', '130214ce-3612-455f-ae39-f6f2a5c2b90d'),
(2, 'App\\Models\\User', '370a8be5-8531-453a-a504-2a610ed8538f'),
(2, 'App\\Models\\User', '3e354d68-8b35-410c-9fd1-827ec786b007'),
(2, 'App\\Models\\User', '57621d3c-c299-4cd2-b96a-9b887752cb73'),
(2, 'App\\Models\\User', '6bdf7417-66c8-407c-828b-77577006dda2'),
(2, 'App\\Models\\User', '70e15b9f-535a-42a2-8ea0-9a26ad7952e5'),
(2, 'App\\Models\\User', '95271004-d8a8-41a4-93eb-62a766c2758d'),
(2, 'App\\Models\\User', 'a82db5a8-5d69-499b-a9a1-3d98ad0c47e4'),
(2, 'App\\Models\\User', 'b5a9eb64-a547-4464-a576-e261ede0d4db'),
(2, 'App\\Models\\User', 'c4536499-9979-4be5-a0ad-775fe9bec19d'),
(2, 'App\\Models\\User', 'd56cc48a-b1fa-4c03-9b72-c8f92766efb3'),
(2, 'App\\Models\\User', 'd91ccba3-e95b-4692-8f8c-63d543549331'),
(2, 'App\\Models\\User', 'dfd391fa-c167-4547-ad17-27d52d9ffc28'),
(2, 'App\\Models\\User', 'e5a05967-00cb-49f6-97bf-95c1bccee6e0'),
(3, 'App\\Models\\User', '44af87c7-cd3f-4f9d-af63-177da19727fb'),
(3, 'App\\Models\\User', '57f63489-134b-498c-ad05-78a3652cb916'),
(3, 'App\\Models\\User', 'e2c23ff6-eda1-4c5c-86a4-d2d1782ed930'),
(5, 'App\\Models\\User', '0ba0b18a-64e7-44ce-8042-8b282ab9c5b3'),
(5, 'App\\Models\\User', '1c3ea59a-f83a-4bdf-aa70-f38ff66f49a2'),
(5, 'App\\Models\\User', '2f040883-ec48-424e-872d-3691d7c1a714'),
(5, 'App\\Models\\User', '33b681e2-efc3-4017-9415-e5d5d197f2fe'),
(5, 'App\\Models\\User', '4a85c36a-caa6-4cc9-9ab6-47f77c0a9a67'),
(5, 'App\\Models\\User', '4c0ff420-34e5-4ecd-bb07-358862f9906a'),
(5, 'App\\Models\\User', '514d04e5-f79b-403a-95f4-2254784db0f0'),
(5, 'App\\Models\\User', '537f352e-a1e3-4daa-86b2-fc6b3366881c'),
(5, 'App\\Models\\User', '56f0bbe7-c52e-4d97-833f-17fba920421f'),
(5, 'App\\Models\\User', '755e0eaa-50e4-46db-9003-7c1fc6674876'),
(5, 'App\\Models\\User', '7d84490a-7661-415a-921c-141c05f38ded'),
(5, 'App\\Models\\User', '896ff4a7-ec81-4be5-ad12-ba4e3bb277de'),
(5, 'App\\Models\\User', '897f6253-86e1-4866-9072-e3e10bb51e5e'),
(5, 'App\\Models\\User', '950e18b7-9af4-468a-8468-edc338b7deec'),
(5, 'App\\Models\\User', '95294c43-b3d8-4b46-b938-e4eea1f3a359'),
(5, 'App\\Models\\User', 'a52ef0ee-6805-4b04-9f23-d6d6410829c5'),
(5, 'App\\Models\\User', 'b497082d-dd9f-4d1c-a611-9e1331eb5393'),
(5, 'App\\Models\\User', 'b55eb675-019c-4fa5-936e-579e2835527d'),
(5, 'App\\Models\\User', 'bace7196-8ce8-4253-baa7-04901e31592e'),
(5, 'App\\Models\\User', 'beaaf326-874c-48c2-b6b8-6bbe655c4df2'),
(5, 'App\\Models\\User', 'd405298f-5481-4038-8474-2ec0283b7608'),
(5, 'App\\Models\\User', 'dc25dea7-9969-46eb-b1ac-fd7f1b8dab77'),
(5, 'App\\Models\\User', 'dffd1060-8999-4d7b-8623-74caf47ab546'),
(5, 'App\\Models\\User', 'f7010485-3236-4341-a22a-48b70260a607'),
(5, 'App\\Models\\User', 'fab7c79d-a7dc-421f-b343-aaf81bdd20da');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('32e1f1c5-9072-4825-83cd-1018cb73d62f', 'App\\Notifications\\ProgramStatusChanged', 'App\\Models\\User', 'b5a9eb64-a547-4464-a576-e261ede0d4db', '{\"program_id\":null,\"judul_kegiatan\":null,\"old_status\":\"pending\",\"new_status\":\"hadir\",\"message\":\"Status program \'\' berubah dari \'pending\' menjadi \'hadir\'.\"}', '2026-06-17 19:03:03', '2026-06-17 19:02:26', '2026-06-17 19:03:03'),
('6f95fb80-2e8d-441d-850a-741dcdc7d1bc', 'App\\Notifications\\ProgramStatusChanged', 'App\\Models\\User', '70e15b9f-535a-42a2-8ea0-9a26ad7952e5', '{\"program_id\":null,\"judul_kegiatan\":null,\"old_status\":\"pending\",\"new_status\":\"hadir\",\"message\":\"Status program \'\' berubah dari \'pending\' menjadi \'hadir\'.\"}', '2026-09-02 06:50:51', '2026-05-24 21:21:26', '2026-09-02 06:50:51'),
('ac5b2d37-85ab-4267-b572-70b998039556', 'App\\Notifications\\ProgramStatusChanged', 'App\\Models\\User', 'dfd391fa-c167-4547-ad17-27d52d9ffc28', '{\"program_id\":null,\"judul_kegiatan\":null,\"old_status\":\"pending\",\"new_status\":\"hadir\",\"message\":\"Status program \'\' berubah dari \'pending\' menjadi \'hadir\'.\"}', '2026-05-24 21:51:12', '2026-05-24 21:48:19', '2026-05-24 21:51:12'),
('f071f5b7-d4aa-44ba-9449-cbd36724f7c8', 'App\\Notifications\\ProgramStatusChanged', 'App\\Models\\User', '70e15b9f-535a-42a2-8ea0-9a26ad7952e5', '{\"program_id\":null,\"judul_kegiatan\":null,\"old_status\":\"pending\",\"new_status\":\"hadir\",\"message\":\"Status program \'\' berubah dari \'pending\' menjadi \'hadir\'.\"}', '2026-05-25 20:36:48', '2026-05-24 21:41:40', '2026-05-25 20:36:48');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `uuid` char(36) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `type` enum('package','class') NOT NULL,
  `package_uuid` char(36) DEFAULT NULL,
  `class_schedule_uuid` char(36) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('pending','paid','failed','expired','cancelled') NOT NULL DEFAULT 'pending',
  `expired_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`uuid`, `name`, `slug`, `description`, `is_popular`, `is_active`, `created_at`, `updated_at`) VALUES
('01a06234-aac1-722c-84d6-c46d4150e70f', 'Studio Class Pack - 60 Minutes', 'studio-class-pack-60-minutes', 'Your perfect escape from the everyday. Step into the Yogaroots studio, move with intention, breathe deeply, and leave feeling refreshed.', 0, 'active', '2026-09-02 06:00:13', '2026-09-13 06:13:58'),
('01a095f2-d286-7241-b566-8027529b8196', 'First Timer Package', 'first-timer-package', 'A welcoming first step into your yoga journey at Yogaroots. Enjoy a guided studio session designed to help you feel comfortable, refreshed, and ready to move.', 1, 'active', '2026-09-12 14:08:33', '2026-09-13 06:13:24'),
('01a09615-73d8-7345-a20f-2d5eeb6b1d1a', 'Unlimited Package', 'unlimited-package', 'Practice freely with unlimited access to Yogaroots classes. Move at your own pace, explore different styles, and make yoga part of your everyday routine.', 0, 'active', '2026-09-12 14:46:23', '2026-09-12 14:46:23'),
('01a098c6-e509-7154-869f-8d336d44ebc4', 'Sharing Package', 'sharing-package', 'A flexible membership designed to be shared with someone special. Enjoy Yogaroots classes together and make your yoga journey a shared experience.', 0, 'active', '2026-09-13 03:19:26', '2026-09-13 06:13:12'),
('01a098cd-3db0-73e5-bbe6-ba63e290f1d0', 'Studio Class Pack - 90 Minutes', 'studio-class-pack-90-minutes', 'A deeper escape from the everyday. Step into the Yogaroots studio, move with intention, breathe deeply, and give yourself more time to reconnect, recharge, and leave feeling refreshed.', 0, 'active', '2026-09-13 03:26:22', '2026-09-13 03:26:22'),
('01a098d2-a02c-72ee-a8eb-b9dc6786761d', '1 On 1 Private Class', '1-on-1-private-class', 'A personalized yoga experience designed around you. Practice one-on-one with our instructor, receive focused guidance, and build a practice that supports your individual goals.', 0, 'active', '2026-09-13 03:32:15', '2026-09-13 03:32:15'),
('01a098e0-878e-7296-b1c0-a550bf0327b0', 'Couple\'s Private Class', 'couples-private-class', 'A private yoga experience to enjoy together. Practice side by side with personalized guidance from our instructor, deepen your connection, and make every session a meaningful shared experience.', 0, 'active', '2026-09-13 03:47:26', '2026-09-13 03:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `package_features`
--

CREATE TABLE `package_features` (
  `uuid` char(36) NOT NULL,
  `package_uuid` char(36) NOT NULL,
  `feature` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_features`
--

INSERT INTO `package_features` (`uuid`, `package_uuid`, `feature`, `sort_order`, `created_at`, `updated_at`) VALUES
('01a09615-73fb-702f-8c0a-b5012141236e', '01a09615-73d8-7345-a20f-2d5eeb6b1d1a', 'Unlimited Class Access', 0, '2026-09-12 14:46:23', '2026-09-12 14:46:23'),
('01a09615-7401-7073-add9-f090d187e2f8', '01a09615-73d8-7345-a20f-2d5eeb6b1d1a', 'Yoga Mat Provided', 1, '2026-09-12 14:46:23', '2026-09-12 14:46:23'),
('01a09615-7402-71bd-a8b8-9e5f3acd8ad7', '01a09615-73d8-7345-a20f-2d5eeb6b1d1a', 'Locker Access', 2, '2026-09-12 14:46:23', '2026-09-12 14:46:23'),
('01a09615-7402-71bd-a8b8-9e5f3ae8a3fb', '01a09615-73d8-7345-a20f-2d5eeb6b1d1a', 'Shower Facilities', 3, '2026-09-12 14:46:23', '2026-09-12 14:46:23'),
('01a09615-7409-70e7-9271-8596c85a0a7d', '01a09615-73d8-7345-a20f-2d5eeb6b1d1a', 'Access to All Studio Classes', 4, '2026-09-12 14:46:23', '2026-09-12 14:46:23'),
('01a098d3-1959-73c1-84e8-f2fd4240cbd4', '01a098cd-3db0-73e5-bbe6-ba63e290f1d0', 'Premium Yoga Mat', 0, '2026-09-13 03:32:46', '2026-09-13 03:32:46'),
('01a098d3-1960-70fd-90f6-1ceed0d1d517', '01a098cd-3db0-73e5-bbe6-ba63e290f1d0', 'Personal Locker', 1, '2026-09-13 03:32:46', '2026-09-13 03:32:46'),
('01a098d3-1961-7365-8471-3b94c5c1b0a2', '01a098cd-3db0-73e5-bbe6-ba63e290f1d0', 'Shower & Changing Room', 2, '2026-09-13 03:32:46', '2026-09-13 03:32:46'),
('01a098d3-1962-7322-a85e-eab4d6238c35', '01a098cd-3db0-73e5-bbe6-ba63e290f1d0', 'Complimentary Drinking Water', 3, '2026-09-13 03:32:46', '2026-09-13 03:32:46'),
('01a098d3-1962-7322-a85e-eab4d6948939', '01a098cd-3db0-73e5-bbe6-ba63e290f1d0', '90-Minute Yoga Session', 4, '2026-09-13 03:32:46', '2026-09-13 03:32:46'),
('01a098de-ec82-701f-bb24-c2dbbe0c59b9', '01a098d2-a02c-72ee-a8eb-b9dc6786761d', 'Private 1-on-1 Session', 0, '2026-09-13 03:45:41', '2026-09-13 03:45:41'),
('01a098de-ec83-7166-a29d-85d9cd8131b5', '01a098d2-a02c-72ee-a8eb-b9dc6786761d', 'Personalized Yoga Practice', 1, '2026-09-13 03:45:41', '2026-09-13 03:45:41'),
('01a098de-ec83-7166-a29d-85d9cdfbb9df', '01a098d2-a02c-72ee-a8eb-b9dc6786761d', 'Dedicated Instructor', 2, '2026-09-13 03:45:41', '2026-09-13 03:45:41'),
('01a098de-ec84-71fb-82be-6092568d7513', '01a098d2-a02c-72ee-a8eb-b9dc6786761d', 'Individual Guidance & Corrections', 3, '2026-09-13 03:45:41', '2026-09-13 03:45:41'),
('01a098de-ec86-70ea-a38d-1c994c52404a', '01a098d2-a02c-72ee-a8eb-b9dc6786761d', 'Practice Tailored to Your Goals', 4, '2026-09-13 03:45:41', '2026-09-13 03:45:41'),
('01a098de-ec87-70ea-ad3c-c41d16e6f542', '01a098d2-a02c-72ee-a8eb-b9dc6786761d', 'Flexible Session Focus', 5, '2026-09-13 03:45:41', '2026-09-13 03:45:41'),
('01a098e0-8799-703c-a314-911481118e4e', '01a098e0-878e-7296-b1c0-a550bf0327b0', 'Private Session for Two', 0, '2026-09-13 03:47:26', '2026-09-13 03:47:26'),
('01a098e0-879f-715a-8e83-0ae3ed067c6f', '01a098e0-878e-7296-b1c0-a550bf0327b0', 'Personalized Yoga Practice', 1, '2026-09-13 03:47:26', '2026-09-13 03:47:26'),
('01a098e0-87a0-705c-94e4-64e7348fd306', '01a098e0-878e-7296-b1c0-a550bf0327b0', 'Dedicated Instructor', 2, '2026-09-13 03:47:26', '2026-09-13 03:47:26'),
('01a098e0-87a1-7275-b6b4-5e5b4873a277', '01a098e0-878e-7296-b1c0-a550bf0327b0', 'Individual Guidance & Corrections', 3, '2026-09-13 03:47:26', '2026-09-13 03:47:26'),
('01a098e0-87a2-72dc-8631-635b1abff726', '01a098e0-878e-7296-b1c0-a550bf0327b0', 'Partner-Based Practice', 4, '2026-09-13 03:47:26', '2026-09-13 03:47:26'),
('01a098e0-87a3-72d4-b233-8ba8254b8bb6', '01a098e0-878e-7296-b1c0-a550bf0327b0', 'Practice Tailored to Your Goals', 5, '2026-09-13 03:47:26', '2026-09-13 03:47:26'),
('01a09965-fbf3-7255-bb66-859b3a4e1bff', '01a098c6-e509-7154-869f-8d336d44ebc4', 'Share Your Class Quota', 0, '2026-09-13 06:13:12', '2026-09-13 06:13:12'),
('01a09965-fbf9-7032-b9db-53e383f6b6c9', '01a098c6-e509-7154-869f-8d336d44ebc4', 'Flexible Class Access', 1, '2026-09-13 06:13:12', '2026-09-13 06:13:12'),
('01a09965-fbfa-72c8-9335-c298673b2bec', '01a098c6-e509-7154-869f-8d336d44ebc4', 'Locker Access', 2, '2026-09-13 06:13:12', '2026-09-13 06:13:12'),
('01a09965-fbfa-72c8-9335-c298680c415e', '01a098c6-e509-7154-869f-8d336d44ebc4', 'Shower Facilities', 3, '2026-09-13 06:13:12', '2026-09-13 06:13:12'),
('01a09965-fbfb-72aa-8e43-d33cdbde0650', '01a098c6-e509-7154-869f-8d336d44ebc4', 'Access to Studio Classes', 4, '2026-09-13 06:13:12', '2026-09-13 06:13:12'),
('01a09966-2967-7153-8bac-e05d58fabab9', '01a095f2-d286-7241-b566-8027529b8196', 'First Studio Session', 0, '2026-09-13 06:13:24', '2026-09-13 06:13:24'),
('01a09966-296d-7188-bf8c-90a9e73adf27', '01a095f2-d286-7241-b566-8027529b8196', 'Yoga Mat Provided', 1, '2026-09-13 06:13:24', '2026-09-13 06:13:24'),
('01a09966-296d-7188-bf8c-90a9e8268917', '01a095f2-d286-7241-b566-8027529b8196', 'Locker Access', 2, '2026-09-13 06:13:24', '2026-09-13 06:13:24'),
('01a09966-296e-71e6-a0f5-c78ca826aad2', '01a095f2-d286-7241-b566-8027529b8196', 'Shower Facilities', 3, '2026-09-13 06:13:24', '2026-09-13 06:13:24'),
('01a09966-296e-71e6-a0f5-c78ca89e5199', '01a095f2-d286-7241-b566-8027529b8196', 'Guidance from Our Instructor', 4, '2026-09-13 06:13:24', '2026-09-13 06:13:24'),
('01a09966-af91-7058-9ac6-0b9ce8883251', '01a06234-aac1-722c-84d6-c46d4150e70f', 'Premium Yoga Mat', 0, '2026-09-13 06:13:58', '2026-09-13 06:13:58'),
('01a09966-af97-7236-bf4d-703e3e28a1b5', '01a06234-aac1-722c-84d6-c46d4150e70f', 'Personal Locker', 1, '2026-09-13 06:13:58', '2026-09-13 06:13:58'),
('01a09966-af98-724e-8431-3f3e29806170', '01a06234-aac1-722c-84d6-c46d4150e70f', 'Shower & Changing Room', 2, '2026-09-13 06:13:58', '2026-09-13 06:13:58'),
('01a09966-af98-724e-8431-3f3e2996fecb', '01a06234-aac1-722c-84d6-c46d4150e70f', 'Complimentary Drinking Water', 3, '2026-09-13 06:13:58', '2026-09-13 06:13:58'),
('01a09966-af99-7238-b1f5-a35b1f405ff9', '01a06234-aac1-722c-84d6-c46d4150e70f', '60-Minute Yoga Session', 4, '2026-09-13 06:13:58', '2026-09-13 06:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `package_options`
--

CREATE TABLE `package_options` (
  `uuid` char(36) NOT NULL,
  `package_uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quota` int(10) UNSIGNED NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `discount_price` bigint(20) UNSIGNED DEFAULT NULL,
  `duration` int(10) UNSIGNED NOT NULL,
  `duration_unit` enum('day','week','month','year') NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_options`
--

INSERT INTO `package_options` (`uuid`, `package_uuid`, `name`, `quota`, `price`, `discount_price`, `duration`, `duration_unit`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
('01a09615-73f9-72ee-85e5-f2be4ef4c502', '01a09615-73d8-7345-a20f-2d5eeb6b1d1a', 'All Classes', 50, 3000000, 2400000, 1, 'month', 0, 1, '2026-09-12 14:46:23', '2026-09-12 14:46:23'),
('01a098d3-1951-7151-a2fb-64955a2f9d09', '01a098cd-3db0-73e5-bbe6-ba63e290f1d0', 'Single drop in', 50, 280000, NULL, 1, 'day', 0, 1, '2026-09-13 03:32:46', '2026-09-13 03:32:46'),
('01a098d3-1955-72ab-8da5-5f9e03ae8831', '01a098cd-3db0-73e5-bbe6-ba63e290f1d0', '3 Classes', 50, 795000, NULL, 10, 'day', 1, 1, '2026-09-13 03:32:46', '2026-09-13 03:32:46'),
('01a098d3-1956-713d-af97-f5237ace5eb4', '01a098cd-3db0-73e5-bbe6-ba63e290f1d0', '5 Classes', 50, 1250000, NULL, 20, 'day', 2, 1, '2026-09-13 03:32:46', '2026-09-13 03:32:46'),
('01a098d3-1957-7323-b837-fbbb3e2ed42b', '01a098cd-3db0-73e5-bbe6-ba63e290f1d0', '10 Classes', 50, 2350000, NULL, 2, 'month', 3, 1, '2026-09-13 03:32:46', '2026-09-13 03:32:46'),
('01a098de-ec50-73bf-b928-c37f31d37568', '01a098d2-a02c-72ee-a8eb-b9dc6786761d', 'Single drop in', 1, 1000000, NULL, 1, 'week', 0, 1, '2026-09-13 03:45:41', '2026-09-13 03:45:41'),
('01a098de-ec7d-7352-9076-67a2defe3fde', '01a098d2-a02c-72ee-a8eb-b9dc6786761d', '5 Private Classes', 1, 4500000, NULL, 5, 'week', 1, 1, '2026-09-13 03:45:41', '2026-09-13 03:45:41'),
('01a098de-ec7f-7275-a7f8-be27d7caa4ff', '01a098d2-a02c-72ee-a8eb-b9dc6786761d', '10 Private Classes', 1, 8100000, NULL, 10, 'week', 2, 1, '2026-09-13 03:45:41', '2026-09-13 03:45:41'),
('01a098e0-8795-71b4-84a4-de9c8a0b517e', '01a098e0-878e-7296-b1c0-a550bf0327b0', 'Single drop in', 2, 1200000, NULL, 1, 'week', 0, 1, '2026-09-13 03:47:26', '2026-09-13 03:47:26'),
('01a098e0-8797-7309-954d-6caac6a8f4ee', '01a098e0-878e-7296-b1c0-a550bf0327b0', '5 Private Classes', 2, 5400000, NULL, 5, 'week', 1, 1, '2026-09-13 03:47:26', '2026-09-13 03:47:26'),
('01a098e0-8798-707b-b260-c1379231361e', '01a098e0-878e-7296-b1c0-a550bf0327b0', '10 Private Classes', 2, 9720000, NULL, 10, 'week', 2, 1, '2026-09-13 03:47:26', '2026-09-13 03:47:26'),
('01a09965-fbf0-7307-ba83-dfa1382cf270', '01a098c6-e509-7154-869f-8d336d44ebc4', '25 Classes', 50, 6999000, 5599000, 1, 'month', 0, 1, '2026-09-13 06:13:12', '2026-09-13 06:13:12'),
('01a09966-2965-7201-ab57-9f085e23bbc7', '01a095f2-d286-7241-b566-8027529b8196', 'First Class Experience', 50, 210000, NULL, 1, 'week', 0, 1, '2026-09-13 06:13:24', '2026-09-13 06:13:24'),
('01a09966-af8d-7252-bbf0-f1665358611d', '01a06234-aac1-722c-84d6-c46d4150e70f', 'Single drop in', 50, 230000, NULL, 1, 'day', 0, 1, '2026-09-13 06:13:58', '2026-09-13 06:13:58'),
('01a09966-af8e-7055-b1a5-460286a5403f', '01a06234-aac1-722c-84d6-c46d4150e70f', '3 Classes', 50, 599000, NULL, 10, 'day', 1, 1, '2026-09-13 06:13:58', '2026-09-13 06:13:58'),
('01a09966-af8f-73fd-94d6-680b288dd1ba', '01a06234-aac1-722c-84d6-c46d4150e70f', '5 Classes', 50, 878000, NULL, 20, 'day', 2, 1, '2026-09-13 06:13:58', '2026-09-13 06:13:58'),
('01a09966-af8f-73fd-94d6-680b28b8b248', '01a06234-aac1-722c-84d6-c46d4150e70f', '10 Classes', 50, 1555000, NULL, 2, 'month', 3, 1, '2026-09-13 06:13:58', '2026-09-13 06:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `uuid` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `user_uuid` char(36) DEFAULT NULL,
  `has_sidebar` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`uuid`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `is_published`, `published_at`, `user_uuid`, `has_sidebar`, `created_at`, `updated_at`) VALUES
('5380a3e5-adfa-437c-a0fa-bc2193d55cb2', 'Privacy Policy', 'privacy-policy', 'By accessing and using the YogaRoots website and services, you acknowledge that you have read, understood, and agreed to this Privacy Policy.', '<h2><strong style=\"color: rgb(71, 85, 105); font-size: 16px; letter-spacing: 0.1px;\">Last Updated:</strong><span style=\"color: rgb(71, 85, 105); font-size: 16px; font-weight: 400; letter-spacing: 0.1px;\"> August 30, 2026</span></h2>\r\n\r\n<p>\r\n  Welcome to <strong>YogaRoots</strong>.\r\n</p>\r\n\r\n<p>\r\n  We value your trust and are committed to protecting the privacy and security of your personal information. This Privacy Policy explains how YogaRoots collects, uses, stores, and protects your information when you visit our website, register for an account, contact us, or use our services.\r\n</p>\r\n\r\n<p>\r\n  By accessing and using the YogaRoots website and services, you acknowledge that you have read, understood, and agreed to this Privacy Policy.\r\n</p>\r\n\r\n<h3>1. Information We Collect</h3>\r\n\r\n<p>\r\n  We may collect information that you voluntarily provide when using the YogaRoots website or services, including:\r\n</p>\r\n\r\n<ul>\r\n  <li>Full name</li>\r\n  <li>Email address</li>\r\n  <li>Phone number</li>\r\n  <li>Information submitted through contact forms</li>\r\n  <li>Class registration or booking information</li>\r\n  <li>Account information if you use our login features</li>\r\n  <li>Other information you voluntarily provide to us</li>\r\n</ul>\r\n\r\n<p>\r\n  We may also automatically collect certain technical information when you access our website, such as your device type, browser type, IP address, and information about your interactions with and use of the website.\r\n</p>\r\n\r\n<h3>2. How We Use Your Information</h3>\r\n\r\n<p>\r\n  The information we collect may be used to:\r\n</p>\r\n\r\n<ul>\r\n  <li>Process class registrations and bookings</li>\r\n  <li>Manage your account and membership</li>\r\n  <li>Respond to your questions, requests, or inquiries</li>\r\n  <li>Provide information about YogaRoots classes, schedules, programs, and services</li>\r\n  <li>Send important information related to the services you use</li>\r\n  <li>Improve our website, services, and overall user experience</li>\r\n  <li>Maintain website security and prevent misuse or unauthorized activity</li>\r\n  <li>Comply with applicable legal and regulatory requirements</li>\r\n</ul>\r\n\r\n<p>\r\n  We strive to use your personal information only for purposes that are relevant and necessary to provide and improve YogaRoots services.\r\n</p>\r\n\r\n<h3>3. Protection of Your Information</h3>\r\n\r\n<p>\r\n  YogaRoots takes reasonable administrative, technical, and organizational measures to protect your personal information from unauthorized access, use, alteration, disclosure, or loss.\r\n</p>\r\n\r\n<p>\r\n  However, no storage system or transmission of information over the internet can be guaranteed to be completely secure. Therefore, while we make reasonable efforts to protect your information, we cannot guarantee absolute security.\r\n</p>\r\n\r\n<h3>4. Third-Party Services</h3>\r\n\r\n<p>\r\n  To operate and improve our services, YogaRoots may work with trusted third-party service providers, including technology providers, payment processors, authentication services, analytics providers, communication platforms, and other service partners.\r\n</p>\r\n\r\n<p>\r\n  Information may be shared with these third parties only to the extent reasonably necessary to provide, maintain, or improve the relevant services.\r\n</p>\r\n\r\n<p>\r\n  Third-party providers may have their own privacy policies and terms of use. We encourage you to review the privacy policies of any third-party services you choose to use.\r\n</p>\r\n\r\n<h3>5. Cookies</h3>\r\n\r\n<p>\r\n  The YogaRoots website may use cookies and similar technologies to help the website function properly, remember your preferences, understand how visitors use our website, and improve your overall experience.\r\n</p>\r\n\r\n<p>\r\n  You can manage or disable cookies through your browser settings. Please note that disabling certain cookies may affect the functionality or availability of some features on our website.\r\n</p>\r\n\r\n<h3>6. Information You Provide to Us</h3>\r\n\r\n<p>\r\n  When you contact YogaRoots through our contact forms, email, WhatsApp, or other communication channels, the information you provide may be used to respond to your inquiry and provide the assistance or information you need.\r\n</p>\r\n\r\n<p>\r\n  We do not sell or rent your personal information to third parties.\r\n</p>\r\n\r\n<h3>7. Data Retention</h3>\r\n\r\n<p>\r\n  We may retain your personal information for as long as necessary to provide our services, fulfill the purposes for which the information was collected, complete transactions, comply with legal obligations, or address legitimate administrative and operational needs.\r\n</p>\r\n\r\n<p>\r\n  When your information is no longer required, we may delete or anonymize it in accordance with our internal policies and applicable laws and regulations.\r\n</p>\r\n\r\n<h3>8. Your Rights</h3>\r\n\r\n<p>\r\n  You may contact YogaRoots if you wish to:\r\n</p>\r\n\r\n<ul>\r\n  <li>Update your personal information</li>\r\n  <li>Correct inaccurate or incomplete information</li>\r\n  <li>Ask about the personal information we hold about you</li>\r\n  <li>Request the deletion of certain information, where permitted and where such deletion does not conflict with applicable legal or service requirements</li>\r\n  <li>Ask how your personal information is collected, used, or processed</li>\r\n</ul>\r\n\r\n<p>\r\n  We will review and respond to requests in accordance with applicable laws, our policies, and the circumstances of each request.\r\n</p>\r\n\r\n<h3>9. Children\'s Privacy</h3>\r\n\r\n<p>\r\n  YogaRoots respects the privacy of children and does not knowingly intend to collect personal information from children without appropriate involvement or consent from a parent or legal guardian.\r\n</p>\r\n\r\n<p>\r\n  If you believe that a child has provided personal information to us without appropriate consent, please contact us so that we can review the matter and take appropriate action.\r\n</p>\r\n\r\n<h3>10. Changes to This Privacy Policy</h3>\r\n\r\n<p>\r\n  YogaRoots may update this Privacy Policy from time to time to reflect changes in our services, technology, business practices, or applicable laws and regulations.\r\n</p>\r\n\r\n<p>\r\n  Any changes will be published on this page, and the \"Last Updated\" date will be revised accordingly.\r\n</p>\r\n\r\n<p>\r\n  We encourage you to review this page periodically to stay informed about how we collect, use, and protect your personal information.\r\n</p>\r\n\r\n<h3>11. Contact Us</h3>\r\n\r\n<p>\r\n  If you have any questions about this Privacy Policy or how YogaRoots handles your personal information, please contact us through the following channels:\r\n</p>\r\n\r\n<p>\r\n  <strong>YogaRoots</strong>\r\n</p>\r\n\r\n<p>\r\n  <strong>Email:</strong>&nbsp;\r\n</p>\r\n\r\n<p>\r\n  <strong>Phone / WhatsApp:</strong> +62 813 2122 1270\r\n</p>\r\n\r\n<p>\r\n  <strong>Address:</strong> Roots Prasasta Building, Jl. Kawi Raya No.37, RT.6/RW.2, Guntur, Setiabudi, South Jakarta City, Jakarta 12980\r\n</p>\r\n\r\n<p>\r\n  We will do our best to assist you and provide the information you need regarding your privacy and the handling of your personal information.\r\n</p>', 'pages/KGpKHJFc1aFrX0OocaW7I9uDWxmWiRAc9XA3gCzQ.png', 1, '2026-08-30 17:00:00', NULL, 0, '2025-10-16 04:07:16', '2026-09-06 21:25:55'),
('9e55815c-a4dd-4df2-8cb5-27f7de7249fd', 'Terms & Conditions', 'terms-conditions', 'By accessing or using the YogaRoots website and services, you acknowledge that you have read, understood, and agreed to these Terms & Conditions.', '`<strong style=\"letter-spacing: 0.1px;\">Last Updated:</strong><span style=\"letter-spacing: 0.1px;\"> August 30, 2026</span><p>\r\n  Welcome to <strong>YogaRoots</strong>.\r\n</p>\r\n\r\n<p>\r\n  These Terms &amp; Conditions explain the rules and guidelines for using the YogaRoots website, purchasing memberships, booking classes, making payments, and using our services.\r\n</p>\r\n\r\n<p>\r\n  By accessing or using the YogaRoots website and services, you acknowledge that you have read, understood, and agreed to these Terms &amp; Conditions.\r\n</p>\r\n\r\n<h3>1. Website Use</h3>\r\n\r\n<p>\r\n  You agree to use the YogaRoots website responsibly and only for lawful purposes.\r\n</p>\r\n\r\n<p>\r\n  You must not use the website to:\r\n</p>\r\n\r\n<ul>\r\n  <li>Provide false, misleading, or inaccurate information</li>\r\n  <li>Attempt to gain unauthorized access to accounts or systems</li>\r\n  <li>Interfere with or disrupt the operation of the website</li>\r\n  <li>Use the website for fraudulent, abusive, or unlawful activities</li>\r\n  <li>Copy, reproduce, or misuse YogaRoots content without permission</li>\r\n</ul>\r\n\r\n<p>\r\n  YogaRoots reserves the right to restrict or suspend access to the website or services if we reasonably believe that these Terms &amp; Conditions have been violated.\r\n</p>\r\n\r\n<h3>2. Account Registration</h3>\r\n\r\n<p>\r\n  Certain YogaRoots services may require you to create an account.\r\n</p>\r\n\r\n<p>\r\n  When creating an account, you agree to provide accurate and up-to-date information and to keep your account information secure.\r\n</p>\r\n\r\n<ul>\r\n  <li>You are responsible for maintaining the confidentiality of your login credentials.</li>\r\n  <li>You are responsible for activities performed through your account.</li>\r\n  <li>You must notify YogaRoots if you believe your account has been accessed without authorization.</li>\r\n  <li>You must not create an account using another person\'s identity or information without permission.</li>\r\n</ul>\r\n\r\n<h3>3. Membership</h3>\r\n\r\n<p>\r\n  YogaRoots offers different membership packages and options designed to suit different practice needs.\r\n</p>\r\n\r\n<p>\r\n  Each membership option may have different pricing, class quota, duration, benefits, and conditions.\r\n</p>\r\n\r\n<ul>\r\n  <li>Memberships are personal and may only be used by the registered member.</li>\r\n  <li>Memberships cannot be transferred, resold, or shared with another person.</li>\r\n  <li>A membership becomes active after the payment has been successfully completed and confirmed.</li>\r\n  <li>Membership validity follows the duration stated in the selected membership option.</li>\r\n  <li>Unused class quota may expire when the membership period ends.</li>\r\n  <li>Unlimited memberships may provide unlimited class access during the applicable membership period, subject to class availability and booking requirements.</li>\r\n</ul>\r\n\r\n<p>\r\n  YogaRoots reserves the right to update membership packages, pricing, benefits, availability, or terms from time to time.\r\n</p>\r\n\r\n<h3>4. Membership Options</h3>\r\n\r\n<p>\r\n  A membership package may contain one or more membership options. Each option may have its own price, duration, and class quota.\r\n</p>\r\n\r\n<p>\r\n  When purchasing a membership, you are responsible for reviewing the selected option before completing your payment.\r\n</p>\r\n\r\n<p>\r\n  The membership option selected at checkout determines the applicable price, duration, quota, and benefits associated with your membership.\r\n</p>\r\n\r\n<h3>5. Class Booking</h3>\r\n\r\n<p>\r\n  Class availability is limited and subject to the capacity of each scheduled class.\r\n</p>\r\n\r\n<p>\r\n  Members must complete the booking process through the available YogaRoots booking system before attending a class.\r\n</p>\r\n\r\n<ul>\r\n  <li>A booking is considered confirmed once the booking process has been successfully completed.</li>\r\n  <li>Class availability may change at any time based on capacity.</li>\r\n  <li>Members are encouraged to arrive at least 10 minutes before the scheduled class.</li>\r\n  <li>Late arrival may result in the member being unable to join the class if entering the studio may disturb the ongoing practice.</li>\r\n  <li>Members must follow the instructions provided by the instructor and YogaRoots staff.</li>\r\n</ul>\r\n\r\n<h3>6. Class Cancellation &amp; No-Show</h3>\r\n\r\n<p>\r\n  We understand that plans can change. However, we ask members to cancel their bookings as early as possible so that another member may have the opportunity to attend.\r\n</p>\r\n\r\n<ul>\r\n  <li>Class cancellations must be made through the available YogaRoots booking system.</li>\r\n  <li>Late cancellations may result in the applicable class quota being deducted.</li>\r\n  <li>No-shows may result in the applicable class quota being deducted.</li>\r\n  <li>Repeated cancellations or no-shows may affect future booking privileges.</li>\r\n</ul>\r\n\r\n<p>\r\n  Specific cancellation periods or policies may apply to certain classes, workshops, events, or special programs.\r\n</p>\r\n\r\n<h3>7. Payments</h3>\r\n\r\n<p>\r\n  All prices displayed on the YogaRoots website are stated in Indonesian Rupiah (IDR), unless otherwise specified.\r\n</p>\r\n\r\n<ul>\r\n  <li>A membership or service is considered purchased only after payment has been successfully completed.</li>\r\n  <li>Prices, discounts, and promotional offers may change from time to time.</li>\r\n  <li>Promotional prices may only be available for a specific period or under specific conditions.</li>\r\n  <li>The final amount payable will be displayed during the checkout process before payment is completed.</li>\r\n  <li>Payment transactions may be processed through third-party payment providers.</li>\r\n</ul>\r\n\r\n<p>\r\n  By proceeding with a payment, you agree to the applicable payment terms and conditions provided by YogaRoots and the relevant payment provider.\r\n</p>\r\n\r\n<h3>8. Refunds &amp; Cancellations</h3>\r\n\r\n<p>\r\n  Refund eligibility may depend on the type of purchase, payment status, membership status, booking status, and applicable YogaRoots policies.\r\n</p>\r\n\r\n<p>\r\n  Membership purchases and completed payments may not be refundable unless otherwise stated or required under applicable laws and regulations.\r\n</p>\r\n\r\n<p>\r\n  If you believe that a payment was made incorrectly or you experience a payment-related issue, please contact YogaRoots as soon as possible so that we can review the transaction.\r\n</p>\r\n\r\n<h3>9. Studio Rules</h3>\r\n\r\n<p>\r\n  YogaRoots is a shared space where everyone should feel comfortable, safe, and respected.\r\n</p>\r\n\r\n<p>\r\n  Members are expected to:\r\n</p>\r\n\r\n<ul>\r\n  <li>Respect instructors, staff, and fellow members.</li>\r\n  <li>Keep phones on silent during classes.</li>\r\n  <li>Maintain cleanliness and cleanliness of shared studio areas.</li>\r\n  <li>Return studio equipment after use.</li>\r\n  <li>Follow instructor and staff instructions.</li>\r\n  <li>Avoid behavior that may disturb or make other members uncomfortable.</li>\r\n  <li>Take reasonable care of YogaRoots facilities and equipment.</li>\r\n</ul>\r\n\r\n<p>\r\n  YogaRoots may take reasonable action if a member\'s behavior negatively affects the safety, comfort, or experience of other members.\r\n</p>\r\n\r\n<h3>10. Health &amp; Safety</h3>\r\n\r\n<p>\r\n  Yoga is a physical activity and may involve physical risks. Every member is responsible for practicing according to their own physical ability and condition.\r\n</p>\r\n\r\n<ul>\r\n  <li>Members should inform the instructor about relevant physical limitations, injuries, or conditions before participating.</li>\r\n  <li>Members should not force movements beyond their comfortable limits.</li>\r\n  <li>If you experience pain, dizziness, discomfort, or other concerning symptoms, stop practicing and inform the instructor immediately.</li>\r\n  <li>Members are responsible for determining whether they are physically able to participate in a class.</li>\r\n</ul>\r\n\r\n<p>\r\n  YogaRoots and its instructors are not a substitute for professional medical advice, diagnosis, or treatment.\r\n</p>\r\n\r\n<p>\r\n  If you have concerns about whether yoga or a particular class is suitable for you, we recommend consulting a qualified healthcare professional before participating.\r\n</p>\r\n\r\n<h3>11. Personal Belongings</h3>\r\n\r\n<p>\r\n  Members are responsible for their personal belongings while visiting YogaRoots.\r\n</p>\r\n\r\n<p>\r\n  We recommend keeping valuable items secure and bringing only essential belongings into the studio.\r\n</p>\r\n\r\n<p>\r\n  YogaRoots is not responsible for loss, theft, or damage to personal belongings except where responsibility cannot legally be excluded.\r\n</p>\r\n\r\n<h3>12. Class Schedules &amp; Instructors</h3>\r\n\r\n<p>\r\n  YogaRoots makes reasonable efforts to maintain the published class schedule. However, schedules and instructors may occasionally change due to operational requirements, instructor availability, maintenance, special events, or other circumstances.\r\n</p>\r\n\r\n<p>\r\n  YogaRoots reserves the right to modify, reschedule, replace, or cancel a class when necessary.\r\n</p>\r\n\r\n<p>\r\n  Where reasonably possible, YogaRoots will provide notice of significant schedule changes to affected members.\r\n</p>\r\n\r\n<h3>13. Promotions &amp; Special Offers</h3>\r\n\r\n<p>\r\n  YogaRoots may offer promotional packages, discounts, introductory offers, events, workshops, or other special programs from time to time.\r\n</p>\r\n\r\n<p>\r\n  Each promotion may have its own eligibility requirements, validity period, pricing, limitations, and terms.\r\n</p>\r\n\r\n<ul>\r\n  <li>Promotions may only be available for a limited period.</li>\r\n  <li>Promotions may not be combined with other offers unless explicitly stated.</li>\r\n  <li>Promotional benefits cannot be exchanged for cash unless otherwise stated.</li>\r\n  <li>YogaRoots may modify or discontinue a promotion in accordance with its applicable terms.</li>\r\n</ul>\r\n\r\n<h3>14. Intellectual Property</h3>\r\n\r\n<p>\r\n  All content available on the YogaRoots website, including logos, photographs, graphics, illustrations, text, videos, designs, and other materials, is owned by or licensed to YogaRoots unless otherwise stated.\r\n</p>\r\n\r\n<p>\r\n  You may access and use the content for personal, non-commercial purposes only.\r\n</p>\r\n\r\n<p>\r\n  You may not reproduce, distribute, modify, publish, sell, or commercially use YogaRoots content without prior written permission.\r\n</p>\r\n\r\n<h3>15. Third-Party Services</h3>\r\n\r\n<p>\r\n  YogaRoots may use or provide access to third-party services, including payment providers, communication platforms, analytics services, authentication services, and other technology providers.\r\n</p>\r\n\r\n<p>\r\n  Your use of third-party services may be subject to the terms and policies of the relevant third-party provider.\r\n</p>\r\n\r\n<p>\r\n  YogaRoots is not responsible for the policies, availability, or practices of third-party services that are outside our control.\r\n</p>\r\n\r\n<h3>16. Website Availability</h3>\r\n\r\n<p>\r\n  YogaRoots aims to keep the website and services available and functioning properly. However, we cannot guarantee that the website will always be available, uninterrupted, or free from errors.\r\n</p>\r\n\r\n<p>\r\n  Website availability may occasionally be affected by maintenance, technical issues, network problems, security incidents, or circumstances beyond our reasonable control.\r\n</p>\r\n\r\n<h3>17. Limitation of Responsibility</h3>\r\n\r\n<p>\r\n  YogaRoots strives to provide a safe, comfortable, and high-quality experience for all members.\r\n</p>\r\n\r\n<p>\r\n  However, participation in yoga and physical activities involves inherent risks. Members are responsible for practicing within their own capabilities and following reasonable instructions provided by instructors and staff.\r\n</p>\r\n\r\n<p>\r\n  Nothing in these Terms &amp; Conditions is intended to exclude or limit any rights, responsibilities, or liabilities that cannot legally be excluded or limited under applicable laws and regulations.\r\n</p>\r\n\r\n<h3>18. Changes to These Terms</h3>\r\n\r\n<p>\r\n  YogaRoots may update these Terms &amp; Conditions from time to time to reflect changes in our services, business practices, technology, or applicable laws and regulations.\r\n</p>\r\n\r\n<p>\r\n  Any changes will be published on this page, and the \"Last Updated\" date will be revised accordingly.\r\n</p>\r\n\r\n<p>\r\n  We encourage you to review this page periodically to stay informed about the terms that apply to your use of YogaRoots services.\r\n</p>\r\n\r\n<h3>19. Contact Us</h3>\r\n\r\n<p>\r\n  If you have any questions about these Terms &amp; Conditions, membership, class bookings, payments, or other YogaRoots services, please contact us through the following channels:\r\n</p>\r\n\r\n<p>\r\n  <strong>YogaRoots</strong>\r\n</p>\r\n\r\n<p>\r\n  <strong>Email:</strong>&nbsp;\r\n</p>\r\n\r\n<p>\r\n  <strong>Phone / WhatsApp:</strong> +62 813 2122 1270\r\n</p>\r\n\r\n<p>\r\n  <strong>Address:</strong> Roots Prasasta Building, Jl. Kawi Raya No.37, RT.6/RW.2, Guntur, Setiabudi, South Jakarta City, Jakarta 12980\r\n</p>\r\n\r\n<p>\r\n  We will do our best to assist you and provide the information you need regarding our services, memberships, bookings, and these Terms &amp; Conditions.\r\n</p>', 'pages/UYCMzdX1OfuyrVRPYwicwNu1JZnHYBZhRSUjL4ki.jpg', 1, '2026-09-12 17:00:00', '787b72ea-59d0-4d54-848b-c200bddafdd2', 0, '2026-09-13 03:01:40', '2026-09-13 03:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `uuid` char(36) NOT NULL,
  `order_uuid` char(36) NOT NULL,
  `payment_gateway` varchar(255) NOT NULL DEFAULT 'midtrans',
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `gross_amount` decimal(15,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `raw_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`raw_response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'menu.main-menu', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(2, 'menu.role-permission', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(3, 'menu.access-management', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(4, 'dashboard.index', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(5, 'user.index', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(6, 'user.store', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(7, 'user.update', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(8, 'user.destroy', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(9, 'menu-group.index', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(10, 'menu-group.store', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(11, 'menu-group.update', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(12, 'menu-group.destroy', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(13, 'menu-item.index', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(14, 'menu-item.store', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(15, 'menu-item.update', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(16, 'menu-item.destroy', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(17, 'route.index', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(18, 'route.store', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(19, 'route.update', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(20, 'route.destroy', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(21, 'role.index', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(22, 'role.store', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(23, 'role.update', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(24, 'role.destroy', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(25, 'permission.index', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(26, 'permission.store', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(27, 'permission.update', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(28, 'permission.destroy', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(29, 'faq.destroy', 'web', '2024-09-27 00:07:55', '2025-09-16 01:45:11'),
(30, 'faq.index', 'web', '2024-09-27 00:08:52', '2025-09-16 01:45:00'),
(31, 'faq.store', 'web', '2024-09-27 00:09:11', '2025-09-16 01:45:36'),
(32, 'faq.update', 'web', '2024-09-27 00:09:36', '2025-09-16 01:45:20'),
(33, 'menu.main-portofolio', 'web', '2024-09-27 00:11:21', '2024-09-27 00:11:21'),
(35, 'company.index', 'web', '2024-09-27 01:42:51', '2024-09-27 01:52:59'),
(36, 'company.store', 'web', '2024-09-27 01:43:04', '2024-09-27 01:53:19'),
(37, 'company.update', 'web', '2024-09-27 01:43:16', '2024-09-27 01:53:10'),
(38, 'categories.destroy', 'web', '2024-09-29 12:28:15', '2024-10-15 13:50:56'),
(39, 'categories.index', 'web', '2024-09-29 12:28:26', '2024-10-15 13:51:03'),
(40, 'categories.store', 'web', '2024-09-29 12:28:42', '2024-10-15 13:51:13'),
(41, 'categories.update', 'web', '2024-09-29 12:28:54', '2024-10-15 13:51:20'),
(46, 'banner.destroy', 'web', '2024-09-30 12:05:12', '2024-10-13 22:29:29'),
(47, 'banner.index', 'web', '2024-09-30 12:05:28', '2024-10-13 22:29:37'),
(48, 'banner.store', 'web', '2024-09-30 12:05:41', '2024-10-13 22:29:45'),
(49, 'banner.update', 'web', '2024-09-30 12:05:59', '2024-10-13 22:29:53'),
(50, 'articles.destroy', 'web', '2024-10-15 14:19:19', '2024-10-15 14:19:19'),
(51, 'articles.create', 'web', '2024-10-15 14:19:37', '2024-10-15 14:20:03'),
(52, 'articles.index', 'web', '2024-10-15 14:20:16', '2024-10-15 14:20:16'),
(53, 'articles.store', 'web', '2024-10-15 14:20:34', '2024-10-15 14:20:34'),
(54, 'articles.update', 'web', '2024-10-15 14:20:52', '2024-10-15 14:20:52'),
(55, 'dashboard.form', 'web', '2025-07-21 15:03:35', '2025-07-21 16:36:22'),
(60, 'poll.destroy', 'web', '2025-07-21 17:50:21', '2025-09-17 22:51:57'),
(65, 'poll.index', 'web', '2025-07-21 17:50:33', '2025-09-17 22:52:13'),
(70, 'poll.store', 'web', '2025-07-21 17:50:49', '2025-09-17 22:52:25'),
(75, 'poll.update', 'web', '2025-07-21 17:51:14', '2025-09-17 22:52:37'),
(85, 'account.index', 'web', '2025-07-22 23:35:48', '2025-07-22 23:35:48'),
(90, 'account.update', 'web', '2025-07-22 23:36:13', '2025-07-22 23:36:13'),
(100, 'program.destroy', 'web', '2025-07-23 22:07:49', '2025-07-23 22:07:49'),
(105, 'program.create', 'web', '2025-07-23 22:08:13', '2025-07-23 22:08:13'),
(110, 'program.index', 'web', '2025-07-23 22:08:39', '2025-07-23 22:08:39'),
(115, 'program.store', 'web', '2025-07-23 22:09:41', '2025-07-23 22:09:41'),
(120, 'program.update', 'web', '2025-07-23 22:11:45', '2025-07-23 22:11:45'),
(125, 'filedownload.destroy', 'web', '2025-07-25 16:48:18', '2025-07-25 16:48:18'),
(130, 'filedownload.index', 'web', '2025-07-25 16:48:48', '2025-07-25 16:48:48'),
(135, 'filedownload.store', 'web', '2025-07-25 16:49:09', '2025-07-25 16:49:09'),
(140, 'filedownload.update', 'web', '2025-07-25 16:49:23', '2025-07-25 16:49:23'),
(145, 'layanan.kontak', 'web', '2025-07-27 23:46:01', '2025-07-27 23:46:01'),
(146, 'instruktur.index', 'web', '2025-09-14 12:04:29', '2026-09-01 14:30:03'),
(147, 'pages.create', 'web', '2025-09-17 23:27:58', '2025-09-17 23:27:58'),
(148, 'pages.destroy', 'web', '2025-09-17 23:28:08', '2025-09-17 23:28:08'),
(149, 'pages.index', 'web', '2025-09-17 23:28:19', '2025-09-17 23:28:19'),
(150, 'pages.store', 'web', '2025-09-17 23:28:28', '2025-09-17 23:28:28'),
(151, 'pages.update', 'web', '2025-09-17 23:28:36', '2025-09-17 23:28:36'),
(152, 'instruktur.destroy', 'web', '2025-09-18 01:25:31', '2026-09-01 14:29:43'),
(153, 'instruktur.store', 'web', '2025-09-18 01:25:43', '2026-09-01 14:30:14'),
(154, 'instruktur.update', 'web', '2025-09-18 01:29:03', '2026-09-01 14:30:28'),
(155, 'testimonial.destroy', 'web', '2025-09-21 21:43:09', '2025-09-21 21:43:09'),
(156, 'testimonial.index', 'web', '2025-09-21 21:43:15', '2025-09-21 21:43:15'),
(157, 'testimonial.update', 'web', '2025-09-21 21:43:32', '2025-09-21 21:43:32'),
(158, 'testimonial.store', 'web', '2025-09-21 21:43:59', '2025-09-21 21:43:59'),
(159, 'events.index', 'web', '2025-10-20 08:44:13', '2026-08-30 19:30:03'),
(160, 'events.destroy', 'web', '2025-10-20 08:46:31', '2026-08-30 19:29:50'),
(161, 'events.store', 'web', '2025-10-20 08:47:29', '2026-08-30 19:30:13'),
(162, 'events.update', 'web', '2025-10-20 08:48:18', '2026-08-30 19:30:24'),
(163, 'specializations.index', 'web', '2025-11-11 03:38:59', '2026-08-27 17:28:55'),
(164, 'specializations.destroy', 'web', '2025-11-11 03:39:23', '2026-08-27 17:28:42'),
(165, 'specializations.update', 'web', '2025-11-11 03:39:36', '2026-08-27 17:29:13'),
(166, 'specializations.store', 'web', '2025-11-11 03:39:47', '2026-08-27 17:29:05'),
(167, 'package.destroy', 'web', '2026-09-02 04:53:13', '2026-09-02 04:54:21'),
(168, 'package.index', 'web', '2026-09-02 04:53:33', '2026-09-02 04:53:33'),
(169, 'package.update', 'web', '2026-09-02 04:53:48', '2026-09-02 04:53:48'),
(170, 'package.store', 'web', '2026-09-02 04:55:05', '2026-09-02 04:55:05'),
(171, 'package.member', 'web', '2026-09-02 05:46:57', '2026-09-02 05:46:57'),
(172, 'classes.destroy', 'web', '2026-09-02 14:45:03', '2026-09-02 14:45:03'),
(173, 'classes.index', 'web', '2026-09-02 14:45:18', '2026-09-02 14:45:18'),
(174, 'classes.store', 'web', '2026-09-02 14:45:44', '2026-09-02 14:45:44'),
(175, 'classes.update', 'web', '2026-09-02 14:45:59', '2026-09-02 14:45:59'),
(176, 'dashboard.submitSumber', 'web', '2026-09-04 07:15:06', '2026-09-04 07:15:06'),
(177, 'classes.create', 'web', '2026-09-05 23:52:57', '2026-09-05 23:52:57'),
(178, 'classes.edit', 'web', '2026-09-05 23:53:12', '2026-09-05 23:53:12'),
(179, 'classes.change-level', 'web', '2026-09-06 00:43:33', '2026-09-06 00:45:13'),
(180, 'class-schedules.destroy', 'web', '2026-09-06 03:36:48', '2026-09-06 03:36:48'),
(181, 'class-schedules.index', 'web', '2026-09-06 03:37:03', '2026-09-06 03:37:03'),
(182, 'class-schedules.store', 'web', '2026-09-06 03:37:18', '2026-09-06 03:37:18'),
(183, 'class-schedules.update', 'web', '2026-09-06 03:37:32', '2026-09-06 03:37:32'),
(184, 'class-schedules.print', 'web', '2026-09-06 03:50:48', '2026-09-06 03:50:48'),
(185, 'pengguna.index', 'web', '2026-09-06 20:38:51', '2026-09-06 20:38:51'),
(186, 'pengguna.export', 'web', '2026-09-06 20:39:08', '2026-09-06 20:39:08'),
(187, 'studios.index', 'web', '2026-09-08 06:29:57', '2026-09-08 06:29:57'),
(188, 'studios.destroy', 'web', '2026-09-08 06:30:24', '2026-09-08 06:30:24'),
(189, 'studios.create', 'web', '2026-09-08 06:30:57', '2026-09-08 06:30:57'),
(190, 'studios.store', 'web', '2026-09-08 06:31:17', '2026-09-08 06:31:17'),
(191, 'studios.update', 'web', '2026-09-08 06:31:34', '2026-09-08 06:31:34'),
(192, 'instruktur.mobile', 'web', '2026-09-12 06:49:00', '2026-09-12 06:49:00'),
(193, 'checkout.package', 'web', '2026-09-12 15:39:44', '2026-09-12 15:39:44');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `uuid` char(36) NOT NULL,
  `question` varchar(255) NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`options`)),
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`uuid`, `question`, `options`, `status`, `created_at`, `updated_at`) VALUES
('022cc9a2-dd4a-4dd2-8063-391ae8831214', 'Bagaimana menurut Anda terkait informasi yang tersedia pada website kami?', '[\"Baik\",\"Cukup Baik\",\"Kurang\"]', 'active', '2025-11-11 06:16:57', '2025-11-11 06:16:57');

-- --------------------------------------------------------

--
-- Table structure for table `poll_votes`
--

CREATE TABLE `poll_votes` (
  `uuid` char(36) NOT NULL,
  `poll_uuid` char(36) NOT NULL,
  `option` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `uuid` char(36) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `nama_anak` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` enum('islam','kristen','katolik','hindu','buddha','konghucu') NOT NULL,
  `anak_ke` int(11) NOT NULL,
  `nama_ayah` varchar(255) NOT NULL,
  `nama_ibu` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `specializaty_uuid` char(36) DEFAULT NULL,
  `status` enum('pending','hadir','reschedule','diterima','ditolak') NOT NULL DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super-admin', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(2, 'user', 'web', '2024-09-26 23:27:05', '2024-09-26 23:27:05'),
(3, 'admin', 'web', '2024-09-27 01:40:58', '2024-09-27 01:40:58'),
(5, 'instruktur', 'web', '2025-07-21 13:29:16', '2026-09-01 14:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(3, 1),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(4, 5),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(13, 3),
(14, 1),
(14, 3),
(15, 1),
(15, 3),
(16, 1),
(16, 3),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(29, 3),
(30, 1),
(30, 3),
(31, 1),
(31, 3),
(32, 1),
(32, 3),
(33, 1),
(33, 3),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(38, 3),
(39, 1),
(39, 3),
(40, 1),
(40, 3),
(41, 1),
(41, 3),
(46, 1),
(46, 3),
(47, 1),
(47, 3),
(48, 1),
(48, 3),
(49, 1),
(49, 3),
(50, 1),
(50, 3),
(51, 1),
(51, 3),
(51, 5),
(52, 1),
(52, 3),
(52, 5),
(53, 1),
(53, 3),
(53, 5),
(54, 1),
(54, 3),
(54, 5),
(55, 1),
(55, 2),
(55, 3),
(55, 5),
(60, 1),
(60, 3),
(65, 1),
(65, 3),
(70, 1),
(70, 3),
(75, 1),
(75, 3),
(85, 1),
(85, 2),
(85, 3),
(85, 5),
(90, 1),
(90, 2),
(90, 3),
(90, 5),
(100, 1),
(100, 2),
(100, 3),
(105, 1),
(105, 2),
(105, 3),
(110, 1),
(110, 2),
(110, 3),
(115, 1),
(115, 2),
(115, 3),
(120, 1),
(120, 2),
(120, 3),
(125, 1),
(125, 3),
(130, 1),
(130, 2),
(130, 3),
(130, 5),
(135, 1),
(135, 3),
(140, 1),
(140, 3),
(145, 1),
(145, 3),
(146, 1),
(146, 3),
(147, 1),
(147, 3),
(148, 1),
(148, 3),
(149, 1),
(149, 3),
(150, 1),
(150, 3),
(151, 1),
(151, 3),
(152, 1),
(152, 3),
(153, 1),
(153, 3),
(154, 1),
(154, 3),
(155, 1),
(155, 3),
(156, 1),
(156, 3),
(157, 1),
(157, 3),
(158, 1),
(158, 3),
(159, 1),
(159, 3),
(160, 1),
(160, 3),
(161, 1),
(161, 3),
(162, 1),
(162, 3),
(163, 1),
(163, 3),
(164, 1),
(164, 3),
(165, 1),
(165, 3),
(166, 1),
(166, 3),
(167, 1),
(167, 3),
(168, 1),
(168, 3),
(169, 1),
(169, 3),
(170, 1),
(170, 3),
(171, 1),
(171, 2),
(171, 3),
(172, 1),
(172, 3),
(172, 5),
(173, 1),
(173, 3),
(173, 5),
(174, 1),
(174, 3),
(174, 5),
(175, 1),
(175, 3),
(175, 5),
(176, 2),
(177, 1),
(177, 3),
(177, 5),
(178, 1),
(178, 3),
(178, 5),
(179, 1),
(179, 3),
(180, 1),
(180, 3),
(181, 1),
(181, 2),
(181, 3),
(181, 5),
(182, 1),
(182, 3),
(183, 1),
(183, 3),
(184, 1),
(184, 2),
(184, 3),
(184, 5),
(185, 1),
(185, 3),
(186, 1),
(186, 3),
(187, 1),
(187, 2),
(187, 3),
(188, 1),
(188, 3),
(189, 1),
(189, 3),
(190, 1),
(190, 3),
(191, 1),
(191, 3),
(192, 1),
(192, 2),
(193, 1),
(193, 2),
(193, 3);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `route` varchar(255) NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `route`, `permission_name`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.index', 'dashboard.index', 1, NULL, NULL, NULL),
(2, 'user.index', 'user.index', 1, NULL, NULL, NULL),
(3, 'user.store', 'user.store', 1, NULL, NULL, NULL),
(4, 'user.update', 'user.update', 1, NULL, NULL, NULL),
(5, 'user.destroy', 'user.destroy', 1, NULL, NULL, NULL),
(6, 'menu.index', 'menu-group.index', 1, NULL, NULL, NULL),
(7, 'menu.store', 'menu-group.store', 1, NULL, NULL, NULL),
(8, 'menu.update', 'menu-group.update', 1, NULL, NULL, NULL),
(9, 'menu.destroy', 'menu-group.destroy', 1, NULL, NULL, NULL),
(10, 'menu.item.index', 'menu-item.index', 1, NULL, NULL, NULL),
(11, 'menu.item.store', 'menu-item.store', 1, NULL, NULL, NULL),
(12, 'menu.item.update', 'menu-item.update', 1, NULL, NULL, NULL),
(13, 'menu.item.destroy', 'menu-item.destroy', 1, NULL, NULL, NULL),
(14, 'route.index', 'route.index', 1, NULL, NULL, NULL),
(15, 'route.store', 'route.store', 1, NULL, NULL, NULL),
(16, 'route.update', 'route.update', 1, NULL, NULL, NULL),
(17, 'route.destroy', 'route.destroy', 1, NULL, NULL, NULL),
(18, 'role.index', 'role.index', 1, NULL, NULL, NULL),
(19, 'role.store', 'role.store', 1, NULL, NULL, NULL),
(20, 'role.update', 'role.update', 1, NULL, NULL, NULL),
(21, 'role.destroy', 'role.destroy', 1, NULL, NULL, NULL),
(22, 'permission.index', 'permission.index', 1, NULL, NULL, NULL),
(23, 'permission.store', 'permission.store', 1, NULL, NULL, NULL),
(24, 'permission.update', 'permission.update', 1, NULL, NULL, NULL),
(25, 'permission.destroy', 'permission.destroy', 1, NULL, NULL, NULL),
(26, 'faq.index', 'faq.index', 1, NULL, '2024-09-27 00:20:45', '2024-09-27 00:20:45'),
(27, 'faq.store', 'faq.store', 1, NULL, '2024-09-27 01:45:13', '2024-09-27 01:45:13'),
(28, 'faq.update', 'faq.update', 1, NULL, '2024-09-27 01:45:36', '2024-09-27 01:45:52'),
(29, 'faq.destroy', 'faq.destroy', 1, NULL, '2024-09-27 01:46:45', '2024-09-27 01:46:45'),
(30, 'company.index', 'company.index', 1, NULL, '2024-09-27 01:53:58', '2024-09-27 01:53:58'),
(32, 'company.update', 'company.update', 1, NULL, '2024-09-27 01:55:03', '2024-09-27 01:55:09'),
(33, 'company.store', 'company.store', 1, NULL, '2024-09-27 01:55:29', '2024-09-27 01:55:29'),
(34, 'categories.destroy', 'categories.destroy', 1, NULL, '2024-09-29 12:31:56', '2024-10-15 13:51:53'),
(35, 'categories.index', 'categories.index', 1, NULL, '2024-09-29 12:32:17', '2024-10-15 13:52:11'),
(36, 'categories.store', 'categories.store', 1, NULL, '2024-09-29 12:32:37', '2024-10-15 13:52:26'),
(37, 'categories.update', 'categories.update', 1, NULL, '2024-09-29 12:32:56', '2024-10-15 13:52:45'),
(42, 'banner.destroy', 'banner.destroy', 1, NULL, '2024-09-30 12:06:31', '2024-10-13 22:36:22'),
(43, 'banner.index', 'banner.index', 1, NULL, '2024-09-30 12:06:55', '2024-10-13 22:36:39'),
(44, 'banner.store', 'banner.store', 1, NULL, '2024-09-30 12:07:34', '2024-10-13 22:37:03'),
(45, 'banner.update', 'banner.update', 1, NULL, '2024-09-30 12:07:57', '2024-10-13 22:37:24'),
(46, 'articles.create', 'articles.create', 1, NULL, '2024-10-15 14:22:17', '2024-10-15 14:22:17'),
(47, 'articles.destroy', 'articles.destroy', 1, NULL, '2024-10-15 14:22:51', '2024-10-15 14:22:51'),
(48, 'articles.index', 'articles.index', 1, NULL, '2024-10-15 14:23:15', '2024-10-15 14:23:15'),
(49, 'articles.store', 'articles.store', 1, NULL, '2024-10-15 14:23:49', '2024-10-15 14:23:49'),
(50, 'articles.update', 'articles.update', 1, NULL, '2024-10-15 14:24:09', '2024-10-15 14:24:09'),
(55, 'dashboard.submitSumber', 'dashboard.form', 1, NULL, '2025-07-21 16:35:06', '2025-07-21 16:35:06'),
(60, 'poll.destroy', 'poll.destroy', 1, NULL, '2025-07-21 17:53:17', '2025-09-17 22:55:14'),
(65, 'polls.index', 'poll.index', 1, NULL, '2025-07-21 17:53:47', '2025-09-17 22:54:20'),
(70, 'poll.store', 'poll.store', 1, NULL, '2025-07-21 17:54:16', '2025-09-17 22:55:28'),
(75, 'poll.update', 'poll.update', 1, NULL, '2025-07-21 17:54:35', '2025-09-17 22:55:42'),
(85, 'account.index', 'account.index', 1, NULL, '2025-07-22 23:36:37', '2025-07-22 23:36:37'),
(90, 'account.update', 'account.update', 1, NULL, '2025-07-22 23:37:03', '2025-07-22 23:37:03'),
(95, 'program.create', 'program.create', 1, NULL, '2025-07-23 22:33:56', '2025-07-23 22:33:56'),
(100, 'program.destroy', 'program.destroy', 1, NULL, '2025-07-23 22:34:31', '2025-07-23 22:34:31'),
(105, 'program.index', 'program.index', 1, NULL, '2025-07-23 22:34:58', '2025-07-23 22:34:58'),
(110, 'program.store', 'program.store', 1, NULL, '2025-07-23 22:35:45', '2025-07-23 22:35:45'),
(115, 'program.update', 'program.update', 1, NULL, '2025-07-23 22:36:15', '2025-07-23 22:36:15'),
(120, 'filedownload.index', 'filedownload.index', 1, NULL, '2025-07-25 16:50:03', '2025-07-25 16:50:03'),
(125, 'filedownload.destroy', 'filedownload.destroy', 1, NULL, '2025-07-25 16:50:24', '2025-07-25 16:50:24'),
(130, 'filedownload.store', 'filedownload.store', 1, NULL, '2025-07-25 16:50:51', '2025-07-25 16:50:51'),
(135, 'filedownload.update', 'filedownload.update', 1, NULL, '2025-07-25 16:51:29', '2025-07-25 16:51:29'),
(140, 'layanan.kontak', 'layanan.kontak', 1, NULL, '2025-07-27 23:47:08', '2025-07-27 23:47:08'),
(145, 'banner.update', 'banner.update', 1, NULL, '2025-08-07 12:52:06', '2025-08-07 12:52:06'),
(146, 'instruktur.destroy', 'instruktur.destroy', 1, NULL, '2025-09-14 12:04:52', '2026-09-01 14:31:34'),
(147, 'pages.create', 'pages.create', 1, NULL, '2025-09-17 23:29:27', '2025-09-17 23:29:27'),
(148, 'pages.index', 'pages.index', 1, NULL, '2025-09-17 23:29:41', '2025-09-17 23:29:41'),
(149, 'pages.store', 'pages.store', 1, NULL, '2025-09-17 23:29:59', '2025-09-17 23:29:59'),
(150, 'pages.destroy', 'pages.destroy', 1, NULL, '2025-09-17 23:30:31', '2025-09-17 23:30:31'),
(151, 'pages.update', 'pages.update', 1, NULL, '2025-09-17 23:30:45', '2025-09-17 23:30:45'),
(152, 'instruktur.index', 'instruktur.index', 1, NULL, '2025-09-18 01:27:46', '2026-09-01 14:32:00'),
(153, 'instruktur.store', 'instruktur.store', 1, NULL, '2025-09-18 01:27:59', '2026-09-01 14:32:18'),
(154, 'instruktur.update', 'instruktur.update', 1, NULL, '2025-09-18 01:31:29', '2026-09-01 14:32:46'),
(155, 'testimonial.destroy', 'testimonial.destroy', 1, NULL, '2025-09-21 21:44:13', '2025-09-21 21:44:13'),
(156, 'testimonial.index', 'testimonial.index', 1, NULL, '2025-09-21 21:44:25', '2025-09-21 21:44:25'),
(157, 'testimonial.store', 'testimonial.store', 1, NULL, '2025-09-21 21:44:40', '2025-09-21 21:44:40'),
(158, 'testimonial.update', 'testimonial.update', 1, NULL, '2025-09-21 21:44:53', '2025-09-21 21:44:53'),
(159, 'events.destroy', 'events.destroy', 1, NULL, '2025-10-21 02:47:54', '2026-08-30 19:52:08'),
(160, 'events.index', 'events.index', 1, NULL, '2025-10-21 03:15:35', '2026-08-30 19:52:34'),
(161, 'events.store', 'events.store', 1, NULL, '2025-10-21 03:15:47', '2026-08-30 19:52:53'),
(162, 'events.update', 'events.update', 1, NULL, '2025-10-21 03:15:58', '2026-08-30 19:53:11'),
(163, 'specializations.destroy', 'specializations.destroy', 1, NULL, '2025-11-11 03:40:24', '2026-08-27 17:32:06'),
(164, 'specializations.index', 'specializations.index', 1, NULL, '2025-11-11 03:40:41', '2026-08-27 17:32:27'),
(165, 'specializations.store', 'specializations.store', 1, NULL, '2025-11-11 03:40:58', '2026-08-27 17:32:51'),
(166, 'specializations.update', 'specializations.update', 1, NULL, '2025-11-11 03:42:13', '2026-08-27 17:33:20'),
(167, 'packages.destroy', 'package.destroy', 1, NULL, '2026-09-02 04:55:42', '2026-09-02 04:55:42'),
(168, 'packages.index', 'package.index', 1, NULL, '2026-09-02 04:56:09', '2026-09-02 04:56:09'),
(169, 'packages.store', 'package.store', 1, NULL, '2026-09-02 04:56:34', '2026-09-02 04:56:34'),
(170, 'packages.update', 'package.update', 1, NULL, '2026-09-02 04:57:18', '2026-09-02 04:57:18'),
(171, 'package.member', 'package.member', 1, NULL, '2026-09-02 05:47:34', '2026-09-02 05:47:34'),
(172, 'classes.destroy', 'classes.destroy', 1, NULL, '2026-09-02 15:12:54', '2026-09-02 15:12:54'),
(173, 'classes.index', 'classes.index', 1, NULL, '2026-09-02 15:13:08', '2026-09-02 15:13:08'),
(174, 'classes.update', 'classes.update', 1, NULL, '2026-09-02 15:13:24', '2026-09-02 15:13:24'),
(175, 'classes.store', 'classes.store', 1, NULL, '2026-09-02 15:13:40', '2026-09-02 15:13:40'),
(176, 'dashboard.submitSumber', 'dashboard.submitSumber', 1, NULL, '2026-09-04 07:15:41', '2026-09-04 07:15:41'),
(177, 'classes.create', 'classes.create', 1, NULL, '2026-09-05 23:56:12', '2026-09-05 23:56:12'),
(178, 'classes.edit', 'classes.edit', 0, NULL, '2026-09-05 23:56:28', '2026-09-05 23:56:28'),
(179, 'classes.change-level', 'classes.change-level', 1, NULL, '2026-09-06 00:46:10', '2026-09-06 00:46:10'),
(180, 'class-schedules.destroy', 'class-schedules.destroy', 1, NULL, '2026-09-06 03:37:54', '2026-09-06 03:37:54'),
(181, 'class-schedules.index', 'class-schedules.index', 1, NULL, '2026-09-06 03:38:11', '2026-09-06 03:38:11'),
(182, 'class-schedules.store', 'class-schedules.store', 1, NULL, '2026-09-06 03:38:30', '2026-09-06 03:38:30'),
(183, 'class-schedules.update', 'class-schedules.update', 1, NULL, '2026-09-06 03:38:48', '2026-09-06 03:38:48'),
(184, 'class-schedules.print', 'class-schedules.print', 1, NULL, '2026-09-06 03:51:13', '2026-09-06 03:51:13'),
(185, 'pengguna.index', 'pengguna.index', 1, NULL, '2026-09-06 20:39:23', '2026-09-06 20:39:23'),
(186, 'pengguna.export', 'pengguna.export', 1, NULL, '2026-09-06 20:39:35', '2026-09-06 20:39:35'),
(187, 'studios.create', 'studios.create', 1, NULL, '2026-09-08 06:32:44', '2026-09-08 06:32:44'),
(188, 'studios.index', 'studios.index', 1, NULL, '2026-09-08 06:32:59', '2026-09-08 06:32:59'),
(189, 'studios.destroy', 'studios.destroy', 1, NULL, '2026-09-08 06:33:15', '2026-09-08 06:33:15'),
(190, 'studios.update', 'studios.update', 1, NULL, '2026-09-08 06:33:33', '2026-09-08 06:33:33'),
(191, 'studios.store', 'studios.store', 1, NULL, '2026-09-08 06:33:55', '2026-09-08 06:33:55'),
(192, 'instruktur.mobile', 'instruktur.mobile', 1, NULL, '2026-09-12 06:49:32', '2026-09-12 06:49:32'),
(193, 'checkout.package', 'checkout.package', 1, NULL, '2026-09-12 15:40:03', '2026-09-12 15:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE `seo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `robots` varchar(255) DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo`
--

INSERT INTO `seo` (`id`, `description`, `title`, `image`, `author`, `robots`, `canonical_url`, `created_at`, `updated_at`, `model_type`, `model_id`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-16 00:51:45', '2025-09-16 00:51:45', 'App\\Models\\Category', '0f6f80de-b410-4b7a-88b2-08411c5a063c'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-16 01:03:16', '2025-09-16 01:03:16', 'App\\Models\\Category', '34103609-8116-4baf-bd17-557fc6989e8e'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-16 01:03:22', '2025-09-16 01:03:22', 'App\\Models\\Category', '2162d145-9ef3-4e2f-8c55-81971a015bc5'),
(4, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-16 01:03:27', '2025-09-16 01:03:27', 'App\\Models\\Category', 'bb006a6e-36bc-48cb-a84f-2a562489bb54'),
(5, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-16 01:03:50', '2025-09-16 01:03:50', 'App\\Models\\Category', 'f16ac019-a6b8-4ca6-984a-6c87624d06e9'),
(6, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-16 01:03:56', '2025-09-16 01:03:56', 'App\\Models\\Category', 'd9c59085-6120-487f-bd89-8924f043b70f'),
(7, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-16 01:04:08', '2025-09-16 01:04:08', 'App\\Models\\Category', 'cbe3bfd5-2852-4616-ad1e-e64510623354'),
(8, 'dasdsa', 'dsadas', 'images/BkDwT5z1GU7ge3jsY7cbjqxitH9GVI5bGWrVJXVf.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/dsadas', '2025-09-21 21:24:40', '2025-09-21 21:24:40', 'App\\Models\\Article', 'a7a1ddfd-e34d-4a9b-b1f1-8c3b3f980101'),
(9, 'das', 'dsad', 'images/vOOiSvvssJ0m7N5ZuDV1kqiOAlmAFT1LFkrWIVZM.png', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/dsad', '2025-09-21 23:45:55', '2025-09-21 23:45:55', 'App\\Models\\Article', '9fea3519-9e45-42b6-b0a7-4eda3d36336c'),
(10, 'Kunjungan kerja Pj Wali Kota Bekasi Gani Muhamad didampingi Istri Yolla Kusuma', 'Dedikasi Guru SLB, Pj Wali Kota Bekasi Panjatkan Syukur dan Bangga', 'images/dqG6N4LdZt2BpFYbkRYEipCXhu49cY8Hn4feSGYT.jpg', 'Admin Sekolah', 'index', 'http://103.76.148.154:8000/backend/articles/dedikasi-guru-slb-pj-wali-kota-bekasi-panjatkan-syukur-dan-bangga', '2025-09-29 08:50:56', '2025-09-29 08:50:56', 'App\\Models\\Article', '225a5ce5-27a3-4ebe-a15a-1151ea17f0b2'),
(11, 'Dorong UMKM Naik Kelas, Pemkot Bekasi Gelar Sosialisasi Program KUR Bank BJB', 'Dorong UMKM Naik Kelas, Pemkot Bekasi Gelar Sosialisasi Program KUR Bank BJB', 'images/4Y8xWeFxXgrHTaGGrRR49cTzRgBbnylh8RT8pUcw.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/dorong-umkm-naik-kelas-pemkot-bekasi-gelar-sosialisasi-program-kur-bank-bjb', '2025-09-30 04:31:02', '2025-09-30 04:31:02', 'App\\Models\\Article', 'e26fc79e-6747-4852-8e1b-711cae82c811'),
(12, 'Dorong UMKM Naik Kelas, Pemkot Bekasi Gelar Sosialisasi Program KUR Bank BJB', 'Dorong UMKM Naik Kelas, Pemkot Bekasi Gelar Sosialisasi Program KUR Bank BJB', 'images/4Y8xWeFxXgrHTaGGrRR49cTzRgBbnylh8RT8pUcw.jpg', 'Admin Sekolah', 'index', 'http://103.76.148.154:8000/backend/articles/dorong-umkm-naik-kelas-pemkot-bekasi-gelar-sosialisasi-program-kur-bank-bjb', '2025-09-30 04:36:50', '2025-09-30 04:36:50', 'App\\Models\\Article', 'e26fc79e-6747-4852-8e1b-711cae82c811'),
(13, 'Dorong UMKM Naik Kelas, Pemkot Bekasi Gelar Sosialisasi Program KUR Bank BJB', 'Dorong UMKM Naik Kelas, Pemkot Bekasi Gelar Sosialisasi Program KUR Bank BJB', 'images/4Y8xWeFxXgrHTaGGrRR49cTzRgBbnylh8RT8pUcw.jpg', 'Admin Sekolah', 'index', 'http://103.76.148.154:8000/backend/articles/dorong-umkm-naik-kelas-pemkot-bekasi-gelar-sosialisasi-program-kur-bank-bjb', '2025-09-30 04:37:18', '2025-09-30 04:37:18', 'App\\Models\\Article', 'e26fc79e-6747-4852-8e1b-711cae82c811'),
(14, 'Dorong UMKM Naik Kelas, Pemkot Bekasi Gelar Sosialisasi Program KUR Bank BJB', 'Dorong UMKM Naik Kelas, Pemkot Bekasi Gelar Sosialisasi Program KUR Bank BJB', 'images/4Y8xWeFxXgrHTaGGrRR49cTzRgBbnylh8RT8pUcw.jpg', 'Admin Sekolah', 'index', 'http://103.76.148.154:8000/backend/articles/dorong-umkm-naik-kelas-pemkot-bekasi-gelar-sosialisasi-program-kur-bank-bjb', '2025-09-30 04:37:35', '2025-09-30 04:37:35', 'App\\Models\\Article', 'e26fc79e-6747-4852-8e1b-711cae82c811'),
(15, 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'images/89rXVtDwjTG9EmdgFPogoeFPwAJIirofhidjdrEu.jpg', 'Admin Sekolah', 'index', 'http://103.76.148.154:8000/backend/articles/tri-adhianto-dan-wiwiek-hargono-terima-anugerah-keluarga-termaslahat-dari-lkknu', '2025-09-30 04:39:50', '2025-09-30 04:39:50', 'App\\Models\\Article', 'b74e1fd1-0417-4980-b207-eb8a9901a878'),
(16, 'fsdf', 'fsdf', 'images/58jRWycX0LL0Mmk20xVxBZuLhb13b7gCtnbVFpLf.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/fsdf', '2025-09-30 04:51:15', '2025-09-30 04:51:15', 'App\\Models\\Article', 'ef525ad4-9e6b-40ea-81fd-71de34a4e3a9'),
(17, 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'images/89rXVtDwjTG9EmdgFPogoeFPwAJIirofhidjdrEu.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/tri-adhianto-dan-wiwiek-hargono-terima-anugerah-keluarga-termaslahat-dari-lkknu', '2025-09-30 05:26:51', '2025-09-30 05:26:51', 'App\\Models\\Article', 'b74e1fd1-0417-4980-b207-eb8a9901a878'),
(18, 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'images/89rXVtDwjTG9EmdgFPogoeFPwAJIirofhidjdrEu.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/tri-adhianto-dan-wiwiek-hargono-terima-anugerah-keluarga-termaslahat-dari-lkknu', '2025-09-30 05:29:34', '2025-09-30 05:29:34', 'App\\Models\\Article', 'b74e1fd1-0417-4980-b207-eb8a9901a878'),
(19, 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'images/89rXVtDwjTG9EmdgFPogoeFPwAJIirofhidjdrEu.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/tri-adhianto-dan-wiwiek-hargono-terima-anugerah-keluarga-termaslahat-dari-lkknu', '2025-09-30 05:29:45', '2025-09-30 05:29:45', 'App\\Models\\Article', 'b74e1fd1-0417-4980-b207-eb8a9901a878'),
(20, 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'images/FzjAPJph4NTicYYWBBVghzb9RwjxwfLrr8Jl6wD4.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/tri-adhianto-dan-wiwiek-hargono-terima-anugerah-keluarga-termaslahat-dari-lkknu', '2025-09-30 05:33:35', '2025-09-30 05:33:35', 'App\\Models\\Article', 'b74e1fd1-0417-4980-b207-eb8a9901a878'),
(21, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-01 06:23:46', '2025-10-01 06:23:46', 'App\\Models\\Category', 'e7472961-7151-4c89-bfa8-04eee74d9111'),
(22, 'Juara 3 Lomba Menyanyi', 'Dinda Nurohman', 'images/ZGZUKCAV10bEiRXlkcvW0lKT9J2n50XglYts9jWI.jpg', 'Admin Sekolah', 'index', 'http://103.76.148.154:8000/backend/articles/dinda-nurohman', '2025-10-02 02:24:30', '2025-10-02 02:24:30', 'App\\Models\\Article', 'ef525ad4-9e6b-40ea-81fd-71de34a4e3a9'),
(23, 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'images/bLT73ZQ6e8aVFwZ7hycMkyi8GmfJeuYGvVFuvoK8.jpg', 'Admin Sekolah', 'index', 'http://103.76.148.154:8000/backend/articles/tri-adhianto-dan-wiwiek-hargono-terima-anugerah-keluarga-termaslahat-dari-lkknu', '2025-10-02 02:25:05', '2025-10-02 02:25:05', 'App\\Models\\Article', 'b74e1fd1-0417-4980-b207-eb8a9901a878'),
(24, 'Dorong UMKM Naik Kelas, Pemkot Bekasi Gelar Sosialisasi Program KUR Bank BJB', 'Dorong UMKM Naik Kelas, Pemkot Bekasi Gelar Sosialisasi Program KUR Bank BJB', 'images/qF6sCsDs9ffRTwq44Ofa41hrriVirZ5H47Uee1Bd.jpg', 'Admin Sekolah', 'index', 'http://103.76.148.154:8000/backend/articles/dorong-umkm-naik-kelas-pemkot-bekasi-gelar-sosialisasi-program-kur-bank-bjb', '2025-10-02 02:25:16', '2025-10-02 02:25:16', 'App\\Models\\Article', 'e26fc79e-6747-4852-8e1b-711cae82c811'),
(25, 'Juara lomba menyanyi solo berhasil diraih Adinda eko Subagio', 'Adinda Eko Subagio Juara 1 Lomba menyanyi solo', 'images/FQ4F5RMM3u0ljXS9yWYHDnXsFsPDofYnO3sqgBgV.jpg', 'Admin Sekolah', 'index', 'http://103.76.148.154:8000/backend/articles/adinda-eko-subagio-juara-1-lomba-menyanyi-solo', '2025-10-02 02:30:38', '2025-10-02 02:30:38', 'App\\Models\\Article', '3f026350-7718-43bf-bfd0-088a021e8089'),
(26, 'Juara lomba menyanyi solo berhasil diraih Adinda eko Subagio', 'Adinda Eko Subagio Juara 1 Lomba menyanyi solo', 'images/7vGyW3v4tjrT4MS8i8Alf3KVGE7mzSV3dXd7E4XC.png', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/adinda-eko-subagio-juara-1-lomba-menyanyi-solo', '2025-10-02 05:50:10', '2025-10-02 05:50:10', 'App\\Models\\Article', '3f026350-7718-43bf-bfd0-088a021e8089'),
(27, 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'Tri Adhianto dan Wiwiek Hargono Terima Anugerah Keluarga Termaslahat dari LKKNU', 'images/bLT73ZQ6e8aVFwZ7hycMkyi8GmfJeuYGvVFuvoK8.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/tri-adhianto-dan-wiwiek-hargono-terima-anugerah-keluarga-termaslahat-dari-lkknu', '2025-10-02 06:17:51', '2025-10-02 06:17:51', 'App\\Models\\Article', 'b74e1fd1-0417-4980-b207-eb8a9901a878'),
(28, 'Kunjungan kerja Pj Wali Kota Bekasi Gani Muhamad didampingi Istri Yolla Kusuma', 'Dedikasi Guru SLB, Pj Wali Kota Bekasi Panjatkan Syukur dan Bangga', 'images/dqG6N4LdZt2BpFYbkRYEipCXhu49cY8Hn4feSGYT.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/dedikasi-guru-slb-pj-wali-kota-bekasi-panjatkan-syukur-dan-bangga', '2025-10-02 06:19:06', '2025-10-02 06:19:06', 'App\\Models\\Article', '225a5ce5-27a3-4ebe-a15a-1151ea17f0b2'),
(29, 'Juara lomba menyanyi solo berhasil diraih Adinda eko Subagio', 'Adinda Eko Subagio Juara 1 Lomba menyanyi solo', 'images/pLAsYqB3RjhFGxjr9r3ym0aGIboEuOo9mQqBxmvg.jpg', 'Admin Sekolah', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/adinda-eko-subagio-juara-1-lomba-menyanyi-solo', '2025-10-16 03:16:27', '2025-10-16 03:16:27', 'App\\Models\\Article', '3f026350-7718-43bf-bfd0-088a021e8089'),
(30, 'Kebersaman pemimpin daerah dengan Anak-anak Down Syndrome', 'Wali dan Wakil Wali Kota Bekasi Nyanyi Bersama Anak Down Syndrome di CFD Kota Bekasi', 'images/ESvkOUk4fUn3QIxfGzTdnBDtqcSiQDop8TtFDYvP.jpg', 'Admin Sekolah', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/wali-dan-wakil-wali-kota-bekasi-nyanyi-bersama-anak-down-syndrome-di-cfd-kota-bekasi', '2025-10-16 03:19:35', '2025-10-16 03:19:35', 'App\\Models\\Article', '4922f25e-24ab-45d8-a7bb-ff650c55a578'),
(31, 'Wali Kota Bekasi Tri Adhianto Terima Kunjungan Edukasi Siswa SLB Patriot', 'Wali Kota Bekasi Tri Adhianto Terima Kunjungan Edukasi Siswa SLB Patriot', 'images/jjIvZ0LsGljnaJnPO0VwRRaKIIeoJlGC549B69OZ.jpg', 'super-admin', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/wali-kota-bekasi-tri-adhianto-terima-kunjungan-edukasi-siswa-slb-patriot', '2025-10-17 07:47:37', '2025-10-17 07:47:37', 'App\\Models\\Article', '66ed2a58-530d-4460-b1da-a6d41933540e'),
(32, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-31 03:07:08', '2025-10-31 03:07:08', 'App\\Models\\Category', '72561291-cdcb-484b-a556-0400fbd53c3d'),
(33, 'fsdfsdfsd', 'ffdsdsfsd', 'images/QmD0ntU3jgYsDD1rEXPWdRvz9S1wFj1Ncl1j6lNb.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/ffdsdsfsd', '2025-10-31 03:31:16', '2025-10-31 03:31:16', 'App\\Models\\Article', '1ca939a6-229f-46f2-9ef9-90f6ecf368ef'),
(34, 'fsdfsdfsd', 'ffdsdsfsd', 'images/QmD0ntU3jgYsDD1rEXPWdRvz9S1wFj1Ncl1j6lNb.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/ffdsdsfsd', '2025-10-31 03:41:18', '2025-10-31 03:41:18', 'App\\Models\\Article', '1ca939a6-229f-46f2-9ef9-90f6ecf368ef'),
(35, 'Menyanyi Solo SMPLB FLS3N Disabilitas 2025', 'SMPLB FLS3N Disabilitas 2025', 'images/GXWIGs16PIQbg7gi3yhpcQb1gg58JVu4i6QuOLIt.png', 'Admin Sekolah', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/smplb-fls3n-disabilitas-2025', '2025-10-31 06:48:45', '2025-10-31 06:48:45', 'App\\Models\\Article', '1ca939a6-229f-46f2-9ef9-90f6ecf368ef'),
(36, 'Menyanyi Solo SMPLB FLS3N Disabilitas 2025', 'SMPLB FLS3N Disabilitas 2025', 'images/GXWIGs16PIQbg7gi3yhpcQb1gg58JVu4i6QuOLIt.png', 'Admin Sekolah', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/smplb-fls3n-disabilitas-2025', '2025-11-11 08:00:48', '2025-11-11 08:00:48', 'App\\Models\\Article', '1ca939a6-229f-46f2-9ef9-90f6ecf368ef'),
(37, NULL, 'SLB Patriot Bekasi di Bawah Yayasan Dharma Wanita: Hadir untuk ABK dengan Biaya Sekolah Berkeadilan', NULL, 'Ainun Mutia Zalfina', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/slb-patriot-bekasi-di-bawah-yayasan-dharma-wanita-hadir-untuk-abk-dengan-biaya-sekolah-berkeadilan', '2026-04-17 07:08:11', '2026-04-17 07:08:11', 'App\\Models\\Article', '60dd784c-461e-4ce9-93ae-60d545e5c545'),
(38, NULL, 'SLB Patriot Bekasi di Bawah Yayasan Dharma Wanita: Hadir untuk ABK dengan Biaya Sekolah Berkeadilan', NULL, 'Ainun Mutia Zalfina', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/slb-patriot-bekasi-di-bawah-yayasan-dharma-wanita-hadir-untuk-abk-dengan-biaya-sekolah-berkeadilan', '2026-04-17 07:10:27', '2026-04-17 07:10:27', 'App\\Models\\Article', '60dd784c-461e-4ce9-93ae-60d545e5c545'),
(39, NULL, 'SLB Patriot Bekasi di Bawah Yayasan Dharma Wanita: Hadir untuk ABK dengan Biaya Sekolah Berkeadilan', 'images/8osmllekNYHfwNj1DOfoqmnaW87Cei8CcwavT0pQ.jpg', 'Admin Sekolah', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/slb-patriot-bekasi-di-bawah-yayasan-dharma-wanita-hadir-untuk-abk-dengan-biaya-sekolah-berkeadilan', '2026-05-13 09:15:26', '2026-05-13 09:15:26', 'App\\Models\\Article', '60dd784c-461e-4ce9-93ae-60d545e5c545'),
(40, NULL, 'SLB Patriot Bekasi di Bawah Yayasan Dharma Wanita: Hadir untuk ABK dengan Biaya Sekolah Berkeadilan', 'images/8osmllekNYHfwNj1DOfoqmnaW87Cei8CcwavT0pQ.jpg', 'Admin Sekolah', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/slb-patriot-bekasi-di-bawah-yayasan-dharma-wanita-hadir-untuk-abk-dengan-biaya-sekolah-berkeadilan', '2026-05-13 09:16:41', '2026-05-13 09:16:41', 'App\\Models\\Article', '60dd784c-461e-4ce9-93ae-60d545e5c545'),
(41, 'PENGUMUMAN PENERIMAAN MURID BARU (SPMB) SLB PATRIOT KOTA BEKASI - TA 2026/2027 SLB Patriot Kota Bekasi membuka kesempatan bagi anak berkebutuhan khusus (ABK)', 'SPMB (Sistem Penerimaan Murid Baru) SLB PATRIOT KOTA BEKASI', NULL, 'Ainun Mutia Zalfina', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/spmb-sistem-penerimaan-murid-baru-slb-patriot-kota-bekasi', '2026-05-13 20:51:19', '2026-05-13 20:51:19', 'App\\Models\\Article', '04df33b0-155e-41fc-a904-731c126c75d4'),
(42, 'PENGUMUMAN PENERIMAAN MURID BARU (SPMB) SLB PATRIOT KOTA BEKASI - TA 2026/2027 SLB Patriot Kota Bekasi membuka kesempatan bagi anak berkebutuhan khusus (ABK)', 'SPMB (Sistem Penerimaan Murid Baru) SLB PATRIOT KOTA BEKASI', NULL, 'Ainun Mutia Zalfina', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/spmb-sistem-penerimaan-murid-baru-slb-patriot-kota-bekasi', '2026-05-13 20:57:18', '2026-05-13 20:57:18', 'App\\Models\\Article', '04df33b0-155e-41fc-a904-731c126c75d4'),
(43, 'PENGUMUMAN PENERIMAAN MURID BARU (SPMB) SLB PATRIOT KOTA BEKASI - TA 2026/2027 SLB Patriot Kota Bekasi membuka kesempatan bagi anak berkebutuhan khusus (ABK)', 'SPMB (Sistem Penerimaan Murid Baru) SLB PATRIOT KOTA BEKASI', 'images/DhUdFwOukcm2aJMYNLkSQlOflprS55zlIS2KFK93.jpg', 'Ainun Mutia Zalfina', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/spmb-sistem-penerimaan-murid-baru-slb-patriot-kota-bekasi', '2026-05-14 01:33:57', '2026-05-14 01:33:57', 'App\\Models\\Article', '04df33b0-155e-41fc-a904-731c126c75d4'),
(44, NULL, 'Hadrah', 'images/pKXpNusHLfmir8RYgpkZMheYh03IhYrR39s6l96g.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/hadrah', '2026-06-07 23:22:19', '2026-06-07 23:22:19', 'App\\Models\\Article', 'd5f1b860-3d91-4484-b8d3-fe463a0d72f6'),
(45, NULL, 'Kegiatan ASAS (Assessment Sumatif Akhir) Genap tahun ajaran 2025/2026', 'images/VwcmPvohyFLOgGOlLLNSZwohnu5edSVzNDQIufJp.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/kegiatan-asas-assessment-sumatif-akhir-genap-tahun-ajaran-20252026', '2026-06-17 20:02:59', '2026-06-17 20:02:59', 'App\\Models\\Article', '44cefb8d-2f87-4670-9bbc-631746daba9c'),
(46, 'Ekstrakurikuler Hadroh di SLB Patriot Kota Bekasi merupakan salah satu wadah pembinaan seni musik Islami dan spiritual bagi para peserta didik. Kegiatan ini dirancang khusus untuk memfasilitasi minat dan bakat siswa-siswi berkebutuhan khusus dalam seni tabuh rebana dan seni tarik suara (selawat).  Melalui pendekatan yang sabar, adaptif, dan penuh kasih sayang, ekstra kurikuler ini membuktikan bahwa keterbatasan fisik maupun kognitif bukanlah penghalang untuk menghasilkan harmoni nada yang indah dan menyentuh hati.', 'Hadrah', 'images/pKXpNusHLfmir8RYgpkZMheYh03IhYrR39s6l96g.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/hadrah', '2026-06-19 03:05:59', '2026-06-19 03:05:59', 'App\\Models\\Article', 'd5f1b860-3d91-4484-b8d3-fe463a0d72f6'),
(47, 'Ekstrakurikuler Hadroh di SLB Patriot Kota Bekasi merupakan salah satu wadah pembinaan seni musik Islami dan spiritual bagi para peserta didik. Kegiatan ini dirancang khusus untuk memfasilitasi minat dan bakat siswa-siswi berkebutuhan khusus dalam seni tabuh rebana dan seni tarik suara (selawat).  Melalui pendekatan yang sabar, adaptif, dan penuh kasih sayang, ekstra kurikuler ini membuktikan bahwa keterbatasan fisik maupun kognitif bukanlah penghalang untuk menghasilkan harmoni nada yang indah dan menyentuh hati.', 'Hadrah', 'images/pKXpNusHLfmir8RYgpkZMheYh03IhYrR39s6l96g.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/hadrah', '2026-06-19 03:19:58', '2026-06-19 03:19:58', 'App\\Models\\Article', 'd5f1b860-3d91-4484-b8d3-fe463a0d72f6'),
(48, 'Ekstrakurikuler Hadroh di SLB Patriot Kota Bekasi merupakan salah satu wadah pembinaan seni musik Islami dan spiritual bagi para peserta didik. Kegiatan ini dirancang khusus untuk memfasilitasi minat dan bakat siswa-siswi berkebutuhan khusus dalam seni tabuh rebana dan seni tarik suara (selawat).  Melalui pendekatan yang sabar, adaptif, dan penuh kasih sayang, ekstra kurikuler ini membuktikan bahwa keterbatasan fisik maupun kognitif bukanlah penghalang untuk menghasilkan harmoni nada yang indah dan menyentuh hati.', 'Hadrah', 'images/pKXpNusHLfmir8RYgpkZMheYh03IhYrR39s6l96g.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/hadrah', '2026-06-19 03:21:12', '2026-06-19 03:21:12', 'App\\Models\\Article', 'd5f1b860-3d91-4484-b8d3-fe463a0d72f6'),
(49, 'Ekstrakurikuler Hadroh di SLB Patriot Kota Bekasi merupakan salah satu wadah pembinaan seni musik Islami dan spiritual bagi para peserta didik. Kegiatan ini dirancang khusus untuk memfasilitasi minat dan bakat siswa-siswi berkebutuhan khusus dalam seni tabuh rebana dan seni tarik suara (selawat).  Melalui pendekatan yang sabar, adaptif, dan penuh kasih sayang, ekstra kurikuler ini membuktikan bahwa keterbatasan fisik maupun kognitif bukanlah penghalang untuk menghasilkan harmoni nada yang indah dan menyentuh hati.', 'Hadrah', 'images/pKXpNusHLfmir8RYgpkZMheYh03IhYrR39s6l96g.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/hadrah', '2026-06-19 03:22:51', '2026-06-19 03:22:51', 'App\\Models\\Article', 'd5f1b860-3d91-4484-b8d3-fe463a0d72f6'),
(50, NULL, 'Hadrah', 'images/pKXpNusHLfmir8RYgpkZMheYh03IhYrR39s6l96g.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/hadrah', '2026-06-19 03:23:52', '2026-06-19 03:23:52', 'App\\Models\\Article', 'd5f1b860-3d91-4484-b8d3-fe463a0d72f6'),
(51, NULL, 'Hadrah', 'images/pKXpNusHLfmir8RYgpkZMheYh03IhYrR39s6l96g.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/hadrah', '2026-06-19 03:34:22', '2026-06-19 03:34:22', 'App\\Models\\Article', 'd5f1b860-3d91-4484-b8d3-fe463a0d72f6'),
(52, NULL, 'Hadrah', 'images/pKXpNusHLfmir8RYgpkZMheYh03IhYrR39s6l96g.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/hadrah', '2026-06-19 03:36:25', '2026-06-19 03:36:25', 'App\\Models\\Article', 'd5f1b860-3d91-4484-b8d3-fe463a0d72f6'),
(53, NULL, 'Hadrah', 'images/pKXpNusHLfmir8RYgpkZMheYh03IhYrR39s6l96g.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/hadrah', '2026-06-19 03:39:38', '2026-06-19 03:39:38', 'App\\Models\\Article', 'd5f1b860-3d91-4484-b8d3-fe463a0d72f6'),
(54, NULL, 'Hadrah', 'images/pKXpNusHLfmir8RYgpkZMheYh03IhYrR39s6l96g.jpg', 'Gesik', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/hadrah', '2026-06-19 03:41:59', '2026-06-19 03:41:59', 'App\\Models\\Article', 'd5f1b860-3d91-4484-b8d3-fe463a0d72f6'),
(55, 'tes', 'tes kurikuler', 'images/6g8ACLsBH6dVRSH5HrBWY61iwAaRwYQlnCq9b6Jy.png', 'Admin Sekolah', 'index', 'https://be.slbpatriotkotabekasi.sch.id/backend/articles/tes-kurikuler', '2026-06-20 09:12:25', '2026-06-20 09:12:25', 'App\\Models\\Article', '0ce7a99d-145f-4dce-9c69-fe8be79de363'),
(56, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-20 12:47:44', '2026-06-20 12:47:44', 'App\\Models\\Category', 'a58f5ebc-c8ec-48da-b6f9-a80b05ca40a0'),
(57, 'Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?', 'Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?', 'images/QfojvfEegY7UFF07HkRp7xw9nsI4LZNVx92HxNfJ.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/pilates-vs-yoga-apa-bedanya-dan-mana-yang-cocok-untuk-anda', '2026-08-27 04:59:46', '2026-08-27 04:59:46', 'App\\Models\\Article', '63829ea9-8a32-4f82-94e1-7299120f822c'),
(58, 'Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?', 'Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?', 'images/QfojvfEegY7UFF07HkRp7xw9nsI4LZNVx92HxNfJ.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/pilates-vs-yoga-apa-bedanya-dan-mana-yang-cocok-untuk-anda', '2026-08-27 05:02:14', '2026-08-27 05:02:14', 'App\\Models\\Article', '63829ea9-8a32-4f82-94e1-7299120f822c'),
(59, 'Pilates dan yoga sama-sama populer sebagai olahraga yang membantu meningkatkan kebugaran tubuh sekaligus memberikan manfaat bagi pikiran. Keduanya juga dapat dilakukan oleh pemula dan tidak selalu membutuhkan peralatan yang rumit.', 'Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?', 'images/QfojvfEegY7UFF07HkRp7xw9nsI4LZNVx92HxNfJ.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/pilates-vs-yoga-apa-bedanya-dan-mana-yang-cocok-untuk-anda', '2026-08-27 05:50:43', '2026-08-27 05:50:43', 'App\\Models\\Article', '63829ea9-8a32-4f82-94e1-7299120f822c'),
(60, 'Pilates dan yoga sama-sama populer sebagai olahraga yang membantu meningkatkan kebugaran tubuh sekaligus memberikan manfaat bagi pikiran. Keduanya juga dapat dilakukan oleh pemula dan tidak selalu membutuhkan peralatan yang rumit.', 'Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?', 'images/3MeMVIEBB3e5NU9Tm1Ijda7s7iDDcrmdWakjl1C7.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/pilates-vs-yoga-apa-bedanya-dan-mana-yang-cocok-untuk-anda', '2026-08-30 18:12:39', '2026-08-30 18:12:39', 'App\\Models\\Article', '63829ea9-8a32-4f82-94e1-7299120f822c'),
(61, 'Pilates dan yoga sama-sama populer sebagai olahraga yang membantu meningkatkan kebugaran tubuh sekaligus memberikan manfaat bagi pikiran. Keduanya juga dapat dilakukan oleh pemula dan tidak selalu membutuhkan peralatan yang rumit.', 'Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?', 'images/Q21BSTPfei8FVhkubCnpiCxQYWcL7P6XigMY6gBq.jpg', 'super-admin', 'index', 'http://127.0.0.1:8000/backend/articles/pilates-vs-yoga-apa-bedanya-dan-mana-yang-cocok-untuk-anda', '2026-09-01 03:03:46', '2026-09-01 03:03:46', 'App\\Models\\Article', '63829ea9-8a32-4f82-94e1-7299120f822c');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9dUo4i97cT9aKvXqD2Kyk3D7CSpCsybj8icV3YRr', '70e15b9f-535a-42a2-8ea0-9a26ad7952e5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNkRDVXA3WHo4Y1NnRzY3SVhIbXJ0MXFFZEp3Tjl1Q0xqN1ZybHhGdSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NjoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2JhY2tlbmQvcGFja2FnZXMvbWVtYmVycyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYmFja2VuZC9wYWNrYWdlcy9tZW1iZXJzIjtzOjU6InJvdXRlIjtzOjE1OiJwYWNrYWdlcy5tZW1iZXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiNzBlMTViOWYtNTM1YS00MmEyLThlYTAtOWEyNmFkNzk1MmU1Ijt9', 1789274597),
('CI6DmLpZhaoiNvASxAbdjmpqHKNedTlwGFF6uJfD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMHVrVG9JRWhOMTdpRHhkVFJ5TkNvakJMMjNoQW5WUnp0NWV5aXp3biI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789285531),
('e0GmdHo9A0wBgXmj4c0Sp88prZg0txT4vfnm6p5i', '787b72ea-59d0-4d54-848b-c200bddafdd2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQlcyTFNzeTlRY1E1eUl3WWJuQ2o3UXVWQlhpRDVIVGM0TW1JNnFmQyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYmFja2VuZC9wYWNrYWdlcyI7czo1OiJyb3V0ZSI7czoxNDoicGFja2FnZXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiNzg3YjcyZWEtNTlkMC00ZDU0LTg0OGItYzIwMGJkZGFmZGQyIjt9', 1789280039),
('GjGP7UwQCJisTBp9dbcI0qkWzzoke8ZHnCMSitOl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSDdXbTl6MUV3ODNLVHRZNFN6Y3JMRFZnaXVUUGhHSVNnTFM5UTdEdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789274260),
('gY1uHtZzctah1vfGLDYOQg0rqsX0AM5vmptzsslc', '787b72ea-59d0-4d54-848b-c200bddafdd2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSHY4Z1c1YzF1MkFpbWN5YWtIOWFaQXhIYmdyMjBFeTRRNnNTaWowViI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYmFja2VuZC9wYWNrYWdlcy9tZW1iZXJzIjtzOjU6InJvdXRlIjtzOjE1OiJwYWNrYWdlcy5tZW1iZXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiNzg3YjcyZWEtNTlkMC00ZDU0LTg0OGItYzIwMGJkZGFmZGQyIjt9', 1789271251),
('qizAE5JB4AxQ7JH1SXIj5vjVh2qxjl6jB1NSYbLJ', '787b72ea-59d0-4d54-848b-c200bddafdd2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOGU5VURuaFVvYmdUZGNHR0xBZTloRVpBaWF3S0dka3JjaVhaMG9yZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Nzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9iYWNrZW5kL3BhZ2VzLzllNTU4MTVjLWE0ZGQtNGRmMi04Y2I1LTI3ZjdkZTcyNDlmZC9lZGl0IjtzOjU6InJvdXRlIjtzOjEwOiJwYWdlcy5lZGl0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MzY6Ijc4N2I3MmVhLTU5ZDAtNGQ1NC04NDhiLWMyMDBiZGRhZmRkMiI7fQ==', 1789303025),
('soJuCfkmif6nzFnr7MlbStVoGSjMjNQOp2b4rJ9m', '70e15b9f-535a-42a2-8ea0-9a26ad7952e5', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_6_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.6.2 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNGtFRmNoVUU5MkdZNHljaGJldFBvc1lnQmVWYmFHTXlmVDdkM1ZiYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9iYWNrZW5kL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNToiZGFzaGJvYXJkLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MzY6IjcwZTE1YjlmLTUzNWEtNDJhMi04ZWEwLTlhMjZhZDc5NTJlNSI7fQ==', 1789229876),
('ujO2PdpRAMplZmUQJMkFp8sHcVgWUqZ2WDQq5JeC', '787b72ea-59d0-4d54-848b-c200bddafdd2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRW9wQ0RpWVI0Q3JxcXB0UXgzcHBrdHJGQ0Z1QWs3MHh2MFFBaDBKTCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYmFja2VuZC9yb3V0ZSI7czo1OiJyb3V0ZSI7czoxMToicm91dGUuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiNzg3YjcyZWEtNTlkMC00ZDU0LTg0OGItYzIwMGJkZGFmZGQyIjt9', 1789227604);

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`uuid`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
('11e863ef-4739-4bcf-b7d1-d599b336bb09', 'Alignment', 'alignment', 'Focuses on proper body alignment, anatomical awareness, and safe movement to improve posture, stability, body mechanics, and movement efficiency.', 'active', '2026-09-05 08:39:02', '2026-09-05 09:33:48'),
('2146b32e-85f3-4df1-b8c6-4718bd786114', 'Hatha', 'hatha', 'A foundational yoga practice combining physical postures, breathing techniques, and mindful awareness to develop strength, flexibility, balance, and relaxation.', 'active', '2026-08-27 18:05:32', '2026-09-05 08:51:06'),
('28b37aad-a252-4bbf-9284-d25c63047b19', 'Yin Yoga', 'yin-yoga', 'A slow-paced practice involving longer-held postures to gently work with connective tissues, improve flexibility, and encourage deep relaxation.', 'active', '2026-09-05 08:33:45', '2026-09-05 08:51:53'),
('3cddd283-5b50-493a-9cab-cb04eef88946', 'Holistic', 'holistic', 'A whole-person approach integrating movement, breathwork, mindfulness, meditation, and relaxation to support physical, mental, emotional, and overall well-being.', 'active', '2026-09-05 08:39:55', '2026-09-05 08:53:15'),
('4240ba9b-225f-4544-a558-cc4d30ddefa2', 'Breathwork & Meditation', 'breathwork-meditation', 'Combines conscious breathing techniques and meditation practices to develop self-awareness, promote relaxation, improve focus, and cultivate inner balance.', 'active', '2026-09-05 08:36:05', '2026-09-05 08:54:24'),
('50b72628-5cd5-4f8d-937a-a41852efc90d', 'Asthanga', 'asthanga', 'A structured and physically demanding practice based on a progressive sequence of postures, emphasizing strength, flexibility, discipline, and breath control.', 'active', '2026-09-05 08:36:28', '2026-09-05 08:51:39'),
('6b28240c-d7d9-4b09-850b-6dcbb3875c18', 'Restorative', 'restorative', 'A gentle and supportive practice using props to promote deep relaxation, release physical tension, and support the body\'s natural recovery.', 'active', '2026-09-05 08:37:49', '2026-09-05 08:52:31'),
('ae3ca862-ed29-4025-bab9-4caff951820e', 'Prenatal', 'prenatal', 'Yoga adapted for pregnancy to support mobility, strength, relaxation, breathing, and physical comfort throughout the different stages of pregnancy.', 'active', '2026-09-05 08:38:07', '2026-09-05 08:53:47'),
('cd60d5c4-b89e-42cd-bafb-b10ded0538ec', 'Vinyasa', 'vinyasa', 'A dynamic practice that connects movement with breath through flowing sequences, helping improve strength, mobility, coordination, and body awareness.', 'active', '2026-08-27 18:06:33', '2026-09-05 08:51:22');

-- --------------------------------------------------------

--
-- Table structure for table `studios`
--

CREATE TABLE `studios` (
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `google_maps_url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `studios`
--

INSERT INTO `studios` (`uuid`, `name`, `slug`, `excerpt`, `description`, `address`, `phone`, `email`, `google_maps_url`, `image`, `status`, `created_at`, `updated_at`) VALUES
('363f49dc-b34f-4ac2-ad18-95b140c6335e', 'Yoga Roots Studio', 'yoga-roots-studio', NULL, 'At Yoga Roots Studio, we see yoga as a journey of connection — between the body, mind, and breath. Through thoughtful guidance, you’ll deepen your practice, refine your understanding of each posture, and cultivate greater clarity, balance, and inner peace.', 'Roots Prasasta Building, Jl. Kawi Raya No.37, RT.6/RW.2, Guntur, Setiabudi, South Jakarta City, Jakarta 12980', '0813-2122-1270', 'info@yogaroots.id', NULL, 'studios/Pf3qptHBGxeJgryUNs5MdFVtEKADalPo5BdeNtqy.webp', 'active', '2026-09-08 18:30:24', '2026-09-08 18:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `uuid` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `isi_testimoni` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`uuid`, `nama`, `jabatan`, `isi_testimoni`, `foto`, `urutan`, `is_active`, `created_at`, `updated_at`) VALUES
('267d9987-ea8e-422a-a32d-a26e7e9cea0f', 'Fhadillah Cherly Yunanda', 'Member Since 2024', 'Best yoga place in jkt so far! Very clean, very nice lighting with natural sunlight, and the most important thing - so engaging instructor! Will be back offf course!!!', 'testimoni/ObU2uLK401gA8ZvTKHaLiWZd9Ve4AVloUD1T15PJ.jpg', 2, 'active', '2026-09-11 00:21:17', '2026-09-11 00:21:53'),
('8a7bbb78-eb33-4f1b-941c-cbdcd2b9c5a3', 'Jessica Gloria Mogi', 'Member Since 2024', 'The studio was beautiful, plenty of natural sunlight, it was not stuffy at all. They have a minimalist shower with some skincare products and medium-sized lockers. It\'s a great experience and I\'m coming back tomorrow :)', 'testimoni/6HcmtKnmhk7z2RoV1BkNkQSBo1xrbCbGCC0LBzvx.jpg', 1, 'active', '2026-09-11 00:19:26', '2026-09-11 00:19:44'),
('dcfd5ae2-e3a0-4c4b-a3c4-937af0a086d7', 'Melda Auditia', 'Member Since 2025', 'Amazing experience. Great instructor. Space is quiet, beautiful & clean, with nice shower room for yoga before work. Would definitely come back again👍🏻', 'testimoni/B4JRMECCVIhAeVGY9yo8duoZzS6l4njN4IknQ7Mu.jpg', 3, 'active', '2026-09-11 00:22:56', '2026-09-11 00:23:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kecamatan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kelurahan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya') DEFAULT NULL,
  `pengalaman` varchar(255) DEFAULT NULL,
  `is_active` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `biografi` text DEFAULT NULL,
  `package_uuid` char(36) DEFAULT NULL,
  `sumber_informasi` enum('google','sosmed','friend','community','event','website','other') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uuid`, `name`, `no_hp`, `alamat`, `kecamatan_id`, `kelurahan_id`, `avatar`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `google_id`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `pengalaman`, `is_active`, `deleted_at`, `facebook`, `instagram`, `twitter`, `tiktok`, `youtube`, `biografi`, `package_uuid`, `sumber_informasi`) VALUES
('0ba0b18a-64e7-44ce-8042-8b282ab9c5b3', 'Stella', '6281321221189', NULL, NULL, NULL, 'avatars/9PmebLAmtzYHiguvCksa3jhkQXhIDZwzeOzA8Lkv.jpg', 'stella@yogaroots.id', '2026-09-10 19:16:05', '$2y$12$XTedTKKKf5hI8GCp6n9KQ.rMl9po5GSegd8GVucZUkef3lXRUHG1y', NULL, '2026-09-10 19:16:05', '2026-09-10 19:20:42', NULL, NULL, 'dasd', '2026-09-11', 'P', 'Lainnya', '5 years', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'With a practice spanning nearly three decades, Stella brings depth, versatility, and a deeply inclusive spirit to her teaching. Her Vinyasa classes flow with clarity and purpose, while her extensive training allows her to thoughtfully adapt yoga for different bodies, ages, and needs—from beginners and children to seniors, prenatal students, and those working with specific conditions. She believes yoga is ultimately about more than the body; it is a practice that can create meaningful and lasting change from within. Having first stepped onto a yoga mat in Jakarta in 1998, Stella has witnessed the practice evolve—and continues to share it with the same curiosity and dedication.', NULL, NULL),
('4a85c36a-caa6-4cc9-9ab6-47f77c0a9a67', 'Andrea', '6281321221270', NULL, NULL, NULL, 'avatars/NVMVFyR5dLWAggqVdWc1fMVclwK346qZrgu14qMo.png', 'andrea@yogaroots.id', '2026-09-10 19:18:50', '$2y$12$VOU976RIB.YtryiO5x/FLOUT3t4Y1F.lj157lKfmsfniGJdEuTrYq', NULL, '2026-09-10 19:18:50', '2026-09-10 19:20:27', NULL, NULL, 'dsad', '2026-09-11', 'P', 'Lainnya', '4 years', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Andrea’s yoga journey began as a personal quest to navigate life’s everyday pressures in her career as a researcher. She has experienced firsthand how mindfulness can nurture inner peace and a more compassionate, purpose-driven life—both on and off the mat.', NULL, NULL),
('57621d3c-c299-4cd2-b96a-9b887752cb73', 'Yogaroots.id', NULL, NULL, NULL, NULL, NULL, 'tapayoga@yogaroots.id', '2026-09-11 07:41:34', '$2y$12$vgbZekTedJzp2ClDwMQrTOv4QFSMZuQBWukJ23jHyIwSfHx47jbNS', NULL, '2026-09-06 04:46:09', '2026-09-11 07:41:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('70e15b9f-535a-42a2-8ea0-9a26ad7952e5', 'Wiku Pramesthi Bagaswara', '085691333321', 'jalan gandaria selatan', NULL, NULL, 'avatars/r5YzPXmlkmO6PaSdbPUjr1dL5J9LoYUYVu5eWW9v.jpg', 'wikupb@gmail.com', '2026-09-04 07:49:02', '$2y$12$WXO13gY21gOqgS1s7M743.Oe5UdAxQDykEbmTf0xJ2LnyNdPMzsj6', NULL, '2025-11-12 03:39:36', '2026-09-12 12:28:04', NULL, NULL, 'Pati', '1992-03-30', 'L', 'Islam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01a06234-aac1-722c-84d6-c46d4150e70f', 'website'),
('755e0eaa-50e4-46db-9003-7c1fc6674876', 'Margaretta', NULL, NULL, NULL, NULL, 'avatars/5qVq34VWSWBHYl4FgxzeSZqIEYRFotuSvA6qswLA.jpg', 'margaretta@yogaroots.id', '2026-09-10 19:09:33', '$2y$12$QxXHeDYBv0huosR6U1kUEe2Hq4uDAsdqJlo98wJhBbMiYRpAeZqKu', NULL, '2026-09-10 19:09:33', '2026-09-10 19:21:22', NULL, NULL, 'dasdas', '2026-09-11', 'P', 'Lainnya', '5 years', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'With a practice grounded in Hatha and Ashtanga, and refined through the precision of Iyengar alignment, Margaretta brings a thoughtful and therapeutic approach to teaching. Her work is especially focused on supporting the body through injury, recovery, and the transformative journey of pregnancy. She believes yoga is not about performance, but about creating a deeper relationship with the body, breath, and mind—small practices that can quietly transform the way we move through everyday life. Beyond the mat, she continues to explore holistic approaches to wellbeing through Access Bars and Qi Gong.', NULL, NULL),
('787b72ea-59d0-4d54-848b-c200bddafdd2', 'super-admin', NULL, 'Jl. Gandaria', 4, 17, 'avatars/u5KMRU9jG95SYcdq0vhxnksQ0EFatee9WxrPxrtH.jpg', 'super@admin.com', '2025-09-16 00:23:37', '$2y$12$PRZJcd.nlREU6NRq3jvIVemYmlwxVPTb7En4URyNgyQSfKjWUzwDi', 'qNq8WvehXO6UDTuFBqMxGlKn8mCpYdb4irCGUh0egIDdq84RUvIIfzRB72WB', '2025-09-16 00:23:37', '2026-09-06 23:43:32', NULL, NULL, 'dasda', '2025-09-24', 'P', 'Lainnya', '10 tahun', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sdsddsad', NULL, NULL),
('95294c43-b3d8-4b46-b938-e4eea1f3a359', 'Soni', '8534324202', 'sdcsddfs', NULL, NULL, 'avatars/ImiYBm1Cjs7Sw0eCNBO1Dz6w5XDpNYBWnxoPy5Yc.jpg', 'soni@yogaroots.id', '2026-09-03 18:34:37', '$2y$12$jj/33jNGDxqzXGloYFeLMO5mozoP0v2atkzwf/S7ogXydL8n1hf4G', NULL, '2026-09-03 18:34:37', '2026-09-06 23:44:15', NULL, NULL, 'dasdas', '2026-09-04', 'L', 'Kristen', '20 years', '2026-09-04', NULL, NULL, NULL, NULL, NULL, NULL, 'Soni is a certified RIMYI Introductory Level 2 yoga teacher with over 20 years of experience. His athletic background includes sepak takraw and college hockey, which inspired his path to becoming a sports teacher. His extensive experience allows him to skillfully guide and mentor his students, nurturing them into better practitioners. Join him on a transformative yoga journey, where his years of experience and unwavering dedication are at your service, helping you thrive as a yoga student', NULL, NULL),
('b497082d-dd9f-4d1c-a611-9e1331eb5393', 'Ophellia', NULL, NULL, NULL, NULL, 'avatars/Mo3tGjHS10BSdIshei0ejPknsfvfxj0tiTxNg1xF.png', 'ophellia@yogaroots.id', '2026-09-10 19:24:15', '$2y$12$EYxioqiLzM1FKBBE0XsTzeEX41St.5ocxnaLflhUHOHd0JMAY.yX.', NULL, '2026-09-10 19:24:15', '2026-09-10 19:24:15', NULL, NULL, 'dsad', '2026-09-24', 'L', 'Lainnya', '4 years', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Rooted in mindful movement and conscious alignment, her teaching invites students to cultivate greater awareness, presence, and ease in their practice. With over 800 hours of yoga education and teacher training, she has studied Yoga Fundamentals at Iyengar Yoga Institute Indonesia. Since April 2024, she has been part of the Yoga Roots teaching community, offering a grounded and attentive approach to every practice.', NULL, NULL),
('b55eb675-019c-4fa5-936e-579e2835527d', 'Yuniar', NULL, NULL, NULL, NULL, 'avatars/XjtPl3c2Q5k9OB5ukHIJRmwX2o6vdiPX465T0uZy.jpg', 'yuniar@yogaroots.id', '2026-09-10 19:07:05', '$2y$12$10Z.D3afA7m8Dlt16WfINORNIOzHJadrDcJCx.RChxCnRvlm.oikO', NULL, '2026-09-10 19:07:05', '2026-09-10 19:07:05', NULL, NULL, 'dsad', '2026-09-11', 'P', 'Islam', '20 years', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'With a practice rooted in Iyengar Yoga, Yuniar brings warmth, clarity, and a natural sense of ease to her teaching. She began practising and teaching in 2007, and since then has dedicated her practice to helping students feel at home on the mat. With a particular strength in alignment and beginner guidance, her classes offer a welcoming space to begin—or begin again—with curiosity and confidence. Her teaching is natural, friendly, and joyful, inviting each student to discover that yoga can be both precise and deeply personal.', NULL, NULL),
('beaaf326-874c-48c2-b6b8-6bbe655c4df2', 'Sita Manwani', NULL, NULL, NULL, NULL, 'avatars/5xS7NpjOu3vPmgLh75j4rPpNSRWDr2JDAxYD2v1c.jpg', 'sita@yogaroots.id', '2026-09-10 19:13:42', '$2y$12$D7l1Tg6O9KnxTkHWNKOsouAYcxoTVuqDxqg3Zi9LDtFibOdlO1lw6', NULL, '2026-09-10 19:13:42', '2026-09-10 23:58:20', NULL, NULL, 'dasdas', '2026-09-11', 'P', 'Lainnya', '10 years', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sita is a dedicated and certified yoga teacher with a journey that began at the Art of Living Foundation in 2006. There, she completed the Sri Sri Yoga Teachers Training Course and subsequently became an Art of Living teacher, where she learned how to teach Sudarshan Kriya breathwork. She holds accreditation from the Iyengar Yoga Institute and certifications from both the Sri Sri School of Yoga and the Indian Yoga Association. Her strong belief in yoga\'s potential to unlock the meditative mind\'s power and enhance life drives her passion. As the senior instructor at Yoga Roots, she leads the beginner yoga classes and the SKY breath work classes.\r\n\r\nSita has just completed 100hour Advanced Yoga Teacher Training including Traditional Chinese Medicine Principles, 5 Elements Theory, applied Meridian Sequences for Mandala Vinyasa System and Osteo - Thai Massage.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_packages`
--

CREATE TABLE `user_packages` (
  `uuid` char(36) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `package_uuid` char(36) NOT NULL,
  `order_uuid` char(36) DEFAULT NULL,
  `quota` int(10) UNSIGNED DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_specialization`
--

CREATE TABLE `user_specialization` (
  `uuid` char(36) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `specialization_uuid` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_specialization`
--

INSERT INTO `user_specialization` (`uuid`, `user_uuid`, `specialization_uuid`, `created_at`, `updated_at`) VALUES
('012ddcb9-f54e-46ef-a934-a9598fe92d78', '755e0eaa-50e4-46db-9003-7c1fc6674876', '2146b32e-85f3-4df1-b8c6-4718bd786114', NULL, NULL),
('0a8a1ddd-3bc4-454d-83e2-75e1e6757166', '0ba0b18a-64e7-44ce-8042-8b282ab9c5b3', '3cddd283-5b50-493a-9cab-cb04eef88946', NULL, NULL),
('2be9213a-c244-40ae-aad4-608e2a68a7d5', 'b55eb675-019c-4fa5-936e-579e2835527d', '11e863ef-4739-4bcf-b7d1-d599b336bb09', NULL, NULL),
('566affb7-3d73-4746-bf50-c4d4f22471e8', '755e0eaa-50e4-46db-9003-7c1fc6674876', '50b72628-5cd5-4f8d-937a-a41852efc90d', NULL, NULL),
('73bdbe77-22b2-406c-9a95-d2e23ba60294', '95294c43-b3d8-4b46-b938-e4eea1f3a359', '11e863ef-4739-4bcf-b7d1-d599b336bb09', NULL, NULL),
('8e72d2bf-17c2-4bdf-b23c-92b0b4513a2f', '787b72ea-59d0-4d54-848b-c200bddafdd2', '50b72628-5cd5-4f8d-937a-a41852efc90d', NULL, NULL),
('90cdacd4-a8a3-430b-9635-ae84f965a508', '4a85c36a-caa6-4cc9-9ab6-47f77c0a9a67', '28b37aad-a252-4bbf-9284-d25c63047b19', NULL, NULL),
('a9a97c94-7453-46dd-a663-96a5611664c9', 'beaaf326-874c-48c2-b6b8-6bbe655c4df2', 'cd60d5c4-b89e-42cd-bafb-b10ded0538ec', NULL, NULL),
('ae1928ba-912e-4816-b32a-9e02d137f9ba', 'b497082d-dd9f-4d1c-a611-9e1331eb5393', '11e863ef-4739-4bcf-b7d1-d599b336bb09', NULL, NULL),
('bcea797f-fbe6-4100-affa-90d9fd25eb2a', '95294c43-b3d8-4b46-b938-e4eea1f3a359', '50b72628-5cd5-4f8d-937a-a41852efc90d', NULL, NULL),
('c967bcae-b240-45bd-9030-36cc68ce2a64', '95294c43-b3d8-4b46-b938-e4eea1f3a359', 'ae3ca862-ed29-4025-bab9-4caff951820e', NULL, NULL),
('e5aea86d-50ab-4dc6-a2ab-f10c679f5fe5', '787b72ea-59d0-4d54-848b-c200bddafdd2', '4240ba9b-225f-4544-a558-cc4d30ddefa2', NULL, NULL),
('e78a95e8-373a-4d30-96ee-9eefb6494f78', '787b72ea-59d0-4d54-848b-c200bddafdd2', '2146b32e-85f3-4df1-b8c6-4718bd786114', NULL, NULL),
('eea1d83f-fdaa-4f95-9639-0ec981610d07', '755e0eaa-50e4-46db-9003-7c1fc6674876', 'cd60d5c4-b89e-42cd-bafb-b10ded0538ec', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_user_uuid_foreign` (`user_uuid`),
  ADD KEY `articles_category_uuid_foreign` (`category_uuid`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `classes_slug_unique` (`slug`),
  ADD KEY `classes_instructor_uuid_index` (`instructor_uuid`),
  ADD KEY `classes_is_active_index` (`is_active`);

--
-- Indexes for table `class_bookings`
--
ALTER TABLE `class_bookings`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `class_bookings_user_uuid_status_index` (`user_uuid`,`status`),
  ADD KEY `class_bookings_class_schedule_uuid_status_index` (`class_schedule_uuid`,`status`),
  ADD KEY `class_bookings_package_uuid_index` (`package_uuid`),
  ADD KEY `class_bookings_order_uuid_index` (`order_uuid`);

--
-- Indexes for table `class_schedules`
--
ALTER TABLE `class_schedules`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `class_schedules_class_uuid_date_index` (`class_uuid`,`day`),
  ADD KEY `class_schedules_date_status_index` (`day`,`status`);

--
-- Indexes for table `disabilities`
--
ALTER TABLE `disabilities`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `disabilities_name_unique` (`name`),
  ADD UNIQUE KEY `disabilities_slug_unique` (`slug`);

--
-- Indexes for table `ebooks`
--
ALTER TABLE `ebooks`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `file_downloads`
--
ALTER TABLE `file_downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kecamatans`
--
ALTER TABLE `kecamatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelurahans`
--
ALTER TABLE `kelurahans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelurahans_kecamatan_id_foreign` (`kecamatan_id`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `menu_groups`
--
ALTER TABLE `menu_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_uuid_status_index` (`user_uuid`,`status`),
  ADD KEY `orders_package_uuid_index` (`package_uuid`),
  ADD KEY `orders_class_schedule_uuid_index` (`class_schedule_uuid`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `packages_slug_unique` (`slug`),
  ADD KEY `packages_is_active_index` (`is_active`),
  ADD KEY `packages_is_popular_index` (`is_popular`);

--
-- Indexes for table `package_features`
--
ALTER TABLE `package_features`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `package_features_package_uuid_index` (`package_uuid`);

--
-- Indexes for table `package_options`
--
ALTER TABLE `package_options`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `package_options_package_uuid_index` (`package_uuid`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`),
  ADD KEY `pages_user_uuid_foreign` (`user_uuid`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `payments_transaction_id_index` (`transaction_id`),
  ADD KEY `payments_order_uuid_status_index` (`order_uuid`,`status`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `poll_votes`
--
ALTER TABLE `poll_votes`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `poll_votes_poll_uuid_foreign` (`poll_uuid`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `programs_disability_uuid_foreign` (`specializaty_uuid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seo_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `specializations_name_unique` (`name`),
  ADD UNIQUE KEY `specializations_slug_unique` (`slug`);

--
-- Indexes for table `studios`
--
ALTER TABLE `studios`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `studios_slug_unique` (`slug`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_no_hp_unique` (`no_hp`),
  ADD KEY `users_kecamatan_id_foreign` (`kecamatan_id`),
  ADD KEY `users_kelurahan_id_foreign` (`kelurahan_id`),
  ADD KEY `users_package_uuid_index` (`package_uuid`),
  ADD KEY `users_membership_status_index` (`sumber_informasi`);

--
-- Indexes for table `user_packages`
--
ALTER TABLE `user_packages`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `user_packages_user_uuid_status_index` (`user_uuid`,`status`),
  ADD KEY `user_packages_package_uuid_index` (`package_uuid`),
  ADD KEY `user_packages_order_uuid_index` (`order_uuid`),
  ADD KEY `user_packages_expired_at_index` (`expired_at`);

--
-- Indexes for table `user_specialization`
--
ALTER TABLE `user_specialization`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `user_specialization_user_uuid_specialization_uuid_unique` (`user_uuid`,`specialization_uuid`),
  ADD KEY `user_specialization_specialization_uuid_foreign` (`specialization_uuid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_downloads`
--
ALTER TABLE `file_downloads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kecamatans`
--
ALTER TABLE `kecamatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kelurahans`
--
ALTER TABLE `kelurahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `menu_groups`
--
ALTER TABLE `menu_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `seo`
--
ALTER TABLE `seo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_category_uuid_foreign` FOREIGN KEY (`category_uuid`) REFERENCES `categories` (`uuid`) ON DELETE SET NULL,
  ADD CONSTRAINT `articles_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_instructor_uuid_foreign` FOREIGN KEY (`instructor_uuid`) REFERENCES `users` (`uuid`) ON DELETE SET NULL;

--
-- Constraints for table `class_bookings`
--
ALTER TABLE `class_bookings`
  ADD CONSTRAINT `class_bookings_class_schedule_uuid_foreign` FOREIGN KEY (`class_schedule_uuid`) REFERENCES `class_schedules` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_bookings_order_uuid_foreign` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`uuid`) ON DELETE SET NULL,
  ADD CONSTRAINT `class_bookings_package_uuid_foreign` FOREIGN KEY (`package_uuid`) REFERENCES `packages` (`uuid`) ON DELETE SET NULL,
  ADD CONSTRAINT `class_bookings_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `class_schedules`
--
ALTER TABLE `class_schedules`
  ADD CONSTRAINT `class_schedules_class_uuid_foreign` FOREIGN KEY (`class_uuid`) REFERENCES `classes` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `kelurahans`
--
ALTER TABLE `kelurahans`
  ADD CONSTRAINT `kelurahans_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_class_schedule_uuid_foreign` FOREIGN KEY (`class_schedule_uuid`) REFERENCES `class_schedules` (`uuid`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_package_uuid_foreign` FOREIGN KEY (`package_uuid`) REFERENCES `packages` (`uuid`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `package_features`
--
ALTER TABLE `package_features`
  ADD CONSTRAINT `package_features_package_uuid_foreign` FOREIGN KEY (`package_uuid`) REFERENCES `packages` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `package_options`
--
ALTER TABLE `package_options`
  ADD CONSTRAINT `package_options_package_uuid_foreign` FOREIGN KEY (`package_uuid`) REFERENCES `packages` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_uuid_foreign` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `poll_votes`
--
ALTER TABLE `poll_votes`
  ADD CONSTRAINT `poll_votes_poll_uuid_foreign` FOREIGN KEY (`poll_uuid`) REFERENCES `polls` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_disability_uuid_foreign` FOREIGN KEY (`specializaty_uuid`) REFERENCES `disabilities` (`uuid`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_kelurahan_id_foreign` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_package_uuid_foreign` FOREIGN KEY (`package_uuid`) REFERENCES `packages` (`uuid`) ON DELETE SET NULL;

--
-- Constraints for table `user_packages`
--
ALTER TABLE `user_packages`
  ADD CONSTRAINT `user_packages_order_uuid_foreign` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`uuid`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_packages_package_uuid_foreign` FOREIGN KEY (`package_uuid`) REFERENCES `packages` (`uuid`),
  ADD CONSTRAINT `user_packages_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `user_specialization`
--
ALTER TABLE `user_specialization`
  ADD CONSTRAINT `user_specialization_specialization_uuid_foreign` FOREIGN KEY (`specialization_uuid`) REFERENCES `specializations` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_specialization_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
