<?php
// a_local_file.php


ob_start();
Header("content-type: application/javascript");
ob_end_flush();
require __DIR__.'/../../vendor/autoload.php';
// $settings = \Illuminate\Support\Facades\DB::table('settings');
// $title = $settings->where('key', 'chatbot.chat_title')->first()->value;
$servername = env("DB_HOST");
$username = 'root';
$password = '';
$dbname = 'laravel';

$conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//   \Log::info("Connection failed: " . $conn->connect_error);
// }
$sql = "SELECT * FROM settings";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $arr[] = $row;
    if($row['key'] == 'chatbot.chat_title' ) $title = $row['value'];
    if($row['key'] == 'chatbot.chat_intro_message' ) $intro = $row['value'];
    if($row['key'] == 'chatbot.placeholder_text' ) $placeText = $row['value'];


  }
} else {
  echo "0 results";
}
$conn->close();

echo '
            alert("Hello");
            console.log("Ok");
            var botmanWidget = {
            frameEndpoint: "chat.html",
            aboutLink: "https://teamprodev.com",
	        aboutText: "Powered By TEAMPRO",
            introMessage: "'.$intro.'",
			title: "'. strval($title).'",
			placeholderText: "'.$placeText.'"
	    };
        ';
        $image = "https://dzbc.org/wp-content/uploads/data/2018/2/19/Background.max-x-PIC-MCH043354.jpg";
echo ' t = document.getElementById("messageArea");
        t.style.backgroundImage = url("'.$image.'");
        ';
?>