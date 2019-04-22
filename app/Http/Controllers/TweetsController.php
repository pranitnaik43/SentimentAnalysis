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
use Storage;
use Illuminate\Console\Scheduling\Schedule;

class TweetsController extends Controller
{
    public $topic_global="trump";
    
    public function getTopic(){
        // $symfony_version = \Symfony\Component\HttpKernel\Kernel::VERSION;
        // return $symfony_version; 
        // version: 4.2.4
        return view('getTopic');
    }

    public function scrape(Request $request){
        $topic_original = $request["topic"];
        $topic = str_replace(' ', '', $topic_original);
        $topic = strtolower($topic);
        
        // $process = new Process('python /path/to/your_script.py');

        $process = new Process('python C:\xampp\htdocs\sentiment\public\scripts\webscrape.py '.$topic);
        $process->run();
        $process->setTimeout(180);
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
        // $chart = Charts::database($users, 'pie', 'highcharts')
        $chart = Charts::create('pie', 'highcharts')
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

    public function getLiveTopic(){
        return view('getLiveTopic');
    }
    
    public function live(Request $request){
        $topic =  $request["topic"];
        // $this->$topic_global = $request["topic"];
        $process = new Process('python C:\xampp\htdocs\sentiment\public\scripts\webstream.py '.$topic);
        $process->start();
        $process->setTimeout(180);
        
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                echo "\nRead from stdout: ".$data;
            } 
            else { // $process::ERR === $type
                echo "\nRead from stderr: ".$data;
            }
            $process->stop(3);
        }
       
        $myfile = fopen("scripts\liveTweets.txt", "a") or die("Unable to open file!");
        $old_str = $data;
        $new_str="";
        $str='';
        $new_str=str_replace("j","",$old_str);
        // echo '<br>';
        // echo "new=".$new_str;
        $old_str = '';
        fwrite($myfile,$new_str);
        fclose($myfile);
        
        return Redirect::action('TweetsController@livechart');
    }
    
    public function livechart(){

        // $chart = Charts::realtime(url('json/values.json'), 2000, 'gauge', 'google')
        // $chart = Charts::realtime(url('json/values.json'), 2000, 'line', 'highcharts')
        //     ->values([65, 0, 100])
        //     ->labels(['First', 'Second', 'Third'])
        //     ->responsive(false)
        //     ->height(300)
        //     ->width(0)
        //     ->title("Twitter")
        //     ->valueName('value'); //This determines the json index for the value
        $chart = Charts::realtime(url('json/values.json'), 2000, 'line', 'highcharts')
            ->elementLabel("Opinion")
            // ->values([65,0,100])
            // ->labels(['First', 'Second', 'Third'])
            ->responsive(false)
            ->height(400)
            ->width(0)
            ->title("Twitter")
            ->maxValues(100)
            ->valueName('value'); //This determines the json index for the value

            return view('livechart')->with('chart',$chart);
    }
    // public function callFunc(){
    //     // return 123;
    //     for($i=0;$i<2;$i++){
    //         TweetsController::live();
    //         // TweetsController::updateJSON();
    //         sleep(30);
    //     }
        
    // }

