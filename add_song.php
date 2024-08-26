<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<h2>Add a New Song</h2>

<form method="POST" action="process_add_song.php">
    <input type="text" name="title" placeholder="Song Title" required>
    <input type="text" name="artist" placeholder="Artist" required>

    <!-- Button to insert full template -->
    <div class="template-buttons">
        <button type="button" class="btn btn-secondary" onclick="insertFullTemplate()">Insert Full Template</button>
    </div>

    <textarea name="chords" placeholder="Chords and Lyrics" required oninput="updatePreview(this.value)"></textarea>
    <div id="preview" class="song-preview mb-5 mt-3"></div>

    <select name="capo">
        <option value="No Capo">No Capo</option>
        <option value="Capo 1">Capo 1</option>
        <option value="Capo 2">Capo 2</option>
        <option value="Capo 3">Capo 3</option>
    </select>

    <select name="tuning">
        <option value="Standard">Standard</option>
        <option value="Drop D">Drop D</option>
        <option value="Half Step Down">Half Step Down</option>
    </select>

    <input type="text" name="key_signature" placeholder="Key Signature" required>
    <button type="submit" class="btn btn-primary">Add Song</button>
</form>

<?php include 'includes/footer.php'; ?>

<script>
function insertFullTemplate() {
    const textarea = document.querySelector('textarea[name="chords"]');
    const template = `
[Intro]



[Verse 1]



[Chorus]



[Verse 2]



[Chorus]



[Bridge]



[Chorus]



[Outro]
`;
    textarea.value = template;
    textarea.focus();
    updatePreview(template);
}

function updatePreview(content) {
    document.getElementById('preview').innerHTML = content
        .replace(/\[A\]/g, '<span class="chord" data-chord="A">[A]</span>')
        .replace(/\[B\]/g, '<span class="chord" data-chord="B">[B]</span>')
        .replace(/\[C\]/g, '<span class="chord" data-chord="C">[C]</span>')
        .replace(/\[D\]/g, '<span class="chord" data-chord="D">[D]</span>')
        .replace(/\[E\]/g, '<span class="chord" data-chord="E">[E]</span>')
        .replace(/\[F\]/g, '<span class="chord" data-chord="F">[F]</span>')
        .replace(/\[G\]/g, '<span class="chord" data-chord="G">[G]</span>');
}
</script>

<style>
.template-buttons {
    margin-bottom: 10px;
}

textarea[name="chords"] {
    width: 100%;
    height: 400px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

.song-preview {
    border: 1px solid #ccc;
    padding: 10px;
    background-color: #f9f9f9;
    white-space: pre-wrap; /* Menjaga spasi dan line breaks */
}

.chord {
    cursor: pointer;
    color: blue;
    text-decoration: underline;
}
</style>
