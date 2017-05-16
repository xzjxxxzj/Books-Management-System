/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : crt

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-05-15 21:52:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `crt_admin_group`
-- ----------------------------
DROP TABLE IF EXISTS `crt_admin_group`;
CREATE TABLE `crt_admin_group` (
  `groupid` int(10) NOT NULL,
  `groupname` varchar(20) DEFAULT NULL,
  `createtime` int(10) DEFAULT NULL,
  `updatetime` int(10) DEFAULT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of crt_admin_group
-- ----------------------------
INSERT INTO `crt_admin_group` VALUES ('1', '管理员', '1494658395', '1494658395');

-- ----------------------------
-- Table structure for `crt_admin_jurisdiction`
-- ----------------------------
DROP TABLE IF EXISTS `crt_admin_jurisdiction`;
CREATE TABLE `crt_admin_jurisdiction` (
  `uid` int(11) NOT NULL,
  `jurisdiction` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of crt_admin_jurisdiction
-- ----------------------------

-- ----------------------------
-- Table structure for `crt_admin_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `crt_admin_login_log`;
CREATE TABLE `crt_admin_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `loginip` char(20) DEFAULT NULL,
  `time` int(10) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of crt_admin_login_log
-- ----------------------------
INSERT INTO `crt_admin_login_log` VALUES ('1', '1', '127.0.0.1', '1494149865', '0');
INSERT INTO `crt_admin_login_log` VALUES ('2', '1', '127.0.0.1', '1494150212', '0');
INSERT INTO `crt_admin_login_log` VALUES ('3', '1', '127.0.0.1', '1494150251', '0');
INSERT INTO `crt_admin_login_log` VALUES ('4', '1', '127.0.0.1', '1494150287', '0');
INSERT INTO `crt_admin_login_log` VALUES ('5', '1', '127.0.0.1', '1494150296', '0');
INSERT INTO `crt_admin_login_log` VALUES ('6', '1', '127.0.0.1', '1494150303', '1');
INSERT INTO `crt_admin_login_log` VALUES ('7', '1', '127.0.0.1', '1494158597', '0');
INSERT INTO `crt_admin_login_log` VALUES ('8', '1', '127.0.0.1', '1494158652', '0');
INSERT INTO `crt_admin_login_log` VALUES ('9', '1', '127.0.0.1', '1494158668', '0');
INSERT INTO `crt_admin_login_log` VALUES ('10', '1', '127.0.0.1', '1494158741', '0');
INSERT INTO `crt_admin_login_log` VALUES ('11', '1', '127.0.0.1', '1494159296', '0');
INSERT INTO `crt_admin_login_log` VALUES ('12', '1', '127.0.0.1', '1494159331', '0');
INSERT INTO `crt_admin_login_log` VALUES ('13', '1', '127.0.0.1', '1494159361', '0');
INSERT INTO `crt_admin_login_log` VALUES ('14', '1', '127.0.0.1', '1494159387', '0');
INSERT INTO `crt_admin_login_log` VALUES ('15', '1', '127.0.0.1', '1494159572', '0');
INSERT INTO `crt_admin_login_log` VALUES ('16', '1', '127.0.0.1', '1494159633', '0');
INSERT INTO `crt_admin_login_log` VALUES ('17', '1', '127.0.0.1', '1494159655', '0');
INSERT INTO `crt_admin_login_log` VALUES ('18', '1', '127.0.0.1', '1494159667', '0');
INSERT INTO `crt_admin_login_log` VALUES ('19', '1', '127.0.0.1', '1494159752', '0');
INSERT INTO `crt_admin_login_log` VALUES ('20', '1', '127.0.0.1', '1494159808', '0');
INSERT INTO `crt_admin_login_log` VALUES ('21', '1', '127.0.0.1', '1494159829', '0');
INSERT INTO `crt_admin_login_log` VALUES ('22', '1', '127.0.0.1', '1494159946', '0');
INSERT INTO `crt_admin_login_log` VALUES ('23', '1', '127.0.0.1', '1494159998', '0');
INSERT INTO `crt_admin_login_log` VALUES ('24', '1', '127.0.0.1', '1494160059', '0');
INSERT INTO `crt_admin_login_log` VALUES ('25', '1', '127.0.0.1', '1494160120', '0');
INSERT INTO `crt_admin_login_log` VALUES ('26', '1', '127.0.0.1', '1494160148', '0');
INSERT INTO `crt_admin_login_log` VALUES ('27', '1', '127.0.0.1', '1494160162', '1');
INSERT INTO `crt_admin_login_log` VALUES ('28', '1', '127.0.0.1', '1494160439', '0');
INSERT INTO `crt_admin_login_log` VALUES ('29', '1', '127.0.0.1', '1494160533', '1');
INSERT INTO `crt_admin_login_log` VALUES ('30', '1', '127.0.0.1', '1494654614', '0');
INSERT INTO `crt_admin_login_log` VALUES ('31', '1', '127.0.0.1', '1494654623', '1');
INSERT INTO `crt_admin_login_log` VALUES ('32', '1', '127.0.0.1', '1494674921', '1');
INSERT INTO `crt_admin_login_log` VALUES ('33', '1', '127.0.0.1', '1494742167', '1');
INSERT INTO `crt_admin_login_log` VALUES ('34', '1', '127.0.0.1', '1494747839', '0');
INSERT INTO `crt_admin_login_log` VALUES ('35', '1', '127.0.0.1', '1494747881', '0');
INSERT INTO `crt_admin_login_log` VALUES ('36', '1', '127.0.0.1', '1494752435', '1');

-- ----------------------------
-- Table structure for `crt_admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `crt_admin_menu`;
CREATE TABLE `crt_admin_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `show` int(1) DEFAULT NULL,
  `parentid` int(11) DEFAULT '0',
  `sort` int(3) DEFAULT NULL,
  `createtime` int(10) DEFAULT NULL,
  `updatetime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of crt_admin_menu
-- ----------------------------

-- ----------------------------
-- Table structure for `crt_admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `crt_admin_user`;
CREATE TABLE `crt_admin_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `passcode` char(6) DEFAULT NULL,
  `status` int(1) DEFAULT NULL COMMENT '账号状态 0为正常 1为停用',
  `errornum` int(3) DEFAULT NULL,
  `createtime` int(10) DEFAULT NULL,
  `updatetime` int(10) DEFAULT NULL,
  `group` int(1) DEFAULT NULL,
  `groupleader` int(1) DEFAULT NULL COMMENT '是否是组长  1是组长',
  `lastloginip` char(20) DEFAULT NULL,
  `lastlogintime` int(10) DEFAULT NULL,
  `limitip` varchar(200) DEFAULT NULL COMMENT '限制登录IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of crt_admin_user
-- ----------------------------
INSERT INTO `crt_admin_user` VALUES ('1', 'admin', '20b30909aa02607b300ed8a602927345', 'Vs3i1a', null, '0', '1494075692', '1494752435', '1', null, '127.0.0.1', '1494752435', null);

-- ----------------------------
-- Table structure for `crt_book_list`
-- ----------------------------
DROP TABLE IF EXISTS `crt_book_list`;
CREATE TABLE `crt_book_list` (
  `bookid` bigint(15) NOT NULL COMMENT '书籍ID',
  `bookname` varchar(60) DEFAULT NULL COMMENT '书籍名称',
  `shopid` int(10) DEFAULT NULL COMMENT '店面ID',
  `money` decimal(6,1) DEFAULT NULL COMMENT '书籍价格',
  `num` int(10) DEFAULT NULL COMMENT '总数',
  `outnum` int(10) DEFAULT NULL COMMENT '借出总数',
  `leftnum` int(10) DEFAULT NULL COMMENT '剩余可借总数',
  `lose` int(10) DEFAULT NULL COMMENT '丢失总数',
  `spoil` int(10) DEFAULT NULL COMMENT '损坏总数',
  `image` varchar(50) DEFAULT NULL COMMENT '封面图片路径',
  `status` int(1) DEFAULT NULL COMMENT '状态 0 未上架 1已上架 ',
  `createtime` int(10) DEFAULT NULL COMMENT '录入时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`bookid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of crt_book_list
-- ----------------------------
