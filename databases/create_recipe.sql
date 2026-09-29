-- recipe database schema --
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `recipes` (
  `recipe_id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `prep_time_minutes` INT,
  `cook_time_minutes` INT,
  `servings` INT,
  `calories_per_serving` INT,
  `protein_g` INT,
  `carbs_g` INT,
  `fat_g` INT,
  `ingredients` TEXT NOT NULL,
  `instructions` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `recipe_categories` (
  `recipe_id` INT,
  `category_id` INT,
  PRIMARY KEY (`recipe_id`, `category_id`),
  FOREIGN KEY (`recipe_id`) REFERENCES `recipes`(`recipe_id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Categories used by the Create Recipe form's dropdown
INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Breakfast'),
(2, 'Lunch'),
(3, 'Dinner'),
(4, 'Snack'),
(5, 'Dessert')
ON DUPLICATE KEY UPDATE category_name = VALUES(category_name);

-- Add photo storage to the shared recipes table (non-destructive, nullable)
ALTER TABLE `recipes` ADD COLUMN IF NOT EXISTS `photo` VARCHAR(255) NULL AFTER `instructions`;