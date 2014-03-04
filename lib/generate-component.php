<?php

define( 'TMP_COMPONENT', '../tmp/component' );
define( 'INDEX_HTML', '<html><body bgcolor="#FFFFFF"></body></html>' );

require_once( 'hzip.php' );


/**
 * Delete files recursively.
 * 
 * @param $str 	File or folder path.
 */
function recursiveDelete( $str )
{
    if( is_file($str) ) return @unlink($str);

    elseif( is_dir($str) )
    {
        $scan = glob(rtrim($str,'/').'/*');
        
        foreach( $scan as $index => $path ) recursiveDelete( $path );

        return @rmdir($str);
    }
}


/**
 * Creates the component's files and folders structure.
 */
function createComponentStructure()
{
	global $component_info;

	// Clear previous temp files.
	recursiveDelete( TMP_COMPONENT );
	
	// Create temp folder.
	@mkdir( TMP_COMPONENT );

	// Create main XML file.
	file_put_contents( TMP_COMPONENT . '/' . $component_info['slug'] . '.xml', generateXMLFileContents() );

	// Create the necessary folders.
	@mkdir( TMP_COMPONENT . '/site' );
	@mkdir( TMP_COMPONENT . '/admin' );

	// Create an empty index.html file inside all folders.
	createEmptyIndexHtml( TMP_COMPONENT );

	// Remove unnecessary index.html file inside root folder.
	unlink( TMP_COMPONENT . '/index.html' );
}


/**
 * Generates the component's main XML file.
 */
function generateXMLFileContents()
{
	global $component_info;

	$content = '';

	$content .= indentString( '<?xml version="1.0" encoding="utf-8"?>' );
	$content .= indentString( '<extension type="component" version="3.1" method="upgrade">' );
	
	// Basic info.
	$content .= indentString( '<name>' . $component_info['name'] . '</name>', 1 );
	$content .= indentString( '<creationDate>' . $component_info['creation_date'] . '</creationDate>', 1 );
	$content .= indentString( '<author>' . $component_info['author'] . '</author>', 1 );
	$content .= indentString( '<authorEmail>' . $component_info['author_email'] . '</authorEmail>', 1 );
	$content .= indentString( '<authorUrl>' . $component_info['author_url'] . '</authorUrl>', 1 );
	$content .= indentString( '<copyright>' . $component_info['copyright'] . '</copyright>', 1 );
	$content .= indentString( '<license>' . $component_info['license'] . '</license>', 1 );
	$content .= indentString( '<version>' . $component_info['version'] . '</version>', 1 );
	$content .= indentString( '<description>' . $component_info['description'] . '</description>', 1 );

	// Site folder structure.
	$content .= indentString( '<files folder="site">', 1 );
	$content .= indentString( '<filename>index.html</filename>', 2 );
	$content .= indentString( '<filename>' . $component_info['slug'] . '.php</filename>', 2 );
	$content .= indentString( '</files>', 1 );

	// Administration structure.
	$content .= indentString( '<administration>', 1 );
	$content .= indentString( '<menu>' . $component_info['name'] . '</menu>', 2 );
	$content .= indentString( '<files folder="admin">', 2 );
	$content .= indentString( '<filename>index.html</filename>', 3 );
	$content .= indentString( '<filename>' . $component_info['slug'] . '.php</filename>', 3 );
	$content .= indentString( '<folder>sql</folder>', 3 );
	$content .= indentString( '</files>', 2 );
	$content .= indentString( '</administration>', 1 );
	
	$content .= indentString( '</extension>' );

	return $content;
}


/** 
 * Indents a string and adds a break line at the end.
 * 
 * @param $str 		The string that has to be indented.
 * @param $num_tabs	Amount of tabs to add.
 *
 * @return Indented string with a line-break at the end.
 */
function indentString( $str, $num_tabs = 0 )
{
	$tabs = "";

	for ( $i = 0; $i < $num_tabs; $i++ ) $tabs .= "\t";

	return $tabs . $str . "\r\n";
}


/**
 * Checks if the user didn't send any info.
 */
function checkInfo()
{
	global $component_info;

	$missing_info = array();

	foreach ( $component_info as $key => $value )
	{
		if ( $value == '' ) $missing_info[] = $key;
	}

	return implode(', ', $missing_info);
}


/**
 * Creates and empty index.html file inside all folders recursively, given a path.
 * If it's a file, not happens. Otherwise, an empty index.html is created and the recursion is called.
 * 
 * @param $str 		File or folder path.
 */
function createEmptyIndexHtml( $str )
{
	if ( !is_dir($str) ) return;

	file_put_contents( $str . '/index.html', INDEX_HTML );
	
    $scan = glob(rtrim($str,'/').'/*');
    
    foreach( $scan as $index => $path ) createEmptyIndexHtml( $path );
}


/**
 * Sends JSON response and quit running.
 */
function sendResponse( $success, $message )
{
	echo json_encode( array( 'success' => $success, 'message' => $message ) );
	exit();
}


global $component_info;
$component_info = array();

// First we collect all posted data.
$component_info['name'] 			= isset( $_POST['name'] ) ? trim( $_POST['name'] ) : '';
$component_info['slug'] 			= strtolower( str_replace(' ', '_', $component_info['name'] ) );
$component_info['author'] 			= isset( $_POST['author'] ) ? trim( $_POST['author'] ) : '';
$component_info['author_email'] 	= isset( $_POST['author_email'] ) ? trim( $_POST['author_email'] ) : '';
$component_info['author_url'] 		= isset( $_POST['author_url'] ) ? trim( $_POST['author_url'] ) : '';
$component_info['creation_date'] 	= isset( $_POST['creation_date'] ) ? trim( $_POST['creation_date'] ) : '';
$component_info['copyright'] 		= isset( $_POST['copyright'] ) ? trim( $_POST['copyright'] ) : '';
$component_info['license'] 			= isset( $_POST['license'] ) ? trim( $_POST['license'] ) : '';
$component_info['version'] 			= isset( $_POST['version'] ) ? trim( $_POST['version'] ) : '';
$component_info['description'] 		= isset( $_POST['description'] ) ? trim( $_POST['description'] ) : '';

// Check if the user didn't send any info.
$missing_info = checkInfo();

if ( $missing_info != '' )
{
	sendResponse( 0, 'There are some fields missing: ' . $missing_info );
}

// Create all the files and folders of the component.
createComponentStructure();

// Generate .zip file.
HZip::zipDir( TMP_COMPONENT, '../tmp/component.zip' );

sendResponse( 1, 'Component created! <a href="tmp/component.zip">Download</a>.' );

?>