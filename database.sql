<<<<<<< HEAD
﻿
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
=======
CREATE TABLE user (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50),
    profile_picture VARCHAR(255),
    profile_certified BOOL,
    PRIMARY KEY (
        id
    )
);

INSERT INTO user (username, profile_picture, profile_certified) VALUES
('Hall 9000', 'hall_9000.jpeg', 0),
('TARS', 'tars.jpeg', 0),
('David', 'david.jpeg', 0),
('Marvin', 'marvin.jpeg', 0),
('Mondoshawan', 'mondoshawan.jpeg', 0),
('Johnny Cab', 'johnny_cab.jpeg', 0),
('Droïde sonde', 'droide_sonde.jpg', 0),
('Roy Batty', 'roy_batty.jpeg', 0),
('Eve', 'eve.jpeg', 0),
('Dr Manhattan', 'dr_manhattan.jpeg', 0),
('Gort', 'gort.jpg', 0),
('AMEE', 'amee.jpeg', 0),
('Geth', 'geth.jpeg', 0),
('Robot', 'robot.jpeg', 0),
('O-Mars-y', 'o-mars-y.jpeg', 0),
('Matt Damon', 'matt_damon.jpg', 1);

CREATE TABLE message (
    id INT NOT NULL AUTO_INCREMENT,
    content TEXT,
    post_date DATE,
    user_id INT,
    photo_id INT,
    PRIMARY KEY (
        id
    )
);

ALTER TABLE message ADD likescounter INT;

INSERT INTO message (content, likescounter, user_id) VALUES
('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id rutrum lorem, scelerisque vehicula lorem. Donec metus lorem, egestas ut tincidunt vitae, tempor vitae ex. Duis est ipsum, blandit vitae felis pellentesque, pellentesque ultrices felis viverra.', 46, 5),
('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id rutrum lorem, scelerisque vehicula lorem. Donec metus lorem, egestas ut tincidunt vitae, tempor vitae ex. Duis est ipsum, blandit vitae felis pellentesque, pellentesque ultrices felis viverra.', 27, 3),
('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id rutrum lorem, scelerisque vehicula lorem. Donec metus lorem, egestas ut tincidunt vitae, tempor vitae ex. Duis est ipsum, blandit vitae felis pellentesque, pellentesque ultrices felis viverra.', 14, 9);

CREATE TABLE photo (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    url VARCHAR(255),
    description TEXT,
    user_id INT,
    PRIMARY KEY (
        id
    )
);

ALTER TABLE message ADD CONSTRAINT fk_message_user_id FOREIGN KEY(user_id)
REFERENCES user (id);

ALTER TABLE message ADD CONSTRAINT fk_message_photo_id FOREIGN KEY(photo_id)
REFERENCES photo (id);

ALTER TABLE photo ADD CONSTRAINT fk_photo_user_id FOREIGN KEY(user_id)
REFERENCES user (id);
>>>>>>> dev
