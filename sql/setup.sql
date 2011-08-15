CREATE TABLE IF NOT EXISTS `canvass` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `volunteer_id` varchar(50) DEFAULT NULL,
  `person_id` varchar(50) DEFAULT NULL,
  `place_id` varchar(50) DEFAULT NULL,
  `begin` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `opened_door` datetime DEFAULT NULL,
  `answered_questions` datetime DEFAULT NULL,
  `address_region` varchar(50) DEFAULT NULL,
  `address_district` varchar(50) DEFAULT NULL,
  `address_street` varchar(50) DEFAULT NULL,
  `address_building` varchar(5) DEFAULT NULL,
  `address_level` varchar(5) DEFAULT NULL,
  `address_house` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- --------------------------------------------------------

--
-- Structure de la table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_user` datetime DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `phone_signature` varchar(50) NOT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `mail_signature` varchar(50) NOT NULL,
  `will_vote` datetime DEFAULT NULL,
  `for_party` datetime DEFAULT NULL,
  `for_independent` datetime DEFAULT NULL,
  `opinion` varchar(150) DEFAULT NULL,
  `is_supporter` datetime DEFAULT NULL,
  `is_volunteer` datetime DEFAULT NULL,
  `note` varchar(150) DEFAULT NULL,
  `user_key` varchar(50) NOT NULL,
  `creator_key` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

insert into person (id, name, login, password, is_user, user_key) values (1, "First User", "h", md5('mosta9ella'), now(), aes_encrypt('mefta7', 'mosta9ella'));
