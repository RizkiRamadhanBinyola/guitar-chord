<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<?php
if (!isset($_GET['id'])) {
    echo "Song ID is missing.";
    exit();
}

$song_id = intval($_GET['id']);

$sql = "SELECT * FROM songs WHERE id = $song_id";
$result = mysqli_query($conn, $sql);

if ($result) {
    $song = mysqli_fetch_assoc($result);
} else {
    echo "Error: " . mysqli_error($conn);
    exit();
}
?>

<h2><?php echo htmlspecialchars($song['title']); ?></h2>
<p><strong>Artist:</strong> <?php echo htmlspecialchars($song['artist']); ?></p>

<div class="song-details">
    <div class="song-chords">
        <?php echo nl2br(htmlspecialchars($song['chords'])); ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
// Replace with your API URL
const CHORD_API_URL = 'https://api.example.com/chord-shapes/'; 

document.addEventListener('DOMContentLoaded', function() {
    const songChords = document.querySelector('.song-chords').innerHTML;
    const preview = document.querySelector('.song-chords');

    // Update chords with span elements
    preview.innerHTML = songChords
        .replace(/\[A\]/g, '<span class="chord" data-chord="A">[A]</span>')
        .replace(/\[B\]/g, '<span class="chord" data-chord="B">[B]</span>')
        .replace(/\[C\]/g, '<span class="chord" data-chord="C">[C]</span>')
        .replace(/\[D\]/g, '<span class="chord" data-chord="D">[D]</span>')
        .replace(/\[E\]/g, '<span class="chord" data-chord="E">[E]</span>')
        .replace(/\[F\]/g, '<span class="chord" data-chord="F">[F]</span>')
        .replace(/\[G\]/g, '<span class="chord" data-chord="G">[G]</span>');
});

document.addEventListener('mouseover', function(e) {
    if (e.target.classList.contains('chord')) {
        const chord = e.target.getAttribute('data-chord');
        showChordTooltip(chord, e.target);
    }
});

document.addEventListener('mouseout', function(e) {
    if (e.target.classList.contains('chord')) {
        hideChordTooltip();
    }
});

function showChordTooltip(chord, element) {
    const tooltip = document.querySelector('.tooltip');
    if (!tooltip) {
        const newTooltip = document.createElement('div');
        newTooltip.className = 'tooltip';
        document.body.appendChild(newTooltip);
    }

    const tooltipElement = document.querySelector('.tooltip');
    
    fetchChordShape(chord).then(shape => {
        tooltipElement.innerHTML = shape;
        tooltipElement.style.display = 'block';
        tooltipElement.style.left = `${element.getBoundingClientRect().left}px`;
        tooltipElement.style.top = `${element.getBoundingClientRect().bottom + window.scrollY}px`;
    }).catch(err => {
        console.error('Error fetching chord shape:', err);
    });
}

function hideChordTooltip() {
    const tooltip = document.querySelector('.tooltip');
    if (tooltip) {
        tooltip.style.display = 'none';
    }
}

function fetchChordShape(chord) {
    return fetch(`${CHORD_API_URL}${chord}`)
        .then(response => response.json())
        .then(data => data.shape); // Assume the API returns a 'shape' field
}
</script>

<style>
.song-details {
    margin: 20px;
}

.song-chords {
    white-space: pre-wrap;
}

.chord {
    cursor: pointer;
    color: blue;
    text-decoration: underline;
    position: relative; /* Important for positioning tooltip */
}

.tooltip {
    position: absolute;
    background-color: #333;
    color: #fff;
    padding: 10px;
    border-radius: 5px;
    display: none;
    z-index: 1000;
    max-width: 300px;
    word-wrap: break-word;
}
</style>
