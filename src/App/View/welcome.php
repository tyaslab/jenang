<?php $this->layout('base'); ?>

<h2>Welcome</h2>

<p>Welcome to my beloved project.</p>

<?php $this->start('script_bottom'); ?>
<script>
console.log('Welcome to JavaScript console');
</script>
<?php $this->stop(); ?>