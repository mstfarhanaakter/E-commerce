CREATE TABLE `role` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `first_name` varchar(255),
  `last_name` varchar(255),
  `email` varchar(255) UNIQUE,
  `password` varchar(255),
  `address` text,
  `phone_number` varchar(255),
  `role_id` int
);

CREATE TABLE `categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

CREATE TABLE `sub_category` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `category_id` int
);

CREATE TABLE `products` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `category_id` int,
  `sub_category_id` int,
  `user_id` int,
  `name` varchar(255),
  `price` decimal(15,2),
  `description` text
);

CREATE TABLE `orders` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `order_date` datetime,
  `total_price` decimal(15,2),
  `status` varchar(255),
  `user_id` int,
  `payment_id` int
);

CREATE TABLE `order_items` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `quantity` int,
  `order_id` int,
  `product_id` int
);

CREATE TABLE `payments` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `date` datetime,
  `method` varchar(255),
  `amount` decimal(15,2),
  `status` varchar(255),
  `user_id` int
);

CREATE TABLE `carts` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `quantity` int,
  `user_id` int,
  `product_id` int
);

CREATE TABLE `wishlist` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `product_id` int
);

CREATE TABLE `coupons` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `code` varchar(255) UNIQUE,
  `percentage` decimal(5,2),
  `valid_from` date,
  `valid_to` date,
  `max_uses` int,
  `use_count` int
);

CREATE TABLE `coupon_usages` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `usage_count` int,
  `user_id` int,
  `coupon_id` int
);

CREATE TABLE `delivery` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `delivery_date` datetime,
  `recipient` varchar(255),
  `address` text,
  `status` varchar(255),
  `order_id` int
);

CREATE TABLE `purchase` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `quantity` int,
  `invoice_number` varchar(255),
  `unit` varchar(255),
  `date` datetime,
  `price` decimal(15,2),
  `product_id` int,
  `user_id` int
);

CREATE TABLE `sales_invoice` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `invoice_number` varchar(255) UNIQUE,
  `date` datetime,
  `total_amount` decimal(15,2),
  `status` varchar(255),
  `user_id` int,
  `order_id` int
);

CREATE TABLE `purchase_invoice` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `invoice_number` varchar(255) UNIQUE,
  `date` datetime,
  `total_amount` decimal(15,2),
  `status` varchar(255),
  `user_id` int,
  `purchase_id` int
);

CREATE TABLE `sales_return` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `quantity` int,
  `return_date` datetime,
  `reason` text,
  `status` varchar(255),
  `sales_invoice_id` int,
  `product_id` int
);

CREATE TABLE `purchase_return` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `product_id` int,
  `purchase_invoice_id` int,
  `quantity` int,
  `return_date` datetime,
  `reason` text,
  `status` varchar(255)
);

CREATE TABLE `inventory` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `product_id` int,
  `quantity_available` int,
  `low_stock_alert` boolean
);

CREATE TABLE `refunds` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `return_type` varchar(255),
  `amount` decimal(15,2),
  `refund_date` datetime,
  `method` varchar(255),
  `status` varchar(255),
  `sales_return_id` int,
  `purchase_return_id` int,
  `refunded_to_user_id` int,
  `refunded_by_user_id` int
);

CREATE TABLE `total_sales` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `sales_date` date,
  `total_amount` decimal(15,2),
  `total_orders` int,
  `total_products_sold` int,
  `generated_by` int
);

CREATE TABLE `total_purchase` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `purchase_date` date,
  `total_amount` decimal(15,2),
  `total_products_purchased` int,
  `total_users` int,
  `generated_by` int
);

CREATE TABLE `income_summary` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `generated_by` int,
  `summary_date` date,
  `total_sales` decimal(15,2),
  `total_purchase` decimal(15,2),
  `total_refund` decimal(15,2),
  `net_income` decimal(15,2)
);

ALTER TABLE `users` ADD FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

ALTER TABLE `sub_category` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

ALTER TABLE `products` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

ALTER TABLE `products` ADD FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`id`);

ALTER TABLE `products` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `orders` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `orders` ADD FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`);

ALTER TABLE `order_items` ADD FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

ALTER TABLE `order_items` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `payments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `carts` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `carts` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `wishlist` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `wishlist` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `coupon_usages` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `coupon_usages` ADD FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`);

ALTER TABLE `delivery` ADD FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

ALTER TABLE `purchase` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `purchase` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `sales_invoice` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `sales_invoice` ADD FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

ALTER TABLE `purchase_invoice` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `purchase_invoice` ADD FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`);

ALTER TABLE `sales_return` ADD FOREIGN KEY (`sales_invoice_id`) REFERENCES `sales_invoice` (`id`);

ALTER TABLE `sales_return` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `purchase_return` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `purchase_return` ADD FOREIGN KEY (`purchase_invoice_id`) REFERENCES `purchase_invoice` (`id`);

ALTER TABLE `inventory` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `refunds` ADD FOREIGN KEY (`sales_return_id`) REFERENCES `sales_return` (`id`);

ALTER TABLE `refunds` ADD FOREIGN KEY (`purchase_return_id`) REFERENCES `purchase_return` (`id`);

ALTER TABLE `refunds` ADD FOREIGN KEY (`refunded_to_user_id`) REFERENCES `users` (`id`);

ALTER TABLE `refunds` ADD FOREIGN KEY (`refunded_by_user_id`) REFERENCES `users` (`id`);

ALTER TABLE `total_sales` ADD FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`);

ALTER TABLE `total_purchase` ADD FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`);

ALTER TABLE `income_summary` ADD FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`);
