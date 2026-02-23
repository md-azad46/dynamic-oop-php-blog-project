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
.btn-delete{ background: #e74c3c; }
.btn:hover{ opacity: 0.85; }
</style>

<div class="grid_10">
    <div class="box round first grid">
        <h2>User List</h2>

        <?php
        // Delete user
        if (isset($_GET['deluser'])) {
            $deluser = mysqli_real_escape_string($db->link, $_GET['deluser']);
            $delquery = "DELETE FROM tbl_user WHERE id = '$deluser'";
            if ($db->delete($delquery)) {
                echo "<span class='success'>User Deleted Successfully.</span>";
            } else {
                echo "<span class='error'>User Not Deleted.</span>";
            }
        }
        ?>

        <div class="block">        
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Details</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php 
                $query = "SELECT * FROM tbl_user ORDER BY id DESC";
                $alluser = $db->select($query);
                if ($alluser) {
                    $i = 0;
                    while ($result = $alluser->fetch_assoc()) {
                        $i++;
                ?>
                    <tr class="odd gradeX">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['name']; ?></td>
                        <td><?php echo $result['username']; ?></td>
                        <td><?php echo $result['email']; ?></td>
                        <td><?php echo $fm->textShorten($result['details'], 30); ?></td>
                        <td>
                            <?php
                            if ($result['role'] == '0') {
                                echo 'Admin';
                            } elseif ($result['role'] == '1') {
                                echo 'Author';
                            } elseif ($result['role'] == '2') {
                                echo 'Editor';
                            }
                            ?>
                        </td>
                        <td>
                            <a class="btn btn-view"
                               href="viewuser.php?userid=<?php echo $result['id']; ?>">
                               View
                            </a>

                            <?php if (Session::get('userRole') == '0') { ?>
                                <a class="btn btn-delete"
                                   onclick="return confirm('Are you sure to delete this user?');"
                                   href="?deluser=<?php echo $result['id']; ?>">
                                   Delete
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                    }
                }
                ?>
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