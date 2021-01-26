DROP VIEW IF EXISTS v_Distribution;

CREATE VIEW v_Distribution AS
SELECT a.nfc, d.feedid, d.portion, d.assigned
FROM Animal AS a INNER JOIN Distribution AS d ON a.id = d.animalid;