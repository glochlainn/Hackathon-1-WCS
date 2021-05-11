
CREATE TABLE `user` (
    `id` INT,
    `username` VARCHAR(50),
    `profile_picture` VARCHAR(255),
    `profile_certified` BOOL,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `message` (
    `id` INT,
    `content` TEXT,
    `post_date` DATE,
    `user_id` INT,
    `photo_id` INT,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `photo` (
    `id` INT,
    `name` VARCHAR(255),
    `url` VARCHAR(255),
    `description` TEXT,
    `user_id` INT,
    PRIMARY KEY (
        `id`
    )
);

ALTER TABLE `message` ADD CONSTRAINT `fk_message_user_id` FOREIGN KEY(`user_id`)
REFERENCES `user` (`id`);

ALTER TABLE `message` ADD CONSTRAINT `fk_message_photo_id` FOREIGN KEY(`photo_id`)
REFERENCES `photo` (`id`);

ALTER TABLE `photo` ADD CONSTRAINT `fk_photo_user_id` FOREIGN KEY(`user_id`)
REFERENCES `user` (`id`);