<h1 align="center">Vakantiewoningen makelaar Vrij Wonen</h1>
<p align="center">Uitleg om de website te kunnen opstarten</p>


## Database

1. Maak een nieuwe database in [PhpMyAdmin](http://localhost/phpmyadmin/ "phpmyadmin") genaamd: **vw_db**
2. Voer de onderstaande SQL query uit:
```SQL
CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    role_id INT NOT NULL, 
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE role ( 
    `id` INT NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(20) NOT NULL , 
    PRIMARY KEY (`id`)
);

CREATE TABLE object ( 
    `id` INT NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL , 
    `description` VARCHAR(255) NOT NULL , 
    `size` INT NOT NULL ,
    `price` INT NOT NULL , 
    `street` VARCHAR(255) NOT NULL , 
    `city` VARCHAR(255) NOT NULL , 
    `housenumber` VARCHAR(20) NOT NULL , 
    `postalcode` VARCHAR(20) NOT NULL , 
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`id`)
);

CREATE TABLE property ( 
    `id` INT NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(255) NOT NULL , 
    PRIMARY KEY (`id`)
);

CREATE TABLE attribute ( 
    `id` INT NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(255) NOT NULL , 
    `property_id` INT NOT NULL , 
    PRIMARY KEY (`id`)
);

CREATE TABLE object_attribute ( 
    `object_id` INT NOT NULL , 
    `attribute_id` INT NOT NULL 
);

ALTER TABLE `users` ADD CONSTRAINT `user_has_role` FOREIGN KEY (`role_id`) REFERENCES `role`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `object_attribute` ADD CONSTRAINT `object_has_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `attribute`(`id`) ON DELETE CASCADE ON UPDATE CASCADE; 
ALTER TABLE `object_attribute` ADD CONSTRAINT `object_has_id` FOREIGN KEY (`object_id`) REFERENCES `object`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `attribute` ADD CONSTRAINT `attribute_has_property` FOREIGN KEY (`property_id`) REFERENCES `property`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `role` (`id`, `name`) VALUES (NULL, 'werknemer'), (NULL, 'admin'), (NULL, 'beheerder');
INSERT INTO `property` (`id`, `name`) VALUES (NULL, 'Eigenschap'), (NULL, 'Ligging');
INSERT INTO `attribute` (`id`, `name`, `property_id`) VALUES (NULL, 'Bosrand', '2'), (NULL, 'Stad', '2'), (NULL, 'In woonwijk', '2'), (NULL, 'Appartement', '1'), (NULL, 'Vrijstaand', '1'), (NULL, 'Balkon', '1');

```
3. Maak een gebruiker aan via: **... /auth/register**
