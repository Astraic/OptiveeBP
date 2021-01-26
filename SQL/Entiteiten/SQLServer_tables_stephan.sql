DROP TABLE IF EXISTS [Classification];
DROP TABLE IF EXISTS FeedingMachine;
DROP TABLE IF EXISTS FeedDistribution;
DROP TABLE IF EXISTS MeatGrade;
DROP TABLE IF EXISTS FatGrade;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Feed;

CREATE TABLE Feed 
(
	[name] VARCHAR(50) PRIMARY KEY
);

CREATE TABLE Category
(
	[name] CHAR(1) PRIMARY KEY
);

CREATE TABLE FatGrade 
(
	[name] CHAR(1) PRIMARY KEY
);

CREATE TABLE MeatGrade 
(
	[name] CHAR(1) PRIMARY KEY
);

CREATE TABLE FeedDistribution 
(
	animalid UNIQUEIDENTIFIER NOT NULL,
	[date] DATE NOT NULL,
	[time] TIME(7) NOT NULL,
	feedname VARCHAR(50) NOT NULL,
	portionsize DECIMAL(5, 3) NOT NULL,
	allocated DECIMAL(5, 3) NOT NULL,
	consumed DECIMAL(5, 3) NOT NULL,
	PRIMARY KEY(animalid, [date], [time]),
	CONSTRAINT FeedDistribution_Animal_FK FOREIGN KEY (animalid) REFERENCES Animal(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FeedDistribution_Feed_FK FOREIGN KEY (feedname) REFERENCES Feed(name) ON UPDATE CASCADE,
);

CREATE TABLE FeedingMachine 
(
	hardwareid UNIQUEIDENTIFIER PRIMARY KEY NOT NULL default NEWID(),
	[group] INT,
	feedname VARCHAR(50),
	allocated DECIMAL(5, 3),
	portionsize DECIMAL(5, 3),
	CONSTRAINT FeedingMachine_Feed_FK FOREIGN KEY (feedname) REFERENCES Feed(name) ON UPDATE CASCADE,
);

CREATE TABLE [Classification]
(
	animalid UNIQUEIDENTIFIER PRIMARY KEY NOT NULL,
	[date] DATE NOT NULL,
	[time] TIME(7) NOT NULL,
	category CHAR(1) NOT NULL,
	fatgrade CHAR(1) NOT NULL,
	meatgrade CHAR(1) NOT NULL,
	amount DECIMAL(5, 3) NOT NULL,
	CONSTRAINT FeedDistributions_Animal_FK FOREIGN KEY (animalid) REFERENCES Animal(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT Classification_Category_FK FOREIGN KEY (category) REFERENCES Category(name) ON UPDATE CASCADE,
	CONSTRAINT Classification_FatGrade_FK FOREIGN KEY (fatgrade) REFERENCES FatGrade(name) ON UPDATE CASCADE,
	CONSTRAINT Classification_MeatGrade_FK FOREIGN KEY (meatgrade) REFERENCES MeatGrade(name) ON UPDATE CASCADE,
);