<?php
$server_url = "server/mail_server.php";

$filenames =  array();
foreach($_FILES as $files){
    $filenames[iconv("Encoding","Encoding",$files['name'])] = $files['tmp_name'];
}

//$filenames looks like
//$filenames = array(iconv("Encoding","Encoding",$_FILES['first_file']['name']) => $_FILES['fisrt_file']['tmp_name'], iconv("UTF-8","EUC-KR",$_FILES['second_file']['name']) => $_FILES['second_file']['tmp_name']);

$files2 = array();
foreach( $filenames as $k=> $f){
    if($f == '') continue;
    //get stream of file
	$files2[$k] = file_get_contents($f);
} 

$params = array(
    'to' => 'send email',
    'subject' =>  "subject",
    'content' => "content",
);

// CURL to MailServer
$m = curl_init();

//make boundary about multipart form
$boundary = uniqid("somthing unique");
$delemiter = '-------------' . $boundary;

//make multipart data form
$post_data = build_data_files($boundary, $params,$files2);

curl_setopt($m, CURLOPT_URL, $server_url);
curl_setopt($m, CURLOPT_POST, 1);
curl_setopt($m, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($m, CURLOPT_TIMEOUT, 60);
curl_setopt($m, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($m, CURLOPT_RETURNTRANSFER, true);
curl_setopt($m, CURLOPT_HTTPHEADER , array(
"Content-Type: multipart/form-data; boundary=" . $delemiter,
"Content-Length: " . strlen($post_data)
));
$result = curl_exec($m);

curl_close($m);

//get data to distinguish between file and not file
function build_data_files($boundary, $fields, $files){
    $data = '';
    $eol = "\r\n";

    $delimiter = '-------------' . $boundary;

    foreach ($fields as $name => $content) {
        $data .= "--" . $delimiter . $eol
            . 'Content-Disposition: form-data; name="' . $name . "\"".$eol.$eol
            . $content . $eol;
    }
    foreach ($files as $name => $content) {
        $data .= "--" . $delimiter . $eol
            . 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $name . '"' . $eol
            //. 'Content-Type: image/png'.$eol
            . 'Content-Transfer-Encoding: binary'.$eol
            ;

        $data .= $eol;
        $data .= $content . $eol;
    }
    $data .= "--" . $delimiter . "--".$eol;


    return $data;
}
