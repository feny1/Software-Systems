<?php
// sample_data.php

// 1. Insert sample users
$userCount = $db->querySingle("SELECT COUNT(*) FROM users");
if ($userCount == 0) {
$db->exec("INSERT OR IGNORE INTO users (name, email, password, bio, type, linkedin, phone) VALUES
  ('Ahmed Ali', 'ahmed@example.com', 'password123', 'Software Developer with 5 years experience.', 0, 'https://www.linkedin.com/in/ahmedali', '1234567890'),
  ('Sara Hussein', 'sara@example.com', 'password123', 'HR Specialist with a passion for recruitment.', 0, 'https://www.linkedin.com/in/sarahussein', '0987654321'),
  ('Company Owner', 'owner@company.com', 'password123', 'Entrepreneur and owner of Sample Company.', 1, 'https://www.linkedin.com/in/companyowner', '1112223334')");

// Retrieve user IDs for later use
$ahmedId = $db->querySingle("SELECT id FROM users WHERE email = 'ahmed@example.com'");
$saraId  = $db->querySingle("SELECT id FROM users WHERE email = 'sara@example.com'");
$ownerId = $db->querySingle("SELECT id FROM users WHERE email = 'owner@company.com'");

// 2. Insert sample languages
$db->exec("INSERT OR IGNORE INTO languages (name) VALUES 
  ('English'), 
  ('Arabic')");

// 3. Insert sample skills
$db->exec("INSERT OR IGNORE INTO skills (user_id, name, soft) VALUES 
  ($ahmedId, 'PHP', 1),
  ($ahmedId, 'JavaScript', 1),
  ($saraId, 'Recruitment', 1)");

// 4. Insert sample education
$db->exec("INSERT OR IGNORE INTO education (user_id, name, start, end) VALUES 
  ($ahmedId, 'Bachelor of Computer Science', '2010-09-01', '2014-06-30'),
  ($saraId, 'Bachelor of Business Administration', '2008-09-01', '2012-06-30')");

// 5. Insert sample experience
$db->exec("INSERT OR IGNORE INTO experience (user_id, name, description, company, years, start) VALUES 
  ($ahmedId, 'Junior Developer', 'Worked on internal projects at Tech Corp.', 'Tech Corp', 2, '2014-07-01'),
  ($ahmedId, 'Senior Developer', 'Led a team of developers at Innovatech.', 'Innovatech', 3, '2016-08-01'),
  ($saraId, 'HR Assistant', 'Assisted with recruitment and employee onboarding at People Inc.', 'People Inc', 1, '2012-07-01')");

// 6. Insert sample certificates
$db->exec("INSERT OR IGNORE INTO certificates (user_id, name, description, company) VALUES 
  ($ahmedId, 'PHP Certification', 'Certified PHP Developer by Zend.', 'Zend'),
  ($saraId, 'HR Certification', 'Certified HR Professional by HRCI.', 'HRCI')");

// 7. Insert sample company
$db->exec("INSERT OR IGNORE INTO company (owner_id, hr_id, name, location, email, linkedin, phone, bio) VALUES 
  ($ownerId, $saraId, 'Sample Company', 'Riyadh', 'contact@samplecompany.com', 'https://www.linkedin.com/company/samplecompany', '555666777', 'We are a sample company providing innovative solutions.')");

// Retrieve the company_id
$companyId = $db->querySingle("SELECT company_id FROM company WHERE name = 'Sample Company'");

// 8. Insert sample jobs for the company with start and end dates
$db->exec("INSERT OR IGNORE INTO jobs (company_id, name, description, salary, language_id, type, start, end) VALUES 
  ($companyId, 'Web Developer', 'Develop and maintain web applications.', 5000, 1, 0, '2023-01-01', '2023-12-31'),
  ($companyId, 'Project Manager', 'Manage project timelines and deliverables.', 7000, 1, 0, '2023-02-01', NULL)");

// 9. Insert sample applications (job applications)
$db->exec("INSERT OR IGNORE INTO applications (job_id, user_id, status) VALUES 
  (1, $ahmedId, 'pending'),
  (2, $ahmedId, 'accepted')");

// 10. Insert sample employees (ex employees or current employees)
$db->exec("INSERT OR IGNORE INTO employees (user_id, job_id, start, end) VALUES 
  ($ahmedId, 1, '2020-01-01', '2021-12-31'),
  ($saraId, 2, '2020-06-01', NULL)");

  }
?>

