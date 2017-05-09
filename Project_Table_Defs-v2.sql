
--
-- Database: `meetup`
--
CREATE DATABASE IF NOT EXISTS `meetup` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `meetup`;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `firstname` varchar(20) NOT NULL DEFAULT '',
  `lastname` varchar(20) NOT NULL DEFAULT '',
  `zipcode` int(5) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`group_id`),
  FOREIGN KEY (`username`) REFERENCES `member` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `interest`
--

DROP TABLE IF EXISTS `interest`;
CREATE TABLE IF NOT EXISTS `interest` (
  `interest_name` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`interest_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groupinterest`
--

DROP TABLE IF EXISTS `about`;
CREATE TABLE IF NOT EXISTS `about` (
  `interest_name` varchar(20) NOT NULL DEFAULT '',
  `group_id` int(20) NOT NULL,
  PRIMARY KEY (`group_id`,`interest_name`),
  FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`),
  FOREIGN KEY (`interest_name`) REFERENCES `interest` (`interest_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `memberinterest`
--

DROP TABLE IF EXISTS `interested_in`;
CREATE TABLE IF NOT EXISTS `interested_in` (
  `username` varchar(20) NOT NULL DEFAULT '',
  `interest_name` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`username`,`interest_name`),
  FOREIGN KEY (`username`) REFERENCES `member` (`username`),
  FOREIGN KEY (`interest_name`) REFERENCES `interest` (`interest_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `groupuser`
--

DROP TABLE IF EXISTS `belongs_to`;
CREATE TABLE IF NOT EXISTS `belongs_to` (
  `group_id` int(20) NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  `authorized` tinyint(1) NOT NULL,
  PRIMARY KEY (`group_id`,`username`),
  FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`),
  FOREIGN KEY (`username`) REFERENCES `member` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `lname` varchar(20) NOT NULL DEFAULT '',
  `zip` int(5) NOT NULL,
  `street` varchar(50) NOT NULL DEFAULT '',
  `city` varchar(20) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `latitude` bigint(50) NOT NULL,
  `longitude` bigint(50) NOT NULL,
  PRIMARY KEY (`lname`,`zip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `group_id` int(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `zip` int(5) NOT NULL,
  PRIMARY KEY (`event_id`),
  FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`),
  FOREIGN KEY (`lname`, `zip`) REFERENCES `location` (`lname`, `zip`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `eventuser`
--

DROP TABLE IF EXISTS `attend`;
CREATE TABLE IF NOT EXISTS `attend` (
  `event_id` int(20) NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  `rsvp` tinyint(1) NOT NULL,
  `rating` int(1) NOT NULL,
  PRIMARY KEY (`event_id`,`username`),
  FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  FOREIGN KEY (`username`) REFERENCES `member` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
