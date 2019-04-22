<?php 
use \App\Http\Controllers\TweetsController;
?>
<html>
    <head>
    <link href = "{{ asset('css/page.css') }}" rel="stylesheet">
    <title>Live</title>
    <script>
        function perform(){
            new updateVal();
            new getSentiment();
            // alert("hi");
            
        }
        // setInterval(function(){ alert("Hello"); }, 3000);
        // setInterval(new perform(), 3000);
        // setInterval(function(){ alert("Hello"); }, 3000);
        // window.setTimeout(function(){
        //     new updateVal();
        // }, 5000);

        function updateVal(){
            // alert("update val");
            var feedback = $.ajax({//Ajax
                                type: "GET",
                                url: 'updateJSON',
                                dataType: 'json',
                                data: {_token: '{!! csrf_token() !!}'},
                                success: function(){
                                    // alert("updated");
                                },

                            // complete: function() {
                            //     alert("updated");
                            // // Schedule the next request when the current one's complete
                            // }
                                }).responseText;//end of ajax
        // setInterval(new updateVal(), 10000);
        }
        function getSentiment(){
            // alert("get sentiments");
            var feedback = $.ajax({//Ajax
                                type: "GET",
                                url: 'live2',
                                dataType: 'json',
                                data: {_token: '{!! csrf_token() !!}'},
                                success:function() {
                                // alert("got sentiments");
                            },
                        }).responseText;//end of ajax
            // var feedback = $.ajax({//Ajax
            //                     type: "POST",
            //                     url: 'live',
            //                     dataType: 'json',
            //                     data: {_token: '{!! csrf_token() !!}'},
            //                     success:function() {
            //                     alert("got sentiments");
            //                 },
            //             }).responseText;//end of ajax
        }
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