public function updateJSON(){
    $myfile = fopen("scripts\liveTweets.txt", "r") or die("Unable to open file!");
    if(filesize("scripts\liveTweets.txt")!=0){
        $str = fread($myfile,filesize("scripts\liveTweets.txt"));
        fclose($myfile);
        file_put_contents("scripts\liveTweets.txt", "");    //clear the file after reading sentiments
        $str=str_replace("\n","",$str);
        $str=str_replace("\r","",$str);
        // echo $str;
        $str2 = explode(" ", $str);
        
        $myfile2 = fopen("scripts\checkTweets.txt", "a") or die("Unable to open file!");    //store the sentiments in this file for checking
        $str3=implode(" ",$str2);
        // echo "<script>console.log( 'Debug Objects: " . $str3 . "' );</script>";
        fwrite($myfile2,$str3);
        fwrite($myfile2,"/n/n/n");
        fclose($myfile2);
        
        // return $str2;
        foreach($str2 as $word){
            // echo $word;
            $myJSON = fopen("json/values.json", "r") or die("Unable to open file!");
            $contents = fread($myJSON,filesize("json/values.json"));
            fclose($myJSON);
            // $contents = Storage::disk('chartJSON')->get('values.json');
            $data = json_decode($contents,true); 
            // return $data['value'];
            $val = $data['value'];
            echo "<script>console.log( 'Debug Objects: " . $val . "' );</script>";
            if($word == 'pos'){
                $val=$val+1;
            }
            else if($word == 'neg'){
                $val=$val-1;
            }
            // echo "<script>console.log( 'Debug Objects: " . $val . "' );</script>";
            // echo "<script type='text/javascript'>alert('update done');</script>";
            $data['value'] = $val;
            $content = json_encode($data,true);
            // Storage::disk('chartJSON')->put('values.json', $content);      //store json(write original file)
            $myJSON = fopen("json/values.json", "w") or die("Unable to open file!");
            fwrite($myJSON,$content);
            fclose($myJSON);
            sleep(2);   //Important(do not delete)
        }
    }     
}

public function live2(){
    return $this->$topic_global;
    $topic =  $this->$topic_global;
    $process = new Process('python C:\xampp\htdocs\sentiment\public\scripts\webstream.py '.$topic);
    $process->start();
    // $process->setTimeout(75);
    
    foreach ($process as $type => $data) {
        if ($process::OUT === $type) {
            echo "\nRead from stdout: ".$data;
        } 
        else { // $process::ERR === $type
            echo "\nRead from stderr: ".$data;
        }
        $process->stop(3);
    }
   
    $myfile = fopen("scripts\liveTweets.txt", "a") or die("Unable to open file!");
    $old_str = $data;
    $new_str="";
    $str='';
    $new_str=str_replace("j","",$old_str);
    // echo '<br>';
    // echo "new=".$new_str;
    $old_str = '';
    fwrite($myfile,$new_str);
    fclose($myfile);
}
// public static function updateJSON(){
//     $myfile = fopen("json/values.json", "r") or die("Unable to open file!");
//     $contents = fread($myJSON,filesize("json/values.json"));
//         $myJSON = fopen("json/values.json", "r") or die("Unable to open file!");
//         $contents = fread($myJSON,filesize("json/values.json"));
//         fclose($myJSON);
//         // $contents = Storage::disk('chartJSON')->get('values.json');
//         $data = json_decode($contents,true); 
//         // return $data['value'];
//         $val = $data['value'];
//         $val=$val+1;
//         $data['value'] = $val;
//         $content = json_encode($data,true);
//         // Storage::disk('chartJSON')->put('values.json', $content);      //store json(write original file)
//         $myJSON = fopen("json/values.json", "w") or die("Unable to open file!");
//         fwrite($myJSON,$content);
//         fclose($myJSON);
//         sleep(2);
//     }
 

// public function test(){
//     $topic =  'modi';
//     $process = new Process('python C:\xampp\htdocs\sentiment\public\scripts\webstream.py '.$topic);
//     $process->setTimeout(null);
//     // $process->run(function ($type, $buffer) {
//     //     if ('err' === $type) {
//     //         echo 'ERR > '.$buffer;
//     //     } else {
//     //         echo 'OUT > '.$buffer;
//     //     }
//     // });
    
//     $process->start();
//     // $process->setTimeout(75);
//     foreach ($process as $type => $data) {
//         if ($process::OUT === $type) {
//             echo "\nRead from stdout: ".$data;
    
//         } 
//         else { // $process::ERR === $type
//             echo "\nRead from stderr: ".$data;
//         }
//         // $process->stop(3);
//     }
// }

}