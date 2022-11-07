-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2022 at 03:22 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `starorganic`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addProduct` (IN `name` VARCHAR(50) CHARSET utf8mb4, IN `price` FLOAT UNSIGNED, IN `detail` TEXT, IN `catID` INT, IN `imgURL` TEXT CHARSET utf8mb4)   INSERT INTO product (productName, unitPrice, productDetail, categoryID, imgURL) VALUES (name, price, detail, catID, imgURL)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchProduct` (IN `search` VARCHAR(20))   SELECT img.imgURL, pd.productID, pd.productName, ct.categoryName, pd.productDetail, pd.unitPrice, pd.stock 
FROM product as pd 
INNER JOIN category as ct ON pd.categoryID = ct.categoryID 
INNER JOIN image as img ON pd.productID = img.productID 
WHERE pd.productName LIKE CONCAT('%',search,'%')
ORDER by ct.categoryName$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePrice` (IN `ID` INT UNSIGNED, IN `price` FLOAT)   UPDATE product SET unitPrice = price WHERE productID = ID$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `categoryName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryDetail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`, `unit`, `categoryDetail`, `status`) VALUES
(1, 'Bia Lon', 'thùng', 'Bia dong lon', 1),
(2, 'Bia chai', 'Két', 'Bia dong chai', 1),
(3, 'Rượu', 'Chai', 'Rượi', 1),
(4, 'Nước giải khát', 'Thùng', 'Nước ngọt', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `first_name`, `last_name`, `email`, `phone`, `message`, `datetime`, `status`) VALUES
(1, 'Duy', 'Khanh', 'khanh@gmail.com', '0123456789', 'test', '2021-08-11 10:31:37', 1),
(2, 'Phạm', 'Đạt', 'phamquangdat2208@gmail.com', '0904855879', 'I want to contact with you', '2021-08-11 11:30:53', 1),
(3, 'Đào', 'Hà', 'thanhha@fac.vn', '+84904833800', 'I want to by some fruit', '2021-08-12 15:38:24', 1),
(4, 'Nguyen Huu', 'Tung', 'nguyenhuutung02042001@gmail.com', '0387582508', 'tesstttt', '2021-08-18 16:05:34', 1),
(5, 'Ha', 'Thanh', 'duykhanh@gmail.com', '909897786', '&lt;script&gt;alert(&quot;test&quot;)&lt;/script&gt;', '2021-08-18 16:06:13', 1),
(6, 'Minh Thái', 'Nguyễn', 'nguyenminhthai22092000@gmail.com', '0981640965', 'Hello ae \r\n', '2021-08-18 16:07:26', 1),
(9, 'Thanh Hà', 'Đào', 'june25th87@gmail.com', '+84988144706', '&lt;i&gt;Xin chào&lt;/i&gt;', '2021-08-18 16:26:32', 1),
(10, 'Thanh', 'Đào', 'june25th87@gmail.com', '+84988144706', 'Test message', '2021-08-18 16:28:40', 1),
(11, 'Đào', 'Hà', 'thanhha@fac.vn', '+84904833800', 'Hello', '2021-08-18 16:39:59', 1),
(12, 'Pham', 'Dat', 'phamquangdat2208@gmail.com', '0904855879', 'Hello', '2021-08-18 22:39:51', 1),
(13, 'Duy', 'Khanh', 'duykhanh@gmail.com', '0123456789', 'test', '2021-08-19 20:56:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `customerName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerPhone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `joinDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `customerName`, `customerEmail`, `customerPhone`, `password`, `joinDate`) VALUES
(1, 'default', 'default', 'default', 'default', '2021-07-22 20:57:15'),
(2, 'ThanhHa', 'thanhha@gmail.com', '0988144706', '$2y$10$gRdJPpAMgtRNRRWlp8Q.MeSR.LSi2zJBHbcPAiPcLlCVnyfoh3aSu', '2021-08-06 15:11:20'),
(3, 'DuyKhanh', 'duykhanh@gmail.com', '0987654322', '$2y$10$qmR7bBXmSaJHESzYQtVl.e5ZiehEy.7wZCTM.d5QYG/Jalv7qHPDq', '2021-08-06 15:12:45'),
(4, 'MinhThai', 'thai@gmail.com', '1234567809', '$2y$10$6KNDFZXgICsAynGzfyCUP.dE31mdhvAiP2CvSwk2WBcHdkG83XK0W', '2021-08-06 15:28:49'),
(5, 'duchiep', 'hiep@gmail.com', '0987654321', '$2y$10$45DREmGENXLQa8FdkVnlPeL6F2H1N9RB27L1a5mlwYljcFHPJ5wXi', '2021-08-11 10:33:40'),
(6, 'Phạm Quang Đạt', 'phamquangdat2208@gmail.com', '0904855879', '$2y$10$Oz0jufoXSMwltQwM989J8eWBQZKK2ohLqB.JuI6O40gqnKFacJjLu', '2021-08-11 11:33:44'),
(7, 'Pham Quang Dat', 'dat@gmail.com', '0913579951', '$2y$10$qvRHsw2VikJ.ASGRpugOjOUdbsITTNCuOR1jSIb9ZMnPpqHlOnQNS', '2021-08-17 20:00:24'),
(8, 'Pham Quang Dat', 'dat2@gmail.com', '0904855869', '$2y$10$j4KFLI83UBtAMmFR1riWVORQRr8g1Zu9a7YUh9a6tK7G9kxwlWVjy', '2021-08-21 00:56:38');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `imgURL` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `imgURL`, `category`) VALUES
(1, 'imgs/gallery/farmer.jpg', 'Farmer'),
(2, 'imgs/gallery/farm.jpg', 'Farm'),
(3, 'imgs/gallery/farmer2.jpg', 'Farmer'),
(4, 'imgs/gallery/animal.jpg', 'Animal'),
(5, 'imgs/gallery/product.jpg', 'Product'),
(6, 'imgs/gallery/animal2.jpg', 'Animal'),
(7, 'imgs/gallery/animal3.jpg', 'Animal'),
(8, 'imgs/gallery/farmer3.jpg', 'Farmer'),
(9, 'imgs/gallery/product2.jpg', 'Product'),
(10, 'imgs/gallery/animal4.jpg', 'Animal'),
(12, 'imgs/gallery/farmer4.jpg', 'Farmer'),
(13, 'imgs/gallery/farm2.jpg', 'Farm'),
(15, 'imgs/gallery/farm4.jpg', 'Farm'),
(16, 'imgs/gallery/farm5.jpg', 'Farm'),
(17, 'imgs/gallery/product4.jpg', 'Product'),
(18, 'imgs/gallery/farmer5.jpg', 'Farmer'),
(19, 'imgs/gallery/product3.jpg', 'Product'),
(20, 'imgs/gallery/product5.jpg', 'Product'),
(21, 'imgs/gallery/farm3.jpg', 'Farm'),
(22, 'imgs/gallery/611fcf2435c08animal5.jpg', 'Animal');

-- --------------------------------------------------------

--
-- Table structure for table `gallerycat`
--

CREATE TABLE `gallerycat` (
  `ID` int(11) NOT NULL,
  `category` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallerycat`
