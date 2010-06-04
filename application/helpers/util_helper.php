<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function print_array($arr, $die=FALSE){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    if( $die ) die();
}

function file_search_special($dir, $filename_search){
    if( substr($dir,-1)=="/" ) $dir = substr($dir, 0, strlen($dir)-1);
    if( is_dir($dir) ){
        $d=opendir($dir);
        while( $file = readdir($d) ){
            if( $file!="." AND $file!=".." ){
                if( is_file($dir.'/'.$file) ){
                    // Es Archivo
                    if( strpos($file, $filename_search) ){
                        return ($dir.'/'.$file);
                    }
                }

                if( is_dir($dir.'/'.$file) ){
                     // Es Directorio
                     // Volvemos a llamar
                     $r = file_search($dir.'/'.$file, $filename_search);
                     if( basename($r) == $filename_search ){
                        return $r;
                     }
                }
            }
        }
    }
    return false;
}

 function part_filename($name){
    return array(
        'ext'=>substr($name, (strripos($name, ".")-strlen($name))+1),
        'basename'=>substr($name, 0, strripos($name, "."))
    );
 }

function delete_images_temp(){
    $d = opendir(UPLOAD_DIR_TMP);
    $CI =& get_instance();
    while( $file = readdir($d) ){
        if( $file!="." AND $file!=".." ){
            if( preg_match("/^".$CI->session->userdata('user_id')."\_.*$/", $file) ){
                @unlink(UPLOAD_DIR_TMP.$file);
            }
        }
    }
}

function order_dates($str_date, $order='asc', $format='d-m-Y'){
    if( !is_array($str_date) ) (array)$str_date;

    $str_date_new = array();
    foreach( $str_date as $key=>$val ){
        $str_date_new[$key] = strtotime($val);
    }

    if( $order=="asc" || ($order!='asc'&&$order!='desc') ) arsort($str_date_new);
    elseif( $order=="desc" ) asort($str_date_new);

    $str_date = array();
    foreach( $str_date_new as $key=>$val ){
        $d = date($format, $val);
        $str_date[$key] = $d;
    }
    return $str_date;
}

function display_error($file, $function, $err, $param=array()){
    if( count($param)>0 ) {
        $err = vsprintf($err, $param);
    }
    log_message("error", $file." | ".$function." | ".$err);
    show_error($err);
}

function add_date($givendate, $day=0, $mth=0, $yr=0) {
    $cd = strtotime($givendate);
    $newdate = date('d-m-Y h:i:s', mktime(date('h',$cd),
    date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
    date('d',$cd)+$day, date('Y',$cd)+$yr));
    return $newdate;
}

function is_date($strdate){
    $timestamp = strtotime($strdate);
    if( $timestamp === false ) return false;

    $time = strtotime($strdate);
    return checkdate(date('m', $time), date('d', $time), date('Y', $time));
}

/*
 * @example : arr_search($myarray, 'keyname==4)
 */
function arr_search ( $array, $expression ) {
    $result = array();
    $expression = preg_replace ( "/([^\s]+?)(=|<|>|!)/", "\$a['$1']$2", $expression );
    foreach ( $array as $a ) if ( eval ( "return $expression;" ) ) $result[] = $a;
    return $result;
}

function get_text_month($month){
    switch ((int)$month){
        case 1: return "Enero";
        case 2: return "Febrero";
        case 3: return "Marzo";
        case 4: return "Abril";
        case 5: return "Mayo";
        case 6: return "Junio";
        case 7: return "Julio";
        case 8: return "Agosto";
        case 9: return "Septiembre";
        case 10: return "Octubre";
        case 11: return "Noviembre";
        case 12: return "Diciembre";
    }
}

function get_datetime($date, $timer){
    list($d, $m, $y) = preg_split("/[\/]|[\,]/", $date);
    $date = mktime(0, 0, 0, $m, $d, $y);
    $ret = date('d', $date) ." de ". get_text_month(date('n', $date));
    if( isset($timer) && !empty($timer) && !is_null($timer) ) $ret.=", ".date('H:i', strtotime($timer))." hs";
    return $ret;
}
?>
