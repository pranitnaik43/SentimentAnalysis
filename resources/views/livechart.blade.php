<?php 
use \App\Http\Controllers\TweetsController;
?>
<html>
    <head>
    <title>Live</title>
    <script>
        // $(".panel-body").load(function() {
        //     new get_fb();
        //     });
        function get_fb(){
        var feedback = $.ajax({//Ajax
                                type: "GET",
                                url: 'updateJSON',
                                dataType: 'json',
                                data: {_token: '{!! csrf_token() !!}'},
                                }).responseText;//end of ajax
        }
        
    </script>

    </head>
    <body onload="get_fb()">
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
