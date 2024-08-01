<?php
$conn = mysqli_connect("localhost:3307", "root", "", "db_pariwisata");

// if (!$conn) {
//     die("Connection Failed: ");
// } else {
//     echo ("Connection Success");
// }

function signup_acc($dataUsers)
{
    global $conn;

    $name = strtolower(stripslashes($dataUsers["name"]));
    $email = mysqli_real_escape_string($conn, $dataUsers["email"]);
    $password = mysqli_real_escape_string($conn, $dataUsers["password"]);

    $result = mysqli_query($conn, "SELECT email FROM users WHERE email='$email'");
    if (mysqli_fetch_row($result)) {
        return false;
    };

    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users VALUES 
('','$name','$email','$password','')");

    return mysqli_affected_rows($conn);
}


function getData($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $array = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
    return $array;
}

function deleteData($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM paket_wisata WHERE id = '$id'");

    return mysqli_affected_rows($conn);
}