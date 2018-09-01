<?php

namespace Hanson\MyVbot\Handlers\Type;

use Carbon\Carbon;
use Hanson\Vbot\Contact\Friends;
use Hanson\Vbot\Contact\Groups;
use Hanson\Vbot\Message\Text;
use Hanson\Vbot\Support\File;
use Illuminate\Support\Collection;

class TextType
{
    public static function messageHandler(Collection $message, Friends $friends, Groups $groups)
    {
        //var_dump($message);
        if ($message['type'] === 'text') {

            $username = null;
            foreach ($message['from']['MemberList'] as $_member) {
                if ($_member['UserName'] == $message['raw']['FromUserName']) {
                    $username = $_member['NickName'];
                    break;
                } if ($_member['NickName'] == $message['sender']['NickName']) {
                    $username = $message['sender']['NickName'];
                    break;
                }
            }
            //var_dump($message['sender']['NickName']);

            //var_dump($username);
            if (!is_null($username)) {
                $postfields = [
                //'address' => '0x9480ac572b16f94a66758f110e5f10eaa42f621b',
                    'name' => $username,
                    'time' => date("Y-m-d H:i:s", time()),
                    'type' => 'text',
                    'content' => $message['content'],
                    'url' => '',
                    'group_name' => $message['from']['NickName'],
                ];
                //var_dump($postfields);exit;
                //exit;
            //vbot('console')->log($postfields, 'call');
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.nasface.com/api/message');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_POST, 1);
            // Edit: prior variable $postFields should be $postfields;
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
                $result = curl_exec($ch);
                //var_dump($result);exit;
                if ($message['from']['NickName'] == 'NervAct_hackathon_team') {
                    $format_result = json_decode($result, true);

                    if ($format_result['data']['token'] > 0) {

                        $url = "https://microscope.cryptape.com/#/transaction/" . $format_result['data']['hash'];
                        $short_url = json_decode(file_get_contents("http://api.t.sina.com.cn/short_url/shorten.json?source=1681459862&url_long=" . $url), true);
                        //var_dump($short_url[0]['url_short']);
                        //exit;

                        Text::send($message['from']['UserName'], "恭喜 @" . $username . " 获得 " . $format_result['data']['token'] . " 个 token \r\n" .
                            "交易地址: " . $url);
                    }
                }
                //exit;
            }
            //vbot('console')->log($result, 'call');
            //var_dump($result);
            //exit;
            //exit;

            /*if ($message['content'] === 'time') {
                $datetime = Carbon::parse(vbot('config')->get('server.time'));
                Text::send($message['from']['UserName'], 'Running:'.$datetime->diffInHours().'小时');
            }

            if ($message['content'] === '拉我') {
                $username = $groups->getUsernameByNickname('Vbot 体验群');
                $groups->addMember($username, $message['from']['UserName']);
            }

            if ($message['content'] === '叫我') {
                $username = $friends->getUsernameByNickname('HanSon');
                Text::send($username, '主人');
            }

            if ($message['content'] === '头像') {
                $avatar = $friends->getAvatar($message['from']['UserName']);
                File::saveTo(vbot('config')['user_path'].'avatar/'.$message['from']['UserName'].'.jpg', $avatar);
            }

            if ($message['content'] === '报名') {
                $username = $groups->getUsernameByNickname('vbot 反馈群');
                $groups->addMember($username, $message['from']['UserName']);
            }*/
        } else if ($message['type'] == 'Share' && $message['from']['NickName'] == '杭州吃鸡群') {
            //var_dump($message['from']['NickName']);exit;
            Text::send($message['from']['UserName'], "识别分享程序为官方游戏APP
            ---------------------------
            场次: 0x345sdfa890sdf token: 30
            游戏名次:
            1. 张三 淘汰 5 人
            2. 李四 淘汰 3 人
            3. 王五 淘汰 0 人
            张三吃鸡，张三获得 30 token");

        } else if (strtolower($message['type']) == 'share' && $message['app'] == '绝地求生：刺激战场') {


//var_dump($message['sender']['NickName']);exit;
            foreach ($message['from']['MemberList'] as $_member) {
                if ($_member['UserName'] == $message['raw']['FromUserName']) {
                    $username = $_member['NickName'];
                    break;
                } if ($_member['NickName'] == $message['sender']['NickName']) {
                    $username = $message['sender']['NickName'];
                    break;
                }
            }

            //var_dump($message);exit;
            if (!is_null($username)) {
                $postfields = [
                //'address' => '0x9480ac572b16f94a66758f110e5f10eaa42f621b',
                    'name' => $username,
                    //'time' => date("Y-m-d H:i:s", time()),
                    'type' => 'share',
                    'content' => $message['title'],
                    'url' => '',
                    'app' => $message['app'],
                    'group_name' => $message['from']['NickName'],
                ];
                //var_dump($postfields);exit;
                //exit;
            //vbot('console')->log($postfields, 'call');
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.nasface.com/api/transaction/receive');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_POST, 1);
            // Edit: prior variable $postFields should be $postfields;
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
                $result = curl_exec($ch);
                if ($message['from']['NickName'] == 'NervAct_hackathon_team') {
                    $format_result = json_decode($result, true);

                    $url = "https://microscope.cryptape.com/#/transaction/" . $format_result['data']['hash'];
                    //$short_url = json_decode(file_get_contents("http://api.t.sina.com.cn/short_url/shorten.json?source=1681459862&url_long=" . $url), true);

                    //var_dump($message['from']['UserName']);
                    Text::send($message['from']['UserName'], "识别分享程序为" . $message['app'] . "\r\n" .
                        "---------------------------
                        场次: 0x345sdfa890sdf
                        token: 100
                        游戏名次:
                        1. 张伟杰 淘汰 5 人
                        2. 蔡欣 淘汰 3 人
                        3. 熊彪 淘汰 0 人
                        张传杰吃鸡，张伟杰获得 100 token
                        交易地址: " . $url);
                }
                //exit;
            }




        }
    }
}
