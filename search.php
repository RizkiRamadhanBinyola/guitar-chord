<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM songs WHERE title LIKE '%$search_term%' OR artist LIKE '%$search_term%'";
    $result = mysqli_query($conn, $sql);
}
?>

<form method="GET" action="search.php">
    <input type="text" name="search" placeholder="Search for songs or artists" required>
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<?php if (isset($result)): ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <ul>
            <?php while ($song = mysqli_fetch_assoc($result)): ?>
                <li><a href="song.php?id=<?php echo $song['id']; ?>"><?php echo $song['title']; ?> by <?php echo $song['artist']; ?></a></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No results found for "<?php echo htmlspecialchars($search_term); ?>"</p>
    <?php endif; ?>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
