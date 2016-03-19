SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `netflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `netflows`
--

CREATE TABLE IF NOT EXISTS `netflows` (
  `router_id` char(1) NOT NULL,
  `src_ipn` varchar(20) NOT NULL,
  `dst_ipn` varchar(20) NOT NULL,
  `nxt_ipn` bigint(20) unsigned NOT NULL,
  `ifin` smallint(5) unsigned NOT NULL,
  `ifout` smallint(5) unsigned NOT NULL,
  `packets` int(10) unsigned NOT NULL,
  `octets` int(10) unsigned NOT NULL,
  `starttime` varchar(64) NOT NULL,
  `endtime` varchar(64) NOT NULL,
  `srcport` smallint(5) unsigned NOT NULL,
  `dstport` smallint(5) unsigned NOT NULL,
  `tcp` tinyint(3) unsigned NOT NULL,
  `prot` tinyint(3) unsigned NOT NULL,
  `tos` tinyint(3) unsigned NOT NULL,
  `srcas` smallint(5) unsigned NOT NULL,
  `dstas` smallint(5) unsigned NOT NULL,
  `srcmask` tinyint(3) unsigned NOT NULL,
  `dstmask` tinyint(3) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
