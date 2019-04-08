<?php include('../header.php'); ?>



<?php

    require_once('../table/Table.php');
    $table = new Table();

    $table->printTable(["id", "Employee id", "Customer id", "Date", "Total quantity", "Total price", "Created at", "Updated at"], "SELECT * FROM bookstore_test.sales");


?>

