<style>
td.right { text-align: right }
</style>

<table class="table table-hover table-condensed table-striped table-bordered">
<thead>
<tr>
    <th>filename</th>
    <th width="80px">mode</th>
    <th width="60px">uid</th>
    <th width="60px">gid</th>
    <th width="80px">size</th>
    <th width="180px">last modified</th>
    <th width="180px">last access</th>
</tr>
</thead>

<tbody>
<? foreach ($files as $file): ?>
<tr onclick="location.href='filelist.php?dir=<?=$currdir.$file['filename']?>'">
    <td><?=$file['filename']?></td>
    <td><?=filemode2str($file)?></td>
    <td class="right"><?=$file['uid']?></td>
    <td class="right"><?=$file['gid']?></td>
    <td class="right"><?=$file['size']?></td>
    <td><?=date('d M Y H:i:s', $file['mtime'])?></td>
    <td><?=date('d M Y H:i:s', $file['atime'])?></td>
</tr>
<? endforeach ?>
</tbody>
</table>
