<?php

header('Content-type: image/png');



function drawRadarGraph($img, $x, $y, $radius, $radius2, $sides, $color, $text, $ability)
{
	//arrays to hold the points that will lead to drawing each polygon
    $insidePoints = array();
	$outsidePoints = array();
	$dataPoints = array();
	
	$white = ImageColorAllocate($img, 255, 255, 255); 
	ImageFillToBorder($img, 0, 0, $white, $white);
	
	
    $counter = 0;
	// Finds points to be used with graph
	for($a = 0;$a < 360; $a += 360/$sides)
    {
		//finds the points to fill out graph
        $dataPoints[] = $x + $radius * (cos(deg2rad($a)) * ($ability[$counter] / 100));
        $dataPoints[] = $y + $radius * (sin(deg2rad($a)) * ($ability[$counter++] / 100));
		
		
		
	}
	
	//draws the polygon used to show data in the graph
	imagefilledpolygon($img,$dataPoints,$sides,0xFF9F33);
	
	//draws a polygon used to store the graph
    for($a = 0;$a < 360; $a += 360/$sides)
    {
		//marks points to be used within first polygon
        $insidePoints[] = $x + $radius * cos(deg2rad($a));
        $insidePoints[] = $y + $radius * sin(deg2rad($a));
		end($insidePoints);
		imageline($img, $x, $y, prev($insidePoints), end($insidePoints), 0x000000);
		
		//draws small circles on each line
		imagefilledellipse($img,$x + $radius * cos(deg2rad($a)) * .1, $y + $radius * sin(deg2rad($a)) * .1, 4, 4, 0x000000);
		imagefilledellipse($img,$x + $radius * cos(deg2rad($a)) * .2, $y + $radius * sin(deg2rad($a)) * .2, 4, 4, 0x000000);
		imagefilledellipse($img,$x + $radius * cos(deg2rad($a)) * .3, $y + $radius * sin(deg2rad($a)) * .3, 4, 4, 0x000000);
		imagefilledellipse($img,$x + $radius * cos(deg2rad($a)) * .4, $y + $radius * sin(deg2rad($a)) * .4, 4, 4, 0x000000);
		imagefilledellipse($img,$x + $radius * cos(deg2rad($a)) * .5, $y + $radius * sin(deg2rad($a)) * .5, 4, 4, 0x000000);
		imagefilledellipse($img,$x + $radius * cos(deg2rad($a)) * .6, $y + $radius * sin(deg2rad($a)) * .6, 4, 4, 0x000000);
		imagefilledellipse($img,$x + $radius * cos(deg2rad($a)) * .7, $y + $radius * sin(deg2rad($a)) * .7, 4, 4, 0x000000);
		imagefilledellipse($img,$x + $radius * cos(deg2rad($a)) * .8, $y + $radius * sin(deg2rad($a)) * .8, 4, 4, 0x000000);
		imagefilledellipse($img,$x + $radius * cos(deg2rad($a)) * .9, $y + $radius * sin(deg2rad($a)) * .9, 4, 4, 0x000000);
		
    }
	$counter = 0;
	
	//draws a outer polygon with n sides
	for($a = 0;$a < 360; $a += 360/$sides)
    {
        $outsidePoints[] = $x + $radius2 * cos(deg2rad($a) );
        $outsidePoints[] = $y + $radius2 * sin(deg2rad($a) );
		end($outsidePoints);
		
		//draw circles and stores text with them
		imagefilledellipse($img, prev($outsidePoints), end($outsidePoints), 200, 200, 0xFF9F33);
		imagettftext($img,16,0,prev($outsidePoints) - 75 ,end($outsidePoints) + 10 ,0x000000,"a.TTF",$text[$counter]);
		$counter = $counter + 1;
		
	}
	
	//draws the 2 polygons as holders for the radar graph
	imagepolygon($img,$insidePoints,$sides,$color);
	imagepolygon($img,$outsidePoints,$sides,0xFF9F33);
	
   
	
}
//canvas for image
$img = imagecreatetruecolor(800,800);
//smoothes out line
ImageAntiAlias($img, true);

//arrays to hold data being passed into function
define('size', 8);
$programs = new SplFixedArray(size);
$programs = array('php','c++','HTML','css','C#','asp.net','javascript','java');
$proficiency = new SplFixedArray(size);
$proficiency = array(50,80,90,90,40,70,90,70);
drawRadarGraph($img,800/2,800/2,200, 300,size,0x000000, $programs, $proficiency);


imagepng($img);
imagedestroy($img);
?>