<?php
    class Query {
        function execute($query) {
            $connection = include('connection.php');
            $returnValue = array();
            $queryResult = $connection->query($query);
            if ($queryResult->num_rows > 0) {
                while ($row = $queryResult->fetch_assoc()) {
                    array_push($returnValue, $row);
                }
            }
            $connection->close();
            return $returnValue;
        }
    }
?>