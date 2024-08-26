document.getElementById('transup').addEventListener('click', function() {
    transposeChords(1);
});

document.getElementById('transdown').addEventListener('click', function() {
    transposeChords(-1);
});

function transposeChords(steps) {
    const chords = document.querySelectorAll('.song-details pre');
    chords.forEach(chord => {
        chord.innerHTML = chord.innerHTML.replace(/[A-G][#b]?/g, function(match) {
            return transpose(match, steps);
        });
    });
}

function transpose(chord, steps) {
    const allChords = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];
    let index = allChords.indexOf(chord.replace('m', '').replace('7', ''));
    if (index === -1) return chord;

    let newIndex = (index + steps + allChords.length) % allChords.length;
    let newChord = allChords[newIndex];

    return chord.replace(/^[A-G][#b]?/, newChord);
}
