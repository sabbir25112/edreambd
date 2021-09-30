@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>Exam Hall of {{ $exam->name }}</h3>
                            </div>
                            <div class="col-md-2">
                                <p id="demo"></p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @foreach($unanswered_question as $index => $question)
                            <div class="container mt-sm-5 my-1" id="question_{{$index}}" style="@if ($index != 0) display: none; @endif">
                                <div class="question ml-sm-5 pl-sm-5 pt-2">
                                    <div class="py-2 h5">
                                        <b>Q. {{ $question->question->question }}</b>
                                    </div>
                                    <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">
                                        <label class="options">
                                            <input type="radio" name="question_{{$question->id}}" value="1"> <span class="checkmark"></span>
                                            {{ $question->question->option_1 }}
                                        </label>
                                        <br>
                                        <label class="options">
                                            <input type="radio" name="question_{{$question->id}}" value="2"> <span class="checkmark"></span>
                                            {{ $question->question->option_2 }}
                                        </label>
                                        <br>
                                        <label class="options">
                                            <input type="radio" name="question_{{$question->id}}" value="3"> <span class="checkmark"></span>
                                            {{ $question->question->option_3 }}
                                        </label>
                                        <br>
                                        <label class="options">
                                            <input type="radio" name="question_{{$question->id}}" value="4"> <span class="checkmark"></span>
                                            {{ $question->question->option_4 }}
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center pt-3">
                                    <div class="ml-auto mr-sm-5">
                                        <button class="btn btn-success" onclick="processAnswer('{{ $question->id }}', '{{ $index }}')">Submit and Get Next Question</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var max_index = Number('{{ $unanswered_question->count() - 1 }}');
        var finish_url = '{{ $finish_url }}';
        var answer_submit_url = "{{ route('classroom.exam.answer.submit', $exam->id) }}";
        console.log(answer_submit_url);
        document.addEventListener("DOMContentLoaded", function() {

        });

        function processAnswer(question_id, index)
        {
            var answer = $('input[name="question_' + question_id +'"]:checked').val();
            if (answer == undefined) {
                var is_skip = confirm("Do you really want to skip this question?");
                if (is_skip) {
                    showNextQuestion(index);
                    return ;
                }
                return ;
            } else {
                $.ajax({
                    'url': answer_submit_url,
                    'data' : {
                        'exam_sheet_id' : question_id,
                        'answer'        : answer
                    }
                });

                showNextQuestion(index);

                return ;
            }
        }

        function showNextQuestion(index)
        {
            $('#question_' + index).hide();
            var next_index = Number(index) + 1;
            if (next_index > max_index) {
                window.location.href = finish_url;
            }
            $('#question_' + next_index).show();
        }

        // Set the date we're counting down to
        var countDownDate = new Date("{{ $exam->end_time }}").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("demo").innerHTML = hours + "h "
            + minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                alert("time is expired");
                document.getElementById("demo").innerHTML = "EXPIRED";
                window.location.href = finish_url;
            }
        }, 1000);
    </script>
@endsection

