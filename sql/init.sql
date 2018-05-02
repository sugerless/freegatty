SET FOREIGN_KEY_CHECKS=0;
use freegatty;
-- ----------------------------
-- Table structure for freegatty_grade_record
-- ----------------------------
DROP TABLE IF EXISTS freegatty_grade_record;
CREATE TABLE freegatty_grade_record (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `swuid` varchar(16) NOT NULL,
  `academic_year` smallint(5) NOT NULL COMMENT '学年',
  `term` tinyint(3) NOT NULL COMMENT '学期',
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
INSERT INTO freegatty_grade_record VALUES (1,'222015321210005',60,'高等数学上',2017,1,2.0,3.0,'2018-01-01','2018-02-02');


-- ----------------------------
-- Table structure for freegatty_schedule
-- ----------------------------
DROP TABLE IF EXISTS freegatty_schedule;
CREATE TABLE freegatty_schedule (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `academic_year` smallint(5) NOT NULL,
  `term` tinyint(3) NOT NULL ,
  `lesson_id` varchar(16) NOT NULL,
  `lesson_name` varchar(32) NOT NULL,
  `teacher` varchar(32) NOT NULL,
  `start_time` varchar(32) NOT NULL,
  `end_time` varchar(32) NOT NULL,
  `day` varchar(32) NOT NULL,
  `capmus` varchar(32) NOT NULL,
  `classroom` varchar(32) NOT NULL,
  `capmus` varchar(32) NOT NULL,
  `week_time` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of freegatty_schedule
-- ----------------------------



-- ----------------------------
-- Table structure for freegatty_elective
-- ----------------------------
DROP TABLE IF EXISTS freegatty_elective;
CREATE TABLE freegatty_elective (
  `student_id` varchar(16) not null,
  `lesson_id` int not null,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`student_id`,`lesson_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
