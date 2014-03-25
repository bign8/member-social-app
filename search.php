<?php

$db = new PDO('sqlite:db.sqlite3');

$sth = $db->query("SELECT First,Last,EVENT_11_12,EVENT_12_13,EVENT_13_14,COMPANY,TITLE,CITY,STATE,Bio FROM participants;");

echo json_encode($sth->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT);