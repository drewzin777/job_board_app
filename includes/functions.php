<?php
//data connection setup
function connectDb() {
    $host = 'localhost';
    $dbname = 'job_board';
    $username = 'root';
    $password = 'root'; // MAMP default password
    $port = '8889';     // MAMP default MySQL port
    return new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
}


function getJobs($limit, $offset) {
    $pdo = connectDb(); 
    $stmt = $pdo->prepare("SELECT * FROM jobs ORDER BY date_posted DESC LIMIT :limit OFFSET :offset"); 

    //Bind the limit and offset parameters as integers
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getJobById($id) {
    $pdo = connectDb(); 
    $stmt = $pdo->prepare('SELECT * FROM jobs WHERE id = ?'); 
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addJob($title, $description, $company, $location, $salary_range) {
    $pdo = connectDb();
    $stmt = $pdo->prepare('INSERT INTO jobs (title, description, company, location, salary_range, date_posted) VALUES (?, ?, ?, ?, ?, NOW())');
    $stmt->execute([$title, $description, $company, $location, $salary_range]);
}   

function updateJob($id, $title, $description, $company, $location, $salary_range) {
    $pdo = connectDb();
    $stmt = $pdo->prepare('UPDATE jobs SET title = ?, description = ?, company = ?, location = ?, salary_range = ? WHERE id = ?');
    $stmt->execute([$title, $description, $company, $location, $salary_range, $id]);
}

function deleteJob($id) {
    $pdo = connectDb();
    $stmt = $pdo->prepare('DELETE FROM jobs WHERE id = ?');
    $stmt->execute([$id]);
}


















