<?php

session_start();

$xmlFilePath = 'employees.xml';

if (!file_exists($xmlFilePath)) {
    $dom = new DOMDocument('1.0', 'UTF-8');
    $root = $dom->createElement('employees');
    $dom->appendChild($root);
    $dom->save($xmlFilePath);
} else {
    $dom = new DOMDocument();
    $dom->load($xmlFilePath);
}

function getEmployeeByIndex($index, $dom)
{
    $employees = $dom->getElementsByTagName('employee');
    if ($index >= 0 && $index < $employees->length) {
        $employee = $employees->item($index);
        $id = $employee->getAttribute('id');
        $name = $employee->getElementsByTagName('name')->item(0)->nodeValue;
        $phone = $employee->getElementsByTagName('phone')->item(0)->nodeValue;
        $address = $employee->getElementsByTagName('address')->item(0)->nodeValue;
        $email = $employee->getElementsByTagName('email')->item(0)->nodeValue;
        return ['id' => $id, 'name' => $name, 'phone' => $phone, 'address' => $address, 'email' => $email];
    }
    return null;
}

$employeeIndex = $_SESSION['employeeIndex'] ?? 0;
if ($employeeIndex < 0) {
    $employeeIndex = 0;
}

$current_employee = $_SESSION['id'] ?? 1;

function insertEmployee($name, $phone, $address, $email, $dom, $xmlFilePath)
{
    $employees = $dom->getElementsByTagName('employee');
    $lastEmployee = $employees->item($employees->length - 1);
    $lastId = $lastEmployee ? $lastEmployee->getAttribute('id') : 0;
    $newId = $lastId + 1;

    $employee = $dom->createElement('employee');
    $employee->setAttribute('id', $newId);
    $employee->appendChild($dom->createElement('name', $name));
    $employee->appendChild($dom->createElement('phone', $phone));
    $employee->appendChild($dom->createElement('address', $address));
    $employee->appendChild($dom->createElement('email', $email));
    $dom->documentElement->appendChild($employee);
    $dom->save($xmlFilePath);
}

function updateEmployee($id, $name, $phone, $address, $email, $dom, $xmlFilePath)
{
    $employees = $dom->getElementsByTagName('employee');
    foreach ($employees as $employee) {
        if ($employee->getAttribute('id') == $id) {
            $employee->getElementsByTagName('name')->item(0)->nodeValue = $name;
            $employee->getElementsByTagName('phone')->item(0)->nodeValue = $phone;
            $employee->getElementsByTagName('address')->item(0)->nodeValue = $address;
            $employee->getElementsByTagName('email')->item(0)->nodeValue = $email;
            $dom->save($xmlFilePath);
            return;
        }
    }
}

function searchEmployee($searchValue, $dom)
{
    $searchResults = [];
    $employees = $dom->getElementsByTagName('employee');
    foreach ($employees as $employee) {
        $currentFieldValue = $employee->getElementsByTagName('name')->item(0)->nodeValue;
        if (str_contains(strtolower($currentFieldValue), strtolower($searchValue))) {
            array_push($searchResults, $employee);
        }
    }
    return $searchResults;
}


function deleteEmployee($id, $dom, $xmlFilePath)
{
    $employees = $dom->getElementsByTagName('employee');
    foreach ($employees as $employee) {
        if ($employee->getAttribute('id') == $id) {
            $dom->documentElement->removeChild($employee);
            $dom->save($xmlFilePath);
            return;
        }
    }
}

function displaySearchResults($searchResults)
{
    if (!empty($searchResults)) {
        echo '<div class="search-results mt-4">';
        echo '<h2 class="mb-3">Search Results</h2>';
        foreach ($searchResults as $contact) {
            echo '<div class="card mb-3">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($contact->getElementsByTagName('name')->item(0)->nodeValue) . '</h5>';
            echo '<p class="card-text"><strong>Phone:</strong> ' . htmlspecialchars($contact->getElementsByTagName('phone')->item(0)->nodeValue) . '</p>';
            echo '<p class="card-text"><strong>Address:</strong> ' . htmlspecialchars($contact->getElementsByTagName('address')->item(0)->nodeValue) . '</p>';
            echo '<p class="card-text"><strong>Email:</strong> ' . htmlspecialchars($contact->getElementsByTagName('email')->item(0)->nodeValue) . '</p>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
}

$searchResults = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $searchValue = $_POST['searchValue'] ?? '';

    switch ($action) {
        case 'Insert':
            insertEmployee($name, $phone, $address, $email, $dom, $xmlFilePath);
            $employeeIndex = $dom->getElementsByTagName('employee')->length - 1;
            $empResults = getEmployeeByIndex($employeeIndex, $dom);
            break;
        case 'Update':
            updateEmployee($id, $name, $phone, $address, $email, $dom, $xmlFilePath);
            $empResults = getEmployeeByIndex($employeeIndex, $dom);
            break;
        case 'Delete':
            deleteEmployee($id, $dom, $xmlFilePath);
            if ($employeeIndex > 0) {
                $employeeIndex--;
            }
            $empResults = getEmployeeByIndex($employeeIndex, $dom);
            break;
        case 'Prev':
            if ($employeeIndex > 0) {
                $employeeIndex--;
            }
            $empResults = getEmployeeByIndex($employeeIndex, $dom);
            break;
        case 'Next':
            if ($employeeIndex < $dom->getElementsByTagName('employee')->length - 1) {
                $employeeIndex++;
            }
            $empResults = getEmployeeByIndex($employeeIndex, $dom);
            break;
        case 'Search':
            $searchResults = searchEmployee($searchValue, $dom);
            $empResults = getEmployeeByIndex($employeeIndex, $dom);
            break;
    }
    $_SESSION['employeeIndex'] = $employeeIndex;
} else {
    $empResults = getEmployeeByIndex($employeeIndex, $dom);
}

require_once 'view.php';
