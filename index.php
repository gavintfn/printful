<?php
session_start();
?>
<html>
    <head>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous" >

    <style>
        .d-ib{
              display:inline-block;
          }
        .d-b{
            display:block;
        }
        .m-a{
            margin:0 auto;
        }
        .w80{
             width:80%;
         }
        .w40{
            width:40%;
        }
        .container-fluid.w80 {
            padding-top: 10%;
        }
        h1 {
            text-align:center ;
        }
        .tac{
            text-align:center;
        }
        .dnone {
            display: none;
        }
        .w50{
            width:50%;
        }
        .w95{
            width:95%;
        }
        .p10{
            padding:10%;
        }
        h4#result {
            text-align: center;
            margin-top: 3%;
        }
        h2#thanks {
            margin-top: 10%;
        }
        .answer_button{
            border:1px solid lightgray;
            border-radius: 7px;
            background-color:linen;
            margin-bottom:5%;
            background-color: #494949;
            color: white;
        }
        .status_bar {
            height: 30px;
            border: 2px solid black;
            border-radius: 19px;
            margin-bottom: 2%;
            overflow:hidden;
        }
        div#status_inner {
            display: block;
            background: green;
            width: 0%;
            float: left;
            height: 100%;
        }
        .p10{
            padding:5%;
        }
        .answers{
            font-size: 1.3em;
            display:block;
            text-align:center;
            padding:10% 0;
        }
        h2{
            text-align:center;
            margin: 0 auto;
        }
        .p05{
            padding: 0 5%;
        }
        .m0a{
            margin:0 auto;
        }
        .27em{
            font_size:2.7em !important;
           }
        .2em{
               font_size:2em !important;
           }
        .15em{
               font_size:1.5em !important;
           }

    </style>
    </head>
<body>
    <div class="container-fluid w80">
        <form id="testform">
            <div id="start" class="d-b m-a">
            <h1 class="tac">So you want a quiz huh?</h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">@</span>
                </div>
                <input id="username" type="text" name="name" class="tac form-control" placeholder="What is you name" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Tests</label>
                </div>
                <select id="select_test"  name='test' class="tac custom-select" id="inputGroupSelect01">
                    <option class="tac">Choose a test</option>
                    <option value="1" class="tac">Test One - Math (duh..duh..duh....)</option>
                    <option value="2" class="tac">Test Two - Band Name Acronyms ( mostly )</option>
                </select>
            </div>
            <div class="d-flex m-a">
                <button id="start_test" type="button" data-action='start' class="btn btn-secondary btn-lg btn-block w40 m-a" disabled>Start Test</button>
            </div>
        </div>
        <div id="test" class="m-a dnone">
            <h1 id="quiz_title"></h1>
            <div class="d-flex">
                <h2 id="question"></h2>
            </div>
            <div id="acontainer" class="d-flex">
                <div class="answer_holders d-ib w50 p05">
                    <div class="d-b answer_button">
                        <span id="answer_0" class="answers"></span>
                    </div>
                    <div class="d-b answer_button">
                        <span id="answer_1" class="answers"></span>
                    </div>
                </div>
                <div class="answer_holders d-ib w50 p05">
                    <div class="d-b answer_button">
                        <span id="answer_3" class="answers"></span>
                    </div>
                    <div class="d-b answer_button">
                        <span id="answer_4" class="answers"></span>
                    </div>
                </div>
                <input type="hidden" name="answer" value="">
            </div>
            <div class="status_bar">
                <div class="status_outer">
                    <div id="status_inner"></div>
                </div>
            </div>
            <div class="d-flex">
                <button id="submit_answer" type="button" data-action='answer' class="m-a btn btn-secondary btn-lg btn-block" disabled>Submit Answer</button>
            </div>
        </div>
            <div id="results" class="m-a dnone">
                <h2 id="thanks"></h2>
                <h4 id="result"></h4>
            </div>





        </form>

    </div>

</body>
<script>
    $(document).ready(function(){
        var sc = screen.width;
        if(sc<980){
          // $('html').width = sc + 'px';
            $('body').addClass('27em');
            $('button').addClass('2em');
            $('h1').addClass('2em');
            $('h2').addClass('15em');
            $('input').addClass('2em');
            $('select').addClass('2em');
            $('.answers').addClass('2em');

            $('#acontainer').removeClass('d-flex');
            $('.answer_holders').removeClass('d-ib');
            $('.answer_holders').removeClass('w50');
            $('.answer_holders').addClass('w95');
            $('.answer_holders').addClass('d-b');
            $('.answer_holders').addClass('m0a');

        }
        $('#username').on('change',function(){
            if($(this).val() !='' && ($('#select_test').val() === "1" || $('#select_test').val() === "2")){
                $('#start_test').prop('disabled',false);
            }else{
                $('#start_test').prop('disabled',true);
            }
        });

        $('#select_test').on('change',function(){
            if(($(this).val() === "1"|| $(this).val() === "2") && $('#username').val() != ''){
                $('#start_test').prop('disabled',false);
            }else{
                $('#start_test').prop('disabled',true);
            }
        });

        function change(data){
            var d = JSON.parse(data);
            var statusperc = ((d.answered_questions/d.total_questions)*100) + "%";
            $('#status_inner').width(statusperc);
            if(d.question == 'test_complete'){
                $('#test').removeClass('d-b');
                $('#test').addClass('dnone');
                $('#results').removeClass('dnone');
                $('#results').addClass('d-b');
                $('#thanks').text('Thanks, '+ d.username);
                $('#result').text('You responded correctly to ' + d.correct + ' out of ' + d.total_questions + ' questions.');
            }else {
                $('.answers').removeClass('alert-success');
                $('#quiz_title').text(d.test_name);
                $('#question').text(d.question.q);
                $('.answers').each(function (index) {
                    $(this).text(d.question.a[index]);
                });
            }




        }
        $('.answers').on('click',function(){
            $('.answers').removeClass('alert-success');
            $(this).addClass('alert-success');
            $('#submit_answer').prop('disabled',false);
        });

        $('button').each(function(){

            var input = [];
            var $this = $(this);
            $this.on('click',function(){
                var formData;
                formData = new FormData();
                formData.append("action", $(this).data('action'));
                $('input').each(function() {
                    var k = $(this).prop('name');
                    formData.append(k,$(this).val());
                });
                $('select').each(function() {
                    var k = $(this).prop('name');
                    formData.append(k,$(this).val());
                });
                var request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Typical action to be performed when the document is ready:
                         change(request.responseText);
                    }
                };
                request.open("POST", "quiz.php");
                request.send(formData);
                if($(this).data('action') == 'start'){
                    $('#start').addClass('dnone');
                    $('#test').removeClass('dnone');
                    $('#test').addClass('d-b');

                }


            });


        });

    });
</script>
</html>

