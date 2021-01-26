USE [optiveedb]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Country](
	[code] [varchar](2) NOT NULL,
	[name] [varchar](100) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[code] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [ak1005] UNIQUE NONCLUSTERED 
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
CREATE TABLE [dbo].[Product](
	[product] [varchar](30) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[product] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
CREATE TABLE [dbo].[Reasonofdeath](
	[reasonofdeath] [varchar](30) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[reasonofdeath] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[Animal](
	[id] [uniqueidentifier] NOT NULL,
	[nfc] [varchar](20) NOT NULL,
	[country] [varchar](2) NULL,
	[serial] [smallint] NULL,
	[working] [smallint] NULL,
	[control] [smallint] NULL,
	[product] [varchar](30) NULL,
	[reasonofdeath] [varchar](30) NULL,
	[passdate] [date] NULL,
	[environment] [varchar](30) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [ak1003] UNIQUE NONCLUSTERED 
(
	[nfc] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [ak1013] UNIQUE NONCLUSTERED 
(
	[country] ASC,
	[serial] ASC,
	[working] ASC,
	[control] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[Animal] ADD  CONSTRAINT [DF_Animal_id]  DEFAULT (newid()) FOR [id]
GO
ALTER TABLE [dbo].[Animal]  WITH NOCHECK ADD  CONSTRAINT [animal2002] FOREIGN KEY([product])
REFERENCES [dbo].[Product] ([product])
GO
ALTER TABLE [dbo].[Animal] CHECK CONSTRAINT [animal2002]
GO
ALTER TABLE [dbo].[Animal]  WITH NOCHECK ADD  CONSTRAINT [animal2003] FOREIGN KEY([reasonofdeath])
REFERENCES [dbo].[Reasonofdeath] ([reasonofdeath])
GO
ALTER TABLE [dbo].[Animal] CHECK CONSTRAINT [animal2003]
GO
ALTER TABLE [dbo].[Animal]  WITH NOCHECK ADD  CONSTRAINT [animal2005] FOREIGN KEY([country])
REFERENCES [dbo].[Country] ([code])
CREATE TABLE [dbo].[Production](
	[animal] [uniqueidentifier] NOT NULL,
	[production] [int] NOT NULL,
	[product] [varchar](30) NOT NULL,
	[productiondatetime] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[animal] ASC,
	[product] ASC,
	[productiondatetime] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[Production]  WITH NOCHECK ADD  CONSTRAINT [production2001] FOREIGN KEY([animal])
REFERENCES [dbo].[Animal] ([id])
GO
ALTER TABLE [dbo].[Production] CHECK CONSTRAINT [production2001]
GO
ALTER TABLE [dbo].[Production]  WITH NOCHECK ADD  CONSTRAINT [production2002] FOREIGN KEY([product])
REFERENCES [dbo].[Product] ([product])
GO
ALTER TABLE [dbo].[Production] CHECK CONSTRAINT [production2002]
GO
CREATE VIEW [dbo].[ActiveAnimal]
AS
SELECT        nfc, id, country, serial, working, control, product, environment, passdate, reasonofdeath
FROM            dbo.Animal
WHERE        (passdate IS NULL) AND (country IS NOT NULL) AND (reasonofdeath IS NULL)
GO
CREATE VIEW [dbo].[NewAnimal]
AS
SELECT        id, nfc, country, serial, working, control, product, environment
FROM            dbo.Animal
WHERE        (country IS NULL)
GO
CREATE VIEW [dbo].[DeceasedAnimal]
AS
SELECT        id, nfc, country, serial, working, control, product, reasonofdeath, passdate, environment
FROM            dbo.Animal
WHERE        (passdate IS NOT NULL);
GO
CREATE VIEW [dbo].[MLViewAnimal]
AS
SELECT        dbo.Animal.id, dbo.Animal.reasonofdeath, dbo.Animal.passdate, dbo.Production.production, dbo.Production.productiondatetime, dbo.Consumption.date, dbo.Consumption.feedid, dbo.Consumption.portion, 
                         dbo.Consumption.assigned, dbo.Consumption.consumption
FROM            dbo.Animal INNER JOIN
                         dbo.Production ON dbo.Animal.id = dbo.Production.animal INNER JOIN
                         dbo.Consumption ON dbo.Animal.id = dbo.Consumption.animalid
GO



