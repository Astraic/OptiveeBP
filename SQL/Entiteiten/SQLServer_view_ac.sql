DROP VIEW IF EXISTS AnimalClassification;

CREATE VIEW AnimalClassification AS
SELECT *
FROM Animal INNER JOIN [Classification] ON Animal.id = [Classification].animalid;