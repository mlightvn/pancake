
<html>
<head>
    <title>BOMBERMAN JAVASCRIPT GAME</title>
<link rel="stylesheet" type="text/css" media="screen" href="/common/game/bomber/css/game.css" />
<script type="text/javascript" src="/common/game/bomber/js/bomberman.js"></script>

</head>
<body>
    <div id="border">
        <div id="viewport"></div>
    </div>
    <div id="info">
        TODO: [<a href="http://code.google.com/p/js-blaster/issues/list">full list</a>]<br>
            <span id="soundLevelContainer"><span id="soundLevelIndicator"></span></span>
    <form>
        <input type="checkbox" value="1" id="bgsoundcheckbox"> No BGSound (the background music is the start of "Fourty niners" artist: <a href="http://www.jamendo.com/en/artist/gina.artworth">Gina Artworth</a>)<br>
    graphics by artist <a href="http://clipart.nicubunu.ro">nicubunu</a><br><hr>you can play against a friend <a href="http://www.e-forum.ro:8080/dynagame/index">here</a><br>first real time network game<br> in javascript afaik .</form>
    <hr>
        SCORE: <span id="score">0</span>
        <hr>
         i see the game is played by non-developers too.<br>
         for this reason i update this page:<br>
         1. if you want to contact me and request features, <br>complain or submit a bug, <a href="http://groups.google.com/group/jsblaster">do it here</a><br>
             or mail me at jajalinux AT gmail .<br>
          or check <a href="http://bash.editia.info">my blog</a>
          <br>
         2. legend:<br> bombs do no vaporate other bombs, <br>to get to the next level go through the door that is hidden under a fake-rock
         ,<br> the yellow monsters are smarter so pay attention to them, <br>get goodies that you find under the fake-rocks, <br> get a higher score,<br>
             ARROWS to move, SPACE to bomb.<br>P p ESC to pause<br>
         BOMB AWAY.
         <BR>
             I minified the js source, you can still check it <a href="http://www.e-forum.ro/bomberman/dynagame2.html">here</a>
             and <a href="http://code.google.com/p/js-blaster">here</a>.
             <hr>
               1. a new monster added:<br> <img src="img/zbadguy.png" width="50" height="50" border="0"><br>
               this guy can fly over walls. be aware! :). monsters being generated randomly, you may encounter it in the 2nd or 3rd level.
               <br>
                   2. More sounds added for explosions and upon dying.
                   <br>
                    3. new darkBlue monster added, that changes into a fireball and cannot die at that moment.<br>
                    <img src="img/fbadguy.png" width="50" height="50" border="0"> <img src="img/fireball.png" width="50" height="50" border="0">
               <br>
                   <a href="http://code.google.com/p/js-blaster">SVN and screenshots here</a>
    </div>
    <div class="adcontainer">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- js-bomberman -->
<ins class="adsbygoogle"
     style="display:inline-block;width:120px;height:600px"
     data-ad-client="ca-pub-4478308152807315"
     data-ad-slot="8716253316"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
    </div>
    <div id="swfContainer"></div>
</body>
</html>
