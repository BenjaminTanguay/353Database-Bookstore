<?php include('../header.php'); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Late orders of books</div>

                <div class="card-body">
                    <p> Here are the late shipments of books!</p>


                    <?php

                    $today = date('Y-m-d');

                    require_once('../table/Table.php');
                    $table = new Table();
                    $tableHeaders = [
                        "ISBN",
                        "Title",
                        "Price",
                        "Quantity",
                        "Publisher contact person",
                        "Expected shipment date"];
                    $bookQuery = " SELECT 
                                   `late_books`.`ISBN`,
                                   `late_books`.`title`,
                                   `late_books`.`price`,
                                   `late_books`.`quantity`,
                                   `late_books`.`name`,
                                   `late_books`.`expected_receive_date` 
                                   FROM
                                      (
                                        SELECT
                                        `books`.`ISBN`,
                                        `books`.`title`,
                                        `books`.`price`,
                                        `shipments`.`received`,
                                        `shipment_details`.`quantity`,
                                        `contact_information`.`name`,
                                        `shipments`.`expected_receive_date`
                                        FROM `shipments`
                                        INNER JOIN `shipment_details` on `shipments`.`id` = `shipment_details`.`shipment_id`
                                        INNER JOIN `books` on `shipment_details`.`ISBN` = `books`.`ISBN`
                                        INNER JOIN `publishers` on `shipments`.`publisher_number` = `publishers`.`publisher_number`
                                        INNER JOIN `contact_information` on `publishers`.`contact_id` = `contact_information`.`id`
                                        WHERE `expected_receive_date` < \"" . $today . "\" AND `received` = 0 order by `ISBN` asc
                                      ) as late_books
                                    ";
                    $table->printTable($tableHeaders, $bookQuery);


                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

