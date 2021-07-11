<?php

$db = new mysqli('localhost', 'user', 'password');
$db->select_db('db');
$db->query("SET NAMES utf8");

function dbs($sql, $raw = false, $useDb = false) {
    if ($useDb) {
        global ${$useDb};
        $db = ${$useDb};
    }
    else {
        global $db;
    }

    $sql = ($raw ? "" : "select * from ") . $sql;
    $result = $db->query($sql);
    $data = [];

    if (isset($result->num_rows)) {
        if ($result->num_rows) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = (object) $row;
            }
        }
    }
    else {
        $message = json_encode([
            'db_error' => $db->error,
            'sql' => $sql
        ]);
    }

    if ($db->error) {
        echo "$db->error<br>$sql<br>";
    }
    return $data;
}

function dbi($sql, $raw = false) {
    global $db;
    $sql = ($raw ? "" : "insert into ") . $sql;
    $result = $db->query($sql);
    if ($db->error) {
        echo "$db->error<br>$sql<br>";
    }
    return $db->insert_id ?: $result;
}

function dbu($sql, $raw = false) {
    global $db;

    $sql = ($raw ? "" : "update ") . $sql;
    $result = $db->query($sql);

    if ($db->error) {
        echo "$db->error<br>$sql<br>";
    }
    return $db->affected_rows;
}