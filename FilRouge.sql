-- 1. Création de la table des agences (nécessaire avant les propriétés)
CREATE TABLE `agencies` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `city` VARCHAR(50) NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Création de la table des utilisateurs
  CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `role` ENUM('admin', 'agent', 'client') NOT NULL DEFAULT 'client',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Création de la table des propriétés
CREATE TABLE `properties` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `agency_id` INT NOT NULL,
  `agent_id` INT NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `city` VARCHAR(50) NOT NULL,
  `surface` INT NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  `prix` INT NOT NULL,
  `type` ENUM('residential', 'professional') NOT NULL,
  `status` ENUM('available', 'sold', 'pending') NOT NULL DEFAULT 'available',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_properties_agency` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`),
  CONSTRAINT `fk_properties_agent` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Création de la table des images
CREATE TABLE `properties_images` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `property_id` INT NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `sort_order` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_images_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Création de la table des transactions
CREATE TABLE `transactions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `property_id` INT NOT NULL,
  `seller_id` INT NOT NULL,
  `buyer_id` INT NOT NULL,
  `agency_id` INT NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_trans_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  CONSTRAINT `fk_trans_seller` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_trans_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_trans_agency` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;