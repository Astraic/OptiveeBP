DROP VIEW IF EXISTS AnimalFeedCache;

CREATE VIEW AnimalFeedCache AS
SELECT TOP 1 animalid, feedname, portionsize, allocated
FROM FeedDistribution
ORDER BY [date], [time] DESC;