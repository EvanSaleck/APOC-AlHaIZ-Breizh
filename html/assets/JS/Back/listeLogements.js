import { ThrowAlertPopup } from '../utils.js';

// au chargement du dom js 
document.addEventListener('DOMContentLoaded', function() {
    const storedPopup = localStorage.getItem('alertPopup');
    if (storedPopup) {
        const { message, type } = JSON.parse(storedPopup);
        ThrowAlertPopup(message, type);
    }
});
