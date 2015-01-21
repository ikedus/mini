<div class="container">
    <h2>You are in the View: application/view/song/edit.php (everything in this box comes from that file)</h2>
    <!-- add song form -->
    <div>
        <h3>Edit a blog</h3>
        <form action="<?php echo URL; ?>blog/updateblog" method="POST">
            <label>auteur</label>
            <input autofocus type="text" name="auteur" value="<?php echo htmlspecialchars($this->blog->auteur, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>titel</label>
            <input type="text" name="titel" value="<?php echo htmlspecialchars($this->blog->titel, ENT_QUOTES, 'UTF-8'); ?>" required /><br>
            <label>content</label><br>
            <textarea name="content" style="width:100%;height:200px;resize:vertical;"><?php echo htmlspecialchars($this->blog->content, ENT_QUOTES, 'UTF-8'); ?></textarea><br>
            <input type="hidden" name="blog_id" value="<?php echo htmlspecialchars($this->blog->id, ENT_QUOTES, 'UTF-8'); ?>" />
            <input type="submit" name="submit_update_blog" value="Update" />
        </form>
    </div>
</div>

