@extends('layouts.main')

@section('title', $diary->title ?? 'My Diary')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $diary->title }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&family=Patrick+Hand&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/diary-show.css') }}">
</head>

<body>
    <header class="cute-header">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="brand">🍓 Cottage Diary</h1>
            <a href="{{ route('diary.index') }}" class="back-btn">← Back</a>
        </div>
    </header>

    <main class="content container">
        <div class="recipe-header text-center mb-4">
            <h2>{{ $diary->title }}</h2>
            <p class="author">By <strong>{{ $diary->user->name }}</strong></p>
            <p class="meta">💪 Difficulty: <b>{{ ucfirst($diary->difficulty) }}</b> • ⏰ {{ $diary->make_time }} mins</p>
        </div>

        <div class="column g-4">
            <div class="col-lg-5">
                <section class="ingredients box">
                    <h4>🧺 Ingredients</h4>
                    <ul class="list-unstyled mt-3">
                        @foreach(explode("\n", $diary->ingredients) as $item)
                            <li>
                                <input type="checkbox" id="ing-{{ $loop->index }}" class="ingredient-check">
                                <label for="ing-{{ $loop->index }}">{{ $item }}</label>
                            </li>
                        @endforeach
                    </ul>
                </section>

                @if($diary->note)
                <section class="note box mt-4">
                    <h4>🌷 Note</h4>
                    <p>{{ $diary->note }}</p>
                </section>
                @endif
            </div>

            <div class="col-lg-7 mt-4">
                <section class="directions box">
                    <h4>🍰 Directions</h4>

                    <div class="direction-cards">
                        @foreach($diary->directions as $step)
                        <div class="direction-card" data-step="{{ $loop->iteration }}">
                            <div class="step-header">
                                <!-- <span class="emoji">{{ ['😀','😋','🍳','🧁','🌸'][$loop->index % 5] }}</span> -->
                                <span class="step-count">Step {{ $loop->iteration }}/{{ count($diary->directions) }}</span>
                                <span class="checkmark">✔</span>
                            </div>
                            <p class="step-text">{{ $step->description }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="progress-container">
                        <p class="progress-text"><span id="progressPercent">0%</span> Complete</p>
                        <div class="progress">
                            <div class="progress-bar" id="progressBar"></div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </main>

    <script>
        const cards = document.querySelectorAll('.direction-card');
        const progressBar = document.getElementById('progressBar');
        const progressPercent = document.getElementById('progressPercent');
        const diaryId = {{ $diary->id }};
        const csrf = '{{ csrf_token() }}';

        // Load saved progress from Laravel session (if available)
        let saved = @json(session("diary_progress_" . $diary->id, []));
        cards.forEach((card, i) => {
            if (saved[i]) card.classList.add('done');
        });

        function updateProgress() {
            const done = document.querySelectorAll('.direction-card.done').length;
            const total = cards.length;
            const percent = total ? Math.round((done / total) * 100) : 0;
            progressBar.style.width = percent + '%';
            progressPercent.textContent = percent + '%';

            const progress = Array.from(cards).map(c => c.classList.contains('done'));
            fetch(`/diary/progress/${diaryId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ progress })
            });
        }

        cards.forEach(card => {
            card.addEventListener('click', () => {
                card.classList.toggle('done');
                updateProgress();
            });
        });

        updateProgress();
        </script>

</body>
</html>
@endsection
