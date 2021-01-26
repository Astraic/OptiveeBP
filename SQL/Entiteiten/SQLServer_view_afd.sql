DROP VIEW IF EXISTS AnimalFeedDistribution;

CREATE VIEW AnimalFeedDistribution AS
SELECT *
FROM Animal INNER JOIN FeedDistribution ON Animal.id = FeedDistribution.animalid;