
document.addEventListener('DOMContentLoaded', () => {
    console.log("Script cargado correctamente");

    const currentQuestionElement = document.getElementById('current-question');
    const accumulatedPrizeElement = document.getElementById('accumulated-prize');
    const questionTextElement = document.getElementById('question-text');

    let questionNumber = 1;
    let prize = 0;
    let level = 1;
    let correctAnswer = null;
    const questionsPerLevel = 5;

    const prizePerQuestion = [50, 100, 150, 200, 250, 500, 600, 700, 800, 900, 1000, 1200, 1400, 1600, 2000];

    async function loadQuestion() {
        try {
            const response = await fetch(`http://localhost/projecte3/backend/api/get_question.php?level=${level}`);
            const result = await response.json();

            if (result.status === 'success') {
                const question = result.question;

                questionTextElement.textContent = question.question_text;
                document.getElementById('answerA').textContent = `A) ${question.answer_a}`;
                document.getElementById('answerB').textContent = `B) ${question.answer_b}`;
                document.getElementById('answerC').textContent = `C) ${question.answer_c}`;
                document.getElementById('answerD').textContent = `D) ${question.answer_d}`;
                
                currentQuestionElement.textContent = questionNumber;

                correctAnswer = question.correct_answer;
                console.log("Correcta era:", correctAnswer);
            } else {
                alert(result.message);
            }
        } catch (error) {
            alert('Error al cargar la pregunta.');
            console.error(error);
        }
    }

    function handleAnswer(selectedAnswerId) {
        const selectedLetter = selectedAnswerId.replace('answer', '').trim().toUpperCase();
        const correct = correctAnswer.trim().toUpperCase();

        console.log("Has elegido:", selectedLetter);
        console.log("Correcta era:", correct);

        if (selectedLetter === correct) {
            alert("¡Correcto!");
            prize += prizePerQuestion[questionNumber - 1] || 0;
            accumulatedPrizeElement.textContent = prize;
            questionNumber++;

            // cada 5 preguntas subimos el nivel (5, 10 → cambia a 2, 3)
            if ((questionNumber - 1) % questionsPerLevel === 0 && level < 3) {
                level++;
            }

            if (questionNumber > 15) {
                saveScore(prize);
            } else {
                loadQuestion();
            }
        } else {
            alert("¡Incorrecto! Fin del juego.");
            saveScore(prize);
        }
    }

    async function saveScore(finalScore) {
        const user_id = localStorage.getItem('user_id');
        localStorage.setItem('last_score', finalScore);
        if (!user_id) {
            alert("No se ha encontrado el usuario.");
            return;
        }

        try {
            const response = await fetch('http://localhost/projecte3/backend/api/submit_scores.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ user_id: parseInt(user_id), score: finalScore })
            });

            const text = await response.text();
            console.log("Respuesta bruta del servidor:", text);

            const result = JSON.parse(text);
            if (result.status === 'success') {
                window.location.href = "result.html";
            } else {
                alert(result.message || "Error al guardar puntuación.");
            }
        } catch (error) {
            alert("Error al guardar puntuación.");
            console.error("Error al conectar o parsear:", error);
        }
    }

    document.querySelectorAll('.answer-btn').forEach(btn => {
        console.log("Asignando evento a:", btn.id);
        btn.addEventListener('click', () => {
            console.log("Click detectado en:", btn.id);
            handleAnswer(btn.id);
        });
    });

    loadQuestion();
});
