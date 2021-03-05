/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : lacms

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-01-09 21:14:57
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `categories`
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `image` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT '0',
  `lang` varchar(5) DEFAULT 'vi',
  `type` tinyint(1) DEFAULT '1',
  `description` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `is_home` tinyint(1) DEFAULT '1',
  `pid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('2', 'Siêu thị', '0', null, '1', '1536303600', 'vi', '1', null, null, '1', '0');
INSERT INTO `categories` VALUES ('3', 'Điện gia dụng', '1', null, '10', '1536303600', 'vi', '1', null, null, '1', '0');
INSERT INTO `categories` VALUES ('6', 'Spa & Làm đẹp', '1', null, '30', '1536303600', 'vi', '1', null, null, '1', '0');
INSERT INTO `categories` VALUES ('7', 'Mỹ phẩm', '1', null, '40', '1536303600', 'vi', '1', null, null, '1', '0');
INSERT INTO `categories` VALUES ('8', 'Công nghệ & Điện tử', '1', null, '50', '1536303600', 'vi', '1', null, null, '1', '0');
INSERT INTO `categories` VALUES ('9', 'Mẹ & Bé', '1', null, '60', '1536303600', 'vi', '1', null, null, '1', '0');
INSERT INTO `categories` VALUES ('10', 'Thể thao - Du lịch', '1', null, '70', '1536303600', 'vi', '1', null, null, '1', '0');
INSERT INTO `categories` VALUES ('11', 'Sách & VPP', '1', null, '80', '1536303600', 'vi', '1', null, null, '1', '0');
INSERT INTO `categories` VALUES ('15', 'Sách văn học', '1', null, '100', '1536311812', 'vi', '1', null, null, '1', '11');
INSERT INTO `categories` VALUES ('16', 'Sách văn học nước ngoài', '1', '-1536313298.jpg', '100', '1536312408', 'vi', '1', null, null, '1', '15');
INSERT INTO `categories` VALUES ('17', 'Khuyến mãi', '1', null, '500', '1545207150', 'vi', '2', null, null, '1', '0');
INSERT INTO `categories` VALUES ('18', 'Sự kiện', '1', null, '400', '1545207566', 'vi', '2', null, null, '1', '0');
INSERT INTO `categories` VALUES ('19', 'Tin tức', '1', null, '300', '1545207590', 'vi', '2', null, null, '1', '0');

-- ----------------------------
-- Table structure for `customers`
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `reg_ip` varchar(20) DEFAULT NULL,
  `last_login_ip` varchar(20) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - chua active | 1 - active email | 2 - active phone | 3 - active all',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 - BT | 0 - xoa',
  `last_login` int(11) DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `last_active` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('2', 'lymanhha@gmail.com', 'Lý Mạnh Hà', '$2y$10$KyeX3AZubyyeTqIodrPgNeIq6YladSrAtQXshm8N6vVxDeumuLcOi', 'lymanhha@gmail.com', '0906122309', '::1', '162.158.178.63', '1', '1', '1536060457', '1535877350', 'XkRynRW6HBvHvEc97J2n9uA9c4nttF0gb63QozxlC8qkmrWD7zIha0R399hF', '0', '');
INSERT INTO `customers` VALUES ('3', 'phanthuylinh.tk@gmail.com', 'Phan Thùy Linh', '$2y$10$MOVoAu2fTJ6zX23jbmAl4OOqWjUOS0OSGeMKl3IDZb1yui./yM3LO', 'phanthuylinh.tk@gmail.com', '0902177007', '::1', null, '1', '1', '0', '1535880856', null, '0', null);

-- ----------------------------
-- Table structure for `customer_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `customer_tokens`;
CREATE TABLE `customer_tokens` (
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT '0',
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(1) DEFAULT '1' COMMENT '1: register | 2: reset pass',
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_tokens
-- ----------------------------
INSERT INTO `customer_tokens` VALUES ('halymanh@gmail.com', '0c8ff1237d6a8844a0aa14636fb569f8', '1535881918', '4', '1');

-- ----------------------------
-- Table structure for `features`
-- ----------------------------
DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `link` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `image` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `sort` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `lang` varchar(3) COLLATE utf8_unicode_ci DEFAULT 'vi',
  `positions` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of features
-- ----------------------------
INSERT INTO `features` VALUES ('1', 'Test', 'https://vnexpress.net/', 'test-1546603583.jpg', null, '1545214590', '1', 'vi', 'big_home,fae_home');

-- ----------------------------
-- Table structure for `gallery`
-- ----------------------------
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `changed` int(11) DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `uname` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) DEFAULT '1' COMMENT 'So cang nho cang len dau',
  `is_cover` tinyint(1) DEFAULT '0' COMMENT '1: anh dai dien album',
  `size` int(11) DEFAULT '0',
  `lang` varchar(5) CHARACTER SET utf8 DEFAULT 'vi',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of gallery
