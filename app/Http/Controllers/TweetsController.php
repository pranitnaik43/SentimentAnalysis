<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
//====<for running python script>===============
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
//====</for running python script>===============

//====<charts>===============
use Charts;
use App\Test;
use DB;
//====</charts>===============


class TweetsController extends Controller
{
    public function getTopic(){
        return view('getTopic');
    }

    public function display(Request $request){
        $topic_original = $request["topic"];
        $topic = str_replace(' ', '', $topic_original);
        $topic = strtolower($topic);
        
        // $process = new Process('python /path/to/your_script.py');

        $process = new Process('python C:\xampp\htdocs\sentiment\public\scripts\webscrape.py '.$topic);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // return var_dump($process->getOutput());
        $sentiment = $process->getOutput();
        return Redirect::action('TweetsController@index', array("sentiment"=>$sentiment, 'topic'=>$topic_original));
    }
    
    public function index($sentiment, $topic)
    {
        // return $data;
        // $myfile = fopen("scripts\scrapedTweetsSentiments.txt", "r") or die("Unable to open file!");
        // $data = fread($myfile,filesize("scripts\scrapedTweetsSentiments.txt"));
        
        $pos = substr_count($sentiment, "pos");
        $neg = substr_count($sentiment, "neg");
        // fclose($myfile);
        $users = Test::all();
        // return $users;
        $chart = Charts::database($users, 'pie', 'highcharts')
			      ->title($topic)
                //   ->elementLabel("Sentiment")
                  ->labels(['positive', 'negative'])
                  ->values([$pos, $neg])
                  ->colors(['#00ff00','#ff0000'])
			      ->dimensions(800, 500)
			      ->responsive(false);
			    //   ->groupByMonth(date('Y'), true);
        return view('chart')->with('chart',$chart);
    }
    public function live(){
        // $process = new Process('python C:\xampp\htdocs\sentiment\public\scripts\stream.py');
        // $process->run();
        // // executes after the command finishes
        // if (!$process->isSuccessful()) {
        //     throw new ProcessFailedException($process);
        // }

        // // return var_dump($process->getOutput());
        // $sentiment = $process->getOutput();
        // return $sentiment;

        $process = new Process('python C:\xampp\htdocs\sentiment\public\scripts\webstream.py');
        $process->start();
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                echo "\nRead from stdout: ".$data;
            } else { // $process::ERR === $type
                echo "\nRead from stderr: ".$data;
            }
        }
    }
}

