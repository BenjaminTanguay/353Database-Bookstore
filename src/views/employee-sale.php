<?php include('../header.php'); ?>


    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Employee sales</div>

                    <div class="card-body">
                        <p>Employee search</p>

                        <form method="POST" action="">
                            Name:
                            <input type="text" name="employee_sale_name"/></br>
                            Date:
                            <input type="text" name="employee_sale_date"/></br>
                            <button type="submit" name="search_candidates" class="btn btn-success submit">Search</button>
                        </form>

                        <?php

                            $employee_id = -1;
                            $date = -1;
                            if (isset($_POST['employee_sale_name']) &&
                                isset($_POST["employee_sale_date"])) {
                                require_once('../database/Query.php');
                                $sql = "SELECT `employees`.`id` as `employee_id`, `employees`.`name`
                                        FROM `employees` 
                                        WHERE `employees`.`name` LIKE \"" . $_POST['employee_sale_name'] . "\"";
                                $query = new Query();
                                $result = $query->execute($sql);

                                if (count($result) > 0) {
                                    $employee_id = $result[0]["employee_id"];
                                    $date = $_POST["employee_sale_date"];
                                }
                            }


                            if ($employee_id != -1 && $date != -1) {
                                require_once('../table/Table.php');
                                $table = new Table();
                                $tableHeaders = [
                                    "Sale ID",
                                    "ISBN",
                                    "Employee Name",
                                    "Customer Name",
                                    "Sale Date"];
                                $employeeSalesQuery = "
                                                    SELECT 
                                                    `sales`.`id`, 
                                                    `ISBN`, 
                                                    `employees`.`name` as `employee_name`, 
                                                    `contact_information`.`name` as `customer_name`, 
                                                    `sales`.`date` 
                                                    FROM `sales` 
                                                    INNER JOIN `sale_line_items` on `sales`.`id` = `sale_line_items`.`sale_id` 
                                                    INNER JOIN `employees` on `sales`.`employee_id` = `employees`.`id` 
                                                    INNER JOIN `customers` on `sales`.`customer_id` = `customers`.`id` 
                                                    INNER JOIN `contact_information` on `customers`.`contact_id` = `contact_information`.`id` 
                                                    WHERE `employee_id` = " . $employee_id . " AND `date` = \"$date\"
                                ";
                                $table->printTable($tableHeaders, $employeeSalesQuery);
                            }
                        ?>
    
                    </div>
                </div>
            </div>
        </div>
    </div>