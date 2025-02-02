<?php
$db = new SQLite3('./database.db');

// Check if there are existing users
$result = $db->query('SELECT COUNT(*) as count FROM users');
$row = $result->fetchArray(SQLITE3_ASSOC);
if ($row['count'] == 0) {
    // Insert sample users
    $db->exec("INSERT INTO users (name, email, password, bio, type, phone) VALUES
        ('John Doe', 'john@example.com', 'hashedpassword1', 'Software Developer', 1, '1234567890'),
        ('Jane Smith', 'jane@example.com', 'hashedpassword2', 'Data Scientist', 0, '0987654321')");

    // Insert sample languages
    $db->exec("INSERT INTO languages (name) VALUES ('English'), ('Spanish'), ('French')");

    // Insert sample skills directly tied to users
    $db->exec("INSERT INTO skills (user_id, name, soft) VALUES
        (1, 'PHP', 0), (1, 'JavaScript', 0), 
        (2, 'Python', 0), (2, 'Machine Learning', 1)");

    // Insert sample education directly tied to users
    $db->exec("INSERT INTO education (user_id, name, start, end) VALUES
        (1, 'BSc Computer Science', '2015-09-01', '2019-06-30'),
        (2, 'MSc Data Science', '2016-09-01', '2020-06-30')");

    // Insert sample experience directly tied to users
    $db->exec("INSERT INTO experience (user_id, name, description, company, years, start) VALUES
        (1, 'Software Engineer', 'Developed scalable web applications', 'Tech Corp', 3, '2019-07-01'),
        (2, 'Data Scientist', 'Built predictive models', 'AI Labs', 2, '2020-08-01')");

    // Insert sample certificates directly tied to users
    $db->exec("INSERT INTO certificates (user_id, name, description, company) VALUES
        (1, 'AWS Certified', 'Cloud Computing Certification', 'Amazon'),
        (2, 'Google Data Analytics', 'Data Analytics Certification', 'Google')");

    // Insert sample companies
    $db->exec("INSERT INTO company (owner_id, hr_id, name, location, bio) VALUES
        (1, 2, 'Tech Corp', 'New York', 'Leading software company'),
        (2, 1, 'AI Labs', 'San Francisco', 'AI and Data Science Experts')");

    // Insert sample jobs
    $db->exec("INSERT INTO jobs (company_id, name, description, salary, language_id, type) VALUES
        (1, 'Full Stack Developer', 'Develop full-stack applications', 70000, 1, 1),
        (2, 'Data Scientist', 'Work on AI projects', 80000, 2, 1)");

    // Insert sample employees
    $db->exec("INSERT INTO employees (user_id, job_id, start) VALUES
        (1, 1, '2021-01-01'), 
        (2, 2, '2022-02-01')");

    echo "Sample data inserted successfully.";
} else {
    echo "Database already contains data. No new records were added.";
}
?>
