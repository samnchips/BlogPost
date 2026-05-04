<?php 
session_start();
include "db.php";
include "allheader.php"; 
?>

<div style="max-width:1100px; margin:0 auto;">

<?php
$sql = "SELECT p.*, u.name as author_name, c.name as category_name 
        FROM posts p 
        LEFT JOIN users u ON p.author_id = u.id 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)):
?>
    <div class="post">
        <h2><?= htmlspecialchars($row['title']) ?></h2>
        <p><small>By <strong><?= htmlspecialchars($row['author_name']) ?></strong> • 
           <?= htmlspecialchars($row['category_name'] ?? 'Uncategorized') ?></small></p>
        
        <?php if(!empty($row['image'])): ?>
            <img src="image/<?= htmlspecialchars($row['image']) ?>" alt="">
        <?php endif; ?>

        <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>

        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] != "subscriber"): ?>
            <a href="updatepost.php?post_id=<?= $row['id'] ?>">Edit</a> | 
            <a href="deletepost.php?post_id=<?= $row['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
        <?php endif; ?>

        <hr>
        <h3>Comments</h3>

        <?php
        $post_id = $row['id'];
        $comments_sql = "SELECT * FROM comments WHERE post_id = '$post_id' ORDER BY id ASC";
        $comments_result = mysqli_query($conn, $comments_sql);

        while($comment = mysqli_fetch_assoc($comments_result)):
        ?>
            <div class="comment">
                <strong><?= htmlspecialchars($comment['user_name']) ?></strong>: 
                <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <br><a href="displaypost.php?reply_to=<?= $comment['id'] ?>&post_id=<?= $post_id ?>">Reply</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>

        <?php if(isset($_GET['reply_to']) && $_GET['post_id'] == $post_id): ?>
            <form action="insertcomment.php" method="post" style="margin-left:40px; margin-top:10px;">
                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                <input type="hidden" name="parent_id" value="<?= $_GET['reply_to'] ?>">
                <textarea name="comment" placeholder="Write your reply..." required></textarea><br>
                <input type="submit" name="submit" value="Post Reply">
                <a href="displaypost.php">Cancel</a>
            </form>
        <?php endif; ?>

        <?php if(isset($_SESSION['user_id'])): ?>
            <form action="insertcomment.php" method="post" style="margin-top:25px;">
                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                <textarea name="comment" placeholder="Write a comment..." required></textarea><br>
                <input type="submit" name="submit" value="Post Comment">
            </form>
        <?php else: ?>
            <p><a href="login.php">Login</a> to comment.</p>
        <?php endif; ?>
    </div>
<?php endwhile; ?>

<a href="dashboard.php" class="btn" style="display:inline-block; margin-top:30px;">← Back to Dashboard</a>

</div>
</body>
</html>