--

INSERT INTO `gallerycat` (`ID`, `category`) VALUES
(3, 'Animal'),
(2, 'Farm'),
(1, 'Farmer'),
(4, 'Product');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `orderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `orderDetailPrice` float NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`orderID`, `productID`, `orderDetailPrice`, `quantity`) VALUES
(1, 9, 0.25, 1),
(1, 10, 0.25, 1),
(1, 22, 0.5, 1),
(2, 5, 1.25, 4),
(2, 6, 3.5, 1),
(2, 7, 3.5, 1),
(3, 9, 0.25, 3),
(3, 10, 0.25, 3),
(3, 22, 0.5, 3),
(4, 3, 1.75, 5),
(4, 4, 1, 3),
(4, 11, 2.29, 5),
(4, 15, 6.99, 2),
(5, 2, 0.75, 1),
(5, 6, 3.5, 1),
(5, 10, 0.25, 1),
(8, 1, 0.5, 5),
(8, 5, 1.25, 7),
(8, 6, 3.5, 4),
(9, 2, 0.75, 4),
(9, 3, 1.75, 5),
(9, 6, 3.5, 5),
(9, 9, 0.25, 6),
(9, 10, 0.25, 5),
(9, 12, 3.99, 1),
(9, 13, 4.99, 1),
(10, 1, 0.5, 1),
(10, 2, 0.75, 1),
(10, 3, 1.75, 4),
(10, 4, 1, 1),
(10, 6, 3.5, 3),
(10, 7, 3.5, 1),
(11, 2, 0.75, 1),
(11, 3, 1.75, 1),
(11, 4, 1, 1),
(11, 6, 3.5, 1),
(12, 2, 0.75, 2),
(12, 6, 3.5, 1),
(13, 2, 0.75, 1),
(13, 3, 1.75, 1),
(14, 1, 0.5, 3),
(14, 2, 0.75, 1),
(14, 3, 1.75, 1),
(14, 6, 3.5, 1),
(14, 17, 2.5, 1),
(14, 18, 3.5, 4),
(14, 21, 6.5, 1),
(14, 34, 5.5, 1),
(15, 2, 0.75, 3),
(15, 3, 1.75, 3),
(15, 4, 1, 3);

--
-- Triggers `orderdetail`
--
DELIMITER $$
CREATE TRIGGER `totalValue_Delete` AFTER DELETE ON `orderdetail` FOR EACH ROW UPDATE orders SET orderValue = (SELECT SUM(orderDetailPrice * quantity) FROM orderdetail) WHERE orderID = OLD.orderID
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `totalValue_Update` AFTER UPDATE ON `orderdetail` FOR EACH ROW UPDATE orders SET orderValue = (SELECT SUM(orderDetailPrice * quantity) FROM orderdetail) WHERE orderID = NEW.orderID
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `unitprice` BEFORE INSERT ON `orderdetail` FOR EACH ROW IF NEW.orderDetailPrice = 0 THEN
SET NEW.orderDetailPrice = (SELECT unitPrice FROM product WHERE productID = NEW.productID);
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `orderTime` datetime DEFAULT current_timestamp(),
  `dAdd` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderValue` float NOT NULL DEFAULT 0,
  `orderStatus` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `staffID` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `customerID`, `orderTime`, `dAdd`, `phone`, `orderValue`, `orderStatus`, `staffID`) VALUES
