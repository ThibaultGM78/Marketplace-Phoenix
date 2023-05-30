DROP DATABASE IF EXISTS marketplace;
CREATE DATABASE marketplace;
USE marketplace;

DROP TABLE IF EXISTS marketplace_product;
DROP TABLE IF EXISTS marketplace_order;
DROP TABLE IF EXISTS marketplace_customer;
DROP TABLE IF EXISTS marketplace_contract;
DROP TABLE IF EXISTS marketplace_compagny;
DROP TABLE IF EXISTS marketplace_user;
DROP TABLE IF EXISTS marketplace_purchase;
DROP TABLE IF EXISTS marketplace_subscription;
DROP TABLE IF EXISTS marketplace_Livreur;
DROP TABLE IF EXISTS marketplace_Vehicle;
/*DROP TABLE IF EXISTS marketplace_contains;*/

/* Partie market place*/

CREATE TABLE marketplace_user(
	id_user INT AUTO_INCREMENT,
	user_login VARCHAR(15),
    user_passwd VARCHAR(15),
    user_mail VARCHAR(40),
    user_role VARCHAR(20),

	PRIMARY KEY(id_user)
);
    
CREATE TABLE marketplace_contract(
	id_contract INT AUTO_INCREMENT, 
    contract_start DATE,
    contract_end DATE,
    contract_commission INT,
	id_compagny INT,

	PRIMARY KEY(id_contract)
);
    
CREATE TABLE marketplace_order(
	id_order INT AUTO_INCREMENT,
	PRIMARY KEY(id_order)
);

CREATE TABLE marketplace_subscription(
	id_subscription INT AUTO_INCREMENT, 
    subscription_start DATE,
    subscription_end DATE,
    subscription_reduction INT,
	id_customer INT,

	PRIMARY KEY(id_subscription)
);

CREATE TABLE marketplace_customer(
	id_customer INT AUTO_INCREMENT,
    id_user INT,
	id_subscription INT,

    FOREIGN KEY fk_user(id_user) REFERENCES marketplace_user(id_user),
	FOREIGN KEY fk_(id_subscription) REFERENCES marketplace_subscription(id_subscription) ON DELETE CASCADE,

	PRIMARY KEY(id_customer)
);

CREATE TABLE marketplace_compagny(
	id_compagny INT AUTO_INCREMENT,
    id_user INT,
    id_contract INT,
	compagny_name VARCHAR(15),
	compagny_turnover TEXT,
    FOREIGN KEY fk_user(id_user) REFERENCES marketplace_user(id_user),
    FOREIGN KEY fk_contract(id_contract) REFERENCES marketplace_contract(id_contract) ON DELETE CASCADE,

	PRIMARY KEY(id_compagny)
);

CREATE TABLE marketplace_product(
	id_product INT AUTO_INCREMENT,
	product_name VARCHAR(30),
	product_price DECIMAL(6,2),
   	product_category VARCHAR(15),
    product_stock INT,
    product_desc TEXT,
    product_img VARCHAR(100),
    id_compagny INT,
	product_stats TEXT,

    FOREIGN KEY fk_compagny(id_compagny) REFERENCES marketplace_compagny(id_compagny),
	PRIMARY KEY(id_product)
);

/*Echantillon*/

/*Admin/owner*/
/*id == 1*/
INSERT INTO `marketplace_contract`(`contract_start`, `contract_end`, `contract_commission`) VALUES ("2023-01-01","2099-12-31", "0");
INSERT INTO `marketplace_user`(`user_login`,`user_passwd`,`user_mail`,`user_role`)
VALUES("Admin","0000","admin@phoenix.com","compagny");
INSERT INTO `marketplace_compagny`(`id_user`,`compagny_name`,`id_contract`,`compagny_turnover`)
VALUES(1,"Phoenix", 1, '{"January": 0,"February": 0,"March": 0,"April": 0,"May": 0,"June": 0,"July": 0,"August": 0,"September": 0,"October": 0,"November": 0,"December": 0,"lastSaleMonth": ""}');

