document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('http://localhost/projecte3/backend/api/get_scores.php');
        const result = await response.json();

        if (result.status === 'success') {
            const rankingBody = document.getElementById('ranking-body');
            result.scores.forEach(score => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${score.username}</td>
            <td>${score.score}</td>
          `;
                rankingBody.appendChild(row);
            });
        } else {
            alert("No se pudieron cargar los resultados.");
        }
    } catch (error) {
        console.error("Error al obtener el ranking:", error);
        alert("Error al conectar con el servidor.");
    }
});
