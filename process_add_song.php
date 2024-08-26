<?php
include 'includes/config.php';
session_start(); // Memulai sesi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Periksa apakah sesi pengguna ada
    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Debugging output: Memeriksa apakah user_id ada di tabel users
    $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
    if (mysqli_num_rows($checkUser) == 0) {
        echo "User ID does not exist.";
        exit();
    }

    // Mengamankan data input
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $artist = mysqli_real_escape_string($conn, $_POST['artist']);
    $chords = mysqli_real_escape_string($conn, $_POST['chords']);
    $capo = mysqli_real_escape_string($conn, $_POST['capo']);
    $tuning = mysqli_real_escape_string($conn, $_POST['tuning']);
    $key_signature = mysqli_real_escape_string($conn, $_POST['key_signature']);

    // Query untuk menambahkan data ke tabel songs
    $sql = "INSERT INTO songs (title, artist, chords, capo, tuning, key_signature, user_id) 
            VALUES ('$title', '$artist', '$chords', '$capo', '$tuning', '$key_signature', '$user_id')";

    if (mysqli_query($conn, $sql)) {
        // Redirect ke halaman song.php dengan ID lagu yang baru ditambahkan
        header('Location: song.php?id=' . mysqli_insert_id($conn));
    } else {
        // Menampilkan pesan error jika query gagal
        echo "Error: " . mysqli_error($conn);
    }
}
?>
