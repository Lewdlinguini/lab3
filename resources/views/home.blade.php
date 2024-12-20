@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Welcome!') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are now logged in') }}

                    <hr>
                    <h3>Guess the Book Title</h3>
                    <p>Try to guess the correct title from the scrambled letters. You have 10 questions!</p>

                    <div id="game">
                        <p><strong>Scrambled Title:</strong> <span id="scrambled-title"></span></p>
                        <input type="text" id="user-guess" class="form-control" placeholder="Your guess here">
                        <button id="check-answer" class="btn btn-primary mt-3">Check Answer</button>
                        <p id="result-message" class="mt-3"></p>
                        <p><strong>Score:</strong> <span id="score">0</span> / 10</p>
                        <p><strong>Question:</strong> <span id="question-number">1</span> / 10</p>
                    </div>

                    <div id="final-score" style="display: none;">
                        <h4>Game Over!</h4>
                        <p>Your final score is: <strong><span id="final-score-value"></span> / 10</strong></p>
                        <button id="restart-game" class="btn btn-secondary">Play Again</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // List of scrambled titles and correct answers
        const questions = [
            { scrambled: "mTeh GoFritlHgea", answer: "The Fright Gala" },
            { scrambled: "kMiob Lla", answer: "Moby All" },
            { scrambled: "rHya Ptopter", answer: "Harry Potter" },
            { scrambled: "hTe LoRsd fo eht Rgnsi", answer: "The Lords of the Rings" },
            { scrambled: "rDcaalu", answer: "Dracula" },
            { scrambled: "kTleilgnhcooMko aBbdir", answer: "To Kill a Mockingbird" },
            { scrambled: "Pdrie nad Prejcuide", answer: "Pride and Prejudice" },
            { scrambled: "tChaa siFrreo", answer: "Catch a Fire" },
            { scrambled: "reigS ouf lRionS", answer: "Rise of Lions" },
            { scrambled: "oXeh rTtAhBte", answer: "The Box Theater" }
        ];

        let score = 0;
        let currentQuestionIndex = 0;
        const totalQuestions = 10;

        // Shuffle questions and pick 10 randomly
        const shuffledQuestions = questions.sort(() => Math.random() - 0.5).slice(0, totalQuestions);

        const scrambledTitleElement = document.getElementById('scrambled-title');
        const userGuessElement = document.getElementById('user-guess');
        const resultMessageElement = document.getElementById('result-message');
        const scoreElement = document.getElementById('score');
        const questionNumberElement = document.getElementById('question-number');
        const finalScoreElement = document.getElementById('final-score');
        const finalScoreValueElement = document.getElementById('final-score-value');
        const restartGameButton = document.getElementById('restart-game');
        const checkAnswerButton = document.getElementById('check-answer');

        function loadNextQuestion() {
            if (currentQuestionIndex < totalQuestions) {
                scrambledTitleElement.textContent = shuffledQuestions[currentQuestionIndex].scrambled;
                userGuessElement.value = '';
                resultMessageElement.textContent = '';
                questionNumberElement.textContent = currentQuestionIndex + 1;
            } else {
                endGame();
            }
        }

        function endGame() {
            document.getElementById('game').style.display = 'none';
            finalScoreElement.style.display = 'block';
            finalScoreValueElement.textContent = score;
        }

        function restartGame() {
            score = 0;
            currentQuestionIndex = 0;
            document.getElementById('game').style.display = 'block';
            finalScoreElement.style.display = 'none';
            scoreElement.textContent = score;
            loadNextQuestion();
        }

        checkAnswerButton.addEventListener('click', function () {
            const userGuess = userGuessElement.value.trim();

            if (userGuess.toLowerCase() === shuffledQuestions[currentQuestionIndex].answer.toLowerCase()) {
                resultMessageElement.textContent = "🎉 Correct! Great job!";
                resultMessageElement.style.color = "green";
                score++;
                scoreElement.textContent = score;
            } else {
                resultMessageElement.textContent = "❌ Incorrect. The correct answer was: " + shuffledQuestions[currentQuestionIndex].answer;
                resultMessageElement.style.color = "red";
            }

            currentQuestionIndex++;
            setTimeout(loadNextQuestion, 2000); // Delay before showing the next question
        });

        restartGameButton.addEventListener('click', restartGame);

        // Start the game
        loadNextQuestion();
    });
</script>
@endsection