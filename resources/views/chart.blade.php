<html>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
        
                        <div class="panel-body">
                            {!! $chart->html() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Charts::scripts() !!}
        {!! $chart->script() !!}
    </body>
</html>