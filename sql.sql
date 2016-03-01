-- 1.
CREATE TABLE `parent` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `leaf` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 1.а.
SELECT
	P.*,
	COUNT(L.id) AS num
FROM
	`parent` P
	INNER JOIN `leaf` L ON L.parent_id = P.id
GROUP BY
	P.id
ORDER BY
	num DESC;

-- 1.б.
SELECT
	P.name,
	COUNT(L.id) AS num
FROM
	`parent` P
GROUP BY
	P.name
ORDER BY
	num DESC;

-- 1.в.
SELECT
	P.*
FROM
	`parent` P
	LEFT JOIN `leaf` L ON L.parent_id = P.id
WHERE
	L.alias IS NULL OR LENGTH(L.alias) > 5;

ALTER TABLE leaf ADD INDEX fast(`parent_id`,`alias`);

-- 2.
ALTER TABLE leaf ADD INDEX fast1(`parent_id`);
ALTER TABLE leaf ADD INDEX fast2(`alias`,`parent_id`);
