<?php
    require_once('../database/Query.php');

    class Table {
        function printTable($tableHeaderArray, $sqlQueryToDisplay) {
            $query = new Query();
            $rows = $query->execute($sqlQueryToDisplay);

            echo '<table class="table table-hover table-bordered table-striped">';
            echo '<thead>';
            foreach($tableHeaderArray as $tableHeader) {
                echo '<th>';
                echo $tableHeader;
                echo '</th>';
            }

            echo '</thead>';

            if (count($rows) != 0 && count($rows[0]) == count($tableHeaderArray)) {
                echo '<tbody>';
                foreach($rows as $row) {
                    echo '<tr>';
                    foreach($row as $data) {
                        echo '<td>';
                        echo $data;
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody>';
            }
        }
    }
?>