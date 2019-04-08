<?php include('../header.php'); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Back Order</div>

                <div class="card-body">
                    <p> Here are all of the back orders!</p>


                    <?php



                        require_once('../table/Table.php');
                        $table = new Table();
                        $tableHeaders = [
                            "Order Number",
                            "ISBN",
                            "Book Authors",
                            "Book Title",
                            "Book Editions",
                            "Book Price",
                            "Ordered Quantity",
                            "Publisher Name"];
                        $backOrderQuery = "
                                                SELECT `orders`.`order_number`, 
                                                `books`.`ISBN`, 
                                                `books`.`authors`, 
                                                `books`.`title`, 
                                                `books`.`edition`, 
                                                `books`.`price`, 
                                                `order_details`.`quantity` as `ordered_quantity`, 
                                                `contact_information`.`name` as `publisher_name` 
                                                FROM `orders` 
                                                INNER JOIN `order_details` on `order_details`.`order_number` = `orders`.`order_number` 
                                                INNER JOIN `books` on `order_details`.`ISBN` = `books`.`ISBN` 
                                                INNER JOIN `publishers` on `publishers`.`publisher_number` = `books`.`publisher_number` 
                                                INNER JOIN `contact_information` on `publishers`.`contact_id` = `contact_information`.`id` 
                                                ORDER BY `orders`.`order_number` asc
                                    ";
                        $table->printTable($tableHeaders, $backOrderQuery);


                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

