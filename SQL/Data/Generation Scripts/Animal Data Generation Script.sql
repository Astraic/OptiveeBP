
DECLARE @i INT = 0

WHILE @i < 15
BEGIN
	INSERT INTO Animal (nfc, country, serial, working, control, product, reasonofdeath, passdate, environment) 
	VALUES (
		CONVERT(VARCHAR(4), REPLACE(NEWID(), '-', '')), 
		(SELECT TOP 1 code FROM Country ORDER BY NEWID()), 
		FLOOR(RAND()*9000+1000), 
		FLOOR(RAND()*9000+1000), 
		CEILING(RAND()*9), 
		'Melk', 
		(SELECT TOP 1 reasonofdeath FROM Reasonofdeath ORDER BY NEWID()), 
		CONVERT(DATE, DATEADD(DAY, FLOOR(RAND()*12), '2021-01-10'), 23), 
		'Weiland')
SET @i = @i + 1
END