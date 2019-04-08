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
                            "Customer ID",
                            "Order Number",
                            "Publisher",
                            "Branch",
                            "Date",
                            "Total",
                            "Books Quantity"];
                        $specialOrderQuery = "
                                                SELECT `confirmation_number`, 
                                                `customer_id`, 
                                                `orders`.`order_number`, 
                                                `contact_information`.`name` as `publisher_name`, 
                                                `branches`.`name` as `branch_name`, 
                                                `orders`.`date`, 
                                                `total_price`, 
                                                `orders`.`quantity` as `quantity` 
                                                FROM `logs` 
                                                INNER JOIN `orders` on `logs`.`order_number` = `orders`.`order_number` 
                                                INNER JOIN `branches` on `orders`.`branch_id` = `branches`.`id` 
                                                INNER JOIN `publishers` on `publishers`.`publisher_number` = `orders`.`publisher_number` 
                                                INNER JOIN `contact_information` on `publishers`.`contact_id` = `contact_information`.`id` 
                                                INNER JOIN `customers` on `logs`.`customer_id` = `customers`.`id` 
                                                WHERE `customer_id` = ". $customer_id ." 
                                                ORDER BY `confirmation_number` asc
                                    ";
                        $table->printTable($tableHeaders, $specialOrderQuery);


                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