/*Contract*/
INSERT INTO `marketplace_contract`(`contract_start`, `contract_end`, `contract_commission`) VALUES ("2023-02-03","2024-02-03", "15");
INSERT INTO `marketplace_contract`(`contract_start`, `contract_end`, `contract_commission`) VALUES ("2023-02-03","2025-02-03", "10");
SET FOREIGN_KEY_CHECKS=0; -- to disable them*/

/*USER*/
INSERT INTO `marketplace_user`(`user_login`,`user_passwd`,`user_mail`,`user_role`)
VALUES("Maxime","mama","max.cymes@gmail.com","compagny");
INSERT INTO `marketplace_user`(`user_login`,`user_passwd`,`user_mail`,`user_role`)
VALUES("Patrick","papa","patrick.timsit@gmail.com","compagny");
INSERT INTO `marketplace_user`(`user_login`,`user_passwd`,`user_mail`,`user_role`)
VALUES("steguo","sqsq","steg@gmail.com","customer");
SELECT * FROM marketplace_user;

/*Customer*/
INSERT INTO `marketplace_customer`(`id_user`,`id_subscription`)
VALUES(4,1);

/*Subscription*/
INSERT INTO `marketplace_subscription`(`subscription_start`, `subscription_end`, `subscription_reduction`, `id_customer`)
VALUES ("2023-02-03","2026-02-03", 10, 1);

/*COMPAGNY*/
INSERT INTO `marketplace_compagny`(`id_user`,`compagny_name`,`id_contract`,`compagny_turnover`)
VALUES(2,"MaximePull",2, '{"January": 0,"February": 0,"March": 0,"April": 0,"May": 0,"June": 0,"July": 0,"August": 0,"September": 0,"October": 0,"November": 0,"December": 0,"lastSaleMonth": ""}');
INSERT INTO `marketplace_compagny`(`id_user`,`compagny_name`,`id_contract`,`compagny_turnover`)
VALUES(3,"EISTEL",3, '{"January": 0,"February": 0,"March": 0,"April": 0,"May": 0,"June": 0,"July": 0,"August": 0,"September": 0,"October": 0,"November": 0,"December": 0,"lastSaleMonth": ""}');
SELECT * FROM marketplace_compagny;

/*DELETE marketplace_contract, marketplace_compagny FROM marketplace_contract
JOIN marketplace_compagny ON marketplace_compagny.id_contract = marketplace_contract.id_contract
WHERE id_compagny = "1";*/
SELECT * FROM marketplace_contract;

