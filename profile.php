<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id=$user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<h2>Welcome, <?php echo $user['username']; ?></h2>
<p>Email: <?php echo $user['email']; ?></p>

<a href="add_song.php" class="btn btn-primary">Add a New Song</a>

<h3>Your Songs</h3>
<ul>
    <?php
    $song_sql = "SELECT * FROM songs WHERE user_id=$user_id";
    $song_result = mysqli_query($conn, $song_sql);

    while ($song = mysqli_fetch_assoc($song_result)): ?>
        <li><a href="song.php?id=<?php echo $song['id']; ?>"><?php echo $song['title']; ?></a></li>
    <?php endwhile; ?>
</ul>

<?php include 'includes/footer.php'; ?>
