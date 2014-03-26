<?php

$db = new PDO('sqlite:db.sqlite3');
$sth = $db->query("SELECT first,last,EVENT_11_12,EVENT_12_13,EVENT_13_14,company,title,city,state,bio FROM participants;");
echo json_encode($sth->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT);
