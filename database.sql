CREATE TABLE `user` (
    `id` INT  NOT NULL ,
    `username` VARCHAR(50)  NOT NULL ,
    `profile_picture` VARCHAR(255)  NOT NULL ,
    `profile_certified` BOOL  NOT NULL ,
    PRIMARY KEY (
        `id`
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

CREATE TABLE `message` (
    `id` INT  NOT NULL ,
    `content` TEXT  NOT NULL ,
    `post_date` DATE  NOT NULL ,
    `user_id` INT  NOT NULL ,
    `photo_id` INT  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `photo` (
    `id` INT  NOT NULL ,
    `name` VARCHAR(255)  NOT NULL ,
    `url` VARCHAR(255)  NOT NULL ,
    `description` TEXT  NOT NULL ,
    `user_id` INT  NOT NULL ,
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
