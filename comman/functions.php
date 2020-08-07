<?php 

function get_TimeDifference($t1,$t2){
    $diff = abs($t1 - $t2);  
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));   
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
    $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
    $s = '';
    if($years > 0)
      $s = $years . ' years ago';
    else if($months > 0)
      $s = $years . ' months ago';
    else if($days > 0)
      $s = $days . ' days ago';
    else if($hours > 0)
      $s = $hours . ' hours ago';
    else if($minutes > 0)
      $s = $minutes . ' minutes ago';
    else if($seconds > 0)
      $s = $seconds . ' seconds ago';
    else
      $s = ' Less than a second ago';
    return $s;
}
// function get_TimeDifference($t1,$t2,$pre,$post){
//     $diff = abs($t1 - $t2);  
//     $years = floor($diff / (365*60*60*24));
//     $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));   
//     $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
//     $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
//     $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
//     $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
//     $s = '';
//     if($years > 0)
//       $s = $years . $pre.' years '.$post;
//     else if($months > 0)
//       $s = $years . $pre.' months '.$post;
//     else if($days > 0)
//       $s = $days . $pre.' days '.$post;
//     else if($hours > 0)
//       $s = $hours . $pre.' hours '.$post;
//     else if($minutes > 0)
//       $s = $minutes . $pre.' minutes '.$post;
//     else if($seconds > 0)
//       $s = $seconds . $pre.' seconds '.$post;
//     else
//       $s = $pre.' Less than a second '.$post;
//     return $s;
// }
function setTimeRemain($bus){
  date_default_timezone_set("Asia/Colombo");
  $bus->Speed = getAverageSpeed($bus->RegNo,date('Y-m-d').'');
  $t1 = strtotime($bus->Available);
  $t2 = strtotime(date('H:i:s').'');
  //$diff;
  if($t1 < $t2){
    //return 'OK';
    //$diff = strtotime('2020-01-02 '.date('H:i:s').'') - strtotime('2020-01-01'.$bus->Available);
    if($bus->Speed > 0){
      $bus->AvailableToday = 1;
      $bus->AvailableIn = 'Started at '.$bus->Available;
    }
    else{
      $bus->AvailableToday = 0;
      $bus->AvailableIn = 'Tomorrow at '.$bus->Available; 
    }
  } 
  else{
    $bus->AvailableToday = 1;
    $bus->AvailableIn = 'Today at '.$bus->Available;
    //$diff = $t1 - $t2;  
  }
  // $years = floor($diff / (365*60*60*24));
  // $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));   
  // $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
  // $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
  // $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
  // $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));

  // $s = 'in ';
  // if($days > 0)
  //   $s = $s.$days.'D '.$post;
  // if($hours > 0)
  //   $s = $s.$hours .'H ';
  // if($minutes > 0)
  //   $s = $s.$minutes .'M ';
  // if($seconds > 0)
  //   $s = 'in '.$seconds .'in seconds ';
  // else
  //   $s = 'Available';
  //$bus->AvailableIn = $s;
}
function getCategory($cat){
  switch ($cat) {
    case 0:
      return "Normal";
    case 1:
      return "Semi-Luxury";
    case 2:
      return "Luxury";
    case 3:
      return "Super Luxury";
    default:
      return "Undefind";
    }
}
function getExpress($exp){
  switch ($exp) {
    case 0:
      return "Express";
    
    default:
      return "Undefind";
  }
}
function getAddTimeFunctionText($hours){
  $txt = "";
  $diff = floor($hours * 3600);
  $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));   
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60)); 
    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
    $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));

  if($hours > 0)
    $txt = '+'.$hour.' hour ';
  if($minutes > 0)
    $txt = $txt.'+'.$minutes.' minutes ';
  if($seconds > 0)
    $txt = $txt.'+'.$seconds.' seconds';
  return $txt;
}
?>