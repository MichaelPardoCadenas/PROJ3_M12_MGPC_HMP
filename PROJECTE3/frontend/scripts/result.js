document.addEventListener('DOMContentLoaded', () => {
    const score = localStorage.getItem('last_score');
    const scoreElement = document.getElementById('final-score');

    if (scoreElement && score !== null) {
        scoreElement.textContent = `Tu puntuación: ${score}`;
    }
});
