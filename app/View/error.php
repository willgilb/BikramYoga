<?php if ($error) : ?>
    <div class="error">
        <p>Please correct the following errors:</p>
        <ol>
            <?php foreach ($error as $item) : ?>
                <li><?php echo $item; ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
<?php endif; ?>