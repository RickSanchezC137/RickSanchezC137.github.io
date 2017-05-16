<?php

$dir = "files";
// debugging
// $a = scandir(__DIR__ . '/' . $dir);
// print_r($a);

// Run the recursive function 

$response = scan(__DIR__ . '/' . $dir); // pass the full path to the scan function

// This function scans the files folder recursively, and builds a large array

function scan($dir){

	$files = array();

	// Is there actually such a folder/file?

	if(file_exists($dir)){
	
		foreach(scandir($dir) as $f) { // scandir() accepts the full path of the folder to be scanned
		
			if(!$f || $f[0] == '.') {

				// It is a hidden file
				
				continue; 
			}

			if(is_dir($dir . '/' . $f)) {

				// The path is a folder

				$files[] = array(
					"name" => $f,
					"type" => "folder",
					"path" => $dir . '/' . $f,
					"items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
				);
			}
			
			else {

				// It is a file

				$files[] = array(
					"name" => $f,
					"type" => "file",
					"path" => $dir . '/' . $f,
					"size" => filesize($dir . '/' . $f) // Gets the size of this file
				);
			}

		}
	
	}

	return $files;
}

// Output the directory listing as JSON

header('Content-type: application/json');

// debugging
// print_r($response);

echo json_encode(array(
	"name" => basename($dir),
	"type" => "folder",
	"path" => $dir,
	"items" => $response
));

// echo "\n";
