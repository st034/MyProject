<?php

function Ceckstringvalidate($string){
$newstr = $string;
//IF NO PASS RETURN ''
//FILTER_FLAG_STRIP_LOW - Remove characters with ASCII value < 32
//FILTER_FLAG_STRIP_HIGH - Remove characters with ASCII value > 127
$newstr = filter_var($newstr, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$newstr = filter_var($newstr, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
if ($newstr==$string){
return $string;
}else{
    return '';
}}

function Ceckintvalidate($int){
$newint = $int;
// if number isn't an integer return ''
$newint = filter_var($newint, FILTER_SANITIZE_NUMBER_INT);
if ($newint==$int){
return $int;
}else{
    return '';
}}

function Ceckmailvalidate($mail){
    $newmail = $mail;
    // if mail isn't an mail return ''
    $newmail = filter_var($newmail, FILTER_SANITIZE_EMAIL);
    if ($newmail==$mail){
    return $mail;
    }else{
        return '';  
}}

function Ceckusernamevalidate($username){
$isUsernameValid=$username;
$isUsernameValid = filter_var($username,FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[a-z\d_]{3,20}$/i"]]);
if ($isUsernameValid==$username){
    return $username;
    }else{
        return '';  
}}
?>