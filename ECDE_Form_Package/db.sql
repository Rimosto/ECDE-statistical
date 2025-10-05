-- db.sql - create database and tables for ECDE form
CREATE DATABASE IF NOT EXISTS ecde_forms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ecde_forms;

CREATE TABLE IF NOT EXISTS submissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  school_name VARCHAR(255),
  ward VARCHAR(255),
  sub_county VARCHAR(255),
  sponsor_name VARCHAR(255),
  registration_no VARCHAR(100),
  fee_per_term DECIMAL(10,2) NULL,
  email VARCHAR(255),
  tel_no VARCHAR(50),
  date_of_entry DATE,
  pp1_boys INT DEFAULT 0,
  pp1_girls INT DEFAULT 0,
  pp1_streams INT DEFAULT 0,
  pp2_boys INT DEFAULT 0,
  pp2_girls INT DEFAULT 0,
  pp2_streams INT DEFAULT 0,
  total_boys INT DEFAULT 0,
  total_girls INT DEFAULT 0,
  total_learners INT DEFAULT 0,
  below_4 INT DEFAULT 0,
  age_4_5 INT DEFAULT 0,
  age_5_6 INT DEFAULT 0,
  above_7 INT DEFAULT 0,
  feeding_funding_source VARCHAR(255),
  feeding_sponsor VARCHAR(255),
  feeding_type VARCHAR(255),
  class_perm INT DEFAULT 0,
  class_semi INT DEFAULT 0,
  class_total INT DEFAULT 0,
  toilet_perm INT DEFAULT 0,
  toilet_semi INT DEFAULT 0,
  toilet_total INT DEFAULT 0,
  kitchen_perm INT DEFAULT 0,
  kitchen_semi INT DEFAULT 0,
  kitchen_total INT DEFAULT 0,
  admin_perm INT DEFAULT 0,
  admin_semi INT DEFAULT 0,
  admin_total INT DEFAULT 0,
  swing_count INT DEFAULT 0,
  seesaw_count INT DEFAULT 0,
  slide_count INT DEFAULT 0,
  merrygo_count INT DEFAULT 0,
  other_equipment TEXT,
  general_remarks TEXT,
  headteacher_name VARCHAR(255),
  signature_file VARCHAR(255),
  school_stamp_file VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS sne_learners (
  id INT AUTO_INCREMENT PRIMARY KEY,
  submission_id INT NOT NULL,
  class_name VARCHAR(50),
  gender VARCHAR(10),
  visual_impairment INT DEFAULT 0,
  hearing_impairment INT DEFAULT 0,
  physical_handicap INT DEFAULT 0,
  mental_handicap INT DEFAULT 0,
  others INT DEFAULT 0,
  FOREIGN KEY (submission_id) REFERENCES submissions(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS teachers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  submission_id INT NOT NULL,
  s_no INT,
  teacher_name VARCHAR(255),
  tsc_no VARCHAR(100),
  gender VARCHAR(10),
  degree BOOLEAN DEFAULT FALSE,
  diploma BOOLEAN DEFAULT FALSE,
  certificate BOOLEAN DEFAULT FALSE,
  remarks VARCHAR(500),
  FOREIGN KEY (submission_id) REFERENCES submissions(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS non_teaching_staff (
  id INT AUTO_INCREMENT PRIMARY KEY,
  submission_id INT NOT NULL,
  s_no INT,
  name VARCHAR(255),
  duties VARCHAR(255),
  FOREIGN KEY (submission_id) REFERENCES submissions(id) ON DELETE CASCADE
);
