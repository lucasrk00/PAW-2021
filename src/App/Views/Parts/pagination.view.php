<?php if(isset($pagination)): ?>
<ul class="paginacion">
	<?php if($pagination["pageStart"] > 1 ): ?>
	<li class="<?php if ( 1 == $pagination["currentPage"]){ echo "active"; }?>">
		<a href="?page=1">1</a>
	</li>
	<li class="separator">...</li>
	<?php endif; ?>
	<?php
		foreach( range($pagination["pageStart"], $pagination["pageEnd"]) as $page):
	?>
		<li class="<?php if ($page == $pagination["currentPage"]){ echo "active"; }?>">
			<a href="?page=<?=$page?>"><?=$page?></a>
		</li>
	<?php endforeach; ?>
	<?php if($pagination["pageEnd"] < $pagination["lastPage"]): ?>
	<li class="separator">...</li>
	<li class="<?php if ($pagination["lastPage"] == $pagination["currentPage"]){ echo "active"; }?>">
		<a href="?page=<?=$pagination["lastPage"]?>"><?=$pagination["lastPage"]?></a>
	</li>
	<?php endif; ?>
</ul>
<?php endif; ?>