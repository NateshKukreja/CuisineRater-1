INSERT INTO CUISINE(typeID, description) VALUES
(0, 'Unknown'),
(1, 'Mexican'),
(2, 'Indian'),
(3, 'Korean'),
(4, 'Chinese'),
(5, 'Italian'),
(6, 'Fine Dining'),
(7, 'Breakfast'),
(8, 'Middle Eastern'),
(9, 'Sandwiches'),
(10, 'Other');

INSERT INTO RaterCredibility(typeID, description) VALUES
(0, 'Other'),
(1, 'Occasional'),
(2, 'Blogger'),
(3, 'Certifided Critic'),
(4, 'Admin');

INSERT INTO Rater(email, name, signup_date, typeID, password) VALUES
('max@munch.com', 'MunchMax', '2017-09-03', 3, 'password'),
('danny@food.com', 'DannyFood', '2017-10-15', 3, 'password'),
('super@hotmail.com', 'Missy', '2017-02-28', 1, 'password'),
('dog123@gmail.com', 'ShepherdRule', '2017-04-10', 1, 'password'),
('fakeemail@fakeemails.com', 'LegitUser', '2017-12-01', 0, 'password'),
('fight@ftp.com', 'Fight', '2017-06-30', 2, 'password'),
('tasty@gmail.com', 'Tasty', '2017-04-19', 3, 'password'),
('imhungry@feedme.com', 'FeedMe', '2017-05-10', 3, 'password'),
('jesselovescats@yahoo.ca', 'CatsAreCute22', '2017-01-08', 1, 'password'),
('batman@bw.com', 'BruceWayne', '2017-07-29', 1, 'password'),
('dead@spiderman.com', 'PeterParker', '2017-09-09', 1, 'password'),
('myplanetisgone@superman.com', 'KryptoniteSucks', '2017-12-14', 1, 'password'),
('admin@admin.me', 'admin', '2017-04-12', 4, 'admin');


INSERT INTO Restaurant(name, varType, url) VALUES

('Sunshine Breakfast', 7, 'sunshine.ca'),
('Shawarma Palace', 8, 'shawarma.ca'),
('WitchShop', 9, null),
('Food and Wine', 6, 'f&w.ca'),
('KoreaTown', 3, 'koreatown.ca'),
('Chinese Palace', 4, 'chinesepalace.com'),
('Highland', 9, null),
('Hola', 1, 'hola.com'),
('East India', 2, 'eindia.com'),
('Marios', 5, 'marios.ca'),
('Upscale', 6, 'Upscale.com'),
('Pizza Heaven', 10, null),
('China Hut', 4, null),
('Indian Delight', 2, 'indiandelight.com');

INSERT INTO Location(first_open_date, manager_name, phone_number, street_address, hour_open, hour_close, restaurant_id) VALUES
('2017-01-01', 'Cirtus Jackson', '6135555555', '55 Lees Ave', 1200, 0000, 1),
('2017-01-01', 'Micheal Jackson', '6134443333', '100 Sussex Drive', 0800, 2300, 2),
('2017-01-01', 'Lebron James', '613123456', '94 Daly Ave', 0800, 2300, 3),
('2017-01-01', 'Tiger Woods', null, '926 York Street', 0800, 0200, 4),
('2017-01-01', 'Natesh Kukreja', '613888888', '482 George Street', 1400, 0200, 5),
('2017-01-01', 'Daneyal Siddiqui', '6131231234', '1 Macdonald Road', 1100, 2300, 6),
('2017-01-01', 'Abel Tesfye', '6131234211', '45 Bolton Street', 0700, 0000, 7),
('2017-01-01', 'Martha Stwart', '6133456789', '7451 Long Road', 1400, 0100, 8),
('2017-01-01', 'Brad Smith', '6139876543', '200 Cedargrove Road', 0530, 1400, 9),
('2017-01-01', null, '6139999999', '47 Cumberland Road', 0700, 0000, 10),
('2017-01-01', 'Al Pacino', '6132222222', '101 Dalhousie Road', 1100, 2300, 11),
('2017-01-01', 'James Patterson', '6131111111', '30 St Patrick Street', 0900, 0200, 12),
('2017-01-01', 'David Lee', '6130000000', '55 Nelson Street', 0800, 0200, 13),
('2017-01-01', null, '6136666666', '11 Somerset Drive', 0700, 0000, 14);