-- ----------------------------

-- ----------------------------
-- Table structure for `gallery_cats`
-- ----------------------------
DROP TABLE IF EXISTS `gallery_cats`;
CREATE TABLE `gallery_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `total` int(5) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `uname` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `safe_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of gallery_cats
-- ----------------------------
INSERT INTO `gallery_cats` VALUES ('1', 'Mặc định', 'Mặc định', '1315728528', '3', '1', 'admin', 'mac-dinh');

-- ----------------------------
-- Table structure for `images`
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `size` int(11) DEFAULT '0',
  `type` varchar(50) DEFAULT '',
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images
-- ----------------------------

-- ----------------------------
-- Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `sort` int(11) DEFAULT '0',
  `created` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `lang` varchar(3) DEFAULT 'vi',
  `pid` int(11) DEFAULT '0',
  `perm` varchar(255) DEFAULT '',
  `type` tinyint(1) DEFAULT '0' COMMENT '0: admin left | 1: admin top | 2: admin bot | 3: header menu | 4: footer menu',
  `no_follow` tinyint(1) DEFAULT '0' COMMENT '0: false | 1: true',
  `newtab` tinyint(1) DEFAULT '0' COMMENT '0: false | 1: true',
  `icon` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', 'Quản trị', null, '200', '1535305090', '1', 'vi', '0', null, '0', '1', '0', null);
