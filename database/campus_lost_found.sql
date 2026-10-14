-- MySQL dump 10.13  Distrib 9.6.0, for Win64 (x86_64)
--
-- Host: localhost    Database: campus_lost_found
-- ------------------------------------------------------
-- Server version	9.6.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Điện thoại','dien-thoai','Các loại điện thoại thông minh, điện thoại bàn phím cơ bản.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(2,'Ví / Bóp','vi-bop','Ví tiền, bóp đựng giấy tờ, ví cầm tay các loại.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(3,'Giấy tờ / Thẻ sinh viên','giay-to-the-sinh-vien','Thẻ sinh viên HUIT, CCCD, GPLX, thẻ ngân hàng và giấy tờ tùy thân.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(4,'Tai nghe / Thiết bị điện tử','tai-nghe-thiet-bi-dien-tu','Tai nghe bluetooth, sạc dự phòng, chuột máy tính, laptop, máy tính cầm tay.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(5,'Chìa khóa','chia-khoa','Chìa khóa xe máy, chìa khóa phòng trọ, chùm chìa khóa kèm móc khóa.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(6,'Sách vở / Tài liệu','sach-vo-tai-lieu','Giáo trình, tập vở ghi chép bài học, tài liệu ôn thi.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(7,'Bình nước / Đồ dùng cá nhân','binh-nuoc-do-dung-ca-nhan','Bình giữ nhiệt, áo khoác, nón bảo hiểm, dù che mưa, kính mắt.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(8,'Mục khác','muc-khac','Các loại đồ dùng, vật dụng cá nhân khác chưa nằm trong các danh mục trên.','2026-10-14 14:12:02','2026-10-14 14:12:02');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `claims`
--

DROP TABLE IF EXISTS `claims`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `claims` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `claims_item_id_foreign` (`item_id`),
  KEY `claims_user_id_foreign` (`user_id`),
  CONSTRAINT `claims_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `claims_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `claims`
--

LOCK TABLES `claims` WRITE;
/*!40000 ALTER TABLE `claims` DISABLE KEYS */;
INSERT INTO `claims` VALUES (1,2,4,'Chào bạn, thẻ sinh viên này chính xác là của mình bị rơi trưa nay tại căn tin. Mình có mang theo CCCD và app sinh viên HUIT để đối chiếu thông tin cá nhân.','pending',NULL,'2026-10-14 14:12:03','2026-10-14 14:12:03'),(2,18,2,'Em là chủ nhân chiếc thẻ, em đã xuất trình CCCD trùng khớp thông tin và nhận lại thẻ thành công.','approved','Đã đối chiếu thông tin sinh viên và trao trả tại văn phòng.','2026-10-14 14:12:03','2026-10-14 14:12:03');
/*!40000 ALTER TABLE `claims` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_item_id_foreign` (`item_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  CONSTRAINT `comments_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,3,'Bạn thử ghé quầy lễ tân thư viện hỏi xem, hôm qua mình thấy có chú bảo vệ đi gom đồ bạn đọc để quên đấy!','2026-10-14 14:12:03','2026-10-14 14:12:03'),(2,1,4,'Hy vọng bạn sớm tìm lại được đồ nhé, Thư viện trường mình bảo vệ trực rất cẩn thận.','2026-10-14 14:12:03','2026-10-14 14:12:03');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `type` enum('lost','found') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `event_date` date NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','returned') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `items_user_id_foreign` (`user_id`),
  KEY `items_category_id_foreign` (`category_id`),
  KEY `items_location_id_foreign` (`location_id`),
  CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `items_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,2,1,1,'lost','Để quên điện thoại iPhone 11 màu đen tại bàn đọc tầng 2','Mình có để quên một chiếc iPhone 11 màu đen có ốp lưng trong suốt viền xanh tại bàn đọc sách lầu 2 Thư viện chiều ngày hôm qua. Màn hình khóa có hình chú mèo.','item_1.png','2026-10-13','SĐT: 0912345678 (Luân)','approved','2026-10-14 14:12:02','2026-10-14 14:12:02'),(2,3,3,2,'found','Nhặt được Thẻ sinh viên HUIT mang tên Trần Minh Tâm','Trưa nay lúc ăn cơm tại Căn tin bàn số 14, mình có nhặt được 01 thẻ sinh viên khoa CNTT tên Trần Minh Tâm, MSSV: 2001229988. Bạn nào là chủ nhân liên hệ mình để nhận lại nhé.','item_2.png','2026-10-14','Liên hệ Duy - 0923456789 hoặc qua zalo','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(3,4,2,3,'lost','Rơi ví da nam màu nâu tại khu vực gửi xe máy Tòa B','Sáng nay khoảng 7h15 lúc lấy xe tại hầm xe Tòa B mình làm rơi ví da màu nâu hiệu Pedro. Bên trong có GPLX, CCCD và một ít tiền mặt. Rất mong bạn nào nhặt được cho mình chuộc lại.','item_3.png','2026-10-12','Diệu - 0934567890','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(4,5,4,5,'found','Nhặt được hộp sạc tai nghe AirPods Pro màu trắng phòng B302','Sau tiết học Kỹ thuật lập trình tại phòng máy B302, mình thấy hộp sạc tai nghe AirPods Pro bỏ quên trên bàn giáo viên. Hiện mình đang giữ, ai mất liên hệ đối chiếu seri.','item_4.png','2026-10-13','Nguyên - 0945678901','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(5,2,5,7,'found','Chùm chìa khóa xe Honda kèm móc khóa gấu bông màu đỏ','Nhặt được ở hàng ghế khán đài sân bóng rổ trường vào chiều thứ Ba. Chùm gồm 2 chìa khóa xe máy Smartkey và 1 chìa khóa phòng trọ.','item_5.png','2026-10-11','0912345678','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(6,3,6,4,'lost','Mất tập giáo trình Cấu trúc dữ liệu và giải thuật tại phòng A205','Chiều qua mình học môn CTDL&GT tại phòng A205 và có bỏ quên cuốn giáo trình bìa xanh lá, bên trong có kẹp nhiều bài tập và ghi chú quan trọng.','item_6.png','2026-10-12','Duy - duy.nk@huit.edu.vn','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(7,4,7,1,'found','Bình giữ nhiệt Lock&Lock màu xanh ngọc tại phòng tự học','Bình giữ nhiệt dung tích 500ml màu xanh ngọc bích, có dán sticker anime One Piece, để quên tại góc tự học tầng 1 Thư viện.','item_7.png','2026-10-13','Diệu - 0934567890','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(8,5,1,2,'found','Nhặt được điện thoại Samsung Galaxy A54 màu tím nhạt','Trưa nay nhặt được máy Samsung màu tím nhạt để trên bàn ăn căn tin. Máy đã hết pin tắt nguồn, đã sạc lên được một chút. Ai là chủ nhân vui lòng đem giấy tờ xác minh.','item_8.png','2026-10-14','Nguyên - 0945678901','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(9,2,3,6,'lost','Rơi ví kẹp thẻ chứa Căn cước công dân và thẻ ATM Vietcombank','Đoạn đường từ sảnh Tòa C sang văn phòng khoa mình làm rơi bóp kẹp thẻ màu xám. Bên trong có thẻ CCCD mang tên Lê Hữu Luân.','item_9.png','2026-10-10','0912345678','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(10,3,4,1,'lost','Tìm chuột không dây Logitech MX Anywhere 3 màu xám tro','Hôm qua mình ngồi làm đồ án tại phòng máy tính thư viện lầu 3 và để quên chuột không dây. Chuột có vết xước nhẹ ở nút click trái.','item_10.png','2026-10-12','2001230124@huit.edu.vn','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(11,4,7,3,'found','Nhặt được nón bảo hiểm Royal màu xanh rêu còn mới','Bác bảo vệ gửi mình nón bảo hiểm treo trên gương xe máy Wave đỏ ở hàng B nhà xe suốt 2 ngày chưa thấy ai lấy. Bạn nào quên thì liên hệ nhận lại.','item_11.png','2026-10-12','0934567890','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(12,5,6,5,'found','Tài liệu ôn thi Lập trình mã nguồn mở của Nhóm 4','Thấy một bìa hồ sơ màu vàng chứa bản thảo tài liệu báo cáo đồ án và một cuốn sổ tay nhỏ để quên tại ghế đá trước Tòa B.','item_12.png','2026-10-13','Phòng thực hành B301 hoặc gọi 0945678901','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(13,2,5,4,'lost','Đánh rơi chìa khóa xe Yamaha Exciter kèm thẻ từ chung cư','Sáng nay di chuyển từ cầu thang bộ tầng 3 Tòa A xuống sảnh trệt, mình đánh rơi móc khóa xe máy và thẻ từ thang máy màu xanh dương.','item_13.png','2026-10-14','Luân - 0912345678','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(14,3,4,2,'found','Nhặt được sạc dự phòng Baseus 20000mAh màu đen','Cục pin sạc dự phòng công suất 65W màu đen nhám để quên cạnh ổ cắm điện căn tin trường trưa hôm nay.','item_14.png','2026-10-14','Liên hệ Duy - SĐT: 0923456789','approved','2026-10-14 14:12:03','2026-10-14 14:12:03'),(15,4,1,7,'lost','Đánh rơi điện thoại Xiaomi Redmi Note 12 khi chơi bóng chuyền','Chiều nay lúc 16h mình tham gia đá cầu tại sân thể thao và bị rớt điện thoại Xiaomi màu xanh dương. Mặt lưng có dán tem bảo hành.','item_15.png','2026-10-14','Diệu - 0934567890','pending','2026-10-14 14:12:03','2026-10-14 14:12:03'),(16,5,2,6,'found','Nhặt được ví nữ mini màu hồng phấn tại hành lang tầng 3','Hành lang tầng 3 Tòa C, nhặt được chiếc ví nữ nhỏ màu hồng nhạt. Bên trong có thẻ ngân hàng Agribank và một số giấy tờ.','item_16.png','2026-10-14','Nguyên - 0945678901','pending','2026-10-14 14:12:03','2026-10-14 14:12:03'),(17,2,8,8,'lost','Để quên áo khoác dù màu đen có logo HUIT trước phòng CTSV','Hôm qua đến phòng CTSV nộp hồ sơ xin giấy xác nhận sinh viên mình có cởi áo khoác vắt trên hàng ghế chờ và quên mang về.','item_17.png','2026-10-13','0912345678','pending','2026-10-14 14:12:03','2026-10-14 14:12:03'),(18,3,3,1,'found','Thẻ sinh viên HUIT mang tên Lê Văn Long','Đã xác minh và hoàn trả trực tiếp cho bạn Long vào sáng hôm nay tại sảnh chính Thư viện.','item_18.png','2026-10-09','Đã bàn giao hoàn tất','returned','2026-10-14 14:12:03','2026-10-14 14:12:03'),(19,4,5,3,'lost','Chìa khóa xe máy Sirius màu đen','Mình đã nhận lại chùm chìa khóa từ phòng bảo vệ nhà xe Tòa A. Xin chân thành cảm ơn các bạn và các chú bảo vệ!','item_19.png','2026-10-08','Đã giải quyết','returned','2026-10-14 14:12:03','2026-10-14 14:12:03');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Thư viện','Khuôn viên Thư viện trường HUIT, các phòng đọc và khu tự học.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(2,'Căn tin','Khu dịch vụ ăn uống sinh viên và giảng viên.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(3,'Nhà xe','Bãi giữ xe máy và xe đạp sinh viên trong khuôn viên trường.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(4,'Tòa A','Khu giảng đường và các phòng học lý thuyết Tòa A.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(5,'Tòa B','Khu phòng học thực hành tin học và thí nghiệm Tòa B.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(6,'Tòa C','Khu văn phòng khoa và các phòng chức năng Tòa C.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(7,'Sân thể thao','Khu tập luyện thể dục thể thao, sân bóng rổ, cầu lông.','2026-10-14 14:12:02','2026-10-14 14:12:02'),(8,'Phòng Công tác sinh viên (CTSV)','Văn phòng hỗ trợ sinh viên và tiếp nhận đồ thất lạc chính thức.','2026-10-14 14:12:02','2026-10-14 14:12:02');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_01_01_000001_create_categories_table',1),(5,'2026_01_01_000002_create_locations_table',1),(6,'2026_01_01_000003_create_items_table',1),(7,'2026_01_01_000004_create_claims_table',1),(8,'2026_01_01_000005_create_comments_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `student_code` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Quản trị viên HUIT','admin@huit.edu.vn','$2y$12$Rzv16bdMaokAacw6UnQZL./XtyWg597AeX1ko1zx7XR16zavqFv5a','0901234567','ADMIN01',NULL,'admin',0,NULL,'2026-10-14 14:12:01','2026-10-14 14:12:01'),(2,'Lê Hữu Luân','2001230482@huit.edu.vn','$2y$12$7soqRyydZZ5hS5o0u2qk.ewC9sqYif8ByB6SEdx3kiWGOwe79Pxd2','0912345678','2001230482',NULL,'user',0,NULL,'2026-10-14 14:12:01','2026-10-14 14:12:01'),(3,'Nguyễn Khánh Duy','2001230124@huit.edu.vn','$2y$12$Nb1ZnieU6ob0RMMi.gWuCuREWRbCJ5oB7EQnDq42LJ7G4/wB2umeG','0923456789','2001230124',NULL,'user',0,NULL,'2026-10-14 14:12:01','2026-10-14 14:12:01'),(4,'Trương Quang Diệu','2001230097@huit.edu.vn','$2y$12$HzY9O04IjH3SGezuczuBju8jifZkAUrZSzPsjg59PvyMAMImP9esS','0934567890','2001230097',NULL,'user',0,NULL,'2026-10-14 14:12:02','2026-10-14 14:12:02'),(5,'Phạm Hải Nguyên','2001230581@huit.edu.vn','$2y$12$6BcedMyUauItLYZqncodNO906vj9iQkg2DQBGiyMm9TXEsfSHcqNO','0945678901','2001230581',NULL,'user',0,NULL,'2026-10-14 14:12:02','2026-10-14 14:12:02');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-14 22:23:50
