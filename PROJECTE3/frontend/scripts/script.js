document.addEventListener('DOMContentLoaded', () => {
    console.log("Script cargado correctamente");

    const currentQuestionElement = document.getElementById('current-question');
    const accumulatedPrizeElement = document.getElementById('accumulated-prize');
    const questionTextElement = document.getElementById('question-text');

    let questions = []; // array total de preguntas
    let currentIndex = 0;
    let prize = 0;
    let correctAnswer = null;

    function getPrizeForLevel(level) {
        switch (level) {
            case 1: return 50;
            case 2: return 150;
            case 3: return 300;
            default: return 0;
        }
    }

    async function loadAllQuestions() {
        try {
            const all = [];

            for (let lvl = 1; lvl <= 3; lvl++) {
                const res = await fetch(`/api/get_question.php?level=${lvl}&amount=5`);
                const data = await res.json();
                if (data.status === 'success') {
                    all.push(...data.questions);
                } else {
                    alert(`Error al cargar preguntas de nivel ${lvl}`);
                    return;
                }
            }

            questions = all;
            loadQuestion();
        } catch (error) {
            alert('Error al cargar preguntas.');
            console.error(error);
        }
    }

    function loadQuestion() {
        const current = questions[currentIndex];

        if (!current) {
            alert("No quedan más preguntas.");
            saveScore(prize);
            return;
        }

        questionTextElement.textContent = current.question_text;
        document.getElementById('answerA').textContent = `A) ${current.answer_a}`;
        document.getElementById('answerB').textContent = `B) ${current.answer_b}`;
        document.getElementById('answerC').textContent = `C) ${current.answer_c}`;
        document.getElementById('answerD').textContent = `D) ${current.answer_d}`;

        currentQuestionElement.textContent = currentIndex + 1;
        correctAnswer = current.correct_answer;
    }

    function handleAnswer(selectedAnswerId) {
        const selectedLetter = selectedAnswerId.replace('answer', '').trim().toUpperCase();
        const correct = correctAnswer.trim().toUpperCase();

        if (selectedLetter === correct) {
            alert("¡Correcto!");
            const level = questions[currentIndex].difficulty;
            prize += getPrizeForLevel(level);
            accumulatedPrizeElement.textContent = prize;
            currentIndex++;

            if (currentIndex >= questions.length) {
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
            const response = await fetch('/api/submit_scores.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ user_id: parseInt(user_id), score: finalScore })
            });

            const text = await response.text();
            console.log("Respuesta del servidor:", text);

            const result = JSON.parse(text);
            if (result.status === 'success') {
                window.location.href = "result.html";
            } else {
                alert(result.message || "Error al guardar puntuación.");
            }
        } catch (error) {
            alert("Error al guardar puntuación.");
            console.error(error);
        }
    }

    document.querySelectorAll('.answer-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            handleAnswer(btn.id);
        });
    });

    loadAllQuestions();
});
