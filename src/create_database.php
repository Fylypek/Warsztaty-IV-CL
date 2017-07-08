<?php

require_once 'config.php';

//    "CREATE DATABASE workshop4
//        DEFAULT CHARACTER SET utf8
//        DEFAULT COLLATE utf8_general_ci"


$workshop4Array = array(
    "create table users(
                        id int AUTO_INCREMENT NOT NULL,
                        name varchar(255) NOT NULL,
                        email varchar(255) NOT NULL,
                        password varchar(60) NOT NULL,
                        address varchar(255),
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table items(
                        id int AUTO_INCREMENT NOT NULL,
                        name varchar(255) NOT NULL,
                        description varchar(255) NOT NULL,
                        price decimal(10,2) NOT NULL,
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table photos(
                        id int AUTO_INCREMENT NOT NULL,
                        path varchar(255) NOT NULL,
                        item_id int NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(item_id) REFERENCES items(id) ON DELETE CASCADE)
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table statuses(
                        id int AUTO_INCREMENT NOT NULL,
                        name varchar(255),
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table orders(
                        id int AUTO_INCREMENT NOT NULL,
                        user_id int NOT NULL,
                        status_id int NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
                        FOREIGN KEY(status_id) REFERENCES statuses(id) ON DELETE CASCADE)
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table item_order(
                        id int AUTO_INCREMENT NOT NULL,
                        order_id int NOT NULL,
                        item_id int NOT NULL,
                        quantity int NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(item_id) REFERENCES items(id),
                        FOREIGN KEY(order_id) REFERENCES orders(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table admins(
                        id int AUTO_INCREMENT NOT NULL,
                        email varchar(255) NOT NULL,
                        password varchar(60) NOT NULL,
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table messages(
                        id int AUTO_INCREMENT NOT NULL,
                        user_id int NOT NULL,
                        order_id int NOT NULL,
                        message text NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
                        FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE)
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table categories(
                        id int AUTO_INCREMENT NOT NULL,
                        name varchar(255),
                        PRIMARY KEY(id))
    ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table item_category(
                        id int AUTO_INCREMENT NOT NULL,
                        item_id int NOT NULL,
                        category_id int NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(item_id) REFERENCES items(id),
                        FOREIGN KEY(category_id) REFERENCES categories(id))
    ENGINE=InnoDB, CHARACTER SET=utf8"
                        
);

foreach($workshop4Array as $query){
    $result = $conn->query($query);
    if ($result === TRUE) {
        echo "CREATED SUCCESSFULY<br>";
    } else {
        echo "ERROR: " . $conn->error."<br>";
    }
}


