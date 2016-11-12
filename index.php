<?php

include "filetables.php";

$dataTable = new FileTables("data.json");

//select all
$data = $dataTable->getAll();
print_r($data);

//get existing record
$record = $dataTable->getById(3);
print_r($record);

//update existing record
if($dataTable->updateById(3, array('password' => "123"))) {
    $record = $dataTable->getById(3);
    print_r($record);
}

//delete existing record
if($dataTable->deleteById(3)) {
    $record = $dataTable->getById(3);
    print_r($record);
    $data = $dataTable->getAll();
    print_r($data);
}

//insert new record by supplying key
if($dataTable->updateById(7, array('time' => '2016-11-03 11:03:00', 'password' => "secret"))) {
    $record = $dataTable->getById(7);
    print_r($record);
}

//insert new record with autoincrement
if($dataTable->insert(array('time' => '2016-11-03 11:03:33', 'password' => "lost"))) {
    $data = $dataTable->getAll();
    print_r($data);
}
