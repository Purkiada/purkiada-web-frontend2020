<!DOCTYPE HTML>
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="generator" content="Notepad++, www.notepad-plus-plus.org">
  <link rel="stylesheet" type="text/css" href="global_graphic.css">
  
  <title>H4ck t3st</title>
  </head>
  <body>
  <div class="level">
    <h1>LEVEL <?php echo sha1("6"); ?></h1>
  </div>
  <div class="main">
  <p class="text">Jsi dobrý, když jsi se dostal až sem, ale probojuješ se i dál?<br /> Slyšel jsi už o SHA1 šifrování? Ne? Super tak jsi něco nastuduj.<br />Heslo pro další level je: <?php echo sha1("phpcode"); ?></p>
    
    <form action="./index.php" method="GET">
      <input type="text" name="level" autocomplete="off"><br />
      <input type="submit" value="Odeslat">
    </form>
  </div>


<!-- Pod timhle upozornenim neni v kodu uz nic co by se tykalo zadani!!! !-->
<!-- Pod timhle upozornenim neni v kodu uz nic co by se tykalo zadani!!! !-->
<!-- Pod timhle upozornenim neni v kodu uz nic co by se tykalo zadani!!! !-->
<!-- Pod timhle upozornenim neni v kodu uz nic co by se tykalo zadani!!! !-->
<br><br>
<hr>
<div class="add">
  <span class="authority"><?php echo $autor; ?></span>
</div>

  </body>
</html>