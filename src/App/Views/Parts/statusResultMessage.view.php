<?php 
$statusMessage = $request->getStatusMessage();
if ($statusMessage['type'] !== 'none'):
?>
<p class="status-notification <?=$statusMessage['type']?>-message">
	<?= $statusMessage['message'] ?>
</p>
<?php endif; ?>