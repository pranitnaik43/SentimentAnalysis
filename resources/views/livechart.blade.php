<?php 
use \App\Http\Controllers\TweetsController;
?>
<html>
    <head>
    <title>Live</title>
    <script>
        function perform(){
            // new getSentiment();
            // // alert("hi");
            new updateVal();
        }
        // function perform(){
        //     window.setInterval(function(){
        //         new getSentiment();
        //         window.setTimeout(function(){
        //             new updateVal();
        //         }, 5000);
        //     }, 1000);
        // }

        function updateVal(){
        var feedback = $.ajax({//Ajax
                                type: "GET",
                                url: 'updateJSON',
                                dataType: 'json',
                                data: {_token: '{!! csrf_token() !!}'},
                                }).responseText;//end of ajax
        }
        function getSentiment(){
        var feedback = $.ajax({//Ajax
                                type: "GET",
                                url: 'callFunc',
                                dataType: 'json',
                                data: {_token: '{!! csrf_token() !!}'},
                                success:function() {
                                console.log("worked");
                            },
                        }).responseText;//end of ajax
        }
        // window.setInterval(function(){
        //     new updateVal();
        // },50000);
    </script>

    </head>
    <body onload="perform()">
    {{-- <body onload="updateVal()"> --}}
    {{-- <body> --}}
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
        
                        <div class="panel-body">
                            {!! $chart->html() !!}
                            {{-- {{ TweetsController::updateJSON() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Charts::scripts() !!}
        {!! $chart->script() !!}

    </body>
</html>
