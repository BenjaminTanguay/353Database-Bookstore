<?php include('../header.php'); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Sales</div>

                <div class="card-body">
                    <p> Here are the sales since the start of year <?php echo date("Y")?>!</p>


                    <?php

//                        $startOfYear = date("Y")."-01-01";
                        $startOfYear = "1980-01-01";

                        require_once('../table/Table.php');
                        $table = new Table();
                        $tableHeaders = [
                            "Customer Name",
                            "Amount Paid"];
                        $saleQuery = "
                                        SELECT 
                                        `info`.`name`, 
                                        `info`.`amount_paid` 
                                        FROM
                                          (
                                            SELECT 
                                            `customer_amount`.`customer_id`, 
                                            `customer_amount`.`amount_paid`, 
                                            `customers`.`id`, 
                                            `customers`.`contact_id`, 
                                            `contact_information`.`id` as `contact_information_id`, 
                                            `contact_information`.`name` 
                                            FROM
                                              (
                                                SELECT 
                                                `sales`.`customer_id`, 
                                                `sales`.`date`, 
                                                SUM(`sales`.`total_price`) as amount_paid 
                                                FROM bookstore_test.sales
                                                WHERE `sales`.`date` >= \"" . $startOfYear . "\"
                                                GROUP BY `sales`.`customer_id`
                                              ) as customer_amount
                                            INNER JOIN `customers` on `customer_amount`.`customer_id` = `customers`.`id`
                                            INNER JOIN `contact_information` ON `customers`.`contact_id` = `contact_information`.`id`
                                          ) as info;
                                        ";
                        echo $saleQuery;
                        $table->printTable($tableHeaders, $saleQuery);


                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

