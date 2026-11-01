-- Backup of python_web_db created 2026-11-01 13:35:12.801484
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `age` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` VALUES (1, 'Lovkush', 'love@gmail.com', 22, '2026-11-01 13:31:41');
INSERT INTO `users` VALUES (2, 'Riya Verma', 'riya@example.com', 22, '2026-11-01 13:31:41');
INSERT INTO `users` VALUES (3, 'Sohan Singh', 'sohan@example.com', 23, '2026-11-01 13:31:41');
INSERT INTO `users` VALUES (4, 'Neha Gupta', 'neha@example.com', 20, '2026-11-01 13:31:41');
INSERT INTO `users` VALUES (5, 'Pooja Rawat', 'pooja@example.com', 24, '2026-11-01 13:31:41');
INSERT INTO `users` VALUES (11, 'Kavita Rao', 'kavita@example.com', 24, '2026-11-01 13:34:58');
INSERT INTO `users` VALUES (12, 'Manish Gupta', 'manish@example.com', 29, '2026-11-01 13:34:58');
INSERT INTO `users` VALUES (13, 'Divya Nair', 'divya@example.com', 22, '2026-11-01 13:34:58');
INSERT INTO `users` VALUES (14, 'Arjun Mehta', 'arjun@example.com', 31, '2026-11-01 13:34:58');
INSERT INTO `users` VALUES (15, 'Sneha Joshi', 'sneha@example.com', 27, '2026-11-01 13:34:58');

SET FOREIGN_KEY_CHECKS=1;