(1, 3, '2021-08-08 11:02:39', 'Nhà Thầy Tuấn', '0987654884', 1, 'cancel', 1),
(2, 3, '2021-08-08 14:30:18', 'Some place', '12345', 12, 'success', 1),
(3, 3, '2021-08-09 14:54:25', '283 Đội Cấn', '987760765', 3, 'success', 2),
(4, 3, '2021-08-09 17:11:22', '199 Cầu Giấy', '098734899', 37.18, 'success', 1),
(5, 3, '2021-08-11 19:53:49', 'Riverside Garden - 349 Vũ Tông Phan, Khương Đình, Thanh Xuân, Hà Nội', '+84904833800', 4.5, 'success', 2),
(8, 3, '2021-08-13 09:04:19', '33 ngõ 477 Kim Ngưu - Hai Bà Trưng - Hà Nội', '0987654321', 25.25, 'success', 7),
(9, 3, '2021-08-13 09:20:33', '33 ngõ 477 Kim Ngưu - Hai Bà Trưng - Hà Nội', '0987654321', 40.98, 'success', 7),
(10, 3, '2021-08-17 18:02:03', '33 ngõ 477 Kim Ngưu - Hai Bà Trưng - Hà Nội', '0987654321', 23.25, 'success', 7),
(11, 4, '2021-08-17 18:05:03', 'Nhà của Thái', '0987888655', 7, 'success', 7),
(12, 7, '2021-08-17 20:00:43', 'Au Co', '0913579951', 5, 'success', 7),
(13, 4, '2021-08-18 21:59:49', '59 hàng gai', '0981640965', 2.5, 'pending', 0),
(14, 8, '2021-08-21 00:57:32', '142 Âu Cơ Tây Hồ Hà Nội', '0904855869', 36, 'success', 4),
(15, 4, '2021-08-21 09:14:39', 'Thai&#39;s home', '0987439871', 10.5, 'pending', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int(11) NOT NULL,
  `productName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unitPrice` float NOT NULL,
  `productDetail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryID` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `imgURL` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `unitPrice`, `productDetail`, `categoryID`, `status`, `imgURL`) VALUES
