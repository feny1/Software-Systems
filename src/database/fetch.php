<?php
$db = new SQLite3('../database/database.db');
function fetchAllUsers()
{
    global $db;
    $result = $db->query('SELECT * FROM users');
    $users = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $users[] = $row;
    }
    return $users;
}

function custom_password_verify($pass, $hash)
{
    return $pass === $hash;
}

function login($email, $password)
{
    global $db;
    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);

        $result = $stmt->execute();
        $user = $result->fetchArray(SQLITE3_ASSOC);

        if ($user && custom_password_verify($password, $user['password'])) {
            return $user;
        } else {
            throw new Exception("Invalid email or password.");
        }
    } catch (Exception $e) {
        return ["error" => $e->getMessage()];
    }
}

function fetchAllLanguages()
{
    global $db;
    $result = $db->query('SELECT * FROM languages');
    $languages = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $languages[] = $row;
    }
    return $languages;
}

function fetchAllSkills()
{
    global $db;
    $result = $db->query('SELECT * FROM skills');
    $skills = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $skills[] = $row;
    }
    return $skills;
}

function fetchAllEducation()
{
    global $db;
    $result = $db->query('SELECT * FROM education');
    $education = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $education[] = $row;
    }
    return $education;
}

function fetchAllExperience()
{
    global $db;
    $result = $db->query('SELECT * FROM experience');
    $experience = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $experience[] = $row;
    }
    return $experience;
}
function fetchAllExperienceByUserID($id)
{
    global $db;
    $result = $db->query("SELECT * FROM experience where user_id = $id");
    $experience = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $experience[] = $row;
    }
    return $experience;
}
function fetchAllExperienceNameByUserID($id)
{
    global $db;
    $result = $db->query("SELECT name FROM experience where user_id = $id");
    $experience = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $experience[] = $row['name'];
    }
    return $experience;
}
function fetchAllSkillsByUserID($id)
{
    global $db;
    $result = $db->query("SELECT * FROM skills where user_id = $id");
    $experience = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $experience[] = $row;
    }
    return $experience;
}
function fetchAllSkillsNameByUserID($id)
{
    global $db;
    $result = $db->query("SELECT name FROM skills where user_id = $id");
    $experience = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $experience[] = $row['name'];
    }
    return $experience;
}

function fetchAllCertificates()
{
    global $db;
    $result = $db->query('SELECT * FROM certificates');
    $certificates = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $certificates[] = $row;
    }
    return $certificates;
}

function fetchAllCompanies()
{
    global $db;
    $result = $db->query('SELECT * FROM company');
    $companies = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $companies[] = $row;
    }
    return $companies;
}

function fetchAllJobs()
{
    global $db;
    $result = $db->query('SELECT * FROM jobs');
    $jobs = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $jobs[] = $row;
    }
    return $jobs;
}

function fetchAllEmployees()
{
    global $db;
    $result = $db->query('SELECT * FROM employees');
    $employees = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $employees[] = $row;
    }
    return $employees;
}
function fetchAllEmployeesByJobID()
{
    global $db;
    $result = $db->query('SELECT * FROM employees');
    $employees = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $employees[] = $row;
    }
    return $employees;
}
function fetchAllEmployeesByCompanyID($id)
{
    if ($id === '') {

        $result = [
            "emplyees" => [],
            "success" => "wrong id"
        ];
        return $result;
    }
    global $db;
    $result = $db->query("SELECT employees.*, users.name AS user_name, users.email, jobs.*, company.name AS company_name 
FROM employees
JOIN users ON employees.user_id = users.id
JOIN jobs ON employees.job_id = jobs.job_id
JOIN company ON jobs.company_id = company.company_id
WHERE company.company_id = $id;
");
    $employees = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $employees[] = $row;
    }
    $result = [
        "emplyees" => $employees,
        "success" => isset($employees[0]) ? "data fetched successfuly" : "wrong id"
    ];
    return $result;
}
