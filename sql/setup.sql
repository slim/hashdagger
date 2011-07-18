-- 
-- Structure de la table `canvass`
-- 

CREATE TABLE `canvass` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) default NULL,
  `volunteer_id` varchar(50) default NULL,
  `person_id` varchar(50) default NULL,
  `place_id` varchar(50) default NULL,
  `begin` datetime default NULL,
  `end` datetime default NULL,
  `opened_door` datetime default NULL,
  `answered_questions` datetime default NULL,
  `address_region` varchar(50) default NULL,
  `address_district` varchar(50) default NULL,
  `address_street` varchar(50) default NULL,
  `address_building` varchar(5) default NULL,
  `address_level` varchar(5) default NULL,
  `address_house` varchar(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

-- --------------------------------------------------------

-- 
-- Structure de la table `person`
-- 

CREATE TABLE `person` (
  `id` varchar(50) NOT NULL,
  `name` varchar(50) default NULL,
  `age` int(11) default NULL,
  `phone` varchar(50) default NULL,
  `mail` varchar(50) default NULL,
  `place_id` varchar(50) default NULL,
  `will_vote` datetime default NULL,
  `for_party` datetime default NULL,
  `for_independent` datetime default NULL,
  `opinion` varchar(150) default NULL,
  `is_supporter` datetime default NULL,
  `is_volunteer` datetime default NULL,
  `note` varchar(150) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;