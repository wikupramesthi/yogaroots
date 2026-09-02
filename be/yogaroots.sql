-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2026 at 12:32 AM
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
('63829ea9-8a32-4f82-94e1-7299120f822c', '787b72ea-59d0-4d54-848b-c200bddafdd2', '2162d145-9ef3-4e2f-8c55-81971a015bc5', 'Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?', 'pilates-vs-yoga-apa-bedanya-dan-mana-yang-cocok-untuk-anda', 'Pilates dan yoga sama-sama populer sebagai olahraga yang membantu meningkatkan kebugaran tubuh sekaligus memberikan manfaat bagi pikiran. Keduanya juga dapat dilakukan oleh pemula dan tidak selalu membutuhkan peralatan yang rumit.', '<p><strong>Pilates vs Yoga: Apa Bedanya dan Mana yang Cocok untuk Anda?</strong></p>\r\n\r\n<p>Pilates dan yoga sama-sama populer sebagai olahraga yang membantu meningkatkan kebugaran tubuh sekaligus memberikan manfaat bagi pikiran. Keduanya juga dapat dilakukan oleh pemula dan tidak selalu membutuhkan peralatan yang rumit.</p>\r\n\r\n<p>Namun, <strong>Pilates dan yoga memiliki beberapa perbedaan</strong>, mulai dari tujuan latihan, teknik gerakan, fokus tubuh, hingga pendekatan terhadap pernapasan. Lalu, mana yang lebih cocok untuk Anda?</p>\r\n\r\n<p>Berikut pembahasan lengkap mengenai perbedaan Pilates dan yoga agar Anda dapat menentukan jenis latihan yang sesuai dengan kebutuhan dan tujuan kebugaran Anda.</p>\r\n\r\n<p><strong>Apa Itu Yoga?</strong></p>\r\n\r\n<p>Yoga adalah latihan yang menggabungkan gerakan tubuh, pengaturan pernapasan, konsentrasi, dan relaksasi. Yoga memiliki berbagai jenis dan tingkat intensitas, mulai dari latihan yang lembut hingga latihan yang cukup dinamis.</p>\r\n\r\n<p>Selain membantu menjaga kebugaran tubuh, yoga dapat membantu meningkatkan fleksibilitas, keseimbangan, mobilitas, serta membantu tubuh menjadi lebih rileks.</p>\r\n\r\n<p>Beberapa jenis yoga yang populer antara lain:</p>\r\n\r\n<ul>\r\n    <li><strong>Hatha Yoga</strong>, dengan gerakan yang relatif terstruktur dan cocok untuk mengenal dasar-dasar yoga.</li>\r\n    <li><strong>Vinyasa Yoga</strong>, yang menghubungkan gerakan dengan ritme pernapasan secara lebih dinamis.</li>\r\n    <li><strong>Yin Yoga</strong>, yang menggunakan posisi tertentu dalam durasi lebih lama untuk melatih fleksibilitas.</li>\r\n    <li><strong>Restorative Yoga</strong>, yang berfokus pada relaksasi dengan gerakan yang lebih lembut.</li>\r\n</ul>\r\n\r\n<p><strong>Apa Itu Pilates?</strong></p>\r\n\r\n<p>Pilates merupakan latihan yang berfokus pada kontrol gerakan, stabilitas tubuh, kekuatan otot inti atau <strong>core</strong>, serta postur.</p>\r\n\r\n<p>Gerakan Pilates biasanya dilakukan secara terkontrol dan membutuhkan konsentrasi terhadap posisi tubuh serta teknik pernapasan.</p>\r\n\r\n<p>Pilates dapat dilakukan menggunakan matras maupun peralatan tertentu. Mat Pilates, misalnya, dapat dilakukan tanpa peralatan besar sehingga relatif mudah dimasukkan ke dalam rutinitas olahraga.</p>\r\n\r\n<p>Latihan Pilates banyak menekankan penggunaan otot core sehingga dapat membantu membangun kesadaran terhadap postur dan kontrol tubuh.</p>\r\n\r\n<p><strong>Perbedaan Yoga dan Pilates</strong></p>\r\n\r\n<p>Meskipun terlihat mirip, yoga dan Pilates memiliki fokus latihan yang berbeda. Berikut beberapa perbedaan utamanya.</p>\r\n\r\n<p><strong>1. Fokus Latihan</strong></p>\r\n\r\n<p>Yoga memiliki pendekatan yang lebih luas dengan menggabungkan latihan fisik, pernapasan, konsentrasi, relaksasi, dan kesadaran tubuh.</p>\r\n\r\n<p>Sementara itu, Pilates lebih menitikberatkan pada kontrol gerakan, stabilitas, kekuatan core, dan postur tubuh.</p>\r\n\r\n<p><strong>2. Fleksibilitas</strong></p>\r\n\r\n<p>Yoga umumnya sangat erat kaitannya dengan latihan fleksibilitas. Berbagai posisi yoga dapat membantu tubuh bergerak melalui rentang gerak yang lebih luas secara bertahap.</p>\r\n\r\n<p>Pilates juga melibatkan gerakan yang dapat membantu mobilitas dan fleksibilitas, tetapi fokus utamanya bukan hanya pada kelenturan tubuh.</p>\r\n\r\n<p><strong>3. Kekuatan Core</strong></p>\r\n\r\n<p>Pilates sangat dikenal dengan latihan yang melibatkan otot core. Banyak gerakannya membutuhkan stabilisasi bagian tengah tubuh agar gerakan dapat dilakukan dengan tepat.</p>\r\n\r\n<p>Yoga juga melatih core, terutama pada berbagai pose yang membutuhkan keseimbangan dan stabilitas. Namun, fokusnya dapat berbeda tergantung jenis yoga yang dilakukan.</p>\r\n\r\n<p><strong>4. Pernapasan</strong></p>\r\n\r\n<p>Pernapasan merupakan bagian penting dalam yoga. Pengaturan napas digunakan untuk membantu konsentrasi, mengontrol gerakan, dan menciptakan kondisi tubuh yang lebih rileks.</p>\r\n\r\n<p>Dalam Pilates, pernapasan juga penting dan digunakan untuk membantu kontrol serta koordinasi gerakan.</p>\r\n\r\n<p><strong>5. Relaksasi</strong></p>\r\n\r\n<p>Yoga umumnya memberikan perhatian lebih besar terhadap relaksasi, meditasi, dan kesadaran tubuh.</p>\r\n\r\n<p>Pilates lebih berorientasi pada latihan fisik dan kontrol gerakan, meskipun latihan yang dilakukan dengan fokus dan teratur juga dapat membantu tubuh terasa lebih rileks setelah berolahraga.</p>\r\n\r\n<p><strong>Pilates vs Yoga: Mana yang Lebih Baik?</strong></p>\r\n\r\n<p>Tidak ada jawaban bahwa Pilates selalu lebih baik daripada yoga, atau sebaliknya. Pilihan terbaik bergantung pada tujuan, preferensi, dan kebutuhan masing-masing orang.</p>\r\n\r\n<p>Jika Anda ingin meningkatkan fleksibilitas, melatih keseimbangan, sekaligus mendapatkan latihan yang menggabungkan gerakan dan relaksasi, <strong>yoga dapat menjadi pilihan yang menarik</strong>.</p>\r\n\r\n<p>Jika tujuan utama Anda adalah meningkatkan kekuatan core, kontrol tubuh, dan kesadaran terhadap postur, <strong>Pilates dapat menjadi pilihan yang sesuai</strong>.</p>\r\n\r\n<p>Namun, keduanya juga dapat dikombinasikan. Yoga dan Pilates memiliki karakteristik latihan yang berbeda sehingga dapat saling melengkapi dalam rutinitas kebugaran.</p>\r\n\r\n<p><strong>Yoga Cocok untuk Siapa?</strong></p>\r\n\r\n<p>Yoga dapat menjadi pilihan bagi Anda yang ingin:</p>\r\n\r\n<ul>\r\n    <li>Meningkatkan fleksibilitas tubuh.</li>\r\n    <li>Melatih keseimbangan dan mobilitas.</li>\r\n    <li>Meningkatkan kesadaran terhadap tubuh dan pernapasan.</li>\r\n    <li>Melakukan aktivitas fisik dengan intensitas yang dapat disesuaikan.</li>\r\n    <li>Menambahkan latihan relaksasi dalam rutinitas harian.</li>\r\n    <li>Memulai aktivitas olahraga secara bertahap.</li>\r\n</ul>\r\n\r\n<p><strong>Pilates Cocok untuk Siapa?</strong></p>\r\n\r\n<p>Pilates dapat menjadi pilihan bagi Anda yang ingin:</p>\r\n\r\n<ul>\r\n    <li>Melatih kekuatan otot core.</li>\r\n    <li>Meningkatkan kontrol gerakan.</li>\r\n    <li>Meningkatkan kesadaran terhadap postur tubuh.</li>\r\n    <li>Melatih stabilitas dan koordinasi.</li>\r\n    <li>Melakukan latihan dengan gerakan yang terkontrol.</li>\r\n</ul>\r\n\r\n<p><strong>Apakah Yoga dan Pilates Bisa Dilakukan Bersamaan?</strong></p>\r\n\r\n<p>Tentu saja. Yoga dan Pilates dapat menjadi kombinasi latihan yang menarik.</p>\r\n\r\n<p>Pilates dapat membantu melatih kekuatan dan stabilitas tubuh, sedangkan yoga dapat memberikan latihan fleksibilitas, keseimbangan, mobilitas, serta relaksasi.</p>\r\n\r\n<p>Anda dapat melakukan Pilates pada beberapa hari dalam seminggu dan menambahkan sesi yoga pada hari lainnya. Frekuensi dan intensitas latihan sebaiknya disesuaikan dengan kemampuan tubuh dan rutinitas masing-masing.</p>\r\n\r\n<p><strong>Tips Memilih Yoga atau Pilates</strong></p>\r\n\r\n<p>Sebelum memilih, coba tentukan tujuan utama Anda.</p>\r\n\r\n<p><strong>Pilih yoga jika Anda lebih tertarik pada:</strong></p>\r\n\r\n<ul>\r\n    <li>Fleksibilitas.</li>\r\n    <li>Keseimbangan.</li>\r\n    <li>Mobilitas.</li>\r\n    <li>Pernapasan.</li>\r\n    <li>Relaksasi dan mindfulness.</li>\r\n</ul>\r\n\r\n<p><strong>Pertimbangkan Pilates jika Anda lebih tertarik pada:</strong></p>\r\n\r\n<ul>\r\n    <li>Kekuatan core.</li>\r\n    <li>Stabilitas tubuh.</li>\r\n    <li>Kontrol gerakan.</li>\r\n    <li>Postur.</li>\r\n    <li>Latihan fisik yang terstruktur.</li>\r\n</ul>\r\n\r\n<p>Jika masih bingung, tidak ada salahnya mencoba keduanya. Pengalaman langsung dapat membantu Anda mengetahui latihan mana yang paling nyaman dan sesuai dengan kebutuhan Anda.</p>\r\n\r\n<p><strong>Kesimpulan</strong></p>\r\n\r\n<p>Jadi, <strong>apa perbedaan Pilates dan yoga?</strong> Secara sederhana, yoga memiliki pendekatan yang lebih luas dengan menggabungkan gerakan, pernapasan, keseimbangan, fleksibilitas, dan relaksasi. Sementara itu, Pilates lebih berfokus pada kontrol gerakan, stabilitas, kekuatan core, dan postur.</p>\r\n\r\n<p>Keduanya sama-sama dapat menjadi bagian dari gaya hidup aktif. Yang terpenting adalah memilih latihan yang sesuai dengan tujuan dan dapat dilakukan secara konsisten.</p>\r\n\r\n<p>Jika Anda ingin mencoba yoga, mulailah dari kelas yang sesuai dengan tingkat kemampuan Anda. Dengan instruktur yang tepat, Anda dapat mempelajari teknik dasar dengan lebih nyaman dan membangun kebiasaan latihan secara bertahap.</p>\r\n\r\n<p><strong>Siap Mencoba Yoga?</strong></p>\r\n\r\n<p>Temukan kelas yoga yang sesuai dengan kebutuhan dan tingkat kemampuan Anda. Mulai perjalanan menuju tubuh yang lebih aktif, fleksibel, dan seimbang bersama kelas yoga yang tepat.</p>', 'images/Q21BSTPfei8FVhkubCnpiCxQYWcL7P6XigMY6gBq.jpg', '2026-08-26 17:00:00', 34, 'yoga, tips yogaaa', 'published', 'index', NULL, NULL, '2026-08-27 04:59:46', '2026-09-01 03:03:46', NULL);

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
('c2440bb7-4270-4a1d-ae6c-aba760eb61a8', 'galeri 1', 'galeri 1', NULL, 'banners/NHIBYmp56rvr9ZqG5RwsCraI33gsYg2iLrD9Z7DS.webp', 'galeri', 'active', '2026-08-27 07:09:13', '2026-08-30 18:13:40'),
('f7bd2370-bdad-42dc-909b-1239c040d0d3', 'galeri 2', 'Galeri 2', NULL, 'banners/tG6aNvSSYGlHwKd30UitAQ47YJkCibJKS8kwbLff.webp', 'galeri', 'active', '2026-08-27 07:30:55', '2026-08-30 18:13:47');

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
('contact_captcha_04bfa788-8780-407a-810f-7fe014dbc05c', 'i:8;', 1787908679),
('contact_captcha_0e678328-766a-46d9-b4b7-09abaa6f413b', 'i:15;', 1787908003),
('contact_captcha_145f68e2-4302-470c-8b2e-e97107abcdcb', 'i:6;', 1787905809),
('contact_captcha_14b0174b-d935-4015-bdda-36cb9eb5c954', 'i:13;', 1787908009),
('contact_captcha_1657f8c9-43ae-44af-8114-2470cb67183c', 'i:8;', 1787905530),
('contact_captcha_1ac0546a-5062-48ff-bc8e-d8a04f240790', 'i:12;', 1787906051),
('contact_captcha_2016209a-f0e4-4497-bb2b-bdb32ebb4d43', 'i:13;', 1787908431),
('contact_captcha_26a02495-c8f6-4593-a622-d67e4ff7f8ca', 'i:7;', 1787906669),
('contact_captcha_27ccb400-e616-483f-b018-1f47ca3f63be', 'i:14;', 1787905831),
('contact_captcha_27dd7222-4437-49db-b966-f0a79c92e47f', 'i:11;', 1787905642),
('contact_captcha_29377d09-d0fe-488f-b7b8-0c8d6e3b3ddc', 'i:10;', 1787907501),
('contact_captcha_29e14e57-9cb2-40ec-9eed-6d4b464933e5', 'i:5;', 1788151098),
('contact_captcha_323babac-df26-4afa-aeb6-7502170c7e4c', 'i:8;', 1787906124),
('contact_captcha_3344be3c-2382-4d5f-80ba-85ce00e7c1b9', 'i:14;', 1787907652),
('contact_captcha_44815260-dadf-4407-84ed-cd1643699dab', 'i:6;', 1788230642),
('contact_captcha_486d66ef-0597-45c4-8c72-c2e8c74b90cc', 'i:12;', 1787908145),
('contact_captcha_4cee10bb-7b3e-4252-9140-acc929083d06', 'i:6;', 1787906133),
('contact_captcha_538c3b0e-99b8-4db0-a7d8-99fede766012', 'i:11;', 1787909427),
('contact_captcha_53c93b02-7dce-437c-bbd7-9950f8a1a653', 'i:9;', 1787908013),
('contact_captcha_697b5021-56b0-48d0-a0aa-fa7bc997218d', 'i:6;', 1787906479),
('contact_captcha_69a415e1-1371-4a32-98f3-a98ae5209362', 'i:5;', 1787907056),
('contact_captcha_75abd082-a77a-4035-bcfb-26eaf98f51a9', 'i:6;', 1787905802),
('contact_captcha_7ab7ed39-99df-47c1-897c-ab3f89577d15', 'i:14;', 1787907703),
('contact_captcha_7bcee500-576f-4118-8b79-a66ee23e068f', 'i:13;', 1787906907),
('contact_captcha_852ee308-ccff-4696-b0d8-936f9326dafd', 'i:13;', 1787906072),
('contact_captcha_858feebf-3da6-4e32-95d7-84011683c296', 'i:9;', 1788257525),
('contact_captcha_88e4616e-556f-486e-9fc5-3ec5773d51ad', 'i:7;', 1787908052),
('contact_captcha_92714f45-4908-4178-9201-46fa62fb5f23', 'i:15;', 1787906680),
('contact_captcha_963d9a6e-c61c-45a7-bcdb-27c9c5de3e7a', 'i:18;', 1787907074),
('contact_captcha_9c2c24a7-0e67-403d-9a33-7da126a09e92', 'i:9;', 1787905028),
('contact_captcha_a64a8c56-d481-44f8-b3c3-c70a07f96798', 'i:12;', 1787906917),
('contact_captcha_a9ebeb59-4444-4abd-98a9-7bb713ccbb26', 'i:8;', 1787906290),
('contact_captcha_b0064f18-ffb8-4cc4-8229-6b0988a3e84d', 'i:5;', 1788140990),
('contact_captcha_b57c73fd-311e-426e-841f-36a77c59de33', 'i:6;', 1787910304),
('contact_captcha_b834817d-7fed-418e-94ca-195e6da43d92', 'i:14;', 1787907510),
('contact_captcha_bc693b13-1bb2-468d-8a43-efb731e61959', 'i:7;', 1788140618),
('contact_captcha_bd3f1aa3-62b4-4b8b-89ca-50ba72dcac18', 'i:14;', 1788233761),
('contact_captcha_bdfb783a-e545-4b03-8600-370328bcfec7', 'i:8;', 1787908048),
('contact_captcha_be404286-3e71-4587-ba55-7876a0e98a3f', 'i:9;', 1787907417),
('contact_captcha_c0e1f0dd-a478-4947-8a5d-feb2a17042e2', 'i:10;', 1787906661),
('contact_captcha_c3a906fb-e83d-40e7-a74d-a55af18cdcf9', 'i:14;', 1787906280),
('contact_captcha_c74f2373-3f8d-434f-b77e-0dc49ed8701d', 'i:6;', 1787907857),
('contact_captcha_e0c95fe2-fcd6-4047-89a1-aead1cb1586b', 'i:15;', 1787905163),
('contact_captcha_e9984b04-0531-44e3-8774-35d24eb9f898', 'i:6;', 1788142578),
('contact_captcha_eb629b08-ba43-42e6-ad46-7f99413b7cb0', 'i:10;', 1787907395),
('contact_captcha_f1e10ca3-4310-48d5-b4e4-67756ec3c572', 'i:13;', 1787906646),
('contact_captcha_f1e9b783-cfd9-4620-860b-9623eab7280c', 'i:10;', 1787906469),
('contact_captcha_f249ce9a-1379-4f51-85fe-38ef9e12ec91', 'i:9;', 1787907205),
('contact_captcha_f479c0f5-45ba-46da-9e41-3b84468ea0f3', 'i:9;', 1788233777),
('contact_captcha_f9ab098a-db6c-4013-a9fe-c228b880d5ac', 'i:4;', 1787905818),
('contact_captcha_fb670dbb-7ed4-4313-a201-72cc2e278545', 'i:5;', 1788231829),
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:96:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"menu.main-menu\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:20:\"menu.role-permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:22:\"menu.access-management\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"dashboard.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"user.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:10:\"user.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:11:\"user.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"user.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"menu-group.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:16:\"menu-group.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:17:\"menu-group.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:18:\"menu-group.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:15:\"menu-item.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:15:\"menu-item.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:16:\"menu-item.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:17:\"menu-item.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:11:\"route.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:11:\"route.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:12:\"route.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:13:\"route.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:10:\"role.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:10:\"role.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:11:\"role.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"role.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:16:\"permission.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:16:\"permission.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:17:\"permission.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:18:\"permission.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:11:\"faq.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:9:\"faq.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:9:\"faq.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:10:\"faq.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:20:\"menu.main-portofolio\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:33;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:13:\"company.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:13:\"company.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"company.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:18:\"categories.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:37;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:16:\"categories.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:38;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:16:\"categories.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:39;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:17:\"categories.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:40;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:14:\"banner.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:41;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:12:\"banner.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:42;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:12:\"banner.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:43;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:13:\"banner.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:44;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:16:\"articles.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:45;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:15:\"articles.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:46;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:14:\"articles.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:47;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:14:\"articles.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:48;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:15:\"articles.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:49;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:14:\"dashboard.form\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:50;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:12:\"poll.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:51;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:10:\"poll.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:52;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:10:\"poll.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:53;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:11:\"poll.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:54;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:13:\"account.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:55;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:14:\"account.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:56;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:15:\"program.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:57;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:14:\"program.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:58;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:13:\"program.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:59;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:13:\"program.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:60;a:4:{s:1:\"a\";i:120;s:1:\"b\";s:14:\"program.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:61;a:4:{s:1:\"a\";i:125;s:1:\"b\";s:20:\"filedownload.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:62;a:4:{s:1:\"a\";i:130;s:1:\"b\";s:18:\"filedownload.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:63;a:4:{s:1:\"a\";i:135;s:1:\"b\";s:18:\"filedownload.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:64;a:4:{s:1:\"a\";i:140;s:1:\"b\";s:19:\"filedownload.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:65;a:4:{s:1:\"a\";i:145;s:1:\"b\";s:14:\"layanan.kontak\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:66;a:4:{s:1:\"a\";i:146;s:1:\"b\";s:16:\"instruktur.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:67;a:4:{s:1:\"a\";i:147;s:1:\"b\";s:12:\"pages.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:68;a:4:{s:1:\"a\";i:148;s:1:\"b\";s:13:\"pages.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:69;a:4:{s:1:\"a\";i:149;s:1:\"b\";s:11:\"pages.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:70;a:4:{s:1:\"a\";i:150;s:1:\"b\";s:11:\"pages.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:71;a:4:{s:1:\"a\";i:151;s:1:\"b\";s:12:\"pages.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:72;a:4:{s:1:\"a\";i:152;s:1:\"b\";s:18:\"instruktur.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:73;a:4:{s:1:\"a\";i:153;s:1:\"b\";s:16:\"instruktur.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:74;a:4:{s:1:\"a\";i:154;s:1:\"b\";s:17:\"instruktur.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:75;a:4:{s:1:\"a\";i:155;s:1:\"b\";s:19:\"testimonial.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:76;a:4:{s:1:\"a\";i:156;s:1:\"b\";s:17:\"testimonial.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:77;a:4:{s:1:\"a\";i:157;s:1:\"b\";s:18:\"testimonial.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:78;a:4:{s:1:\"a\";i:158;s:1:\"b\";s:17:\"testimonial.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:79;a:4:{s:1:\"a\";i:159;s:1:\"b\";s:12:\"events.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:80;a:4:{s:1:\"a\";i:160;s:1:\"b\";s:14:\"events.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:81;a:4:{s:1:\"a\";i:161;s:1:\"b\";s:12:\"events.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:82;a:4:{s:1:\"a\";i:162;s:1:\"b\";s:13:\"events.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:83;a:4:{s:1:\"a\";i:163;s:1:\"b\";s:21:\"specializations.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:84;a:4:{s:1:\"a\";i:164;s:1:\"b\";s:23:\"specializations.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:85;a:4:{s:1:\"a\";i:165;s:1:\"b\";s:22:\"specializations.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:86;a:4:{s:1:\"a\";i:166;s:1:\"b\";s:21:\"specializations.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:87;a:4:{s:1:\"a\";i:167;s:1:\"b\";s:15:\"package.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:88;a:4:{s:1:\"a\";i:168;s:1:\"b\";s:13:\"package.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:89;a:4:{s:1:\"a\";i:169;s:1:\"b\";s:14:\"package.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:90;a:4:{s:1:\"a\";i:170;s:1:\"b\";s:13:\"package.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:91;a:4:{s:1:\"a\";i:171;s:1:\"b\";s:14:\"package.member\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:92;a:4:{s:1:\"a\";i:172;s:1:\"b\";s:15:\"classes.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:93;a:4:{s:1:\"a\";i:173;s:1:\"b\";s:13:\"classes.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:94;a:4:{s:1:\"a\";i:174;s:1:\"b\";s:13:\"classes.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:95;a:4:{s:1:\"a\";i:175;s:1:\"b\";s:14:\"classes.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super-admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:4:\"user\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"instruktur\";s:1:\"c\";s:3:\"web\";}}}', 1788471959);

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
  `image` varchar(255) NOT NULL,
  `level` enum('pemula','menengah','advance','semua_level') NOT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `is_active` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time DEFAULT NULL,
  `capacity` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `status` enum('scheduled','ongoing','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('02471b9c-9346-409c-b9b0-5331d91456ed', 'Growing Together in Nature', 'growing-together-in-nature', '<p><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">A special morning created for mama-to-be.</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">Move gently, breathe deeply, connect with your little one, and enjoy a peaceful morning in nature. 🤍</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">📅 Sunday, 13 September 2026</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">⏰ 07.30–10.00 AM</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">📍 Kebun Raya Bogor – Taman Melchior</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">💗 150K / pax</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">Includes Prenatal Yoga, Pregnancy Talk, Mini MCU, Garden Picnic, Goodies &amp; Giveaways! ✨</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">🎟️ Register Now:</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">https://bit.ly/PrenatalGentleYogaatKebunRaya</span><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><br style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\"><span style=\"color: rgb(12, 16, 20); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; letter-spacing: normal;\">Come grow, breathe &amp; connect with us. 🌿</span></p>', 'events/NLg7WQHCoKb9lC1eYoe4r8Ca1tUW2sDfOdFrdj3l.jpg', '2026-09-13', '07:30:00', '10:00:00', 'Kebun Raya Bogor – Taman Melchior', 35, 'published', '2026-08-31 18:39:08', '2026-09-01 03:02:52');

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
('4b9411a3-ccc5-44fd-bc24-e8dc7065773c', 'Apa yang perlu dipersiapkan sebelum mengikuti kelas?', 'Kenakan pakaian yang nyaman untuk bergerak dan bawa botol minum. Perlengkapan latihan tersedia di studio sesuai kebutuhan kelas.', 2, 'active', '2025-09-17 20:19:23', '2026-08-28 00:02:14'),
('6bb623f8-916a-436b-85b3-a57035fe5ac5', 'Apakah perlu melakukan reservasi sebelum mengikuti kelas?', 'Ya, reservasi disarankan untuk memastikan ketersediaan tempat, terutama pada kelas dengan kapasitas terbatas.', 4, 'active', '2025-09-17 20:20:44', '2026-08-28 00:02:48'),
('95b200f1-69c7-4f1b-a76b-172bcf5fcc55', 'Bagaimana jika saya memiliki kondisi atau kebutuhan khusus saat berlatih?', 'Sampaikan kepada instruktur sebelum kelas dimulai agar latihan dapat disesuaikan dengan kondisi dan kebutuhan Anda.', 5, 'active', '2025-09-17 20:21:00', '2026-08-28 00:03:03'),
('fa2b17f9-f0d4-4849-8373-8d787b80113e', 'Apakah YogaRoots cocok untuk pemula?', 'Tentu. YogaRoots terbuka untuk semua tingkat pengalaman, termasuk pemula. Anda dapat memilih kelas sesuai kemampuan dan kebutuhan.', 1, 'active', '2025-09-17 20:13:33', '2026-08-28 00:01:55'),
('fd90f57c-53aa-4b5d-8e11-faea4808686d', 'Bagaimana cara memilih kelas yang sesuai?', 'Setiap kelas memiliki karakter dan tujuan yang berbeda. Anda dapat melihat deskripsi kelas untuk menentukan pilihan yang sesuai dengan pengalaman dan kebutuhan Anda.', 3, 'active', '2025-09-17 20:20:22', '2026-08-28 00:02:30');

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
(2, 'Role dan Akses', 1, 'menu.role-permission', 'bx-shield-quarter', 12, '2024-09-26 23:27:05', '2024-09-26 23:56:50'),
(3, 'Pengaturan', 1, 'menu-item.index', 'bx-cog', 13, '2024-09-26 23:27:05', '2025-09-17 23:25:45'),
(4, 'Pusat Informasi', 1, 'faq.index', 'bx-book', 10, '2024-09-26 23:35:30', '2025-09-16 01:52:59'),
(7, 'Publikasi', 1, 'articles.index', 'bxs-file', 8, '2024-09-29 12:37:06', '2025-09-16 00:42:56'),
(8, 'Media Pustaka', 1, 'banner.index', 'bx-camera', 9, '2024-10-13 22:33:06', '2025-09-11 17:59:03'),
(9, 'Master Data', 1, 'testimonial.index', 'bx-folder-open', 11, '2025-07-21 17:56:19', '2026-08-30 19:07:27'),
(10, 'Instruktur', 1, 'instruktur.index', 'bx-user', 7, '2025-07-23 22:38:22', '2026-09-01 14:33:42'),
(11, 'Kelola Event', 1, 'filedownload.index', 'bxs-calendar', 6, '2025-07-25 16:53:44', '2026-08-30 19:58:23'),
(12, 'Membership', 1, 'package.member', 'bx-package', 4, '2025-09-14 12:05:35', '2026-09-02 05:51:45'),
(22, 'Classes', 1, 'classes.index', 'bx-book', 5, '2026-09-02 15:16:09', '2026-09-02 15:16:57');

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
(7, 'Faq & Answer', NULL, 'faq.index', 1, 'faq.index', 4, 1, '2024-09-27 00:21:24', '2025-09-16 01:54:15'),
(8, 'Kategori', NULL, 'categories.index', 1, 'categories.index', 7, 3, '2024-09-29 12:39:24', '2024-10-15 13:53:37'),
(9, 'Semua Posting', NULL, 'articles.index', 1, 'articles.index', 7, 1, '2024-09-30 12:08:38', '2025-07-22 12:09:34'),
(10, 'Semua Media', NULL, 'banner.index', 1, 'banner.index', 8, 1, '2024-10-13 22:38:24', '2026-08-27 04:09:22'),
(12, 'Tambah Baru', NULL, 'articles.create', 1, 'articles.create', 7, 2, '2025-07-22 12:59:27', '2025-07-22 12:59:27'),
(13, 'Spesialisasi', NULL, 'specializations.index', 1, 'specializations.index', 10, 1, '2025-07-23 23:12:46', '2026-08-27 18:09:25'),
(14, 'Daftar Event', NULL, 'events.index', 1, 'events.index', 11, 1, '2025-07-25 16:55:36', '2026-08-30 20:00:02'),
(15, 'Poling Publik', NULL, 'poll.index', 1, 'poll.index', 4, 2, '2025-07-27 23:51:25', '2025-09-17 22:58:28'),
(40, 'Halaman Statis', NULL, 'pages.index', 1, 'pages.index', 9, 3, '2025-10-21 03:46:02', '2026-08-30 19:08:10'),
(41, 'Data Instruktur', NULL, 'instruktur.index', 1, 'program.index', 10, 2, '2025-11-12 04:02:59', '2026-09-01 14:33:55'),
(42, 'Testimoni', NULL, 'testimonial.index', 1, 'testimonial.index', 4, 3, '2026-08-27 23:58:27', '2026-08-27 23:58:27'),
(43, 'Pesan Masuk', NULL, 'layanan.kontak', 1, 'layanan.kontak', 4, 4, '2026-08-27 23:59:06', '2026-08-27 23:59:06'),
(44, 'Packages', NULL, 'packages.index', 1, 'package.index', 12, 1, '2026-09-02 04:59:49', '2026-09-02 04:59:49'),
(45, 'Our Packages', NULL, 'packages.member', 1, 'package.member', 12, 2, '2026-09-02 05:52:23', '2026-09-02 15:19:17'),
(46, 'Class List', NULL, 'classes.index', 1, 'classes.index', 22, 1, '2026-09-02 15:18:03', '2026-09-02 15:18:03');

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
(49, '2026_09_02_074849_create_class_bookings_table', 13);

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
(5, 'App\\Models\\User', '1c3ea59a-f83a-4bdf-aa70-f38ff66f49a2'),
(5, 'App\\Models\\User', '2f040883-ec48-424e-872d-3691d7c1a714'),
(5, 'App\\Models\\User', '33b681e2-efc3-4017-9415-e5d5d197f2fe'),
(5, 'App\\Models\\User', '4c0ff420-34e5-4ecd-bb07-358862f9906a'),
(5, 'App\\Models\\User', '514d04e5-f79b-403a-95f4-2254784db0f0'),
(5, 'App\\Models\\User', '7d84490a-7661-415a-921c-141c05f38ded'),
(5, 'App\\Models\\User', '896ff4a7-ec81-4be5-ad12-ba4e3bb277de'),
(5, 'App\\Models\\User', '897f6253-86e1-4866-9072-e3e10bb51e5e'),
(5, 'App\\Models\\User', '950e18b7-9af4-468a-8468-edc338b7deec'),
(5, 'App\\Models\\User', 'a52ef0ee-6805-4b04-9f23-d6d6410829c5'),
(5, 'App\\Models\\User', 'bace7196-8ce8-4253-baa7-04901e31592e'),
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
  `price` decimal(15,2) NOT NULL,
  `discount_price` decimal(15,2) DEFAULT NULL,
  `final_price` decimal(15,2) NOT NULL,
  `quota` int(10) UNSIGNED DEFAULT NULL,
  `duration` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `duration_unit` enum('day','week','month','year') NOT NULL DEFAULT 'month',
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`uuid`, `name`, `slug`, `description`, `price`, `discount_price`, `final_price`, `quota`, `duration`, `duration_unit`, `is_popular`, `is_active`, `created_at`, `updated_at`) VALUES
('01a06234-aac1-722c-84d6-c46d4150e70f', 'Bloom', 'bloom', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since 1966, when designers at Letraset and James Mosley, the librarian at St Bride Printing Library in London, took a 1914 Cicero translation and scrambled it to', 500000.00, 200000.00, 0.00, NULL, 1, 'month', 0, 'active', '2026-09-02 06:00:13', '2026-09-02 06:37:40');

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
('01a06256-f170-716c-8d5e-b4a3d92e1767', '01a06234-aac1-722c-84d6-c46d4150e70f', 'matras', 0, '2026-09-02 06:37:40', '2026-09-02 06:37:40'),
('01a06256-f171-72a2-9d0e-9bf7091cfd44', '01a06234-aac1-722c-84d6-c46d4150e70f', 'free cofee', 1, '2026-09-02 06:37:40', '2026-09-02 06:37:40');

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
('5380a3e5-adfa-437c-a0fa-bc2193d55cb2', 'Kebijakan Privasi', 'kebijakan-privasi', 'Dengan menggunakan website dan layanan YogaRoots, Anda dianggap telah membaca dan memahami Kebijakan Privasi ini.', '<h2><strong style=\"color: rgb(71, 85, 105); font-size: 16px; letter-spacing: 0.1px;\">Terakhir Diperbarui:</strong><span style=\"color: rgb(71, 85, 105); font-size: 16px; font-weight: 400; letter-spacing: 0.1px;\"> 30 Agustus 2026</span></h2>\r\n\r\n<p>\r\n  Selamat datang di <strong>YogaRoots</strong>.\r\n</p>\r\n\r\n<p>\r\n  Kami menghargai kepercayaan Anda dan berkomitmen untuk menjaga privasi serta keamanan informasi pribadi yang Anda berikan kepada kami. Kebijakan Privasi ini menjelaskan bagaimana YogaRoots mengumpulkan, menggunakan, menyimpan, dan melindungi informasi Anda ketika Anda mengakses website, melakukan pendaftaran, menghubungi kami, atau menggunakan layanan YogaRoots.\r\n</p>\r\n\r\n<p>\r\n  Dengan menggunakan website dan layanan YogaRoots, Anda dianggap telah membaca dan memahami Kebijakan Privasi ini.\r\n</p>\r\n\r\n<h3>1. Informasi yang Kami Kumpulkan</h3>\r\n\r\n<p>\r\n  Kami dapat mengumpulkan informasi yang Anda berikan secara langsung ketika menggunakan website atau layanan YogaRoots, termasuk:\r\n</p>\r\n\r\n<ul>\r\n  <li>Nama lengkap</li>\r\n  <li>Alamat email</li>\r\n  <li>Nomor telepon</li>\r\n  <li>Informasi yang diberikan melalui formulir kontak</li>\r\n  <li>Informasi pendaftaran atau pemesanan kelas</li>\r\n  <li>Informasi akun apabila Anda menggunakan fitur login</li>\r\n  <li>Informasi lain yang Anda berikan secara sukarela kepada kami</li>\r\n</ul>\r\n\r\n<p>\r\n  Kami juga dapat memperoleh informasi teknis secara otomatis ketika Anda mengakses website, seperti jenis perangkat, browser, alamat IP, dan informasi terkait aktivitas penggunaan website.\r\n</p>\r\n\r\n<h3>2. Penggunaan Informasi</h3>\r\n\r\n<p>\r\n  Informasi yang kami kumpulkan dapat digunakan untuk:\r\n</p>\r\n\r\n<ul>\r\n  <li>Memproses pendaftaran dan pemesanan kelas</li>\r\n  <li>Mengelola akun dan membership</li>\r\n  <li>Menjawab pertanyaan atau permintaan yang Anda kirimkan</li>\r\n  <li>Memberikan informasi mengenai kelas, jadwal, program, dan layanan YogaRoots</li>\r\n  <li>Mengirimkan informasi penting terkait layanan yang Anda gunakan</li>\r\n  <li>Meningkatkan kualitas website dan pengalaman pengguna</li>\r\n  <li>Menjaga keamanan website dan mencegah penyalahgunaan</li>\r\n  <li>Memenuhi kewajiban hukum yang berlaku</li>\r\n</ul>\r\n\r\n<p>\r\n  Kami berusaha menggunakan informasi pribadi Anda hanya untuk tujuan yang relevan dengan layanan YogaRoots.\r\n</p>\r\n\r\n<h3>3. Perlindungan Informasi</h3>\r\n\r\n<p>\r\n  YogaRoots berupaya menerapkan langkah-langkah keamanan yang wajar untuk melindungi informasi pribadi Anda dari akses, penggunaan, perubahan, atau pengungkapan yang tidak sah.\r\n</p>\r\n\r\n<p>\r\n  Meskipun demikian, tidak ada sistem penyimpanan maupun transmisi data melalui internet yang dapat dijamin sepenuhnya aman. Oleh karena itu, kami tidak dapat menjamin keamanan data secara mutlak.\r\n</p>\r\n\r\n<h3>4. Penggunaan oleh Pihak Ketiga</h3>\r\n\r\n<p>\r\n  Dalam menjalankan layanan, YogaRoots dapat menggunakan layanan dari pihak ketiga, seperti penyedia teknologi, layanan pembayaran, autentikasi, analitik, komunikasi, atau layanan pendukung lainnya.\r\n</p>\r\n\r\n<p>\r\n  Informasi hanya akan diberikan sejauh diperlukan untuk menjalankan layanan terkait.\r\n</p>\r\n\r\n<p>\r\n  Pihak ketiga tersebut dapat memiliki kebijakan privasi masing-masing. Kami menyarankan Anda untuk membaca kebijakan privasi dari layanan pihak ketiga yang Anda gunakan.\r\n</p>\r\n\r\n<h3>5. Cookie</h3>\r\n\r\n<p>\r\n  Website YogaRoots dapat menggunakan cookie dan teknologi serupa untuk membantu website bekerja dengan baik, mengingat preferensi pengguna, memahami penggunaan website, serta meningkatkan pengalaman Anda.\r\n</p>\r\n\r\n<p>\r\n  Anda dapat mengatur penggunaan cookie melalui pengaturan browser. Namun, menonaktifkan cookie tertentu dapat menyebabkan beberapa fitur website tidak berfungsi sebagaimana mestinya.\r\n</p>\r\n\r\n<h3>6. Informasi yang Anda Kirimkan kepada Kami</h3>\r\n\r\n<p>\r\n  Apabila Anda menghubungi YogaRoots melalui formulir kontak, email, WhatsApp, atau media komunikasi lainnya, informasi yang Anda berikan dapat kami gunakan untuk menanggapi permintaan dan memberikan bantuan yang Anda butuhkan.\r\n</p>\r\n\r\n<p>\r\n  Kami tidak menjual atau menyewakan informasi pribadi Anda kepada pihak lain.\r\n</p>\r\n\r\n<h3>7. Penyimpanan Data</h3>\r\n\r\n<p>\r\n  Informasi pribadi dapat disimpan selama diperlukan untuk memberikan layanan, memenuhi tujuan pengumpulan informasi, menyelesaikan transaksi, memenuhi kewajiban hukum, atau menyelesaikan kebutuhan administratif lainnya.\r\n</p>\r\n\r\n<p>\r\n  Setelah informasi tidak lagi diperlukan, kami dapat menghapus atau menganonimkan data tersebut sesuai dengan kebijakan dan ketentuan yang berlaku.\r\n</p>\r\n\r\n<h3>8. Hak Pengguna</h3>\r\n\r\n<p>\r\n  Anda dapat menghubungi YogaRoots apabila ingin:\r\n</p>\r\n\r\n<ul>\r\n  <li>Memperbarui informasi pribadi</li>\r\n  <li>Memperbaiki informasi yang tidak akurat</li>\r\n  <li>Menanyakan informasi pribadi yang kami simpan</li>\r\n  <li>Meminta penghapusan informasi tertentu, sepanjang tidak bertentangan dengan kewajiban hukum atau kebutuhan layanan</li>\r\n  <li>Menanyakan bagaimana informasi pribadi Anda digunakan</li>\r\n</ul>\r\n\r\n<p>\r\n  Setiap permintaan akan kami tinjau sesuai dengan kondisi dan ketentuan yang berlaku.\r\n</p>\r\n\r\n<h3>9. Privasi Anak</h3>\r\n\r\n<p>\r\n  YogaRoots menghormati privasi anak dan tidak bermaksud mengumpulkan informasi pribadi anak secara sengaja tanpa keterlibatan atau persetujuan orang tua atau wali yang sesuai.\r\n</p>\r\n\r\n<p>\r\n  Apabila Anda mengetahui adanya informasi anak yang diberikan kepada kami tanpa persetujuan yang semestinya, silakan menghubungi kami.\r\n</p>\r\n\r\n<h3>10. Perubahan Kebijakan Privasi</h3>\r\n\r\n<p>\r\n  YogaRoots dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu untuk menyesuaikan dengan perubahan layanan, teknologi, maupun ketentuan yang berlaku.\r\n</p>\r\n\r\n<p>\r\n  Setiap perubahan akan dipublikasikan pada halaman ini dan tanggal pembaruan akan disesuaikan.\r\n</p>\r\n\r\n<p>\r\n  Kami menyarankan Anda untuk memeriksa halaman ini secara berkala agar tetap mengetahui bagaimana kami melindungi informasi pribadi Anda.\r\n</p>\r\n\r\n<h3>11. Hubungi Kami</h3>\r\n\r\n<p>\r\n  Apabila Anda memiliki pertanyaan mengenai Kebijakan Privasi ini atau bagaimana YogaRoots menangani informasi pribadi Anda, silakan hubungi kami melalui:\r\n</p>\r\n\r\n<p>\r\n  <strong>YogaRoots</strong>\r\n</p>\r\n\r\n<p>\r\n  <strong>Email:</strong>&nbsp;</p>\r\n\r\n<p>\r\n  <strong>Telepon / WhatsApp:</strong> +62 813 2122 1270\r\n</p>\r\n\r\n<p>\r\n  <strong>Alamat:</strong> Roots Prasasta Building, Jl. Kawi Raya No.37, RT.6/RW.2, Guntur, Setiabudi, South Jakarta City, Jakarta 12980<br></p><p>\r\n</p>\r\n\r\n<p>\r\n  Kami akan berusaha membantu dan memberikan informasi yang Anda perlukan terkait privasi dan penggunaan data Anda.\r\n</p>', 'pages/KGpKHJFc1aFrX0OocaW7I9uDWxmWiRAc9XA3gCzQ.png', 1, '2026-08-30 17:00:00', NULL, 0, '2025-10-16 04:07:16', '2026-08-30 18:41:13');

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
(175, 'classes.update', 'web', '2026-09-02 14:45:59', '2026-09-02 14:45:59');

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
(9, 3),
(10, 1),
(10, 3),
(11, 1),
(11, 3),
(12, 1),
(12, 3),
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
(175, 5);

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
(175, 'classes.store', 'classes.store', 1, NULL, '2026-09-02 15:13:40', '2026-09-02 15:13:40');

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
('lZR9UZ9CUJocZHZ17mvDGsjfVRnhz1QGTmtQhQc3', '787b72ea-59d0-4d54-848b-c200bddafdd2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTkRDYkpra1RMbjBtcDhQNFB5djNJRUJtenExc2l4czVjOGpxUFhIeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9iYWNrZW5kL2NsYXNzZXMiO3M6NToicm91dGUiO3M6MTM6ImNsYXNzZXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiNzg3YjcyZWEtNTlkMC00ZDU0LTg0OGItYzIwMGJkZGFmZGQyIjt9', 1788388294);

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
('2146b32e-85f3-4df1-b8c6-4718bd786114', 'Vinyasa', 'vinyasa', 'Praktik dinamis yang mengalir mengikuti ritme pernapasan.', 'active', '2026-08-27 18:05:32', '2026-08-27 18:05:32'),
('31bcc6cd-a596-4504-a12e-b9d6a9121f8a', 'Restorative', 'restorative', 'Praktik lembut yang berfokus pada relaksasi dan pemulihan tubuh.', 'active', '2026-08-27 18:06:01', '2026-08-27 18:06:01'),
('b9138804-0f82-45f7-a9bd-46e3201c5a02', 'Mobility', 'mobility', 'Latihan untuk membantu meningkatkan mobilitas dan kualitas gerak tubuh.', 'active', '2026-08-27 18:06:53', '2026-08-27 18:06:53'),
('c7b32db4-54e4-4773-b361-3174b06f14df', 'Prenatal', 'prenatal', 'Praktik yang disesuaikan untuk mendukung kenyamanan selama masa kehamilan.', 'active', '2026-08-27 18:06:22', '2026-08-27 18:06:22'),
('cd60d5c4-b89e-42cd-bafb-b10ded0538ec', 'Meditation', 'meditation', 'Praktik yang berfokus pada ketenangan, pernapasan, dan kesadaran diri.', 'active', '2026-08-27 18:06:33', '2026-08-27 18:06:33'),
('e4e48123-a4d4-4f39-9023-533c2aa1e8d5', 'Hatha', 'hatha', 'Praktik dengan gerakan yang terstruktur dan ritme yang tenang.', 'active', '2026-08-27 18:05:19', '2026-08-27 18:05:19'),
('ee13048a-ca16-4664-b3ca-8590fe0d7cb5', 'Breathwork', 'breathwork', 'Praktik pengaturan pernapasan untuk membantu meningkatkan kesadaran dan relaksasi.', 'active', '2026-08-27 18:07:07', '2026-08-27 18:07:07'),
('fc5bee22-ea91-4c4e-aa37-6541867365e9', 'Yin', 'yin', 'Praktik dengan posisi yang dipertahankan lebih lama untuk membantu relaksasi dan fleksibilitas.', 'active', '2026-08-27 18:05:43', '2026-08-27 18:05:43');

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
('68930add-7fe9-434f-9491-fa1865f7030f', 'Fhadillah Cherly Yunanda', 'Member sejak 2025', 'Best yoga place in jkt so far! Very clean, very nice lighting with natural sunlight, and the most important thing - so engaging instructor! Will be back offf course!!!', 'testimoni/mTZ6RDcLemyrGMyHtoNDaaDRhUN7ZFSzRnnan3Cy.jpg', 2, 'active', '2026-08-30 18:24:00', '2026-08-30 18:24:12'),
('9752f19a-b312-4cf3-8bb6-60e745ff2021', 'Jessica Gloria Mogi', 'Member sejak 2022', 'The studio was beautiful, plenty of natural sunlight, it was not stuffy at all. They have a minimalist shower with some skincare products and medium-sized lockers. It\'s a great experience and I\'m coming back tomorrow :)', 'testimoni/nidUWjtm96IN7vcNiB4LVGJWiKNbdWtIKiwnr5zB.jpg', 1, 'active', '2026-08-30 18:23:24', '2026-08-30 18:23:40'),
('a831f46c-8e60-4e7d-be60-530cd0976993', 'Melda Auditia', 'Member sejak 2025', 'Amazing experience. Great instructor. Space is quiet, beautiful & clean, with nice shower room for yoga before work. Would definitely come back again👍🏻', 'testimoni/8qAQTxe0Rf5baRNQuqkCHzDJX5ji4RsX2kMls9xb.jpg', 3, 'active', '2026-08-30 18:24:27', '2026-08-30 18:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
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
  `membership_start_date` date DEFAULT NULL,
  `membership_end_date` date DEFAULT NULL,
  `total_quota` int(10) UNSIGNED DEFAULT NULL,
  `remaining_quota` int(10) UNSIGNED DEFAULT NULL,
  `membership_status` enum('active','expired','cancelled') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uuid`, `name`, `no_hp`, `alamat`, `kecamatan_id`, `kelurahan_id`, `avatar`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `google_id`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `pengalaman`, `is_active`, `deleted_at`, `facebook`, `instagram`, `twitter`, `tiktok`, `youtube`, `biografi`, `package_uuid`, `membership_start_date`, `membership_end_date`, `total_quota`, `remaining_quota`, `membership_status`) VALUES
('70e15b9f-535a-42a2-8ea0-9a26ad7952e5', 'Wiku Pramesthi Bagaswara', '85691333321', NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJyIWaZ6DTyCSRR_Updmep-Jj4suOOVAPP5K_9YRLlrcXZaHgwn=s96-c', 'wikupb@gmail.com', '2025-11-12 03:39:36', '$2y$12$WXO13gY21gOqgS1s7M743.Oe5UdAxQDykEbmTf0xJ2LnyNdPMzsj6', NULL, '2025-11-12 03:39:36', '2025-11-13 08:26:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01a06234-aac1-722c-84d6-c46d4150e70f', '2026-09-02', '2026-10-02', 4, 4, 'active'),
('787b72ea-59d0-4d54-848b-c200bddafdd2', 'super-admin', '085691333329', 'Jl. Gandaria', 4, 17, 'avatars/u5KMRU9jG95SYcdq0vhxnksQ0EFatee9WxrPxrtH.jpg', 'super@admin.com', '2025-09-16 00:23:37', '$2y$12$PRZJcd.nlREU6NRq3jvIVemYmlwxVPTb7En4URyNgyQSfKjWUzwDi', 'MMf5hoyFvKn9cNLqQcL9vYvKMtzVNXsNuYWfmYhWitrwyOWP30SGFXlq2GMR', '2025-09-16 00:23:37', '2026-08-31 18:33:47', NULL, NULL, 'dasda', '2025-09-24', 'P', 'Lainnya', '10 tahun', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dsadasd', NULL, NULL, NULL, NULL, NULL, NULL);

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
('8f290da2-8e09-42c6-8fb6-4622eab0df4a', '787b72ea-59d0-4d54-848b-c200bddafdd2', 'ee13048a-ca16-4664-b3ca-8590fe0d7cb5', NULL, NULL),
('c001deec-13ad-42a9-a4e3-0d55d64759fb', '787b72ea-59d0-4d54-848b-c200bddafdd2', 'e4e48123-a4d4-4f39-9023-533c2aa1e8d5', NULL, NULL);

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
  ADD KEY `class_schedules_class_uuid_date_index` (`class_uuid`,`date`),
  ADD KEY `class_schedules_date_status_index` (`date`,`status`);

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
  ADD KEY `users_membership_status_index` (`membership_status`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

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
-- Constraints for table `user_specialization`
--
ALTER TABLE `user_specialization`
  ADD CONSTRAINT `user_specialization_specialization_uuid_foreign` FOREIGN KEY (`specialization_uuid`) REFERENCES `specializations` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_specialization_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
