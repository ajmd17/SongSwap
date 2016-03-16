<?php 
include "sqlconnect.php";

function loadFromDatabase()
{
	$query = mysql_query("SELECT * FROM links"); 
	echo "<div class=\"head\">";
	while ($row = mysql_fetch_array($query)) 
	{
		$submitter = "Anonymous";
		if ($row[3])
		{
			$submitter = $row[3];
		}
		
		if ($row['platform'])
		{
			if ($row['platform'] == 'youtube')
			{
				if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $row[1], $match)) 
				{
					$video_id = $match[1];
					echo "<div class=\"col-sm-4 thumb\" style=\"max-width: 300px; max-height: 300px; min-width: 250px; min-height: 250px;\"> <div class=\"tableView\"> <img src=\"http://img.youtube.com/vi/" . $video_id . "/0.jpg\" onclick=\"window.alert('Hello world!');\" style=\"width: 100%; height: 100%;\">"; // thumbnail
					
					
					/*echo "<div class=\"col-lg-2 col-md-4 col-xs-6 thumb\"> <div class=\"tableView\"> <iframe width=\"200\" height=\"150\" src=\"http://youtube.com/embed/" . $video_id . "\" frameborder=\"0\" allowfullscreen></iframe><br>";*/

					echo "Submitted by: " . $submitter . "";
					
					echo " </div>";
					echo "</div>";
				}
			}
			elseif ($row['platform'] == 'soundcloud')
			{
				$video_id = $match[1];
					echo "<div class=\"col-sm-4 thumb\" style=\"max-width: 300px; max-height: 300px; min-width: 250px; min-height: 250px;\"> <div class=\"tableView\"> Soundcloud Clip";
					
					echo "Submitted by: " . $submitter . "";
					
					echo " </div>";
					echo "</div>";
			}
		}
	}
	echo "</div>";
}

loadFromDatabase();

?>