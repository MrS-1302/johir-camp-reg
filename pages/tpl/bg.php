<div class="landing">
    <video autoplay muted loop>
        <source src="/assets/vid/bg.webm" type="video/mp4">
    </video>
    <div class="darkness-layer"></div>
    <?php if (!isset($bgLines) || (isset($bgLines) && $bgLines)) {?>
        <div class="line1"></div>
        <div class="line2"></div>
    <?php } ?>
</div>