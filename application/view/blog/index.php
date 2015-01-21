<div class="container">
    <h2>You are in the View: application/view/blog/index.php (everything in this box comes from that file)</h2>
    <!-- add song form -->
    <div class="box">
        <h3>Add a blog</h3>
        <form action="<?php echo URL; ?>blog/addblog" method="POST">
            <label>auteur</label>
            <input type="text" name="auteur" value="" required />
            <label>titel</label>
            <input type="text" name="titel" value="" required /><br>
            <label>content</label><br>
            <textarea name="content" style="width:100%;height:200px;resize:vertical;"></textarea><br>
            <input type="submit" name="submit_add_blog" value="Submit" />
        </form>
    </div>
    <!-- main content output -->
    <div class="box">
        <h3>List of songs (data from first model)</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Id</td>
                <td>auteur</td>
                <td>titel</td>
                <td>Link</td>
                <td>DELETE</td>
                <td>EDIT</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->blogs as $blog) { ?>
                <tr>
                    <td><?php if (isset($blog->id)) echo htmlspecialchars($blog->id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($blog->auteur)) echo htmlspecialchars($blog->auteur, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($blog->titel)) echo htmlspecialchars($blog->titel, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <?php if (isset($blog->id)) { ?>
                            <a href="<?php echo URL .'blog/view/'.htmlspecialchars($blog->id, ENT_QUOTES, 'UTF-8'); ?>"><?php echo URL .'blog/view/'.htmlspecialchars($blog->id, ENT_QUOTES, 'UTF-8'); ?></a>
                        <?php } ?>
                    </td>
                    <td><a href="<?php echo URL . 'blog/deleteblog/' . htmlspecialchars($blog->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'blog/editblog/' . htmlspecialchars($blog->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