/*PRODUCT*/
INSERT INTO `marketplace_product`(`product_name`, `product_price`, `product_category`, `product_stock`, `product_desc`, `product_img`, `id_compagny`, `product_stats`)
VALUES("Iphone 6",100,"telephone",16,"Telephone pas ouf","img/compagny/CYTEL/iphone6.jpg", 1, '{"January": 0,"February": 0,"March": 0,"April": 0,"May": 0,"June": 0,"July": 0,"August": 0,"September": 0,"October": 0,"November": 0,"December": 0,"lastSaleMonth": ""}');
INSERT INTO `marketplace_product`(`product_name`, `product_price`, `product_category`, `product_stock`, `product_desc`, `product_img`, `id_compagny`, `product_stats`)
VALUES("Iphone 8",350,"telephone",18,"Telephone un peu mieux","img/compagny/CYTEL/iphone8.jpg", 1, '{"January": 0,"February": 0,"March": 0,"April": 0,"May": 0,"June": 0,"July": 0,"August": 0,"September": 0,"October": 0,"November": 0,"December": 0,"lastSaleMonth": ""}');
INSERT INTO `marketplace_product`(`product_name`, `product_price`, `product_category`, `product_stock`, `product_desc`, `product_img`, `id_compagny`, `product_stats`)
VALUES("Iphone 10",650,"telephone",20,"Telephone 2 fois mieux que le 6","img/compagny/CYTEL/iphone10.jpg", 1, '{"January": 0,"February": 0,"March": 0,"April": 0,"May": 0,"June": 0,"July": 0,"August": 0,"September": 0,"October": 0,"November": 0,"December": 0,"lastSaleMonth": ""}');
INSERT INTO `marketplace_product`(`product_name`, `product_price`, `product_category`, `product_stock`, `product_desc`, `product_img`, `id_compagny`, `product_stats`)
VALUES("Pull Noir",20,"Pull",10,"matière : coton, confortable","img/compagny/Pull.jpg", 2, '{"January": 7,"February": 12,"March": 9,"April": 3,"May": 5,"June": 5,"July": 6,"August": 8,"September": 14,"October": 12,"November": 10,"December": 11,"lastSaleMonth": "10000"}');
INSERT INTO `marketplace_product`(`product_name`, `product_price`, `product_category`, `product_stock`, `product_desc`, `product_img`, `id_compagny`, `product_stats`)
VALUES("Iphone 6",90,"telephone",16,"J'adore les pates et vous ?","img/compagny/CYTEL/iphone6.jpg", 3, '{"January": 0,"February": 0,"March": 0,"April": 0,"May": 0,"June": 0,"July": 0,"August": 0,"September": 0,"October": 0,"November": 0,"December": 0,"lastSaleMonth": ""}');
INSERT INTO `marketplace_product`(`product_name`, `product_price`, `product_category`, `product_stock`, `product_desc`, `product_img`, `id_compagny`, `product_stats`)
VALUES("Iphone 8",360,"telephone",18,"Telephone sucre au sucre","img/compagny/CYTEL/iphone8.jpg", 2, '{"January": 0,"February": 0,"March": 0,"April": 0,"May": 0,"June": 0,"July": 0,"August": 0,"September": 0,"October": 0,"November": 0,"December": 0,"lastSaleMonth": ""}');
INSERT INTO `marketplace_product`(`product_name`, `product_price`, `product_category`, `product_stock`, `product_desc`, `product_img`, `id_compagny`, `product_stats`)
VALUES("Iphone 14",900,"telephone",21,"Smartphone dernière génération de la marque Apple","img/compagny/MaximePull/iphone14.jpg", 2, '{"January": 0,"February": 0,"March": 0,"April": 0,"May": 0,"June": 0,"July": 0,"August": 0,"September": 0,"October": 0,"November": 0,"December": 0,"lastSaleMonth": ""}');
INSERT INTO `marketplace_product`(`product_name`, `product_price`, `product_category`, `product_stock`, `product_desc`, `product_img`, `id_compagny`, `product_stats`)
VALUES("PS5",550,"console",7,"Console de salon SONY dernière generation","img/compagny/MaximePull/ps5.jpg", 2, '{"January": 0,"February": 0,"March": 0,"April": 0,"May": 0,"June": 0,"July": 0,"August": 0,"September": 0,"October": 0,"November": 0,"December": 0,"lastSaleMonth": ""}');
INSERT INTO `marketplace_product`(`product_name`, `product_price`, `product_category`, `product_stock`, `product_desc`, `product_img`, `id_compagny`, `product_stats`)
VALUES("TV Samsung Oled",950,"Television",7,"TV dernière generation commercialisée par Samsung","img/compagny/MaximePull/tvsamsung.jpg", 2, '{"January": 7,"February": 12,"March": 9,"April": 3,"May": 5,"June": 5,"July": 6,"August": 8,"September": 14,"October": 12,"November": 10,"December": 11,"lastSaleMonth": "10000"}');
select * from marketplace_product;

/*Partie livreur*/

CREATE TABLE marketplace_Livreur (
  id_Livreur INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(255) NOT NULL,
  typePermis VARCHAR(2) NOT NULL,
  PRIMARY KEY (id_Livreur)
);
CREATE TABLE marketplace_purchase(
	id_purchase INT AUTO_INCREMENT, 
	id_customer INT,
    purchase_date DATE,
   	purchase_basket TEXT,
	purchase_adress TEXT,
	id_livreur INT,

    etatExped ENUM('enPreparation', 'préparé', 'Livré'),

	FOREIGN KEY fk_customer(id_customer) REFERENCES marketplace_customer(id_customer),
    FOREIGN KEY (id_Livreur) REFERENCES marketplace_Livreur(id_Livreur),
	PRIMARY KEY(id_purchase)
);
ALTER TABLE marketplace_purchase MODIFY etatExped ENUM('enPreparation', 'préparé', 'Livré') DEFAULT 'enPreparation';

