<?php

$db_exists = file_exists("sqlite_export/daypilot.sqlite");

$db = new PDO('sqlite:sqlite_export/daypilot.sqlite');

if (!$db_exists) {
    $db->exec("CREATE TABLE IF NOT EXISTS rooms (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        name TEXT,
                        capacity INTEGER)");

    $db->exec("CREATE TABLE IF NOT EXISTS reservations (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        name TEXT,
                        start DATETIME,
                        end DATETIME,
                        room_id INTEGER,
                        ");

    $rooms = array(
                    array('name' => 'Room 1',
                        'id' => 1,
                        'capacity' => 2),
                    array('name' => 'Room 2',
                        'id' => 2,
                        'capacity' => 2),
                    array('name' => 'Room 3',
                        'id' => 3,
                        'capacity' => 2),
                    array('name' => 'Room 4',
                        'id' => 4,
                        'capacity' => 4),
                    array('name' => 'Room 5',
                        'id' => 5,
                        'capacity' => 1)
        );

    $insert = "INSERT INTO rooms (id, name, capacity) VALUES (:id, :name, :capacity)";
    $stmt = $db->prepare($insert);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':capacity', $capacity);

    foreach ($rooms as $r) {
      $id = $r['id'];
      $name = $r['name'];
      $capacity = $r['capacity'];
      $stmt->execute();
    }

}
