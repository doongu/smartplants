<?php
    
header("Content-Type: application/json; charset=utf-8");
$raw_post_data = file_get_contents( "php://input" );
// $data = json_decode( $raw_post_data, true ); // array
$data = json_decode( $raw_post_data ); // stdClass Object
$user_key = $data->user_key;
$text = $data->content;
//얘내는 위쪽에 몰아둬야함


$mysqli = mysqli_connect('52.14.18.3','root','rlflsdPrh12', 'test2');

mysqli_select_db($mysqli, 'test2') or die('dd');
mysqli_query($mysqli,"set names utf8"); 

$sql = "SELECT res FROM test2";

$result = mysqli_query($mysqli,$sql);
$datata = mysqli_fetch_array($result);

$main_key = ["식물 정보","식물 상태 확인", "문의"];

if($datata[0] == 1000){
  $ms = "물이 많이 부족해요😢";
 }
if($datata[0] == 850){
  $ms = "조금 더 필요해요😐 ";
 }
if($datata[0] == 500){
  $ms = "물 주셔서 감사합니다😁";
 }
if ( $text == "식물 정보" ) { //창업지원단 공지사항 응답
  $message = array(
    'message' => array('text' => "식물 이름 : 스투키\n\n정보 : 건조한 아프리카 동부가 원산지인 다육식물로 Sanseveria stuckyi의 끝 부분을 한국어로 발음한 것이다.\n 해당 글에 따르면 시중에서 판매되는 스투키 대부분은 실린드리카(Sanseveria cylindrica)란 유사종의 잎을 자른 후 물꽂이 해 심은 것이라고 한다.
",
    'photo' => array(
    'url'=>"https://imgur.com/a/RoVrFKU",
    "width"  => 720,
    "height" =>560)
    ),
      //$notice, 이미지 주소 직접넣는거는 안뜸 .
 
    'keyboard' => array(
      'type' => 'buttons',
      'buttons' => $main_key
    )
  );
}


else if ( $text == "식물 상태 확인" ) {
  $message = array(
    'message' => array('text' => $ms),
     //$notice, 이미지 주소 직접넣는거는 안뜸 .
 
    'keyboard' => array(
      'type' => 'buttons',
      'buttons' => $main_key
    )
  );
}

else if ( $text == "문의" ) {
  $message = array(
    'message' => array('text' => "kakaotalk : must1080으로 연락주시길 바랍니다.😁"),
     //$notice, 이미지 주소 직접넣는거는 안뜸 .
 
    'keyboard' => array(
      'type' => 'buttons',
      'buttons' => $main_key
    )
  );
}



else if ( !isset($message) ) { //주관식으로 질문이 들어왔을때 하는 대답 인듯.
   $message = array(
      'message' => array('text' => "오류입니다." ),
      'keyboard' => array(
         'type' => 'buttons',
         'buttons' => $main_key //다시 버튼으로 하는 대답으로 돌아감.
      )
   );
}



echo json_encode( $message );
// echo json_encode( $message, JSON_UNESCAPED_UNICODE );
// print_r($message);

?>
