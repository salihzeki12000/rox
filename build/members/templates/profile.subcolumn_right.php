<? // Profile Relations ?>
<?php 
$relations = $member->relations;
if (count($relations) > 0) { ?>
	    <div class="floatbox box">
		<h3><a href="members/<?=$member->Username?>/relations/ "><?=$words->get('MyRelations');?></a></h3>
		<ul class="linklist">
		    <?php
		        foreach ($relations as $rel) {
		    ?>

		  <li class="floatbox">
		    <a href="<?=PVars::getObj('env')->baseuri."members/".$rel->Username?>"  title="See profile <?=$rel->Username?>">
		      <img class="framed float_left"  src="members/avatar/<?=$rel->Username?>?xs"  height="50px"  width="50px"  alt="Profile" >
		    </a>
			<a class="float_left" href="<?=PVars::getObj('env')->baseuri."members/".$rel->Username?>" ><?=$rel->Username?></a>
		    <br />
		    <?=$rel->Comment?>
		  </li>
		  <?php } ?>
		</ul>
		</div>
<?php } ?>


<? // Profile Comments ?>
<?php
    $comments = $this->member->comments;
    $username = $this->member->Username;
    $layoutbits = new MOD_layoutbits();
    $max = 3;
    if (count($comments) > 0) { 
?>

	<div class="floatbox box">
		
		<h3><a href="members/<?=$member->Username?>/comments/"><?=$words->get('LatestComments')?></a></h3> 

		<?php
		    $iiMax = (isset($max) && count($comments) > $max) ? $max : count($comments);
		    $tt = array ();
		    for ($ii = 0; $ii < $iiMax; $ii++) {
		        $c = $comments[$ii];
		        $quality = "neutral";
		        if ($c->comQuality == "Good") {
		            $quality = "good";
		        }
		        if ($c->comQuality == "Bad") {
		            $quality = "bad";
		        }

		    $tt = explode(",", $comments[$ii]->Lenght);
		    // var_dump($c);
		?>
		<div class="floatbox">
        <a href="people/<?=$c->Username?>">
           <img class="float_left framed"  src="members/avatar/<?=$c->Username?>/?xs"  height="50px"  width="50px"  alt="Profile" />
        </a>
        <div class="comment">
            <p>
              <strong class="<?=$quality?>"><?=$c->comQuality?></strong><br/>
              <span class="small grey"><?=$words->get('CommentFrom','<a href="people/'.$c->Username.'">'.$c->Username.'</a>')?> - <?=$c->created?></span>
            </p>
            <p>
              <?=substr(strip_tags($c->TextFree,'<font>'), 0, 250)?>
              <? if (strlen($c->TextFree) > 250) echo ' ... <a href="people/'.$member->Username.'/comments">'.$ww->more.'</a>'?>
            </p>
	        <? if ($ii != ($iiMax-1)) echo '<hr />' ?>

        </div> <!-- comment -->
        </div>
        <? } ?>

    </div>
<? } ?>

<? // This member's gallery ?>
        <?php        
	    $userid = $member->userid;
	    $gallery = new Gallery;
	    $statement = $userid ? $gallery->getLatestItems($userid) : false;
	    if ($statement) {
		?>
	        <div class="floatbox box">
	        <h3><a href="gallery/show/user/<?=$userid?>" title="<?=$words->getSilent('GalleryTitleLatest')?>"> <?=$words->get('GalleryTitleLatest')?></a></h3>
	    <?php
	        // if the gallery is NOT empty, go show it
	        $p = PFunctions::paginate($statement, 1, $itemsPerPage = 8);
	        $statement = $p[0];
	        foreach ($statement as $d) {
	        	echo '<a href="gallery/show/image/'.$d->id.'"><img src="gallery/thumbimg?id='.$d->id.'" alt="image" style="height: 50px; width: 50px; padding:2px;"/></a>';
	        }
		    echo $words->flushBuffer();
	    }

        ?>