(1, 'Sour Apple', 0.5, 'Sour Apple is a tropical fruit tree, belonging to the Apple family\r\nIn China, it is called sour apple, Indian apple or Tian apple, Yunnan hawthorn. The tree can grow very quickly even in dry places and is up to 12 meters tall, with a lifespan of 25 years.', 1, 1, 'imgs/tao-chua.jpg'),
(2, 'Apple', 0.75, 'Apples are incredibly good for you, and eating them is linked to a lower risk of many major diseases, including diabetes and cancer. What\'s more, its soluble fiber content may promote weight loss and gut health. A medium apple equals 1.5 cups of fruit.', 1, 1, 'imgs/tao-tay.jpg'),
(3, 'Blueberry', 1.75, 'One cup of fresh blueberries contains 85 calories, 1 gram of protein, no fat, and about 20 grams of carbohydrate, with roughly 4 grams as fiber. That same portion also packs over four ounces of water, and nearly a quarter of the daily minimum target for immune- and skin-supporting vitamin C. They also provide over a third of the daily goal for bone-supporting vitamin K, and a quarter for manganese. The latter nutrient also helps maintain strong bones, in addition to promoting collagen production for healthy skin and joints.', 1, 1, 'imgs/viet-quat.jpg'),
(4, 'Banana', 1, 'Bananas are an excellent source of potassium and supply vitamin B6, fibre and carbohydrate, and some vitamin C. Since they have a lower water content than most fruit, bananas typically have more calories as well as a higher sugar content compared to other non-tropical fruits.', 1, 1, 'imgs/chuoi.jpg'),
(5, 'Coconut', 1.25, 'Rich in fiber and MCTs, it may offer a number of benefits, including improved heart health, weight loss, and digestion. Yet, it\'s high in calories and saturated fat, so you should eat it in moderation. Overall, unsweetened coconut meat makes a great addition to a balanced diet.', 1, 1, 'imgs/dua.jpg'),
(6, 'Cherry', 3.5, 'Cherries are low in calories and chock full of fiber, vitamins, minerals, nutrients, and other good-for-you ingredients. You’ll get vitamins C, A, and K. Each long-stemmed fruit delivers potassium, magnesium, and calcium too. They also bring antioxidants, like beta-carotene, and the essential nutrient choline.', 1, 1, 'imgs/cherry.jpg'),
(7, 'Dragon Fruit', 3.5, 'Dragon fruit is a plant grown mainly for its fruit and is also the name of several genera of the cactus family. Dragon fruit is a native plant in Mexico, Central American, and South American countries. \r\nCurrently, these plants are also grown in countries in Southeast Asia such as Vietnam, Malaysia, Thailand, Philippines, Indonesia (especially in western Java island); southern China, Taiwan and some other areas.\r\n', 1, 1, 'imgs/thanh-long.jpg'),
(8, 'Chili', 1.25, 'Chili is a fruit of plants of the genus Capsicum of the Ca family. Chili is a spice as well as a popular vegetable in the world.', 3, 1, 'imgs/ot.jpg'),
(9, 'Spring Onion', 0.25, 'Green onion or Spring Onion, young onion is the common name of the species of the genus Onion. All green onions have hollow green leaves, but lack a fully developed onion stem. \r\nThey are grown for a milder flavor than most onions and are eaten raw or cooked as a vegetable.', 3, 1, 'imgs/hanh-la.jpg'),
(10, 'Garlic', 0.5, 'Garlic is most often used as a flavoring agent but can also be eaten as a vegetable. It is used to flavor many foods, such as salad dressings, vinaigrettes, marinades, sauces, vegetables, meats, soups, and stews. It is often used to make garlic butter and garlic toast.', 3, 1, 'imgs/toi.jpg'),
(11, 'Eight Sea Queens Rice', 2.29, 'Eight rice in Hai Hau, Nam Dinh is one of the special types of rice that is favored by consumers today.\r\nEight fragrant rice in Hai Hau, Nam Dinh is famous near and far and has been included in many folk songs and proverbs of Vietnamese folklore.', 2, 1, 'imgs/tam-hai-hau.png'),
(12, 'Eight-xoan rice', 3.99, 'This is a traditional rice variety, selected from the people and restored to Tam Xoan rice in Hai Hau, with the following specific characteristics: the rice grain is a bit long, thin and crooked at one end; seeds have a clear green color; mild, natural and characteristic aroma; no silver belly.', 2, 1, 'imgs/tam-xoan.jpg'),
(13, 'North Huong rice', 4.99, 'Nam Dinh specialty northern rice - Nam Dinh northern incense rice grown in Hai Hau and Giao Thuy areas is a specialty rice product.\r\nThe rice grain is small, long, white, flexible, and sticky. When cooked, the rice is fragrant, the rice is cooled and still retains its plasticity and aroma.', 2, 1, 'imgs/bac-huong.jpg'),
(14, 'Thai fragrant rice', 5.99, 'Thai fragrant rice originated in Vietnam, small white rice grain slightly opaque.\r\nIn fact, Thai fragrant rice is also known as jasmine fragrant rice, rice variety is propagated from Thai rice variety, giving a natural light aroma, easy to cook rice, especially with stable price and not too much high for Vietnamese working people but still gives delicious meals, suitable for all ages in the family...', 2, 1, 'imgs/thom-thai.jpg'),
(15, 'ST24 Rice', 6.99, 'ST24 rice, also known as jasmine rice vermicelli, is a type of rice grown in Soc Trang province by engineer Ho Quang Cua.\r\nThe characteristic feature of rice variety ST24 is that it is well adapted to changing weather conditions, can be grown in alum, saline soil suitable for alkaline and saline soil conditions in the Southeast region, giving high yield stable rate.', 2, 1, 'imgs/st24.jpg'),
(16, 'Ham Chau Rice', 7.99, 'Ham Chau rice is created from short-term rice varieties. Rice has clear white grain, large and long. When cooking, the rice expands and becomes more spongy. \r\nThey are rice varieties that can be grown in a variety of soil types.\r\nThis is the most suitable type of rice for shops selling fried rice, pancakes, rolls...', 2, 1, 'imgs/ham-chau.png'),
(17, 'Olive Oil', 2.5, 'Olive oil is an oil obtained from the olive tree, a traditional tree of the Mediterranean region. It is commonly used in cooking, cosmetics, pharmaceuticals, and soaps and has fueled traditional kerosene lamps.\r\nOlive oil is used all over the world, but especially in the Mediterranean countries.', 4, 1, 'imgs/dau-olive.jpg'),
(18, 'Soybean Oil', 3.5, 'Soybean oil is a vegetable oil extracted from the seeds of soybeans. It is one of the most widely consumed cooking oils and the second most consumed vegetable oil.\r\nAs a drying oil, processed soybean oil is also used as a base for printing inks and oil paints.', 4, 1, 'imgs/dau-dau-nanh.jpg'),
(19, 'Coconut Oil', 3.5, 'Coconut oil is an edible oil extracted from coconut meat. In the tropics, it is an important source of fat in people\'s diets. \r\nIt is used in many fields such as food, pharmaceutical, and industrial.', 4, 1, 'imgs/dau-dua.jpg'),
(20, 'Fish Oil', 5.5, 'Fish oil is an oil derived from the tissues of oily fish such as salmon, mackerel, sardines, tuna, herring, and cod.\r\nFish oil contains the omega-3 fatty acids eicosapentaenoic acid and docosahexaenoic acid which provide many health benefits.', 4, 1, 'imgs/dau-ca.jpg'),
(21, 'Sesame Oil', 6.5, 'Sesame oil is an edible vegetable oil extracted from sesame seeds.\r\nIn addition to its use as a cooking oil in South India, it is commonly used as a seasoning in Chinese, Japanese, Middle Eastern, Korean, and Southeast Asian cuisines.', 4, 1, 'imgs/dau-me.jpg'),
(22, 'Ginger', 0.5, 'Ginger is often associated with Asian cooking, and commonly used in stir-fries, but its spicy, zesty taste is also delicious in beverages, baked goods, marinades and on fruit and vegetables. ... You can add ginger when cooking at the beginning for a milder taste, or at the end for a more pungent flavor.', 3, 1, 'imgs/gung.jpg'),
(23, 'ST25', 12, 'ST25 rice, also known as Soc Trang fragrant rice, is the result of 20 years of research by engineer Ho Quang Cua.\r\nThe quality of ST25 rice has been recognized in the international arena when it won the title of &quot;&quot;World\'s Best Rice 2019&quot;&quot; and won the second prize at the &quot;&quot;World\'s Best Rice 2020&quot;&quot; contest held in the US. confirmed the premium quality of Vietnamese rice grains\r\n', 2, 1, 'imgs/st25.jpg'),
(28, 'Galic Powder', 1.25, 'Chili powder is the dried, pulverized fruit of one or more varieties of chili pepper, sometimes with the addition of other spices. \r\nIt is used as a spice to add pungency and flavor to culinary dishes. In American English, the spelling is usually &quot;chili&quot;; in British English, &quot;chilli&quot; is used consistently.', 3, 1, 'imgs/bot-toi.jpg'),
(29, 'Carrot Powder', 1.99, 'Carrot powder is a product from carrots after a process of processing by modern methods. The water is completely removed so that the powder is in a dry, smooth form, but its inherent nutritional content is not lost or reduced, but is still preserved thanks to high technology.', 3, 1, 'imgs/bot-ca-rot.png'),
(30, 'Basil Powder', 2.99, 'Basil is an aromatic powder used as a seasoning to marinate meats, stews, roasts, grills, curries, and enhances the flavor of dishes. They are widely used in fatty meat dishes such as braised pork, roast duck, braised beef. In addition, basil is also very popular in stir-fried vegetables and seafood dishes. Not only bringing delicious flavor specific to each dish, basil is also a spice containing many ingredients with healing effects.', 3, 1, 'imgs/bot-hung-liu.jpg'),
(31, 'Lemon Powder', 2.99, 'Lemon powder is a soluble powder, the product is extracted from 100% fresh lemon.\r\nEnsure the convenience, economy, hygiene to keep the taste of fresh lemon to the user.', 3, 1, 'imgs/bot-chanh.jpg'),
(32, 'Pure Salt', 0.99, 'Table salt or simply called salt in folklore (although not all salt is in the correct scientific terms) is a mineral used by humans as a spice in food. \r\nTable salt is essential to life, but excessive use can increase the risk of health problems, such as high blood pressure. In cooking, table salt is used as a preservative as well as a seasoning.', 3, 1, 'imgs/611f219b70ed0muoi.jpg'),
(33, 'Pepper', 1.99, 'Pepper powder is a seasoning ingredient in dishes, contributing to making dishes more attractive and delicious.\r\nQuality pepper powder is a type of pepper powder that has met the standards set out according to Vietnam\'s pepper standards.', 3, 1, 'imgs/611f20fe535b9tieu.jpg'),
(34, 'Avocado Oil', 5.5, 'Avocado oil is an edible oil extracted from the pulp of the avocado, the fruit of Persea americana.\r\nIt is used as a cooking oil both raw and for cooking, where it is noted to have a high smoke point. It is also used for lubrication and in cosmetics.', 4, 1, 'imgs/dau-bo.jpg'),
(35, 'Peanut Oil', 5, 'Peanut oil, also known as peanut oil or arachis oil, is a vegetable oil derived from peanuts.\r\nThe oil usually has a mild or neutral flavor but if made with roasted peanuts, has a stronger peanut flavor and aroma.', 4, 1, 'imgs/611f89dde6fd2dau-lac.jpg'),
(40, 'Bia HaniKen 24 chai/Két', 280, '<p>Gi&aacute; b&aacute;n lẻ 15.000đ/chai</p>\r\n', 2, 1, 'imgs/634a69e49d431hniken.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `userName` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roleID` int(11) NOT NULL DEFAULT 2,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `userName`, `email`, `password`, `roleID`, `status`) VALUES
(1, 'rootadmin', 'ha.dt.1027@aptechlearning.edu.vn', '$2y$10$Ny3sOklqVXCpTGk/LL8.IujSzkcA2RI4e4geA5baBlkL/rOaHWv/O', 1, 1),
(2, 'MinhThai', 'minhthai@gmail.com', '$2y$10$jRntZ8v3QR6nGhSu/GoAsO6OZd/leAs.Aoi4H6vFYrTJonalMwaQm', 2, 1),
(3, 'DuyKhanh', 'khanh@gmail.com', '$2y$10$n4vJSxQEudheEdp8HGoGi.HImLFBzBUr2k5kwEy9YLv9YQLiECQOq', 2, 1),
(4, 'ThanhHa', 'ha.dt@gmail.com', '$2y$10$yBNQYb5MREpLEYsaIW59mOW3fdjL65zn6NIXMFpaYNDD1d9N5wTCG', 2, 1),
(6, 'QuangDat', 'quangdat@gmail.com', '$2y$10$H2pKySGl18oDmplTXg/62uk03mB27hvykyASttMFfAYRYEAR0QmSS', 2, 0),
(7, 'DucHiep', 'duchiep@gmail.com', '$2y$10$jUM9MawteI31V.FdyhKbDevcIkfyterl1JjdbKVwTcKTKJNvybYhG', 2, 1),
(8, 'HuuTung', 'tung@gmail.com', '$2y$10$n2Zwa160pNR7TYZdNYL.3.vH6Cmym88EatvLEzKTTCl633ORawfCm', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `staffrole`
--

CREATE TABLE `staffrole` (
  `roleID` int(11) NOT NULL,
  `roleName` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roleDetail` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staffrole`
--

INSERT INTO `staffrole` (`roleID`, `roleName`, `roleDetail`) VALUES
(1, 'admin', 'full control over the system, can alter other user account'),
(2, 'sale', 'can only perform sale operation such as: process order, make order...');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`),
  ADD UNIQUE KEY `categoryName` (`categoryName`),
  ADD UNIQUE KEY `categoryName_2` (`categoryName`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`),
  ADD UNIQUE KEY `customerName` (`customerName`,`customerEmail`,`customerPhone`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_name` (`category`);

--
-- Indexes for table `gallerycat`
--
ALTER TABLE `gallerycat`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `galleryName` (`category`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`orderID`,`productID`),
  ADD KEY `FK_OD_PR` (`productID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `FK_Cus_OD` (`customerID`),
  ADD KEY `FK_uID_OD` (`staffID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD UNIQUE KEY `productName` (`productName`),
  ADD UNIQUE KEY `productName_2` (`productName`),
  ADD UNIQUE KEY `productName_3` (`productName`),
  ADD KEY `FK_Pro_Cat` (`categoryID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD UNIQUE KEY `userName` (`userName`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `userName_2` (`userName`,`email`),
  ADD KEY `FK_Staff_Roll` (`roleID`);

--
-- Indexes for table `staffrole`
--
ALTER TABLE `staffrole`
  ADD PRIMARY KEY (`roleID`),
  ADD UNIQUE KEY `roleName` (`roleName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `gallerycat`
--
ALTER TABLE `gallerycat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staffrole`
--
ALTER TABLE `staffrole`
  MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_name` FOREIGN KEY (`category`) REFERENCES `gallerycat` (`category`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `FK_OD_Product` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `FK_OD_order` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_Cus_OD` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_Pro_Cat` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `FK_Staff_Roll` FOREIGN KEY (`roleID`) REFERENCES `staffrole` (`roleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
