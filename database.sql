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
('NASA', 'nasa.png', 1);

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

INSERT INTO message (content, likescounter, post_date, user_id) VALUES
('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id rutrum lorem, scelerisque vehicula lorem. Donec metus lorem, egestas ut tincidunt vitae, tempor vitae ex. Duis est ipsum, blandit vitae felis pellentesque, pellentesque ultrices felis viverra.', 46, '2021-05-11 22:21:20', 5),
('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id rutrum lorem, scelerisque vehicula lorem. Donec metus lorem, egestas ut tincidunt vitae, tempor vitae ex. Duis est ipsum, blandit vitae felis pellentesque, pellentesque ultrices felis viverra.', 27, '2021-05-11 22:33:20', 3),
('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id rutrum lorem, scelerisque vehicula lorem. Donec metus lorem, egestas ut tincidunt vitae, tempor vitae ex. Duis est ipsum, blandit vitae felis pellentesque, pellentesque ultrices felis viverra.', 14, '2021-05-11 22:46:20', 9),
('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id rutrum lorem, scelerisque vehicula lorem. Donec metus lorem, egestas ut tincidunt vitae, tempor vitae ex. Duis est ipsum, blandit vitae felis pellentesque, pellentesque ultrices felis viverra.', 376, '2021-05-12 01:21:20', 17),
('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id rutrum lorem, scelerisque vehicula lorem. Donec metus lorem, egestas ut tincidunt vitae, tempor vitae ex. Duis est ipsum, blandit vitae felis pellentesque, pellentesque ultrices felis viverra.', 234, '2021-05-12 02:21:20', 17);

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