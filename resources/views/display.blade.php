<html>
    <body>
        <div class="tweet-text">
        </div>
        <?php
		$output = shell_exec("python C:\xampp\htdocs\sentiment\public\scripts\scrape.py");
		echo $output;
?>

    </body>
</html>
