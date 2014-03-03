<?php

define( 'TMP_COMPONENT', '../tmp/component' );


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
        
        foreach( $scan as $index=>$path ) recursiveDelete( $path );

        return @rmdir($str);
    }
}


function createComponentStructure()
{
	@mkdir( TMP_COMPONENT );
}


function generateXMLFileContents()
{
	global $component_info;

	$content = '';

	$content .= '<?xml version="1.0" encoding="utf-8"?>';
	$content .= '<extension type="component" version="3.1" method="upgrade">';
	$content .= '<name>com_' . $component_info['name'] . '</name>';

	return $content;
}


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


function sendResponse( $success, $message )
{
	echo json_encode( array( 'success' => $success, 'message' => $message ) );
	exit();
}


global $component_info;
$component_info = array();

$component_info['name'] = isset( $_POST['name'] ) ? trim( $_POST['name'] ) : '';
$component_info['author'] = isset( $_POST['author'] ) ? trim( $_POST['author'] ) : '';
$component_info['creation_date'] = isset( $_POST['creation_date'] ) ? trim( $_POST['creation_date'] ) : '';

$missing_info = checkInfo();

if ( $missing_info != '' )
{
	sendResponse( 0, 'There are some fields missing: ' . $missing_info );
}

sendResponse( 1, 'Component created! <a href="tmp/component.zip">Download</a>.' );

?>