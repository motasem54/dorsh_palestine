-- Notifications table for admin panel
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  KEY `is_read` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample notifications
INSERT INTO `notifications` (`admin_id`, `type`, `title`, `message`, `link`, `is_read`) VALUES
(1, 'order', 'New Order Received', 'Order #1234 has been placed', 'orders/view.php?id=1234', 0),
(1, 'review', 'New Product Review', 'A new review is waiting for approval', 'reviews.php', 0),
(1, 'user', 'New Customer Registered', 'John Doe has created an account', 'customers/', 0);