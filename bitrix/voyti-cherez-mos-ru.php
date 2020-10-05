<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Войти через mos.ru");
?>
<?
	$logout = $_GET["logout"];
	if ($logout = 1){ $USER->Logout();}

	$code = $_GET["code"];
	
  //  echo $code;

   $client_id = "";
	$client_secret = base64_encode(":");
   $redirect_uri = "";
   $url = "https://login.mos.ru/sps/oauth/te";
   $url2 = "https://login.mos.ru/sps/oauth/me";

   $postfield = http_build_query(array(
      'grant_type' => 'authorization_code',
      'code' => "$code",
      'redirect_uri' => "$redirect_uri"
   ));

   $header = array(
      "Authorization: Basic $client_secret",
      'Content-Type: application/x-www-form-urlencoded',
      'Cache-Control: no-cache'
   );

   

   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);

   $response = curl_exec($ch);
//echo $response;
   curl_close($ch);

   $tokens = json_decode($response, true);

   $id_token = $tokens[id_token];
   $access_token = $tokens[access_token];
   $expires_in = $tokens[expires_in];
   $scope = $tokens[scope];
   $token_type = $tokens[token_type];

   $ch2 = curl_init($url2);

   curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
   curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
      "Authorization: $token_type $access_token",
      'Cache-Control: no-cache'
   ));
   $response2 = curl_exec($ch2);
   curl_close($ch2);
//echo $response2;
   $profiledata = json_decode($response2, true);

   function passGen($minchars = 8, $maxchars = 10, $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz")
   {
      $escapecharplus = 0;
      $repeat = mt_rand($minchars, $maxchars);
      $randomword = '';
      while ($escapecharplus < $repeat)
      {
            $randomword .= $chars[mt_rand(1, strlen($chars) - 1) ];
            $escapecharplus += 1;
      }
      return $randomword;
   }

   $lastname = $profiledata[LastName];
   $middlename = $profiledata[MiddleName];
   $guid = $profiledata[guid];
   $firstname = $profiledata[FirstName];
   $mail = $profiledata[mail];
  // $trusted = $profiledata[trusted];
   //$mobile = $profiledata[mobile];
   $group = array(2,3);
   $password = passGen();

	 //echo $lastname;
	 //echo $password;
	 //echo $group;
	
		$user = new CUser;
		$userFields = array(
         "XML_ID" => $guid,
         "EMAIL" => $mail,
         "LOGIN" => $mail,
         "LID" => "ru",
         "ACTIVE" => "Y",
         "GROUP_ID" => $group,
         "NAME" => $firstname,
         "SECOND_NAME" => $middlename,
         "LAST_NAME" => $lastname,
         "PASSWORD" => $password,
         "CONFIRM_PASSWORD" => $password,
     //    'OATOKEN' => $tokens[access_token],
       //  'OATOKEN_EXPIRES' => $tokens[expires_in]
		);
		echo $mail;

if ($mail !== null){

	$filter = Array("LOGIN" => $mail);
	$rsUsers = CUser::GetList(($by="id"), ($order="asc"), $filter); 

		if ($arResult['USER'] = $rsUsers->Fetch()){
			$ID = $arResult['USER']['ID'];
	//		echo 'тут дожен быть id';
		//	echo $ID;
		} else { 
				$ID = $user->Add($userFields);
				if (intval($ID) > 0) echo "Пользователь успешно добавлен.";
				else {echo $user->LAST_ERROR;}
		};
						} 
						//else { echo "e-mail ещё не пришёл";};


   global $USER;
	$USER->Authorize((int)$ID);
	if ($USER->IsAuthorized()) { echo "Вы авторизованы!";}





 print_r($USER->GetID());



$inurl = "https://login.mos.ru/sps/oauth/ae?client_id=moscowzoo.ru&amp;scope=openid%
20contacts%20profile&amp;redirect_uri=https://moscowzoo.ru/voyti-cherez-mos-ru.php&amp;response_type=c
ode";


$outurl = "https://login.mos.ru/sps/login/logout?post_logout_redirect_uri=https://moscowzoo.ru/voyti-cherez-mos-ru.php?logout=1";

	if (!$USER->IsAuthorized())
		{
			echo "<a id='mos_button_link' href='$inurl'><div id='mos_button'>Вход через mos.ru</div></a>";
		} else { 
			echo "<a id='mos_button_link' href='$outurl'><div id='mos_button'>Выйти</div></a>";
		}
exit(1);
?>
<style>


</style>