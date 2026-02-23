<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<style>
.btn{
    padding: 5px 10px;
    text-decoration: none;
    color: #fff;
    border-radius: 4px;
    font-size: 13px;
    margin-right: 4px;
    display: inline-block;
}
.btn-view{ background: #3498db; }
.btn-reply{ background: #2ecc71; }
.btn-seen{ background: #f39c12; }
.btn-unseen{ background: #9b59b6; }
.btn-delete{ background: #e74c3c; }
.btn:hover{ opacity: 0.85; }
</style>

<div class="grid_10">

<!-- ================= INBOX ================= -->
<div class="box round first grid">
    <h2>Inbox</h2>

    <?php
    // Move to Seen
    if (isset($_GET['seenid'])) {
        $seenid = mysqli_real_escape_string($db->link, $_GET['seenid']);
        $query = "UPDATE tbl_contact SET status='1' WHERE id='$seenid'";
        if ($db->update($query)) {
            echo "<span class='success'>Message moved to Seen Box</span>";
        } else {
            echo "<span class='error'>Something went wrong</span>";
        }
    }
    ?>

    <div class="block">
        <table class="data display datatable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Sender</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $query = "SELECT * FROM tbl_contact WHERE status='0' ORDER BY id DESC";
            $msg = $db->select($query);
            if ($msg) {
                $i = 0;
                while ($result = $msg->fetch_assoc()) {
                    $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $result['firstname'].' '.$result['lastname']; ?></td>
                    <td><?php echo $result['email']; ?></td>
                    <td><?php echo $fm->textShorten($result['body'], 30); ?></td>
                    <td><?php echo $fm->formatDate($result['date']); ?></td>
                    <td>
                        <a class="btn btn-view" href="viewmsg.php?msgid=<?php echo $result['id']; ?>">View</a>
                        <a class="btn btn-reply" href="replymsg.php?msgid=<?php echo $result['id']; ?>">Reply</a>
                        <a class="btn btn-seen"
                           onclick="return confirm('Move this message to Seen?');"
                           href="?seenid=<?php echo $result['id']; ?>">
                           Seen
                        </a>
                    </td>
                </tr>
            <?php } } ?>

            </tbody>
        </table>
    </div>
</div>

<!-- ================= SEEN MESSAGES ================= -->
<div class="box round first grid">
    <h2>Seen Messages</h2>

    <?php
    // Delete Message
    if (isset($_GET['delid'])) {
        $delid = mysqli_real_escape_string($db->link, $_GET['delid']);
        $delquery = "DELETE FROM tbl_contact WHERE id='$delid'";
        if ($db->delete($delquery)) {
            echo "<span class='success'>Message Deleted Successfully</span>";
        } else {
            echo "<span class='error'>Message Not Deleted</span>";
        }
    }

    // Move to Unseen
    if (isset($_GET['unseenid'])) {
        $unseenid = mysqli_real_escape_string($db->link, $_GET['unseenid']);
        $query = "UPDATE tbl_contact SET status='0' WHERE id='$unseenid'";
        if ($db->update($query)) {
            echo "<span class='success'>Message moved to Unseen Box</span>";
        } else {
            echo "<span class='error'>Something went wrong</span>";
        }
    }
    ?>

    <div class="block">
        <table class="data display datatable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Sender</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $query = "SELECT * FROM tbl_contact WHERE status='1' ORDER BY id DESC";
            $msg = $db->select($query);
            if ($msg) {
                $i = 0;
                while ($result = $msg->fetch_assoc()) {
                    $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $result['firstname'].' '.$result['lastname']; ?></td>
                    <td><?php echo $result['email']; ?></td>
                    <td><?php echo $fm->textShorten($result['body'], 30); ?></td>
                    <td><?php echo $fm->formatDate($result['date']); ?></td>
                    <td>
                        <a class="btn btn-delete"
                           onclick="return confirm('Delete this message?');"
                           href="?delid=<?php echo $result['id']; ?>">
                           Delete
                        </a>
                        <a class="btn btn-view" href="viewmsg.php?msgid=<?php echo $result['id']; ?>">View</a>
                        <a class="btn btn-unseen" href="?unseenid=<?php echo $result['id']; ?>">Unseen</a>
                    </td>
                </tr>
            <?php } } ?>

            </tbody>
        </table>
    </div>
</div>

</div>

<script type="text/javascript">
$(document).ready(function () {
    setupLeftMenu();
    $('.datatable').dataTable();
    setSidebarHeight();
});
</script>

<?php include 'inc/footer.php'; ?>