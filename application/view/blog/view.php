<div class="container">
    <h2>You are in the View: application/view/blog/view.php (everything in this box comes from that file)</h2>
    <!-- add song form -->
    <div>
            
            <h4><?php echo htmlspecialchars($this->blog->titel, ENT_QUOTES, 'UTF-8'); ?></h4>
            <p>gemaakt op: <?php echo date('d-m-y',htmlspecialchars($this->blog->datum, ENT_QUOTES, 'UTF-8'))?> door <?php echo htmlspecialchars($this->blog->auteur, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><?php echo nl2br(htmlspecialchars($this->blog->content, ENT_QUOTES, 'UTF-8')); ?></p>
    </div>
</div>

