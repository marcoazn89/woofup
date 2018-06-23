<html>
    <head>
        <title>Roadbot - <?php echo $response->getStatusCode();?></title>
<link rel='stylesheet' href='https://www.dropbox.com/static/css/error.css' type='text/css'>
<link rel='shortcut icon' href='http://www.talentinc.com/images/logo-talentinc.svg'>
</head>
<body>
<div class='figure'>
<img src='' width='300'>
</div>
<div id='errorbox'>
<h1>Error (<?php echo $response->getStatusCode();?>)</h1>
<p><?php if (!empty($message)) echo $message; else echo "Well that's embarassing. Something went wrong but we are working on it!"; ?> </p>
<p>Thanks,</p>
<p>Roadbot.</p>
</div>
</body>
</html>
