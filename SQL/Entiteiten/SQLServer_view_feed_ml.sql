DROP VIEW IF EXISTS MLViewFeed;

CREATE VIEW MLViewFeed AS
SELECT p.animal, c.feedid, f.name, c.portion, c.consumption, c.date AS consumptiondate, p.production, CAST(p.productiondatetime AS Date) AS productiondate
FROM Production AS p INNER JOIN Consumption AS c ON c.animalid = p.animal INNER JOIN Feed AS f ON c.feedid = f.id 
WHERE p.product = 'Melk' AND CAST(p.productiondatetime AS Date) = c.date