CREATE TABLE marketplace_archive (
    id_purchase INT AUTO_INCREMENT PRIMARY KEY,
    id_customer INT,
    purchase_date DATE NOT NULL,
    purchase_basket TEXT NOT NULL,
    purchase_adress TEXT NOT NULL,
    id_livreur INT,
    etatExped ENUM('enPreparation', 'préparé', 'Livré') DEFAULT 'enPreparation',
    date_livraison DATE
);
ALTER TABLE marketplace_archive MODIFY etatExped ENUM('enPreparation', 'préparé', 'Livré') DEFAULT 'enPreparation';


INSERT INTO marketplace_archive (id_purchase, id_customer, purchase_date, purchase_basket, purchase_adress, id_Livreur, etatExped, date_livraison) VALUES
(1,1,'2022-02-02', '{"1":2}', '12 Rue de la Paix, Paris', 1,'enPreparation', '2022-02-03'),
(2,2,'2022-02-03', '{"1":2}', '8 Avenue des Champs-Élysées, Paris', 2,'enPreparation', '2022-02-03'),
(3,3,'2022-02-05', '{"3":3,"4":1,"4":1}', '5 Rue de Rivoli, Paris', 3, 'enPreparation', '2022-02-03'),
(4,4,'2022-02-06', '{"1":7,"3":2}', '20 Rue de la Liberté, Lyon', 4, 'enPreparation', '2022-02-03'),
(5,5,'2022-02-08', '{"1":1}', '2 Rue du Faubourg Saint-Honoré, Paris', 5, 'enPreparation', '2022-02-03'),
(6,6,'2022-02-09', '{"2":2}', '15 Rue de la République, Marseille', 6, 'enPreparation', '2022-02-03');

CREATE TABLE marketplace_Vehicle (
  id_Vehicle INT NOT NULL AUTO_INCREMENT,
  id_Livreur INT NOT NULL,
  modele VARCHAR(255) NOT NULL,
  marque VARCHAR(255) NOT NULL,
  typePermis VARCHAR(2) NOT NULL,
  PRIMARY KEY (id_Vehicle),
  FOREIGN KEY (id_Livreur) REFERENCES marketplace_Livreur(id_Livreur)
);
SET FOREIGN_KEY_CHECKS=0; -- to disable them

INSERT INTO marketplace_Livreur (nom, typePermis) VALUES
('Jean Dupont', 'B'),
('Marie Martin', 'C'),
('Pierre Durand', 'B');

INSERT INTO marketplace_Vehicle (id_Livreur, modele, marque, typePermis) VALUES
(1, '208', 'Peugeot','B'),
(2, 'Clio', 'Renault','C'),
(2, 'Golf', 'Volkswagen','B'),
(3, 'C4', 'Citroën','B');

INSERT INTO marketplace_purchase (purchase_date, purchase_basket, purchase_adress, id_customer, id_Livreur) VALUES
('2022-02-02', '{"1":2}', '12 Rue de la Paix, Paris', 1, 1),
('2022-02-03', '{"1":2}', '8 Avenue des Champs-Élysées, Paris', 2, 2),
('2022-02-05', '{"3":3,"4":1,"4":1}', '5 Rue de Rivoli, Paris', 3, 2),
('2022-02-06', '{"1":7,"3":2}', '20 Rue de la Liberté, Lyon', 4, 3),
('2022-02-08', '{"1":1}', '2 Rue du Faubourg Saint-Honoré, Paris', 5, 1),
('2022-02-09', '{"2":2}', '15 Rue de la République, Marseille', 6, 3);


select * from marketplace_purchase;
select * from marketplace_user;
select * from marketplace_customer;
select * from marketplace_archive;
select * from marketplace_product;
select * from marketplace_subscription;

SELECT mp.purchase_adress, mp.purchase_basket
  FROM marketplace_purchase AS mp
  LEFT JOIN marketplace_customer AS mc ON mp.id_customer = mc.id_customer
  WHERE mc.id_subscription IS NULL;
  
  SELECT mp.purchase_adress,  mp.purchase_basket
  FROM marketplace_customer AS mc
  JOIN marketplace_purchase AS mp ON mc.id_customer = mp.id_customer
  JOIN marketplace_subscription AS ms ON mc.id_subscription = ms.id_subscription
  
  