<div class="list-group">
<? foreach ($files as $file): ?>
  <a href="filelist.php?dir=<?=$currdir.$file['filename']?>'" class="list-group-item list-group-item-info"><?=$file['filename']?></a>
<? endforeach ?>
</div>
