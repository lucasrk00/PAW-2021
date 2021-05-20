<?php if (isset($errorMessage)) : ?>
	<p class="status-notification error-message">
		<?= $errorMessage ?>
	</p>
<?php endif; ?>
<?php if (isset($successMessage)) : ?>
	<p class="status-notification success-message">
		<?= $successMessage ?>
	</p>
<?php endif; ?>