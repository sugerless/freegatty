SET FOREIGN_KEY_CHECKS=0;
use freegatty;
-- ----------------------------
-- Table structure for freegatty_grade_record
-- ----------------------------
DROP TABLE IF EXISTS freegatty_grade_record;
CREATE TABLE freegatty_grade_record (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `swuid` varchar(16) NOT NULL,
  `academic_year` smallint(5) NOT NULL COMMENT 'ѧ��',
  `term` tinyint(3) NOT NULL COMMENT 'ѧ��',
  `grade_point` smallint(5) NOT NULL,
  `score` varchar(16) NOT NULL,
  `department` varchar(16) NOT NULL,
  `lesson_name` varchar(16) NOT NULL,
  `exam_type` varchar(16) NOT NULL,
  `teacher` varchar(16) NOT NULL,
  `lesson_type` varchar(16) NOT NULL,
  `credit` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of freegatty_grade_record
-- ----------------------------
INSERT INTO freegatty_grade_record VALUES (1,'222015321210005',60,'�ߵ���ѧ��',2017,1,2.0,3.0,'2018-01-01','2018-02-02');


-- ----------------------------
-- Table structure for freegatty_schedule
-- ----------------------------
DROP TABLE IF EXISTS freegatty_schedule;
CREATE TABLE freegatty_schedule (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `swuid` varchar(16) NOT NULL,
  `academic_year` smallint(5) NOT NULL,
  `term` tinyint(3) NOT NULL ,
  `lesson_id` varchar(16) NOT NULL,
  `lesson_name` varchar(32) NOT NULL,
  `teacher` varchar(32) NOT NULL,
  `academic_title` varchar(32) NOT NULL,
  `start_time` tinyint(3) NOT NULL,
  `end_time` tinyint(3) NOT NULL,
  `week` varchar(32) NOT NULL,
  `capmus` varchar(32) NOT NULL,
  `classroom` varchar(32) NOT NULL,
  `week_time` varchar(64) NOT NULL,
  `DIY` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;




