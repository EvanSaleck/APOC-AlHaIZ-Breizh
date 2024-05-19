
var starFull = '<img class="noteEtoile" src="/assets/imgs/notes/star_full.svg" alt="">';
var starEmpty = '<img class="noteEtoile" src="/assets/imgs/notes/star_empty.svg" alt="">';
var starHalf = '<img class="noteEtoile" src="/assets/imgs/notes/star_half.svg" alt="">';

export function displayNoteEtoiles(div,note) {
    div.innerHTML = '';
    for (let i = 0; i < 5; i++) {
        if (note >= 1) {
            div.innerHTML += starFull;
            note--;
        } else if (note >= 0.5) {
            div.innerHTML += starHalf;
            note = 0;
        } else {
            div.innerHTML += starEmpty;
        }
    }
}

export async function fileExists(path) {
    try {
        const response = await fetch(path, { method: 'HEAD' });
        return response.ok;
    } catch (error) {
        console.error('Erreur:', error);
        return false;
    }
}