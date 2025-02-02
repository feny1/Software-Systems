<?php
// jobs.php

// Include the file that sets up your database connection and tables.
include 'data.php';

// Build a query to fetch job records along with the company name.
// Adjust the query as needed for your schema.
$query = "SELECT j.job_id, j.name AS job_name, j.description, j.type, j.language_id, c.name AS company_name
          FROM jobs j
          LEFT JOIN company c ON j.company_id = c.company_id";
$result = $db->query($query);

$jobs = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {

    // Optionally, fetch a keyword from the languages table if language_id is set.
    $keywords = [];
    if (!empty($row['language_id'])) {
        $langQuery = "SELECT name FROM languages WHERE language_id = " . intval($row['language_id']);
        $langResult = $db->query($langQuery);
        if ($langRow = $langResult->fetchArray(SQLITE3_ASSOC)) {
            $keywords[] = $langRow['name'];
        }
    }

    // Convert the job type (stored as BOOLEAN) to a string.
    // Here we assume: true = "وظيفة موسمية", false = "تطوع موسمي"
    $jobType = ($row['type']) ? "وظيفة موسمية" : "تطوع موسمي";

    // Build the job entry in the format you desire.
    $jobs[] = [
        "name"        => $row['job_name'],
        "description" => $row['description'],
        "company"     => $row['company_name'],
        "keywords"    => $keywords,
        "type"        => $jobType,
    ];
}

// Output the job listings as JSON with proper UTF-8 encoding.
header('Content-Type: application/json; charset=utf-8');
echo json_encode($jobs, JSON_UNESCAPED_UNICODE);
?>
