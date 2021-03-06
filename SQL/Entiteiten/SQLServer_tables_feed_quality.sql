DROP TABLE IF EXISTS Quality;
DROP TABLE IF EXISTS [Distribution];
DROP TABLE IF EXISTS Consumption;
DROP TABLE IF EXISTS Meat;
DROP TABLE IF EXISTS Fat;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Feed;

CREATE TABLE Feed 
(
	id SMALLINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	[name] VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE Category
(
	[name] CHAR(1) PRIMARY KEY
);

CREATE TABLE Fat
(
	[name] CHAR(1) PRIMARY KEY
);

CREATE TABLE Meat 
(
	[name] CHAR(1) PRIMARY KEY
);

CREATE TABLE Consumption 
(
	animalid UNIQUEIDENTIFIER NOT NULL,
	[date] DATE NOT NULL,
	[time] TIME(0) NOT NULL,
	feedid SMALLINT NOT NULL,
	portion DECIMAL(5, 3),
	assigned DECIMAL(5, 3),
	consumption DECIMAL(5, 3) NOT NULL,
	PRIMARY KEY(animalid, [date], [time]),
	CONSTRAINT Consumption_Animal_FK FOREIGN KEY (animalid) REFERENCES Animal(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT Consumption_Feed_FK FOREIGN KEY (feedid) REFERENCES Feed(id) ON UPDATE CASCADE,
);

CREATE TABLE [Distribution] 
(
	animalid UNIQUEIDENTIFIER NOT NULL PRIMARY KEY,
	feedid SMALLINT NOT NULL,
	portion DECIMAL(5, 3),
	assigned DECIMAL(5, 3),
	CONSTRAINT Distribution_Animal_FK FOREIGN KEY (animalid) REFERENCES Animal(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT Distribution_Feed_FK FOREIGN KEY (feedid) REFERENCES Feed(id) ON UPDATE CASCADE,
);

CREATE TABLE Quality
(
	animalid UNIQUEIDENTIFIER NOT NULL PRIMARY KEY,
	[date] DATE NOT NULL,
	[time] TIME(0) NOT NULL,
	catname CHAR(1) NOT NULL,
	fatname CHAR(1) NOT NULL,
	meatname CHAR(1) NOT NULL,
	amount DECIMAL(5, 2) NOT NULL,
	CONSTRAINT Quality_Animal_FK FOREIGN KEY (animalid) REFERENCES Animal(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT Quality_Category_FK FOREIGN KEY (catname) REFERENCES Category(name) ON UPDATE CASCADE,
	CONSTRAINT Quality_Fat_FK FOREIGN KEY (fatname) REFERENCES Fat(name) ON UPDATE CASCADE,
	CONSTRAINT Quality_Meat_FK FOREIGN KEY (meatname) REFERENCES Meat(name) ON UPDATE CASCADE,
);