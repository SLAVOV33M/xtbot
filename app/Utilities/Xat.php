<?php

namespace App\Utilities;

trait Xat
{
    /**
     * @param $xatid
     * @return int
     */
    public static function isValidXatID($xatid)
    {
        return ($xatid & 0xFFFFFFFF);
    }

    /**
     * @param $xatid
     * @return bool
     */
    public static function isXatIDExist($xatid)
    {
        /*$fgc = file_get_contents('http://xat.me/x?id=' . $xatid);
        if (empty($fgc) || is_numeric($fgc)) {
            return false;
        } else {
            return $fgc;
	}*/
        $json = json_decode(file_get_contents('https://xat.com/web_gear/chat/profile2.php?i=' . $xatid), true);
        if (isset($json['Err'])) {
            if (isset($json['Err']['Media'])) {
                var_dump($json['Err']['Media']['id']);
                if ($json['Err']['Media']['id'] == $xatid) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param string $regname
     * @return bool
     */
    public static function isValidRegname(string $regname)
    {
        return (strlen($regname) >= 3);
    }

    /**
     * @param $regname
     * @return true
     */
    public static function isRegnameExist($regname)
    {
        /*$fgc = file_get_contents('http://xat.me/x?name=' . $regname);
        if (empty($fgc)) {
            return false;
        } else {
            return true;
        }*/
        return true;
    }

    /**
     * @param $chatname
     * @return false|float|int|string
     */
    public static function isChatExist($chatname)
    {
        $url = 'http://xat.com/web_gear/chat/roomid.php?d=' . $chatname;
        $ctx = stream_context_create(['http' => ['timeout' => 2]]);
        $fgc = json_decode(file_get_contents($url, false, $ctx), true);

        if (!isset($fgc['id']) || !is_numeric($fgc['id'])) {
            return false;
        } else {
            return $fgc['id'];
        }
    }

    /**
     * @param $chatname
     * @param $chatpw
     * @return string
     */
    public static function getMain($chatname, $chatpw)
    {
        $POST['GroupName'] = $chatname;
        $POST['password'] = $chatpw;
        $POST['SubmitPass'] = 'Submit';
        $stream = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($POST)
            ]
        ];

        $res = file_get_contents('https://xat.com/web_gear/chat/editgroup.php', false, stream_context_create($stream));

        if (strpos($res, '**<span data-localize=buy.wrongpassword>Wrong password</span>')) {
            return 'Wrong password';
        } elseif (strpos($res, '**Error. Try again in 10 minutes.**')) {
            return 'Try again in 10 minutes';
        }

        return Functions::stribet($res, '<input name="pw" type="hidden" value="', '">');
    }
}
