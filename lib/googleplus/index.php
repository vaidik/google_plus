<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
require_once 'google-api-php-client/src/apiClient.php';
require_once 'google-api-php-client/src/contrib/apiPlusService.php';

session_start();

$client = new apiClient();
$client->setApplicationName("Google+ Contributed Module for Drupal");
// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
$client->setClientId('529742799881.apps.googleusercontent.com');
$client->setClientSecret('2fXOTuergEif6jqD3PTflG4t');
$client->setRedirectUri('http://localhost/drupal-7/sites/all/modules/google_plus/lib/googleplus/index.php');
$client->setDeveloperKey('AIzaSyBnxVFLEOZtpQzNlZoWKcNMNxYe11xxepg');
$client->setScopes(array('https://www.googleapis.com/auth/plus.me'));
$plus = new apiPlusService($client);

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['access_token'] = $client->getAccessToken();
	print_r($_SESSION['access_token']);
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}


if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);
}


if ($client->getAccessToken()) {
  $me = $plus->people->get('me');

  $optParams = array('maxResults' => 100);
  $activities = $plus->activities->listActivities('me', 'public', $optParams);

  // The access token may have been updated lazily.
  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}
?>
<!doctype html>
<html>
<head><link rel='stylesheet' href='style.css' /></head>
<body>
<header><h1>Google+ Sample App</h1></header>
<div class="box">
  
<?php if(isset($me) && isset($activities)): ?>
<div class="me">
  <a rel="me" href="<?php echo $me['url'] ?>"><?php print $me['displayName'] ?></a>
  <div><img src="<?php echo $me['image']['url'];?>?sz=82" /></div>
</div>

<div class="activities">Your Activities:
  <?php foreach($activities['items'] as $activity): ?>
    <div class="activity">
      <a href="<?php print $activity['url'] ?>"><?php print $activity['title'] ?></a>
    </div>
  <?php endforeach ?>
</div>
<?php endif ?>
<?php
  if(isset($authUrl)) {
    print "<a class='login' href='$authUrl'>Connect Me!</a>";
  } else {
   print "<a class='logout' href='?logout'>Logout</a>";
  }
?>
</div>
</body>
</html>
