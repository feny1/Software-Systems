<?php
$db = new SQLite3('../database/database.db');

// Create tables with foreign key constraints
$db->exec('CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY, 
    name TEXT, 
    email TEXT UNIQUE, 
    password TEXT, 
    bio TEXT,
    type BOOLEAN,
    linkedin TEXT,
    phone TEXT
)');

$db->exec('CREATE TABLE IF NOT EXISTS languages (
    language_id INTEGER PRIMARY KEY, 
    name TEXT
)');

$db->exec('CREATE TABLE IF NOT EXISTS skills (
    skill_id INTEGER PRIMARY KEY, 
    user_id INTEGER,
    name TEXT,
    soft INTEGER,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)');

$db->exec('CREATE TABLE IF NOT EXISTS education (
    education_id INTEGER PRIMARY KEY, 
    user_id INTEGER,
    name TEXT,
    start DATE,
    end DATE NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)');

$db->exec('CREATE TABLE IF NOT EXISTS experience (
    experience_id INTEGER PRIMARY KEY, 
    user_id INTEGER,
    name TEXT,
    description TEXT,
    company TEXT,
    years INTEGER,
    start DATE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)');

$db->exec('CREATE TABLE IF NOT EXISTS certificates (
    certificate_id INTEGER PRIMARY KEY, 
    user_id INTEGER,
    name TEXT,
    description TEXT,
    company TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)');

$db->exec('CREATE TABLE IF NOT EXISTS company (
    company_id INTEGER PRIMARY KEY, 
    owner_id INTEGER,
    hr_id INTEGER,
    name TEXT,
    location TEXT,
    bio TEXT,
    FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (hr_id) REFERENCES users(id) ON DELETE CASCADE
)');

$db->exec('CREATE TABLE IF NOT EXISTS jobs (
    job_id INTEGER PRIMARY KEY, 
    company_id INTEGER,
    name TEXT,
    description TEXT,
    salary INTEGER,
    language_id INTEGER,
    type BOOLEAN,
    FOREIGN KEY (company_id) REFERENCES company(company_id) ON DELETE CASCADE,
    FOREIGN KEY (language_id) REFERENCES languages(language_id) ON DELETE CASCADE
)');

$db->exec('CREATE TABLE IF NOT EXISTS applications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    job_id INTEGER,
    user_id INTEGER,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)');


$db->exec('CREATE TABLE IF NOT EXISTS employees (
    employee_id INTEGER PRIMARY KEY, 
    user_id INTEGER,
    job_id INTEGER,
    start DATE,
    end DATE NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE
)');
