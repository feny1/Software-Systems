<?php
include('../database/data.php');
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
function getUserById($id)
{
    global $db;

    // Prepare the SQL statement with a parameter placeholder for the id
    $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');

    // Bind the id value to the placeholder. Use SQLITE3_INTEGER if id is an integer.
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

    // Execute the statement
    $result = $stmt->execute();

    // Fetch the user data as an associative array
    $user = $result->fetchArray(SQLITE3_ASSOC);

    // Return the user data (or false/null if not found)
    return $user;
}

function getCompanyByOwnerId($id)
{
    global $db;

    // Prepare the SQL statement with a parameter placeholder for the id
    $stmt = $db->prepare('SELECT * FROM companies WHERE owner_id = :id');

    // Bind the id value to the placeholder. Use SQLITE3_INTEGER if id is an integer.
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

    // Execute the statement
    $result = $stmt->execute();

    // Fetch the user data as an associative array
    $company = $result->fetchArray(SQLITE3_ASSOC);

    // Return the user data (or false/null if not found)
    return $company;
}
function getCompanyById($id)
{
    global $db;

    // Prepare the SQL statement with a parameter placeholder for the id
    $stmt = $db->prepare('SELECT * FROM company WHERE company_id = :id');

    // Bind the id value to the placeholder. Use SQLITE3_INTEGER if id is an integer.
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

    // Execute the statement
    $result = $stmt->execute();

    // Fetch the user data as an associative array
    $company = $result->fetchArray(SQLITE3_ASSOC);

    // Return the user data (or false/null if not found)
    return $company;
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
        if(!empty($user))
        $_SESSION['user']['company_id'] = fetchUserCompany($user['id']);

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
    $result = $db->query('SELECT * FROM jobs ORDER BY 1 DESC');
    $jobs = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $jobs[] = $row;
    }
    return $jobs;
}
function fetchAllJobsByType($type)
{
    global $db;
    $result = $db->query("SELECT * FROM jobs where type = $type ORDER BY 1 DESC");
    $jobs = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $jobs[] = $row;
    }
    return $jobs;
}
function fetchAllJobsAsCompany($id)
{
    global $db;
    $result = $db->query("SELECT * FROM jobs where company_id = $id ");
    $jobs = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $jobs[] = $row;
    }
    return $jobs;
}

function fetchAllCompanyJobs($company_id)
{
    global $db;
    
    $company_id = intval($company_id);

    $stmt = $db->prepare('SELECT * FROM jobs WHERE company_id = :company_id');
    $stmt->bindValue(':company_id', $company_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $jobs = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $jobs[] = $row;
    }

    return $jobs;
}


function fetchAllApplicationsForCompany($company_id)
{
    global $db;
    
    $stmt = $db->prepare("
        SELECT applications.id, applications.applied_at, applications.status, 
               users.name AS applicant_name, jobs.name AS job_title, jobs.salary
        FROM applications
        JOIN jobs ON applications.job_id = jobs.job_id
        JOIN users ON applications.user_id = users.id
        WHERE jobs.company_id = :company_id
        ORDER BY applications.applied_at DESC
    ");
    
    $stmt->bindValue(':company_id', $company_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $applications = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $applications[] = $row;
    }

    return $applications;
}

function fetchResponseByUserID($user_id)
{
    global $db;

    $stmt = $db->prepare("
        SELECT applications.id, applications.status, applications.applied_at, 
               jobs.name AS job_title, company.name AS company_name
        FROM applications
        JOIN jobs ON applications.job_id = jobs.job_id
        JOIN company ON jobs.company_id = company.company_id
        WHERE applications.user_id = :user_id
        ORDER BY applications.applied_at DESC
    ");

    $stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $responses = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $responses[] = $row;
    }

    return $responses;
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
function fetchAllEmployeesByJobID($job_id)
{
    if (empty($job_id) || !is_numeric($job_id)) {
        throw new Exception("Invalid job ID!");
    }

    global $db;

    $query = "SELECT employees.*, 
                     users.name AS user_name, 
                     users.email, 
                     users.id AS user_id,
                     jobs.*, 
                     company.name AS company_name 
              FROM employees
              JOIN users ON employees.user_id = users.id
              JOIN jobs ON employees.job_id = jobs.job_id
              JOIN company ON jobs.company_id = company.company_id
              WHERE jobs.job_id = $job_id;";

    $result = $db->query($query);

    $employees = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $employees[] = $row;
    }

    if (empty($employees)) {
        throw new Exception("No employees found for job ID: $job_id.");
    }

    return [
        "employees" => $employees,
        "success"   => "Data fetched successfully"
    ];
}



function fetchAllEmployeesByCompanyID($company_id)
{
    if (empty($company_id) || !is_numeric($company_id)) {
        throw new Exception("Invalid company ID!");
    }

    global $db;

    $query = "SELECT employees.*, 
                     users.name AS user_name, 
                     users.email, 
                     users.id AS user_id, 
                     jobs.*, 
                     company.name AS company_name 
              FROM employees
              JOIN users ON employees.user_id = users.id
              JOIN jobs ON employees.job_id = jobs.job_id
              JOIN company ON jobs.company_id = company.company_id
              WHERE company.company_id = $company_id;";

    $result = $db->query($query);
    $employees = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $employees[] = $row;
    }


    return [
        "employees" => $employees,
        "success"   => "Data fetched successfully"
    ];
}

function fetchUserCompany($id)
{
    global $db;
    $result = $db->query("SELECT * FROM company WHERE owner_id = $id");
    $company = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $company[] = $row;
    }
    $result = [
        "company" => $company,
        "success" => isset($company[0]) ? "data fetched successfuly" : "wrong id"
    ];
    return isset($company[0]) ? $company[0] : null;
}

function signup($name, $email, $password, $bio = null, $type = 0, $phone = null)
{
    global $db;

    // Check if a user with the same email already exists
    $stmt = $db->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result->fetchArray(SQLITE3_ASSOC)) {
        // Email already registered, you can choose to return false or handle it differently
        return false;
    }

    // Hash the password securely using password_hash
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the INSERT statement
    $stmt = $db->prepare('
        INSERT INTO users (name, email, password, bio, type, phone) 
        VALUES (:name, :email, :password, :bio, :type, :phone)
    ');

    // Bind parameters to the statement
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);
    $stmt->bindValue(':bio', $bio, SQLITE3_TEXT);
    $stmt->bindValue(':type', $type, SQLITE3_INTEGER);
    $stmt->bindValue(':phone', $phone, SQLITE3_TEXT);

    // Execute the statement
    $result = $stmt->execute();

    if ($result) {
        // Return the new user's id on success
        return $db->lastInsertRowID();
    }

    // Insertion failed, return false or handle the error accordingly
    return false;
}
