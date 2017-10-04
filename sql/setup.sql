
-- create database webshop;
--
-- use jopg16;
use webshop;

DROP TABLE IF EXISTS `content`;
DROP TABLE IF EXISTS `Prod2Cat`;
DROP TABLE IF EXISTS `ProdCategory`;
DROP TABLE IF EXISTS `Inventory`;
DROP TABLE IF EXISTS `InvenShelf`;
DROP TABLE IF EXISTS `OrderRow`;
DROP TABLE IF EXISTS `VarukorgRow`;
DROP TABLE IF EXISTS `Order`;
DROP TABLE IF EXISTS `Varukorg`;
DROP TABLE IF EXISTS `Product`;
DROP TABLE IF EXISTS `Customer`;
DROP TABLE IF EXISTS WebshopLog;
DROP TABLE IF EXISTS HaveToOrderLog;

-- SHOW TABLES;
-- SHOW PROCEDURE STATUS;

CREATE TABLE `content`
(
  `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `path` CHAR(120) UNIQUE,
  `slug` CHAR(120) UNIQUE,

  `title` VARCHAR(120),
  `data` TEXT,
  `type` CHAR(20),
  `filter` VARCHAR(80) DEFAULT NULL,

  `published` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted` DATETIME DEFAULT NULL,

  KEY `index_title` (`title`)

) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO `content` (`path`, `slug`, `type`, `title`, `data`, `filter`) VALUES
    ("about", "sneaker-store", "page", "Sneaker Store", "Sneaker Store öppnades den 26 mars 1999 av Peter Jansson och Erik Fagerlind. Båda har tidigare arbetat i sportbranschen och har stor erfarenhet och butiksvana bakom sig. Eftersom de var sneakersamlare så kände de att det fattades ett bra alternativ till de större kedjorna som då dominerade marknaden.
      Efter en lyckad resa till New York hittade de både inspiration och lite varor som de tyckte saknades i det svenska utbudet - Sneaker Store föddes. Senare det året (maj 1999) så öppnades hemsidan SneakerStore.com där butikens utbud skulle erbjudas till resten av landet.
      Ett decennium senare utses Sneaker Store till Årets Modebutik, Årets Butik Ungt Mode samt vinner titeln Årets E-Handel av Nordens största modebranschstidning Habit. Ryktet om södermalmsbutiken med det ovanligt stora intresset för sneakers och deras extremt breda utbud av sneakers har spritt sig.
      Sneaker Store är idag ett företag med kunder från hela världen och Stockholmsbutiken ligger fortfarande kvar på Åsögatan på Södermalm. Dessutom finns det butiker i Berlin, London och Paris och Sneakersnstuff.com säljer idag varor till över 70 olika länder.", "nl2br"),
    ("blogpost-1", "nike-air-max-97-gold-hits-stockholm", "post", "NIKE AIR MAX 97 GOLD HITS STOCKHOLM", '<img src="http://blog.sneakersnstuff.com/wp-content/uploads/2017/05/TRINITY-3.jpg" class="img-responsive">
      To celebrate the launch of the Nike Air Max 97 Metallic Gold, Sneakersnstuff connected with Trinity Tafari of Tafari Gold. Describing himself as ”Sweden’s first and only grill-maker” Trinity’s fascination with gold started  from an early age, and turned into a fascination for bespoke jewelry and grill-making. When he couldn’t buy grills for himself, he simply apprenticed himself to a retiring dental technician and learned the tools of the trade first hand.
      The word spread fast and the gold rush was on. Before long his client base expanded to the Swedish music scene and beyond. Early clients included Stockholm based artists ro$ and Michel Dida with whom Sneakersnstuff linked up to capture the Air Max 97’s golden colourway accessorized with some custom Sneakersnstuff and Nike mouth pieces. Turning heads, draped in gold. Images by Gustav Stegfors for Sneakersnstuff.', "nl2br"),
    ("blogpost-2", "adidas-originals-presents-the-datamosh-pack", "post", "ADIDAS ORIGINALS PRESENTS THE DATAMOSH PACK", '<img src="http://blog.sneakersnstuff.com/wp-content/uploads/2017/05/14.jpg" class="img-responsive">
      Sneakersnstuff are proud to present their latest project with adidas Originals – the Datamosh Pack. The pack consists of two loud colorways of the NMD_R1 Primeknit. The upper is inspired by datamoshing, a process of manipulating the data of media files in order to achieve visual or auditory effects when the files is decoded.
      Sneakersnstuff have linked up with UK grime legend D Double E and rising star Elf Kid to activate the campaign. The video was shot in London by Tim & Barry with an exclusive soundtrack provided by Dullah Beatz.', "nl2br"),
    ("blogpost-3", "nike-sportswear-air-sock-racer-flyknit", "post", "NIKE SPORTSWEAR AIR SOCK RACER FLYKNIT", '<img src="http://blog.sneakersnstuff.com/wp-content/uploads/2017/04/IMG_5851.jpg" class="img-responsive">
      This Thursday sees the release of the Nike Sportswear Air Sock Racer Flyknit. Part sandal, part running tight and originally introduced in a bumblebee color scheme, the Nike Sock Racer wasn’t your average shoe. It was inspired by Bill Bowerman’s mandate to strip away all unnecessary elements of a running shoe and honed to act as an extension of the foot.', "nl2br"),
    ("blogpost-4", "adidas-originals-present-shades-of-white", "post", "ADIDAS ORIGINALS PRESENT: SHADES OF WHITE", '<img src="http://blog.sneakersnstuff.com/wp-content/uploads/2017/04/18_2.jpg" class="img-responsive">
      Back in 2015 Sneakersnstuff worked with adidas Originals on the Shades of White pack. Taking inspiration from the most common tone of white paint used in Stockholm houses and apartments. Today we are happy to present the Shades of White v2 pack. The 2017 release contains the Stan Smith Boost and the Superstar Boost.
      Updating modern classics with future technology the Stan Smith Boost arrives in a soft premium nubuck upper. The Superstar Boost comes with a hackley woven upper. On both shoes we have updated the pop color to Linen Green.', "nl2br"),
    ("footerBlock1", "footerblock1", "block", "footerBlock1", '<img src="img/sneaker.png" class="img-responsive" alt="Logo">', null),
    ("footerBlock2", "footerblock2", "block", "footerBlock2",
      '<h4 class="title">Social Media</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin suscipit, libero a molestie consectetur, sapien elit lacinia mi.</p>
        <ul class="social-icon">
          <a href="#" class="social"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          <a href="#" class="social"><i class="fa fa-twitter" aria-hidden="true"></i></a>
          <a href="#" class="social"><i class="fa fa-instagram" aria-hidden="true"></i></a>
          <a href="#" class="social"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
          <a href="#" class="social"><i class="fa fa-google" aria-hidden="true"></i></a>
          <a href="#" class="social"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
        </ul>', null),
    ("footerBlock3", "footerblock3", "block", "footerBlock3",
      '<h4 class="title">Payment Methods</h4>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        <ul class="payment">
          <li><a href="#"><i class="fa fa-cc-amex" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-credit-card" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-paypal" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-cc-visa" aria-hidden="true"></i></a></li>
        </ul>', null),
    ("footerBlock4", "footerblock4", "block", "footerBlock4",
      '<h4 class="title">My Account</h4>
        <span class="acount-icon">
          <a href="#"><i class="fa fa-heart" aria-hidden="true"></i> Wish List</a>
          <a href="#"><i class="fa fa-cart-plus" aria-hidden="true"></i> Cart</a>
          <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
          <a href="#"><i class="fa fa-globe" aria-hidden="true"></i> Language</a>
        </span>', null);



--
-- Product and product category
--

CREATE TABLE `ProdCategory` (
	`id` INT AUTO_INCREMENT,
	`category` CHAR(10),

	PRIMARY KEY (`id`)
);

CREATE TABLE `Product` (
	`id` INT AUTO_INCREMENT,
	`description` VARCHAR(20),
	`price` INT,
	`picture` VARCHAR(40),

	PRIMARY KEY (`id`),
    KEY `index_description` (`description`)
);

CREATE TABLE `Prod2Cat` (
	`id` INT AUTO_INCREMENT,
	`prod_id` INT,
	`cat_id` INT,

	PRIMARY KEY (`id`),
    FOREIGN KEY (`prod_id`) REFERENCES `Product` (`id`),
    FOREIGN KEY (`cat_id`) REFERENCES `ProdCategory` (`id`)
);

--
-- Inventory and shelfs
--

CREATE TABLE `InvenShelf` (
    `shelf` CHAR(6),
    `description` VARCHAR(40),

	PRIMARY KEY (`shelf`)
);

CREATE TABLE `Inventory` (
	`id` INT AUTO_INCREMENT,
    `prod_id` INT,
    `shelf_id` CHAR(6),
    `items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`prod_id`) REFERENCES `Product` (`id`),
	FOREIGN KEY (`shelf_id`) REFERENCES `InvenShelf` (`shelf`)
);


--
-- Start with the product catalogue
--
INSERT INTO `Product` (`description`, `price`, `picture`) VALUES
("NMD_R2", 1395, "img/webshop/NMD_R2.jpg"),
("ML373", 899, "img/webshop/ML373.jpg"),
("SWIFT RUN", 849, "img/webshop/SWIFT_RUN.jpg"),
("DUALTONE RACER", 679, "img/webshop/DUALTONE.jpg"),
("TUBULAR", 949, "img/webshop/TUBULAR.jpg"),
("HYDE", 1095, "img/webshop/HYDE.jpg"),
("SUPERSTAR", 899, "img/webshop/SUPERSTAR.jpg"),
("FRESH FOAM", 759, "img/webshop/FRESH_FOAM.jpg"),
("FOAM CRUZ", 849, "img/webshop/FOAM_CRUZ.jpg"),
("ROSHE ONE", 999, "img/webshop/ROSHE.jpg")
;

INSERT INTO `ProdCategory` (`category`) VALUES
("Nike"), ("Adidas"), ("NewBalance")
;

INSERT INTO `Prod2Cat` (`prod_id`, `cat_id`) VALUES
(1, 1), (2, 1), (3, 1), (4, 1),
(5, 2), (6, 2), (7, 2), (8, 2),
(9, 3), (10, 3)
;


--
-- The truck has arrived, put the stuff into shelfs and update the database
--
INSERT INTO `InvenShelf` (`shelf`, `description`) VALUES
("AAA101", "House A, aisle A, part A, shelf 101"),
("AAA102", "House A, aisle A, part A, shelf 102"),
("AAA103", "House A, aisle A, part A, shelf 103")
;

INSERT INTO `Inventory` (`prod_id`, `shelf_id`, `items`) VALUES
(1, "AAA101", 30), (2, "AAA101", 20), (3, "AAA101", 25), (4, "AAA101", 15),
(5, "AAA102", 20), (6, "AAA102", 25), (7, "AAA102", 15), (8, "AAA102", 10),
(9, "AAA103", 20), (10, "AAA103", 30)
;

--
-- Customer
--
CREATE TABLE `Customer` (
  `id` INT AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
	`firstName` VARCHAR(20),
	`lastName` VARCHAR(20),
  `password` VARCHAR(100),

	PRIMARY KEY (`id`),
  UNIQUE KEY `username_unique` (`username`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


-- ------------------------------------------------------------------------
--
-- Varukorg
--
CREATE TABLE `Varukorg` (
	`id` INT AUTO_INCREMENT,
    `customer` INT,
	`created` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	`deleted` DATETIME DEFAULT NULL,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`customer`) REFERENCES `Customer` (`id`)
);

CREATE TABLE `VarukorgRow` (
	`id` INT AUTO_INCREMENT,
    `varukorg` INT,
    `product` INT,
	`items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`varukorg`) REFERENCES `Varukorg` (`id`),
	FOREIGN KEY (`product`) REFERENCES `Product` (`id`)
);


-- ------------------------------------------------------------------------
--
-- Order
--
CREATE TABLE `Order` (
	`id` INT AUTO_INCREMENT,
    `customer` INT,
	`created` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	`deleted` DATETIME DEFAULT NULL,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`customer`) REFERENCES `Customer` (`id`)
);

CREATE TABLE `OrderRow` (
	`id` INT AUTO_INCREMENT,
    `order` INT,
    `product` INT,
	`items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`order`) REFERENCES `Order` (`id`),
	FOREIGN KEY (`product`) REFERENCES `Product` (`id`)
);

-- ------------------------------------------------------------------------
--
-- WebshopLog
--
CREATE TABLE WebshopLog
(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `when` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `what` VARCHAR(20),
    `product` CHAR(4),
    `balance` DECIMAL(4, 2),
    `amount` DECIMAL(4, 2)
);


DROP TRIGGER IF EXISTS InventoryUpdates;

CREATE TRIGGER InventoryUpdates
AFTER UPDATE
ON Inventory FOR EACH ROW
    INSERT INTO WebshopLog (`what`, `product`, `balance`, `amount`)
        VALUES ("Inventory", NEW.prod_id, NEW.items, NEW.items - OLD.items);

DROP TRIGGER IF EXISTS newVarukorgRow;

CREATE TRIGGER newVarukorgRow
AFTER INSERT
ON VarukorgRow FOR EACH ROW
    INSERT INTO WebshopLog (`what`, `product`, `balance`, `amount`)
        VALUES (NEW.varukorg, NEW.product, NEW.items, NEW.items);

DROP TRIGGER IF EXISTS deleteVarukorgRow;

CREATE TRIGGER deleteVarukorgRow
AFTER DELETE
ON VarukorgRow FOR EACH ROW
    INSERT INTO WebshopLog (`what`, `product`, `balance`, `amount`)
        VALUES ("deletedVarukorgRow", OLD.product, '0', 0 - OLD.items);

-- DROP TRIGGER IF EXISTS newOrderRow;
--
-- CREATE TRIGGER newOrderRow
-- AFTER INSERT
-- ON OrderRow FOR EACH ROW
--     INSERT INTO WebshopLog (`what`, `product`, `balance`, `amount`)
--         VALUES ("newVarukorgRow", NEW.varukorg, NEW.items, NEW.items);

-- ------------------------------------------------------------------------
--
-- HaveToOrderLog
--
CREATE TABLE HaveToOrderLog
(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `when` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `what` VARCHAR(20),
    `product` CHAR(4),
    `balance` DECIMAL(4, 2)
);

--
-- Trigger for logging updating balance
--
DROP TRIGGER IF EXISTS HaveToOrderUpdates;

DELIMITER //

CREATE TRIGGER HaveToOrderUpdates
BEFORE UPDATE
ON Inventory FOR EACH ROW
	IF NEW.items < 5 THEN
    INSERT INTO HaveToOrderLog (`what`, `product`, `balance`)
        VALUES ("Need to refill", NEW.prod_id, NEW.items);
	END IF;
//

DELIMITER ;

-- ------------------------------------------------------------------------
--
-- create Varukorg
--
DROP PROCEDURE IF EXISTS createVarukorg;

DELIMITER //

CREATE PROCEDURE createVarukorg(
	thisCustomer INT
)
BEGIN
	START TRANSACTION;

	INSERT INTO Varukorg
	SET
	customer = thisCustomer;
	COMMIT;

END
//
DELIMITER ;

-- CALL createVarukorg(1);

-- ------------------------------------------------------------------------
--
-- add To Varukorg
--
DROP PROCEDURE IF EXISTS addToVarukorg;

DELIMITER //

CREATE PROCEDURE addToVarukorg(
    varukorg INT,
	product INT,
    amount INT
)
BEGIN
	DECLARE currentItems INT;

	START TRANSACTION;

	SET currentItems = (SELECT items FROM Inventory WHERE id = product);

	IF currentItems - amount < 0 THEN
	ROLLBACK;
    SELECT "There is not enough items in Inventory to make a transaction.";

	ELSE

    INSERT INTO `VarukorgRow` (`varukorg`, `product`, `items`)
    VALUES
		(varukorg, product, amount)
		;

    UPDATE Inventory
    SET
    	items = items - amount
    WHERE
    	id = product;

    COMMIT;

	END IF;
END
//

DELIMITER ;


-- CALL addToVarukorg(1, 4, 1);

-- ------------------------------------------------------------------------
--
-- remove From Varukorg
--
DROP PROCEDURE IF EXISTS removeFromVarukorg;

DELIMITER //

CREATE PROCEDURE removeFromVarukorg(
		varukorgRow INT,
        product INT,
		amount INT
)
BEGIN

	START TRANSACTION;

	DELETE FROM VarukorgRow WHERE id = varukorgRow;

  UPDATE Inventory
  SET
  	items = items + amount
  WHERE
  	id = product;

  COMMIT;
END
//

DELIMITER ;

-- CALL removeFromVarukorg(1, 2, 20);

-- ------------------------------------------------------------------------
--
-- from Varukorg To Order
--
DROP PROCEDURE IF EXISTS fromVarukorgToOrder;

DELIMITER //

CREATE PROCEDURE fromVarukorgToOrder(
	cartId INT
)
BEGIN
	DECLARE amount INT;
	DECLARE i INT DEFAULT 0;
	DECLARE n INT DEFAULT 0;
	DECLARE productId INT;
	DECLARE orderNr INT;

	START TRANSACTION;

	INSERT INTO `Order` (`customer`)
	SELECT customer FROM Varukorg
	WHERE id = cartId;
	SET orderNr = LAST_INSERT_ID();

	INSERT INTO `Varukorg` (`customer`)
	SELECT customer FROM Varukorg
	WHERE id = cartId;

	SELECT COUNT(*) FROM VarukorgRow WHERE varukorg = cartId INTO n;
	SET i = 0;
	aLoop: WHILE i < n DO
		SELECT items FROM VarukorgRow WHERE varukorg = cartId LIMIT i,1
	    INTO amount;
		SELECT product FROM VarukorgRow WHERE varukorg = cartId LIMIT i,1
	    INTO productId;

	INSERT INTO OrderRow
	(`order`, `product`, `items`)
	SELECT
		orderNr, `product`, `items`
	FROM VarukorgRow
		WHERE varukorg = cartId
			LIMIT i,1;

SET i = i + 1;
END WHILE;

DELETE FROM VarukorgRow WHERE varukorg = cartId;
DELETE FROM Varukorg WHERE id = cartId;

COMMIT;

END
//
DELIMITER ;

-- CALL fromVarukorgToOrder(1);

DROP VIEW IF EXISTS showWebshop;
CREATE VIEW showWebshop AS
SELECT
	S.shelf,
	I.items,
	P.description,
	P.price,
	P.id,
	P.picture,
	GROUP_CONCAT(category) AS category
FROM Inventory AS I
	INNER JOIN InvenShelf AS S
		ON I.shelf_id = S.shelf
	INNER JOIN Product AS P
		ON P.id = I.prod_id
	INNER JOIN Prod2Cat AS P2C
		ON P.id = P2C.prod_id
	INNER JOIN ProdCategory AS PC
		ON PC.id = P2C.cat_id
GROUP BY P.id
;


DROP VIEW IF EXISTS showCart;
CREATE VIEW showCart AS
SELECT
	V.id,
	V.varukorg,
	P.picture,
	V.product,
	P.description,
	P.price,
	V.items,
	GROUP_CONCAT(category) AS category
FROM VarukorgRow AS V
	INNER JOIN Product AS P
		ON P.id = V.product
	INNER JOIN Prod2Cat AS P2C
		ON P.id = P2C.prod_id
	INNER JOIN ProdCategory AS PC
		ON PC.id = P2C.cat_id
GROUP BY V.id
;

DROP VIEW IF EXISTS showOrders;
CREATE VIEW showOrders AS
SELECT
	R.id,
	R.order,
	C.id AS customer,
	C.firstName,
	C.lastName,
	P.picture,
	R.product,
	P.description,
	P.price,
	R.items,
	GROUP_CONCAT(category) AS category
	FROM OrderRow AS R
  INNER JOIN `Order` AS O
		ON O.id = R.order
  INNER JOIN Customer AS C
		ON C.id = O.customer
	INNER JOIN Product AS P
		ON P.id = R.product
	INNER JOIN Prod2Cat AS P2C
		ON P.id = P2C.prod_id
	INNER JOIN ProdCategory AS PC
		ON PC.id = P2C.cat_id
GROUP BY R.id
;

-- SELECT * FROM showOrders;
-- SELECT * FROM VarukorgRow;
-- SELECT * FROM OrderRow;
-- SELECT * FROM `Order`;
-- SELECT * FROM Inventory;
-- SELECT * FROM Varukorg;
