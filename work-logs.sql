/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50719
Source Host           : 127.0.0.1:3306
Source Database       : work-logs

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2020-08-12 21:40:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for work_department
-- ----------------------------
DROP TABLE IF EXISTS `work_department`;
CREATE TABLE `work_department` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dep` varchar(32) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_dep` (`dep`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_department
-- ----------------------------
INSERT INTO `work_department` VALUES ('1', '研发中心', '1', '0', '0');

-- ----------------------------
-- Table structure for work_logs
-- ----------------------------
DROP TABLE IF EXISTS `work_logs`;
CREATE TABLE `work_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dep_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL,
  `work_content` varchar(255) NOT NULL,
  `finished` tinyint(1) NOT NULL DEFAULT '2' COMMENT '0未开始 1进行中 2已完成',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:软删除 1:正常',
  `notes` varchar(255) NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_uid` (`uid`) USING BTREE,
  KEY `index_create_time` (`create_time`) USING BTREE,
  KEY `index_dep_id` (`dep_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_logs
-- ----------------------------
INSERT INTO `work_logs` VALUES ('1', '1', '1', '修改短信为新版（模板模式）', '2', '1', '0', '1581327000', '0');
INSERT INTO `work_logs` VALUES ('2', '1', '2', '测试商城店中店bug', '2', '1', '中途断线四五次，反应有点延迟。', '1581327000', '0');
INSERT INTO `work_logs` VALUES ('3', '1', '3', '商城上线部署', '2', '1', '远程网络不稳定', '1581327000', '0');
INSERT INTO `work_logs` VALUES ('4', '1', '4', '1.报表存储查询优化\r\n2.数据库表进行注释说明', '2', '1', '0', '1581327000', '0');
INSERT INTO `work_logs` VALUES ('5', '1', '5', '微信企业号相关的学习探索 ', '2', '1', 'VPN不稳定，会有断线', '1581327000', '0');
INSERT INTO `work_logs` VALUES ('6', '1', '6', '测试商城店中店bug', '2', '1', '0', '1581327000', '0');
INSERT INTO `work_logs` VALUES ('7', '1', '7', '修改短信为新版（模板模式）药房系统中材料品种页面', '2', '1', '0', '1581327000', '0');
INSERT INTO `work_logs` VALUES ('8', '1', '8', '1、处理线上录档事务\r\n2、整理CRM需求\r\n3、交接公众号事务', '2', '1', '0', '1581327000', '0');
INSERT INTO `work_logs` VALUES ('9', '1', '1', '短信后端测试', '2', '1', '0', '1581413400', '0');
INSERT INTO `work_logs` VALUES ('10', '1', '2', '超级管理员修改密码bug处理，线上商城测试', '2', '1', 'bug已修复，测试正在进行。', '1581413400', '0');
INSERT INTO `work_logs` VALUES ('11', '1', '3', '小程序商城上线', '2', '1', '等待审核', '1581413400', '0');
INSERT INTO `work_logs` VALUES ('12', '1', '4', '1.修正业绩表中不能查询当天业绩\r\n2.添加顾客最后一次上门时间同步表', '2', '1', '0', '1581413400', '0');
INSERT INTO `work_logs` VALUES ('13', '1', '5', '微信商城问题处理', '2', '1', '0', '1581413400', '0');
INSERT INTO `work_logs` VALUES ('14', '1', '6', '测试商城店中店bug', '2', '1', '0', '1581413400', '0');
INSERT INTO `work_logs` VALUES ('15', '1', '8', '1、协调处理微信商城无法使用问题\r\n2、处理小程序配置错误问题\r\n3、协调处理微信公众号对接微信商城事务', '2', '1', '1、已完成\r\n2、进行中\r\n3、已完成', '1581413400', '0');
INSERT INTO `work_logs` VALUES ('16', '1', '7', '短信前端配合测试', '2', '1', '网络不好', '1581413400', '0');
INSERT INTO `work_logs` VALUES ('17', '1', '9', '1、短信接口接入编写\r\n2、沟通与协调', '2', '1', '１、完成\r\n２、持续进行', '1581413400', '0');
INSERT INTO `work_logs` VALUES ('18', '1', '9', '111', '1', '1', '2222', '1581513760', '0');
INSERT INTO `work_logs` VALUES ('19', '1', '5', '微信企业号相关的学习探索', '1', '1', '<br>', '1581494469', '1581512757');
INSERT INTO `work_logs` VALUES ('20', '1', '6', '测试商城店中店bug', '1', '1', '0', '1581513006', '0');
INSERT INTO `work_logs` VALUES ('21', '1', '1', '更新后端短信', '2', '1', '0', '1581513247', '0');
INSERT INTO `work_logs` VALUES ('22', '1', '2', '商城店中店测试，编写后台管理的操作手册。', '2', '1', '0', '1581513389', '0');
INSERT INTO `work_logs` VALUES ('23', '1', '3', '小程序商城上线', '2', '1', '上线后的调试', '1581513507', '0');
INSERT INTO `work_logs` VALUES ('24', '1', '4', '1.整理以前写的存储，把现在没用到的作标记后期删掉<br>2.添加同步表统计每个顾客的消费总额', '1', '1', '完成80%', '1581513603', '0');
INSERT INTO `work_logs` VALUES ('25', '1', '7', '更新前端端短信', '2', '1', '0', '1581513668', '0');
INSERT INTO `work_logs` VALUES ('26', '1', '8', '1、调整微信商城相关设置并交付后台给到运营人员<br>2、整理微信商城报表相关模版', '2', '1', '0', '1581513760', '0');
INSERT INTO `work_logs` VALUES ('27', '1', '5', '工作记录线上程序化', '2', '1', '测试使用', '1581582427', '1581583011');

-- ----------------------------
-- Table structure for work_user
-- ----------------------------
DROP TABLE IF EXISTS `work_user`;
CREATE TABLE `work_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dep_id` int(10) NOT NULL,
  `station` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` char(32) NOT NULL DEFAULT '0',
  `is_manger` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0黑单 1正常',
  `last_login_ip` char(20) NOT NULL DEFAULT '0',
  `last_login_time` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_dep_id` (`dep_id`) USING BTREE,
  KEY `index_user` (`name`) USING BTREE,
  KEY `index_create_time` (`create_time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_user
-- ----------------------------
INSERT INTO `work_user` VALUES ('1', '1', 'java', '张超', 'a00f1c5428215d0d66458440d62fd9aa', '0', '1', '127.0.0.1', '1581513208', '0', '0');
INSERT INTO `work_user` VALUES ('2', '1', 'java', '李成', 'a00f1c5428215d0d66458440d62fd9aa', '0', '1', '127.0.0.1', '1581513366', '0', '0');
INSERT INTO `work_user` VALUES ('3', '1', '架构师', '谢斌', 'a00f1c5428215d0d66458440d62fd9aa', '0', '1', '127.0.0.1', '1581513473', '0', '0');
INSERT INTO `work_user` VALUES ('4', '1', '数据报表', '张杰', 'a00f1c5428215d0d66458440d62fd9aa', '0', '1', '127.0.0.1', '1581513576', '0', '0');
INSERT INTO `work_user` VALUES ('5', '1', 'php', '高远山', 'a00f1c5428215d0d66458440d62fd9aa', '1', '1', '127.0.0.1', '1597238077', '0', '0');
INSERT INTO `work_user` VALUES ('6', '1', '前端', '刘沛杰', 'a00f1c5428215d0d66458440d62fd9aa', '0', '1', '127.0.0.1', '1581513845', '0', '0');
INSERT INTO `work_user` VALUES ('7', '1', '前端', '胡坤', 'a00f1c5428215d0d66458440d62fd9aa', '0', '1', '127.0.0.1', '1581513910', '0', '0');
INSERT INTO `work_user` VALUES ('8', '1', '产品', '赵泽', 'a00f1c5428215d0d66458440d62fd9aa', '0', '1', '127.0.0.1', '1581513701', '0', '0');
INSERT INTO `work_user` VALUES ('9', '1', '经理', '鲁达', 'a00f1c5428215d0d66458440d62fd9aa', '1', '1', '127.0.0.1', '1581513990', '0', '0');
INSERT INTO `work_user` VALUES ('10', '1', '总监', '刘石头', 'a00f1c5428215d0d66458440d62fd9aa', '1', '1', '0', '0', '0', '0');
