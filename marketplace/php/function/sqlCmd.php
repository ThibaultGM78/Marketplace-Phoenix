<?php
    function sqlSearch($PDO, $sql){
        $results = $PDO->prepare($sql);
        $results->execute();

        $list = $results->fetchALL(PDO::FETCH_ASSOC);
        $results->closeCursor();

        return $list;
    }
?>