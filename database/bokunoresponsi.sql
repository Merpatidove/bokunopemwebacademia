SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `articles` (`id`, `title`, `content`, `author_id`, `created_at`, `updated_at`) VALUES
(1, 'All Might: Simbol Kedamaian yang Mengubah Dunia Pahlawan', 'Toshinori Yagi, atau yang lebih dikenal dengan nama pahlawannya, All Might, adalah sosok yang tidak hanya kuat secara fisik, tetapi juga memiliki pengaruh besar terhadap dunia pahlawan di Boku no Hero Academia. Dengan senyum lebarnya yang ikonik dan slogan “I am here!”, All Might menjadi simbol harapan bagi masyarakat dan tembok terakhir yang melindungi mereka dari keputusasaan.\r\n\r\nWalau kini ia tak lagi berada di puncak kekuatannya, perjalanan hidup All Might tetap menjadi salah satu kisah paling inspiratif dalam seri ini. Ia berasal dari Jepang dan sejak muda sudah bercita-cita menjadi pahlawan yang mampu membawa kedamaian setelah melihat dunia dipenuhi ketakutan akibat meningkatnya kejahatan. Mimpinya sederhana, namun bermakna: menciptakan dunia di mana orang-orang bisa tersenyum tanpa rasa takut.\r\n\r\nDi balik sosok heroiknya, All Might punya kepribadian yang hangat dan ringan. Ia gemar membantu siapa pun tanpa memandang status, sering memberikan bimbingan pada murid-muridnya, dan bahkan dikenal sering berpose dramatis hanya untuk menghibur orang lain. Hobinya memang “menolong orang,” dan itu bukan sekadar kalimat—itu adalah cara hidupnya.\r\n\r\nSebagai mentor Izuku Midoriya, All Might tidak hanya memberikan warisan kekuatan One For All, tetapi juga nilai-nilai moral yang membuat seorang pahlawan sejati. Dedikasi dan pengorbanannya menjadikan dia figur yang dicintai, dihormati, dan dirindukan oleh banyak karakter maupun para penggemar.\r\n\r\nAll Might bukan sekadar karakter—dia adalah simbol.\r\nSimbol harapan, keberanian, dan ketulusan yang selalu mengingatkan kita bahwa sekecil apa pun kekuatan kita, selama niatnya tulus, itu sudah cukup untuk membuat perbedaan.', 1, '2025-12-11 09:13:58', '2025-12-11 09:38:21'),
(2, 'Eijiro Kirishima: Pahlawan dengan Semangat Baja', 'Eijiro Kirishima adalah salah satu karakter yang paling mudah disukai di Boku no Hero Academia. Dengan quirk “Hardening” dan kepribadiannya yang penuh semangat, Kirishima dikenal sebagai sosok yang selalu tampil dengan energi positif. Ia bukan hanya keras secara fisik, tetapi juga kuat hati—sebuah kombinasi yang bikin dia tampil beda dibanding pahlawan muda lainnya.\r\n\r\nKirishima berasal dari Prefektur Chiba dan sejak awal bercita-cita menjadi pahlawan yang benar-benar “gagah”. Pengagum berat Crimson Riot ini selalu melihat kepahlawanan dari sudut pandang keberanian. Buat Kirishima, menjadi kuat itu penting, tapi tetap berdiri tegak dan maju walau sedang takut adalah hal yang paling heroik.\r\n\r\nDi kesehariannya, Kirishima punya hobi yang cukup sederhana: latihan. Banyak latihan. Dia tipe cowok yang kalau gabut langsung push-up atau angkat beban karena merasa harus selalu meningkatkan diri. Kepribadiannya yang jujur, loyal, dan penuh perhatian bikin dia jadi salah satu teman terbaik yang bisa dimiliki siapa pun.\r\n\r\nKisah pengembangan dirinya—dari murid biasa yang kurang percaya diri menjadi pahlawan yang gagah berani—membuat Kirishima jadi representasi bahwa kehebatan bukan cuma soal bakat, tapi juga kerja keras.', 1, '2025-12-11 09:25:22', '2025-12-11 09:38:28'),
(3, 'Hanta Sero: Si Tape Hero yang Selalu Bikin Suasana Cair', 'Hanta Sero mungkin bukan karakter yang paling menonjol dalam pertempuran besar, tetapi dia punya peran penting sebagai salah satu murid dengan vibe paling santai dan menyenangkan di kelas 1-A. Dengan quirk “Tape” yang membuat lengannya bisa mengeluarkan pita seperti selotip, Sero sering menjadi penyelamat dalam situasi mobilitas dan penyelamatan.\r\n\r\nSero adalah anak Jakarta—eh, bukan ding—anak Tokyo yang easy-going banget. Dia tipe teman yang selalu bisa bikin suasana jadi lebih enak. Entah itu latihan, kelas, atau momen stres menjelang ujian, Sero selalu siap dengan komentar ringan atau ekspresi lucu yang bikin teman-temannya ketawa.\r\n\r\nDi luar jam sekolah, hobinya simple: skateboard dan nongkrong. Dia punya gaya kasual dan percaya diri yang pas, bikin dia sering disebut “anak gaul kelas 1-A”. Walau terlihat santai, Sero sebenarnya cukup perhatian dan punya ketangkasan luar biasa yang bikin dia sering dilirik dalam misi-misi tim yang butuh koordinasi tinggi.\r\n\r\nSero adalah bukti bahwa pahlawan gak harus selalu serius. Kadang, yang dunia butuhkan adalah seseorang yang bisa membuat semuanya terasa lebih ringan.', 1, '2025-12-11 09:25:42', '2025-12-11 09:38:50'),
(4, 'Hiryu Rin: Murid Asal Tiongkok dengan Ketegasan yang Mengintimidasi', 'Hiryu Rin adalah salah satu murid kelas 1-B yang mencuri perhatian karena auranya yang tegas dan terkontrol. Ia berasal dari Tiongkok sebelum akhirnya bersekolah di U.A., dan hal itu memberi sedikit nuansa internasional pada karakter ini. Dengan quirk “Scales”, Rin mampu menciptakan sisik keras yang meningkatkan kekuatan ofensif dan pertahanannya.\r\n\r\nRin punya pembawaan yang disiplin, mirip atlet bela diri profesional. Cara bicara dan bergeraknya mencerminkan kedewasaan, seolah dia selalu punya rencana matang di kepalanya. Gak heran kalau dia sering tampil sebagai pilar ketenangan ketika teman-temannya mulai panik.\r\n\r\nHobinya berkaitan erat dengan latar belakangnya—latihan bela diri, pola hidup sehat, dan peningkatan stamina. Dia bukan tipe yang suka ribut, tapi sekali sudah turun tangan, hasilnya jarang mengecewakan.\r\n\r\nWalau jarang mendapat sorotan besar, karakter Rin menunjukkan bahwa pahlawan tidak selalu harus flamboyan. Terkadang, pahlawan yang kuat adalah mereka yang hadir dengan disiplin, ketenangan, dan semangat bekerja keras tanpa perlu banyak bicara.', 1, '2025-12-11 09:26:03', '2025-12-11 09:38:58'),
(5, 'Hitoshi Shinso: Dari Underdog Menjadi Calon Pahlawan Besar', 'Hitoshi Shinso adalah salah satu karakter yang paling menarik di Boku no Hero Academia. Dengan quirk “Brainwashing”, dia punya kemampuan yang luar biasa kuat, tetapi juga sering disalahpahami. Sejak awal, Shinso menghadapi prasangka karena quirk-nya dianggap “seram” dan lebih cocok dimiliki villain. Namun justru dari situlah perjalanan berartinya dimulai.\r\n\r\nShinso berasal dari Jepang dan dikenal sebagai murid yang pendiam, serius, dan punya tekad keras. Ia jarang berbicara, tapi ketika ia membuka suara, itu selalu berarti. Di balik ekspresinya yang selalu terlihat ngantuk, sebenarnya Shinso punya ambisi besar: membuktikan bahwa orang tidak bisa dinilai dari quirk semata.\r\n\r\nHobi Shinso cenderung simpel dan relate: tidur. Dia cepat capek, cepat ngantuk, dan gaya hidupnya sering bikin fans bercanda kalau dia “kucing dalam bentuk manusia”. Selain itu, ia juga rajin berlatih mengikuti metode Eraser Head, sehingga skill bertarung fisiknya meningkat drastis.\r\n\r\nYang bikin Shinso spesial adalah perkembangan dirinya. Dari murid biasa yang gagal masuk kelas hero karena kurang kemampuan fisik, ia bekerja keras hingga akhirnya mendapatkan perhatian Aizawa dan masuk ke jalur pahlawan melalui latihan intensif. Transformasi ini menjadikannya simbol bahwa siapapun bisa menjadi pahlawan selama mau berusaha.\r\n\r\nShinso bukan hanya karakter keren—dia adalah representasi dari perjuangan, penerimaan diri, dan dorongan untuk membuktikan nilai seseorang lewat tindakan, bukan penampilan luar.', 1, '2025-12-11 09:27:06', '2025-12-11 09:39:05');

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `comments` (`id`, `article_id`, `user_id`, `message`, `created_at`) VALUES
(5, 5, 2, 'JOSJIS MAS', '2025-12-11 10:01:42');

CREATE TABLE `highscores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `highscores` (`id`, `user_id`, `username`, `score`, `created_at`) VALUES
(1, 2, 'Mas mas', 20, '2025-12-09 14:38:45'),
(2, 1, 'Admin', 0, '2025-12-11 10:07:18');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$or8LfirUMbM4akDI13izXucGW61gSOgNwTEwpeNIEP8tdMOiOAL4m', 'admin', '2025-11-26 14:58:48'),
(2, 'Mas mas', 'mas@gmail.com', '$2y$10$Mf2.YcAIWHV.CeGr0zPQuezXeujRDNhbuyOb/GQO2cdET5YvDQNI.', 'user', '2025-12-11 09:40:50'),
(3, 'halo', 'halo@gmail.com', '$2y$10$pJ5L8/CjyMt1oi9JKnHGJea6fFsOgq29hstTYNadydm3S/DQW6oVu', 'user', '2025-12-11 10:25:46');

ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `highscores`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `highscores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;


ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;