INSERT INTO `menu` VALUES ('3', 'Tin tức', 'admin.news', '100', '1535307370', '1', 'vi', '1', 'news-view', '0', '1', '0', 'icon-book-open');
INSERT INTO `menu` VALUES ('4', 'Banner', 'admin.feature', '90', '1535307731', '1', 'vi', '1', 'feature-view', '0', '1', '0', 'icon-picture');
INSERT INTO `menu` VALUES ('6', 'Danh Mục', 'admin.category', '89', '1535364906', '1', 'vi', '1', 'category-view', '0', '1', '0', 'icon-list');
INSERT INTO `menu` VALUES ('8', 'Khách hàng', 'admin.customer', '50', '1535748979', '1', 'vi', '1', 'customer-view', '0', '1', '0', 'icon-people');
INSERT INTO `menu` VALUES ('9', 'Trang tĩnh', 'admin.page', '40', '1535749819', '1', 'vi', '1', 'page-view', '0', '1', '0', 'icon-map');
INSERT INTO `menu` VALUES ('11', 'HỖ TRỢ KHÁCH HÀNG', null, '200', '1535768367', '1', 'vi', '0', null, '4', '1', '0', null);
INSERT INTO `menu` VALUES ('12', 'Câu hỏi thường gặp', null, '100', '1535768422', '1', 'vi', '11', null, '4', '1', '0', null);
INSERT INTO `menu` VALUES ('13', 'Gửi yêu cầu hỗ trợ', null, '90', '1535768456', '1', 'vi', '11', null, '4', '1', '0', null);
INSERT INTO `menu` VALUES ('14', 'VỀ CHÚNG TÔI', null, '150', '1535768491', '1', 'vi', '0', null, '4', '1', '0', null);
INSERT INTO `menu` VALUES ('15', 'Giới thiệu', null, '100', '1535768580', '1', 'vi', '14', null, '4', '1', '0', null);
INSERT INTO `menu` VALUES ('16', 'Chính sách bảo mật', null, '90', '1535768626', '1', 'vi', '14', null, '4', '1', '0', null);
INSERT INTO `menu` VALUES ('18', 'Subscriber', 'admin.subscriber', '45', '1535775685', '1', 'vi', '1', 'subscriber-view', '0', '1', '0', 'icon-envelope');
INSERT INTO `menu` VALUES ('19', 'Trang chủ', 'home', '100', '1535863551', '1', 'vi', '0', null, '3', '0', '0', null);
INSERT INTO `menu` VALUES ('20', 'Giới thiệu', 'home', '90', '1535864044', '1', 'vi', '0', null, '3', '1', '0', null);
INSERT INTO `menu` VALUES ('21', 'Thư viện Ảnh', 'admin.gallery', '95', '1547040988', '1', 'vi', '1', 'gallery-view', '0', '1', '0', 'icon-grid');

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `title_seo` varchar(255) DEFAULT '',
  `sort_body` text,
  `body` longtext,
  `image` varchar(255) DEFAULT '',
  `created` int(11) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `lang` varchar(3) DEFAULT 'vi',
  `cat_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', 'Cửa ngõ Sài Gòn, Hà Nội kẹt cứng trước kỳ nghỉ lễ 2/9/2018', 'Cửa ngõ Sài Gòn, Hà Nội kẹt cứng trước kỳ nghỉ lễ 2/9', '<p>Tại TP HCM d&ograve;ng xe ken đặc tr&ecirc;n đường dẫn v&agrave;o s&acirc;n bay T&acirc;n Sơn Nhất, c&ograve;n ở Thủ đ&ocirc; người d&acirc;n cũng đổ về qu&ecirc; khiến cửa ng&otilde; qu&aacute; tải.</p>', '<p>Ng&agrave;y 31/8, Thứ trưởng Văn h&oacute;a Thể thao v&agrave; Du lịch Đặng Thị B&iacute;ch Li&ecirc;n k&yacute; văn bản gửi Thủ tướng b&aacute;o c&aacute;o về việc H&agrave; Giang cấp sổ đỏ dinh thự Vua M&egrave;o tại x&atilde; S&agrave; Ph&igrave;n (Đồng Văn) khiến con ch&aacute;u họ Vương bức x&uacute;c.&nbsp;</p>\r\n\r\n<p>Theo b&aacute;o c&aacute;o, năm 1993, khi Bộ Văn h&oacute;a Th&ocirc;ng tin xếp hạng di t&iacute;ch kiến tr&uacute;c nghệ thuật quốc gia dinh Vua M&egrave;o, &ocirc;ng Vương Quỳnh Sơn (ch&aacute;u nội của Vua M&egrave;o Vương Ch&iacute;nh Đức, th&acirc;n sinh &ocirc;ng Vương Duy Bảo) khẳng định l&agrave; chủ trương đ&uacute;ng đắn.&nbsp;</p>\r\n\r\n<p>Bộ Văn h&oacute;a khẳng định, việc lập hồ sơ xếp hạng di t&iacute;ch quốc gia dựa tr&ecirc;n c&aacute;c gi&aacute; trị về văn ho&aacute;, lịch sử v&agrave; kiến tr&uacute;c nghệ thuật. Quyết định xếp hạng di t&iacute;ch kh&ocirc;ng nhằm x&aacute;c lập hay chuyển đổi quyền sở hữu t&agrave;i sản tr&ecirc;n đất v&agrave; quyền sử dụng đất của di t&iacute;ch m&agrave; chỉ l&agrave; cơ sở x&aacute;c lập tr&aacute;ch nhiệm thực hiện g&igrave;n giữ, bảo tồn v&agrave; ph&aacute;t huy gi&aacute; trị di t&iacute;ch.&nbsp;</p>', 'cua-ngo-sai-gon-ha-noi-ket-cung-truoc-ky-nghi-le-292018-1545207457.jpg', '1535753385', '1535821200', '2', 'vi', '17');

-- ----------------------------
-- Table structure for `page_static`
-- ----------------------------
DROP TABLE IF EXISTS `page_static`;
CREATE TABLE `page_static` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `title_seo` varchar(255) DEFAULT '',
  `link_seo` varchar(255) DEFAULT '',
  `body` longtext,
  `created` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `lang` varchar(3) DEFAULT 'vi',
  `sort` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0' COMMENT '0: bt | 1: menu',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_static
-- ----------------------------
INSERT INTO `page_static` VALUES ('1', 'Các câu hỏi thường gặp', 'Các câu hỏi thường gặp', 'faq', '<p>Ch&uacute;ng t&ocirc;i biết rằng t&iacute;nh bảo mật v&agrave; sự ri&ecirc;ng tư quan trọng đối với bạn &ndash; v&agrave; ch&uacute;ng cũng quan trọng đối với ch&uacute;ng t&ocirc;i. Ưu ti&ecirc;n h&agrave;ng đầu của ch&uacute;ng t&ocirc;i l&agrave; cung cấp độ bảo mật cao v&agrave; gi&uacute;p bạn tự tin rằng th&ocirc;ng tin của bạn an to&agrave;n v&agrave; c&oacute; thể truy cập được khi cần.</p>\r\n\r\n<p>Ch&uacute;ng t&ocirc;i kh&ocirc;ng ngừng nỗ lực l&agrave;m việc để đảm bảo khả năng bảo mật mạnh mẽ, để bảo vệ quyền ri&ecirc;ng tư của bạn v&agrave; l&agrave;m cho Google thậm ch&iacute; trở n&ecirc;n hiệu quả v&agrave; hữu &iacute;ch hơn cho bạn. Ch&uacute;ng t&ocirc;i chi h&agrave;ng trăm triệu đ&ocirc; la mỗi năm cho bảo mật v&agrave; thu&ecirc; c&aacute;c chuy&ecirc;n gia nổi tiếng thế giới trong lĩnh vực bảo mật dữ liệu để giữ cho th&ocirc;ng tin của bạn an to&agrave;n. Ch&uacute;ng t&ocirc;i cũng đ&atilde; tạo ra c&aacute;c c&ocirc;ng cụ dễ sử dụng gi&uacute;p bảo mật v&agrave; bảo vệ quyền ri&ecirc;ng tư như Trang tổng quan Google, x&aacute;c minh 2 bước v&agrave; C&agrave;i đặt quảng c&aacute;o. Ch&iacute;nh v&igrave; vậy m&agrave; bạn nắm quyền kiểm so&aacute;t đối với th&ocirc;ng tin bạn chia sẻ với Google.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"text-align:center\"><img alt=\"avatar-vuong-1535744619.jpg\" src=\"http://localhost/emarket/public/upload/file/thumb_800x0/avatar-vuong-1535744619.jpg\" /></p>\r\n\r\n<p>&nbsp;</p>', '1535744403', '2', 'vi', '1', '0');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `permit` text,
  `rank` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'xep hang cap bac nhom quyen',
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'Root', null, '0', '1271326617');
INSERT INTO `roles` VALUES ('2', 'Superiod Admin', '{\"customer\":[\"view\",\"add\",\"edit\",\"delete\"],\"feature\":[\"view\",\"add\",\"edit\",\"delete\"],\"subscriber\":[\"view\",\"add\",\"edit\",\"delete\"],\"news\":[\"view\",\"add\",\"edit\",\"delete\",\"tag\"],\"page\":[\"view\",\"add\",\"edit\",\"delete\"],\"user\":[\"view\",\"add\",\"edit\",\"delete\"],\"role\":[\"view\",\"add\",\"edit\",\"delete\"],\"menu\":[\"view\",\"add\",\"edit\",\"delete\"]}', '2', '1271326617');

-- ----------------------------
-- Table structure for `social_facebook_accounts`
-- ----------------------------
DROP TABLE IF EXISTS `social_facebook_accounts`;
CREATE TABLE `social_facebook_accounts` (
  `user_id` int(11) NOT NULL,
  `provider_user_id` varchar(255) NOT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`provider_user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of social_facebook_accounts
