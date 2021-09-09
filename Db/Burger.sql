drop database if exists McSoupex_DataBase;
create database if not exists McSoupex_DataBase character set ='utf8';

use McSoupex_DataBase;

CREATE TABLE categories (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  primary key(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE items (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  description varchar(255) NOT NULL,
  price numeric(7,2) NOT NULL,
  img varchar(255) NOT NULL,
  category int NOT NULL,
  primary key(id),
  key(category)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE client (
	idcli int NOT NULL AUTO_INCREMENT,
	nomcli varchar(100) NOT NULL,
	prenomcli varchar(100) NOT NULL,
	adressecli varchar(100) NOT NULL,
	telcli varchar(20) NOT NULL,
	mdp varchar(100) not null,
	pseudo VARCHAR(255) not null,
	primary key(idcli)

) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE commande (
	idCommande int not null AUTO_INCREMENT,
	idcli int not null,
	dateC date not null,
	quantite int not null,
	idItems int not null,
	primary key(idCommande),
	key(idcli,iditems)

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

create table admin (
	idAdmin int not null AUTO_INCREMENT,
	pseudoAdmin varchar(100) not null,
	mdp varchar(100) not null,
	primary key(idAdmin)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

create table avis (
	idAvis int not null AUTO_INCREMENT,
	idcli int NOT NULL,
	note tinyint not null,
	textAvis varchar(200) not null,
	primary key(idAvis),
	key(idcli)

)ENGINE=InnoDB DEFAULT CHARSET=latin1;

create table livreur (
	idLivreur int not null AUTO_INCREMENT,
	nom varchar(100) not null,
	mdp varchar(100) not null,
	primary key(idLivreur)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

create table cuisinier (
	idCuisiner int not null AUTO_INCREMENT,
	nom varchar(100) not null,
	mdp varchar(100) not null,
	primary key(idCuisiner)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

create table clientEnAttente(

	idcli int not null,
	primary key(idCli)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Clé étrangère*/

Alter table clientEnAttente ADD CONSTRAINT fkcTClient foreign key(idcli) REFERENCES client(idcli);

ALTER TABLE items
  ADD CONSTRAINT fkItemsCategories FOREIGN KEY (category) REFERENCES categories (id) ON DELETE CASCADE ON UPDATE CASCADE;
  
  alter table commande ADD CONSTRAINT fkCommandeItems FOREIGN KEY (idItems) REFERENCES items (id) ON DELETE CASCADE ON UPDATE CASCADE;
  alter table commande ADD CONSTRAINT fkCommandeClient FOREIGN KEY (idcli) REFERENCES client (idcli) ON DELETE CASCADE ON UPDATE CASCADE;
  
  Alter table avis add CONSTRAINT fkAvisClient foreign key(idcli) REFERENCES client
  (idcli) ON DELETE CASCADE ON UPDATE CASCADE; 


-- Ajout des menus
INSERT INTO categories (name) VALUES
('Menus'),
('Burgers'),
('Snacks'),
('Salades'),
('Boissons'),
('Desserts');

-- Ajout des items
INSERT INTO items (name, description, price, img, category) VALUES
('Menu Classic', 'Sandwich: Burger, Salade, Tomate, Cornichon + Frites + Boisson', 8.9, 'm1.png', 1),
('Menu Bacon', 'Sandwich: Burger, Fromage, Bacon, Salade, Tomate + Frites + Boisson', 9.5, 'm2.png', 1),
('Menu Big', 'Sandwich: Double Burger, Fromage, Cornichon, Salade + Frites + Boisson', 10.9, 'm3.png', 1),
('Menu Chicken', 'Sandwich: Poulet Frit, Tomate, Salade, Mayonnaise + Frites + Boisson', 9.9, 'm4.png', 1),
('Menu Fish', 'Sandwich: Poisson, Salade, Mayonnaise, Cornichon + Frites + Boisson', 10.9, 'm5.png', 1),
('Menu Double Steak', 'Sandwich: Double Burger, Fromage, Bacon, Salade, Tomate + Frites + Boisson', 11.9, 'm6.png', 1),
('Classic', 'Sandwich: Burger, Salade, Tomate, Cornichon', 5.9, 'b1.png', 2),
('Bacon', 'Sandwich: Burger, Fromage, Bacon, Salade, Tomate', 6.5, 'b2.png', 2),
('Big', 'Sandwich: Double Burger, Fromage, Cornichon, Salade', 6.9, 'b3.png', 2),
('Chicken', 'Sandwich: Poulet Frit, Tomate, Salade, Mayonnaise', 5.9, 'b4.png', 2),
('Fish', 'Sandwich: Poisson Pané, Salade, Mayonnaise, Cornichon', 6.5, 'b5.png', 2),
('Double Steak', 'Sandwich: Double Burger, Fromage, Bacon, Salade, Tomate', 7.5, 'b6.png', 2),
('Frites', 'Pommes de terre frites', 3.9, 's1.png', 3),
('Onion Rings', 'Rondelles d''oignon frits', 3.4, 's2.png', 3),
('Nuggets', 'Nuggets de poulet frits', 5.9, 's3.png', 3),
('Nuggets Fromage', 'Nuggets de fromage frits', 3.5, 's4.png', 3),
('Ailes de Poulet', 'Ailes de poulet Barbecue', 5.9, 's5.png', 3),
('César Poulet Pané', 'Poulet Pané, Salade, Tomate et la fameuse sauce César', 8.9, 'sa1.png', 4),
('César Poulet Grillé', 'Poulet Grillé, Salade, Tomate et la fameuse sauce César', 8.9, 'sa2.png', 4),
('Salade Light', 'Salade, Tomate, Concombre, Mais et Vinaigre balsamique', 5.9, 'sa3.png', 4),
('Poulet Pané', 'Poulet Pané, Salade, Tomate et la sauce de votre choix', 7.9, 'sa4.png', 4),
('Poulet Grillé', 'Poulet Grillé, Salade, Tomate et la sauce de votre choix', 7.9, 'sa5.png', 4),
('Coca-Cola', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo1.png', 5),
('Coca-Cola Light', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo2.png', 5),
('Coca-Cola Zéro', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo3.png', 5),
('Fanta', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo4.png', 5),
('Sprite', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo5.png', 5),
('Nestea', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo6.png', 5),
('Fondant au chocolat', 'Au choix: Chocolat Blanc ou au lait', 4.9, 'd1.png', 6),
('Muffin', 'Au choix: Au fruits ou au chocolat', 2.9, 'd2.png', 6),
('Beignet', 'Au choix: Au chocolat ou à la vanille', 2.9, 'd3.png', 6),
('Milkshake', 'Au choix: Fraise, Vanille ou Chocolat', 3.9, 'd4.png', 6),
('Sundae', 'Au choix: Fraise, Caramel ou Chocolat', 4.9, 'd5.png', 6);


INSERT INTO admin (pseudoAdmin,mdp) VALUES
('Admin','adminhelha');

INSERT INTO livreur (nom,mdp) VALUES
('Leopold','livreurhelha');

INSERT INTO livreur (nom,mdp) VALUES
('Arnold','livreur2helha');

INSERT INTO cuisinier (nom,mdp) VALUES
('Joy','cuisinierhelha');

INSERT INTO cuisinier (nom,mdp) VALUES
('Negan','cuisinier2helha');




