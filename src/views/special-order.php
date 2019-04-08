<?php include('../header.php'); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Purchases</div>

                <div class="card-body">
                    <p>Special Orders</p>

                    <form method="POST" action="">
                        Name:
                        <input type="text" name="customer_special_order_name"/></br>
                        Telephone number:
                        <input type="text" name="customer_special_order_phone"/></br>
                        <button type="submit" name="search_candidates" class="btn btn-success submit">Search</button>                            </form>

                    <?php

                    $customer_id = -1;
                    if (isset($_POST['customer_special_order_name']) &&
                        isset($_POST["customer_special_order_phone"])) {
                        require_once('../database/Query.php');
                        $sql = "SELECT *, `c`.`id` as `customer_id`
                                            FROM `customers` as `c`
                                            INNER JOIN `contact_information` ON `c`.`contact_id` = `contact_information`.`id` 
                                            WHERE `contact_information`.`name` LIKE \"" . $_POST['customer_special_order_name'] . "\"  
                                            AND `contact_information`.`phone_number` LIKE \"" . $_POST["customer_special_order_phone"] . "\"";
                        $query = new Query();
                        $result = $query->execute($sql);

                        if (count($result) > 0) {
                            $customer_id = $result[0]["customer_id"];
                        }






                    }

                    if ($customer_id != -1) {
                        require_once('../table/Table.php');
                        $table = new Table();
                        $tableHeaders = [
                            "Confirmation Number",
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
                    }


                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

