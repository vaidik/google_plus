<?php
  $path = drupal_get_path('module', 'google_plus');
  $options = array(
    'group' => CSS_THEME,
  );
  drupal_add_css($path . '/google-plus-user-profile.css', $options);
?>
<table id="profile_header">
  <tr>
    <td valign="top">
        <span id="displayName"><?php echo l($me['displayName'], $me['url']); ?></span>
        <br />
        <span id="tagline"><?php echo $me['tagline']; ?></span>
    </td>
    <td width="100">
      <?php echo theme('image', array('path' => $me['image']['url'] . '?sz=150')); ?>
    </td>
  </tr>
</table>

<?php
  $var = array(
    'rows' => array(
    ),
  );

  if (isset($me['aboutMe'])) {
    $var['rows'][] = array('Introduction', $me['aboutMe']);
  }

  if (isset($me['nickname'])) {
    $var['rows'][] = array('Nickname', $me['nickname']);
  }

  if (isset($me['birthday'])) {
    $var['rows'][] = array('Birthday', $me['birthday']);
  }

  if (isset($me['gender'])) {
    $var['rows'][] = array('Gender', $me['gender']);
  }

  if (isset($me['relationshipStatus'])) {
    $var['rows'][] = array('Relationship Status', $me['relationshipStatus']);
  }

  if (isset($me['languagesSpoken'])) {
    $var['rows'][] = array('Languages Spoken', $me['languagesSpoken']);
  }

  if (isset($me['currentLocation'])) {
    $var['rows'][] = array('Current Location', $me['currentLocation']);
  }

  if (isset($me['emails'])) {
    $column = '';

    foreach($me['emails'] as $email) {
      $column .= $email['type'] . ' - ' . $email['value'] . (($email['primary']) ? ' (primary)' : '') . '<br />';
    }
    $var['rows'][] = array('Emails', $column);
  }

  if (isset($me['placesLived'])) {
    $column = '';

    foreach($me['placesLived'] as $place) {
      $column .= $place['value'] . ((isset($place['primary'])) ? ' (primary)' : '') . '<br />';
    }
    $var['rows'][] = array('Places lived', $column);
  }

  if (isset($me['organizations'])) {
    $column_ed = '';
    $column_job = '';

    foreach($me['organizations'] as $org) {
      if ($org['type'] == 'work') {
        $column_job .= $org['name'] . ((isset($org['primary'])) ? ' (primary)' : '') . '<br />';
      } elseif ($org['type'] == 'school') {
        $column_ed .= $org['name'] . ((isset($org['primary'])) ? ' (primary)' : '') . '<br />';
      }
    }

    if ($column_job != '') {
      $var['rows'][] = array('Employment', $column_job);
    }
    if ($column_ed != '') {
      $var['rows'][] = array('Education', $column_ed);
    }
  }

  echo theme('table', $var);
?>
