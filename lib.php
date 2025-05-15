<?php

    $_theDirName = dirname(__FILE__);

	include_once $_theDirName."/db_info.php";

    function write_log($msg) {    
        $log_file = dirname(__FILE__) . '/write_log.log';
        $date = date('Y-m-d H:i:s');
        $log_message = "[$date]  $msg" . PHP_EOL;
        if ($handle = @fopen($log_file, 'a')) {        
                $result = fwrite($handle, $log_message);
                fclose($handle);
                return ($result !== false);
        }    
        return false;
    }

    function db_conn(){
		global $db, $db_ip, $db_uid, $db_pwd, $db_name;
		if(!$db){
			$db = @mysql_connect($db_ip,$db_uid,$db_pwd) or die("DB 접속 에러---");
			@mysql_select_db($db_name, $db) or die("DB 선택 에러---");
			@mysql_query("SET NAMES EUCKR", $db);
		}
		return $db;
	}

    function go_url($url, $msg="", $frame="", $opener_reload=""){
        if($msg){
            $msg = str_replace(array("\r\n","\r","\n","\""),array("\\r\\n","\\r","\\n","\\\""),$msg);
            $msg = "alert(\"$msg\");";
        }
        if($frame) $frame = "{$frame}.";

        if($url===0) $url = "{$frame}location.reload();";
        else if(is_numeric($url)) $url = "{$frame}history.go($url);";
        else if(strtolower($url)=="close()") $url = "window.close();";
        else if(strtolower($url)=="reload()") $url = "if(opener && opener!=this)opener.location.reload();self.close();";
        else $url = "{$frame}location.replace(\"$url\");";


        //if($opener_reload) $opener_reload = "if(opener && opener!=this)opener.location.reload();";
        if($opener_reload){
            if(stristr($opener_reload,"scr")){
                $opener_reload = "
                    if(opener && opener!=this){
                        if(opener.setCookie){
                            var scr_xpos = opener.trueBody().scrollLeft;
                            var scr_ypos = opener.trueBody().scrollTop;
                            opener.setCookie('ot_scr_xpos', scr_xpos);
                            opener.setCookie('ot_scr_ypos', scr_ypos);
                        }
                        opener.location.reload();
                    }
                ";
            } else{
                $opener_reload = "if(opener && opener!=this) opener.location.reload();";
            }
        }

        print_charset();
        echo "<script type=\"text/JavaScript\">\n{$opener_reload}\n{$msg}\n{$url}\n</script>";

        db_close();
        exit;
	}

    function print_charset(){
		//echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=euc-kr\">";
		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset={$GLOBALS['hanio']['g4_charset']}\" />";
	}

    function movepage($url, $msg="", $frame=""){
		go_url($url, $msg, $frame);
	}

	function msgback($msg, $step=-1, $frame=""){
		go_url($step, $msg, $frame);
	}

	function msgclose($msg="", $refresh=false){
		$url = $refresh? "reload()": "close()";
		go_url($url, $msg);
	}

    function sql_insert_id()             { return @mysql_insert_id(); }
    function sql_num_rows($rs)           { return @mysql_num_rows($rs); }
    function sql_fetch_assoc($rs)        { return @mysql_fetch_assoc($rs); }
    function sql_free_result($rs)        { @mysql_free_result($rs); }

    function s_data($sql,$assoc_flag=true){ // 1개의 데이터를 구한다. (assoc/row)
		$rs = sql_query($sql);
		$bExists = sql_num_rows($rs);
		$buff = $assoc_flag? sql_fetch_assoc($rs): sql_fetch_row($rs);
		sql_free_result($rs);
		if(!$bExists) return array();
		else{
			if($assoc_flag) $buff[bExists] = $bExists; // 갯수
			return $buff;
		}
	}

    function sql_query($sql, $dumy=''){
		global $db;
		if(!$db) $db = db_conn();
		if(getenv('HTTP_HOST')=='localhost' || strstr(getenv('HTTP_HOST'),'172.30.1.')) $rs = @mysql_query($sql) or die("<xmp>-----Query Error(".mysql_errno().")-----\n$sql\n\nERROR Message : ".mysql_error()."\nERROR FILE : {$_SERVER['PHP_SELF']}</xmp>");
		else $rs = @mysql_query($sql);
		//$rs = @mysql_query($sql);
		return $rs;
	}

    function my_json_encode($a=false){
		if(is_null($a)) return 'null';
		if($a === false) return 'false';
		if($a === true) return 'true';
		if(is_scalar($a)){
			if(is_float($a)) return floatval(str_replace(",", ".", strval($a)));
			if(is_string($a)){
				static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
				return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
			} else return $a;
		}
		$isList = true;
		for($i=0, reset($a); $i<count($a); $i++, next($a)){
			if(key($a) !== $i){
				$isList = false;
				break;
			}
		}
		$result = array();
		if($isList){
			foreach($a as $v) $result[] = my_json_encode($v);
			return '[' . join(',', $result) . ']';
		} else{
			foreach($a as $k => $v) $result[] = my_json_encode($k).':'.my_json_encode($v);
			return '{' . join(',', $result) . '}';
		}
	}

    function my_json_decode($json) {
        $comment = false;
        $out = '$x=';
      
        for ($i = 0; $i < strlen($json); $i++) {
            if (!$comment) {
                if (($json[$i] == '{') || ($json[$i] == '[')) $out .= ' array(';
                else if (($json[$i] == '}') || ($json[$i] == ']')) $out .= ')';
                else if ($json[$i] == ':') $out .= '=>';
                else $out .= $json[$i];
            } else $out .= $json[$i];
            if ($json[$i] == '"' && $json[($i - 1)] != "\\") $comment = !$comment;
        }
        eval($out . ';');
        return $x;
    }



?>
    