-- ----------------------------
INSERT INTO `social_facebook_accounts` VALUES ('2', '107323884931007815781', 'google', null);

-- ----------------------------
-- Table structure for `subscribers`
-- ----------------------------
DROP TABLE IF EXISTS `subscribers`;
CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `fullname` varchar(300) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of subscribers
-- ----------------------------
INSERT INTO `subscribers` VALUES ('1', 'lymanhha@gmail.com', '1535734978', '1', '1', 'Lý Mạnh Hà', '0906122309');
INSERT INTO `subscribers` VALUES ('2', 'phanthuylinh.tk@gmail.com', '1535735003', '1', '3', null, null);
INSERT INTO `subscribers` VALUES ('3', 'halymanh@vccorp.vn', '1535736977', '1', '0', null, null);
INSERT INTO `subscribers` VALUES ('4', 'halymanh@gmail.com', '1535740379', '1', '4', null, null);

-- ----------------------------
-- Table structure for `tags`
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `safe_title` varchar(255) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1: news',
  `created` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO `tags` VALUES ('1', 'Test', 'test', '1', '1535753238');
INSERT INTO `tags` VALUES ('3', 'hapam', 'hapam', '1', '1536161943');
INSERT INTO `tags` VALUES ('4', 'ok', 'ok', '1', '1540313576');
INSERT INTO `tags` VALUES ('5', 'hehe', 'hehe', '1', '1540313959');

