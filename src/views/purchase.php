<?php include('../header.php'); ?>


    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Purchases</div>

                        <div class="card-body">
                            <p>Customer search</p>

                            <form method="POST" action="">
                                Name:
                                <input type="text" name="customer_purchase_name"/></br>
                                Telephone number:
                                <input type="text" name="customer_purchase_phone"/></br>
                                <button type="submit" name="search_candidates" class="btn btn-success submit">Search</button>                            </form>

                            <?php

                                $customer_id = -1;
                                if (isset($_POST['customer_purchase_name']) &&
                                isset($_POST["customer_purchase_phone"])) {
                                    require_once('../database/Query.php');
                                    $sql = "SELECT *, `c`.`id` as `customer_id`
                                            FROM `customers` as `c`
                                            INNER JOIN `contact_information` ON `c`.`contact_id` = `contact_information`.`id` 
                                            WHERE `contact_information`.`name` LIKE \"" . $_POST['customer_purchase_name'] . "\"  
                                            AND `contact_information`.`phone_number` LIKE \"" . $_POST["customer_purchase_phone"] . "\"";
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
                                        "Transaction date",
                                        "ISBN",
                                        "Item Price",
                                        "Item Quantity",
                                        "Total Transaction Price",
                                        "Total Transaction Quantity",
                                        "Employee in charge of transaction"];
                                    $purchaseQuery = "
                                                SELECT 
                                                `sales`.`date`, 
                                                `sale_line_items`.`ISBN`, 
                                                `sale_line_items`.`price` as `item_price`, 
                                                `sale_line_items`.`quantity` as `item_quantity`, 
                                                `sales`.`total_price` as `total_transaction_price`, 
                                                `sales`.`total_quantity` as `total_transaction_quantity`, 
                                                `employees`.`name` as `employee_name` 
                                                FROM `sale_line_items` 
                                                INNER JOIN `sales` on `sales`.`id` = `sale_line_items`.`sale_id` 
                                                INNER JOIN `customers` on `sales`.`customer_id` = `customers`.`id` 
                                                INNER JOIN `employees` on `sales`.`employee_id` = `employees`.`id` 
                                                WHERE `sales`.`customer_id` = ". $customer_id ." order by `date` asc
                                    ";
                                    $table->printTable($tableHeaders, $purchaseQuery);
                                }


                            ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

