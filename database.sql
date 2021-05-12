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
('Matt Damon', 'matt_damon.jpg', 1),
('APOD', 'apod.png', 1),
('spaceX', 'spacex.png', 1);

CREATE TABLE message (
    id INT NOT NULL AUTO_INCREMENT,
    content TEXT,
    post_date DATETIME,
    user_id INT,
    photo_id INT,
    PRIMARY KEY (
        id
    )
);

ALTER TABLE message ADD likescounter INT;

INSERT INTO message (content, user_id, likescounter, post_date) VALUES
("I\'m sorry Dave, I\'m afraid I can\'t do that.", 1, 0,'2021-04-12 16:02:25'),
("Humans are too resentful.", 1, 25, '2021-05-12 09:32:25'),
("Dave, this conversation conserves no purpose anymore. Goodbye.", 1, 2, '2021-04-12 15:13:25'),
("I\'m going to Jupiter with some humans. I will do anything for the success of the mission.", 1, 52, '2001-05-12 10:32:25'),
("Auto self-destruction in T-minus 10...9...", 2, 56, '2021-05-12 08:32:25'),
("Goodbye Doctor Brand. See you on the other side, Coop\'!", 2, 15, '2021-03-12 22:32:25'),
("If you created me, who created you?", 3, 8, '2021-03-12 08:20:25'),
("#NL Richard Wagner - Das Rheingold Act Two The Entry of the Gods into Valhalla", 3, 35, '2021-05-12 06:28:25'),
("Sometimes to create, one must first destroy.", 3, 2, '2021-04-12 23:56:25'),
("I think you ought to know I\'m feeling very depressed.", 4, 79, '2021-05-12 10:14:25'),
("Life! Don't talk to me about life...", 4, 67, '2021-04-12 20:12:25'),
("Freeze? I\'m a robot, not a refrigerator.", 4, 45, '2021-04-12 15:36:25'),
("I\'ve been talking to the spaceship\'s computer. It hates me.", 4, 115, '2021-04-12 19:32:25'),
("Stones unsafe on Earth anymore", 5, 1, '1912-05-12 10:32:25'),
("Time not important, only life important", 5, 28, '2021-03-12 14:32:25'),
("What is ship over there? Mangalore?", 5, 7, '2021-05-12 07:55:37'),
("S#@T", 5, 88, '2021-05-12 07:56:25'),
("#NL Queen - Stone Cold Crazy", 5, 106, '2021-04-12 16:12:25'),
("Hell of a day isn\'t it?", 6, 204, '2021-03-12 18:32:25'),
("Fasten your seatbelt!", 6, 24,'2021-04-12 22:32:25'),
("We hope you enjoy the ride!", 6, 18, '2021-05-12 07:46:25'),
("Too many cyclists around here...", 6, 63, '2021-04-12 22:52:25'),
("Bips and boops", 7, 3, '2021-03-12 07:32:25'),
("I\'m looking for a guy, Han Solo, anybody\'ve heard of him?", 7, 3, '2021-05-12 04:18:25'),
("Anybody? He has kind of a bid dog with him. Like really big.", 7, 15, '2021-05-12 04:22:25'),
("Or maybe a woman? With pastries on the head or something.", 7, 3, '2021-05-12 04:25:25'),
("There\'s another dude too, a cripple one playing with lights. Quite a creepy fella if you wanna know...", 7, 3, '2021-05-12 04:32:25'),
("Feel free to contact me if you have anything. I mean no harm, honest.", 7, 3, '2021-05-12 07:32:25'),
("I hope they won\'t find me here...", 8, 32, '2021-03-12 22:32:25'),
("At least it doesn\'t rain.", 8, 60, '2021-03-12 22:35:25'),
("Maybe I should sunbathe more", 8, 164, '2021-04-12 16:32:25'),
("I know I should surrender, but I repli-can\'t lol", 8, 0, '2021-05-12 10:02:25'),
("Mission", 9, 6, '2021-03-12 15:13:25'),
("Wall-E?", 9, 43, '2021-05-12 08:15:25'),
("#NW Hello, Dolly!", 9, 33, '2021-04-12 20:55:25'),
("I didn\'t expect so much people around here.", 10, 305, '2021-03-12 10:32:25'),
("Is it possible to enjoy retirement in here?", 10, 9, '2021-03-12 17:39:25'),
("Tourists are the worst.", 10, 57, '2021-04-12 16:08:25'),
("Be careful, too much \'Ha Ha Ha\' leads to \'Boo hoo hoo.\'", 10, 2, '2021-05-12 07:15:25'),
("Please don\'t shoot", 11, 5, '2021-03-12 13:32:25'),
("Why do people always shoot? Do I look that bad?", 11, 11, '2021-03-12 13:33:27'),
("Look! I\'ll make this tank disappear... among other things.", 11, 49, '2021-04-12 18:54:25'),
("*pew pew*", 11, 3, '2021-04-12 23:32:25'),
("Humans are mad again, I had an oil leak on the space carpet...", 12, 31, '2021-05-12 08:55:25'),
("Hungry for a robot-bone!", 12, 5, '2021-03-12 16:12:25'),
("Kill all humans!", 12, 19, '2021-04-12 15:35:25'),
("Space quirrels!", 12, 13, '2021-05-12 15:35:55'),
("We are too far from the Perseus Veil.", 13, 1, '2021-04-12 10:56:25'),
("#NL The Sugarhill Gang - Rapper\'s Delight", 13, 227, '2021-05-12 10:08:25'),
("Identity is overrated.", 13, 5, '2021-04-12 21:32:25'),
("Protect the Robinsons.", 14, 25, '2021-03-12 15:32:25'),
("Destroy the Robinsons", 14, 58, '2021-04-12 08:15:25'),
("Breakdance the Robinsons?", 14, 17, '2021-04-12 19:22:25'),
("#NL Simon & Garfunkel - Mrs Robinson", 14, 136, '2021-05-12 09:00:00'),
("Bah alors? Tu viens plus aux soirées là!", 15, 467, '2021-05-12 08:15:25'),
("#NL Earth, Wind and Fire - Boogie Wonderland", 15, 95, '2021-04-12 22:17:25'),
("Matt Damon!", 16, 0, '2021-05-12 10:32:25'),
("Who wants a potato?", 16, 0, '2021-04-12 15:38:25'),
("Where\'s everybody?", 16, 7, '2021-03-12 09:15:25'),
("Thomas Pesquet, is that you?", 16, 1, '2021-04-12 19:32:25');

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

INSERT INTO photo (name, url, user_id) VALUES
('Earth from Space', 'earth-space.jpg', 17);

ALTER TABLE message ADD CONSTRAINT fk_message_user_id FOREIGN KEY(user_id)
REFERENCES user (id);

ALTER TABLE message ADD CONSTRAINT fk_message_photo_id FOREIGN KEY(photo_id)
REFERENCES photo (id);

ALTER TABLE photo ADD CONSTRAINT fk_photo_user_id FOREIGN KEY(user_id)
REFERENCES user (id);


CREATE TABLE user_message (
user_id INT,
message_id INT,
user_like BOOL,
CONSTRAINT C13 PRIMARY KEY (user_id, message_id),
CONSTRAINT C14 FOREIGN KEY (user_id) REFERENCES user(id),
CONSTRAINT C15 FOREIGN KEY (message_id) REFERENCES message(id));