-- ----------------------------
-- Table structure for `tag_details`
-- ----------------------------
DROP TABLE IF EXISTS `tag_details`;
CREATE TABLE `tag_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL DEFAULT '0',
  `object_id` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tag_details
-- ----------------------------
INSERT INTO `tag_details` VALUES ('10', '4', '1', '1');
INSERT INTO `tag_details` VALUES ('9', '3', '1', '1');
INSERT INTO `tag_details` VALUES ('8', '1', '1', '1');
INSERT INTO `tag_details` VALUES ('11', '5', '1', '1');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `reg_ip` varchar(20) DEFAULT NULL,
  `last_login_ip` varchar(20) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - chua active | 1 - active email | 2 - active phone | 3 - active all',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 - BT | 0 - xoa',
  `last_login` int(11) DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `last_active` int(11) DEFAULT '0',
  `last_logout` int(11) DEFAULT '0',
  `logout` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `phone` (`phone`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'Admin 2', '$2y$10$M9FApm1d8E1h2SrIZGQwwebK6XXBwWuQLynpQ7djOWZUWGvkH9J72', 'lymanhha@gmail.com', '0906122309', '127.0.0.1', '::1', '3', '1', '1547040688', '1518160500', 'maJj1YHt0sRgOb5cBmuwTnXtxIGlVvv2R6d2nRxyfoY6OQgnb4VuJHWLQaKq', '1547043262', '0', '0');
INSERT INTO `users` VALUES ('2', 'tester', 'Tester 2', '$2y$10$7owbMlPTRztoYa42GqsYteH4JyVhuNvmPH2Hb0AEqcdIhI/JgbaiG', 'lykhanhan.nem@gmail.com', '0906122308', '::1', '::1', '3', '1', '1540310986', '1518160500', 'PhZ1TbbQUiv2E0OTqSQymcZrh1DzMZ7croTfwCV87VOLhflx7an6XZ32HKUR', '1540313185', '1540313189', '0');
INSERT INTO `users` VALUES ('24', 'tannguyen', 'Nguyễn Văn Tấn', '$2y$10$NX6CDDQnmgS351ZrIeSarOfkoRw1.BgC3E8yMFqJ45eF47bzBgptu', 'tannguyenvan@gmail.com', '0982997790', '::1', '::1', '3', '1', '1540313199', '1535431820', 'jY1uNR8qIK6rqTfWpSNIsSd5ECMzqPO9OqjzsT8yevmjtw4r57Iy3vh3Viy5', '1540313973', '0', '0');

-- ----------------------------
-- Table structure for `user_roles`
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `rid` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
INSERT INTO `user_roles` VALUES ('2', '2');
INSERT INTO `user_roles` VALUES ('24', '1');

-- ----------------------------
-- Table structure for `__configs`
-- ----------------------------
DROP TABLE IF EXISTS `__configs`;
CREATE TABLE `__configs` (
  `key` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of __configs
-- ----------------------------
INSERT INTO `__configs` VALUES ('admin-routes', '[\"login\",\"logout\",\"register\",\"password.request\",\"password.email\",\"password.reset\",\"logout\",\"register.success\",\"admin.home\",\"admin.category\",\"admin.category.add\",\"admin.customer\",\"admin.customer.add\",\"admin.feature\",\"admin.feature.add\",\"admin.subscriber\",\"admin.subscriber.add\",\"admin.news\",\"admin.news.add\",\"admin.page\",\"admin.page.add\",\"admin.user\",\"admin.user.add\",\"admin.user.profile\",\"admin.role\",\"admin.role.add\",\"admin.menu\",\"admin.menu.add\",\"admin.config\"]');
INSERT INTO `__configs` VALUES ('config', '{\"site_name\":\"lacms for Laravel\",\"keywords\":\"ezcms, lacms, laravel cms\",\"description\":\"Laravel CMS\",\"version\":\"19\",\"email\":\"lymanhha@gmail.com\",\"hotline\":\"0906122309\",\"tel\":\"0906122309\",\"address\":\"\\u0110\\u1ed1ng \\u0110a, H\\u00e0 N\\u1ed9i\",\"trans_name\":\"Btrip\",\"trans_tel\":\"0985208811\",\"trans_city\":\"1\",\"trans_dis\":\"22\",\"trans_ward\":\"443\",\"trans_add\":\"P120, Nh\\u00e0 A, KS La Th\\u00e0nh, 226 V\\u1ea1n Ph\\u00fac, Ba \\u0110\\u00ecnh, H\\u00e0 N\\u1ed9i\",\"weakpass\":\"123456a@;123456A@;abc@1234;123456\",\"fee_cod\":\"25000\",\"fee_payment\":\"3\",\"image\":\"lacms-for-laravel-1536145700.png\",\"image_medium_seo\":\"http:\\/\\/localhost\\/lacms\\/public\\/upload\\/config\\/thumb_250x0\\/lacms-for-laravel-1536145700.png\",\"image_seo\":\"http:\\/\\/localhost\\/lacms\\/public\\/upload\\/config\\/thumb_800x800\\/lacms-for-laravel-1536145700.png\",\"facebook_name\":\"lymanhha\",\"facebook\":\"https:\\/\\/www.facebook.com\\/lymanhha\\/\",\"google\":\"https:\\/\\/plus.google.com\\/+LyManhHa\",\"instagram\":\"https:\\/\\/twitter.com\\/lymanhha\",\"youtube\":\"https:\\/\\/www.youtube.com\\/channel\\/UC_1p8PYkBf7X9_B3x6mC9tQ\",\"zalo\":\"\"}');
INSERT INTO `__configs` VALUES ('public-routes', '[\"home\",\"product.list\",\"trangtinh\",\"news.list\",\"news.detail\",\"profile\",\"email\",\"register.success\",\"register.verify\",\"login\",\"logout\",\"password\",\"password.reset\",\"facebook.login\",\"facebook.callback\",\"google.login\",\"google.callback\",\"language\",\"assets.lang\",\"public.404\",\"public.500\"]');

-- ----------------------------
-- Table structure for `__logs`
-- ----------------------------
DROP TABLE IF EXISTS `__logs`;
CREATE TABLE `__logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL DEFAULT '',
  `action` varchar(255) DEFAULT '',
  `object_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `after` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `before` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `note` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `device` tinyint(1) DEFAULT '0' COMMENT '0: web | 1: mobile',
  `created` int(11) NOT NULL DEFAULT '0',
  `env` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of __logs
-- ----------------------------
INSERT INTO `__logs` VALUES ('1', '1', 'admin', 'info-logout', '0', '118.70.171.209', '', '', '', 'https://la.ezcms.org/admin/logout', '0', '1541415904', 'admin');
INSERT INTO `__logs` VALUES ('2', '1', 'admin', 'info-login', '0', '118.70.171.209', '', '', '', 'https://la.ezcms.org/admin/login', '0', '1541415917', 'admin');
INSERT INTO `__logs` VALUES ('3', '1', 'admin', 'info-logout', '0', '118.70.171.209', '', '', '', 'https://la.ezcms.org/admin/logout', '0', '1541415921', 'admin');
INSERT INTO `__logs` VALUES ('4', '1', 'admin', 'info-login', '0', '103.238.70.242', '', '', '', 'https://la.ezcms.org/admin/login', '0', '1544183254', 'admin');
INSERT INTO `__logs` VALUES ('5', '1', 'admin', 'info-login', '0', '123.16.13.202', '', '', '', 'https://la.ezcms.org/admin/login', '0', '1545191926', 'admin');
INSERT INTO `__logs` VALUES ('6', '1', 'admin', 'info-logout', '0', '27.72.100.137', '', '', '', 'https://la.ezcms.org/admin/logout', '0', '1545191955', 'admin');
INSERT INTO `__logs` VALUES ('7', '1', 'admin', 'info-login', '0', '27.72.100.137', '', '', '', 'https://la.ezcms.org/admin/login', '0', '1545191960', 'admin');
INSERT INTO `__logs` VALUES ('8', '1', 'admin', 'info-login', '0', '222.254.34.95', '', '', '', 'https://la.ezcms.org/admin/login', '0', '1545192012', 'admin');
INSERT INTO `__logs` VALUES ('9', '1', 'admin', 'info-login', '0', '::1', '', '', '', 'http://localhost/lacms/public/admin/login', '0', '1546603517', 'admin');
INSERT INTO `__logs` VALUES ('10', '1', 'admin', 'menu-edit', '4', '::1', '{\"id\":4,\"title\":\"Banner\",\"link\":\"admin.feature\",\"sort\":\"90\",\"created\":1535307731,\"status\":1,\"lang\":\"vi\",\"pid\":\"1\",\"perm\":\"feature-view\",\"type\":\"0\",\"no_follow\":1,\"newtab\":0,\"icon\":\"icon-picture\"}', '{\"id\":4,\"title\":\"Banner\",\"link\":\"admin.feature\",\"sort\":\"90\",\"created\":1535307731,\"status\":1,\"lang\":\"vi\",\"pid\":\"1\",\"perm\":\"feature-view\",\"type\":\"0\",\"no_follow\":1,\"newtab\":0,\"icon\":\"icon-picture\"}', '', 'http://localhost/lacms/public/admin/menu/edit/4', '0', '1546603536', 'admin');
INSERT INTO `__logs` VALUES ('11', '1', 'admin', 'feature-edit', '1', '::1', '{\"id\":1,\"title\":\"Test\",\"link\":\"https:\\/\\/vnexpress.net\\/\",\"image\":\"test-1546603583.jpg\",\"sort\":null,\"created\":1545214590,\"status\":1,\"lang\":\"vi\",\"positions\":\"big_home,fae_home\"}', '{\"id\":1,\"title\":\"Test\",\"link\":\"https:\\/\\/vnexpress.net\\/\",\"image\":\"test-1546603583.jpg\",\"sort\":null,\"created\":1545214590,\"status\":1,\"lang\":\"vi\",\"positions\":\"big_home,fae_home\"}', '', 'http://localhost/lacms/public/admin/feature/edit/1', '0', '1546603583', 'admin');
INSERT INTO `__logs` VALUES ('12', '1', 'admin', 'info-login', '0', '::1', '', '', '', 'http://localhost/lacms/public/admin/login', '0', '1547040689', 'admin');
INSERT INTO `__logs` VALUES ('13', '1', 'admin', 'menu-add', '21', '::1', '{\"title\":\"Th\\u01b0 vi\\u1ec7n \\u1ea2nh\",\"link\":\"admin.gallery\",\"sort\":\"0\",\"lang\":\"vi\",\"type\":\"0\",\"pid\":\"1\",\"icon\":\"icon-grid\",\"no_follow\":1,\"perm\":\"gallery-view\",\"created\":1547040988,\"newtab\":0,\"id\":21}', '', '', 'http://localhost/lacms/public/admin/menu/add', '0', '1547040988', 'admin');
INSERT INTO `__logs` VALUES ('14', '1', 'admin', 'menu-edit', '21', '::1', '{\"id\":21,\"title\":\"Th\\u01b0 vi\\u1ec7n \\u1ea2nh\",\"link\":\"admin.gallery\",\"sort\":\"95\",\"created\":1547040988,\"status\":1,\"lang\":\"vi\",\"pid\":\"1\",\"perm\":\"gallery-view\",\"type\":\"0\",\"no_follow\":1,\"newtab\":0,\"icon\":\"icon-grid\"}', '{\"id\":21,\"title\":\"Th\\u01b0 vi\\u1ec7n \\u1ea2nh\",\"link\":\"admin.gallery\",\"sort\":\"95\",\"created\":1547040988,\"status\":1,\"lang\":\"vi\",\"pid\":\"1\",\"perm\":\"gallery-view\",\"type\":\"0\",\"no_follow\":1,\"newtab\":0,\"icon\":\"icon-grid\"}', '', 'http://localhost/lacms/public/admin/menu/edit/21', '0', '1547043138', 'admin');
