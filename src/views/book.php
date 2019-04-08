<?php include('../header.php'); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Book</div>

                <div class="card-body">
                    <p> Here are all of the books!</p>


                    <?php



                    require_once('../table/Table.php');
                    $table = new Table();
                    $tableHeaders = [
                        "ISBN",
                        "Title",
                        "Edition",
                        "Price",
                        "Quantity",
                        "Authors",
                        "Publisher"];
                    $bookQuery = "
                                        SELECT 
                                        `books`.`ISBN`, 
                                        `books`.`title`, 
                                        `books`.`edition`, 
                                        `books`.`price`, 
                                        `books`.`quantity`, 
                                        `books`.`authors`, 
                                        `contact_information`.`name`
                                        FROM `books` 
                                        INNER JOIN `publishers` on `books`.`publisher_number` = `publishers`.`publisher_number` 
                                        INNER JOIN `contact_information` on `publishers`.`contact_id` = `contact_information`.`id` 
                                        ORDER BY `ISBN` asc
                                    ";
                    $table->printTable($tableHeaders, $bookQuery);


                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

