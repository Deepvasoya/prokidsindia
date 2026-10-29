-- Video assessment questions (one video -> many questions).
-- Run once on each database (local + live) before using the feature.

CREATE TABLE IF NOT EXISTS `video_assessment_questions` (
  `id`                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `video_id`            INT NOT NULL,
  `admin_id`            INT NOT NULL,
  `added_by`            INT NOT NULL,
  `question_type`       VARCHAR(10) NOT NULL DEFAULT 'mcq'  COMMENT 'mcq | fill',
  `question_text`       TEXT NULL,
  `question_media_type` VARCHAR(10) NOT NULL DEFAULT 'none' COMMENT 'none | image | audio | video',
  `question_media`      VARCHAR(255) NULL                   COMMENT 'path under uploads/video_assessment/',
  `option_type`         VARCHAR(10) NOT NULL DEFAULT 'text' COMMENT 'mcq only: text | image | audio | video',
  `options`             TEXT NULL                           COMMENT 'mcq only: JSON [{"text":"","media":""}, ...]',
  `correct_option`      TINYINT NULL                        COMMENT 'mcq only: 0-based index into options',
  `answers`             TEXT NULL                           COMMENT 'fill only: JSON list of accepted answers',
  `marks`               DECIMAL(6,2) NOT NULL DEFAULT 1.00,
  `show_at_seconds`     INT NULL                            COMMENT 'optional: pause video and show at this second',
  `sort_order`          INT NOT NULL DEFAULT 0,
  `status`              TINYINT NOT NULL DEFAULT 1,
  `created_at`          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`          DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_video` (`video_id`, `status`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- One row per finished attempt by a student.
CREATE TABLE IF NOT EXISTS `video_assessment_attempts` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `video_id`       INT NOT NULL,
  `student_id`     INT NOT NULL,
  `score`          DECIMAL(8,2) NOT NULL DEFAULT 0,
  `total_marks`    DECIMAL(8,2) NOT NULL DEFAULT 0,
  `correct_count`  INT NOT NULL DEFAULT 0,
  `question_count` INT NOT NULL DEFAULT 0,
  `answers`        TEXT NULL COMMENT 'JSON {question_id: {"answer":..,"correct":0|1}}',
  `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_student_video` (`student_id`, `video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
