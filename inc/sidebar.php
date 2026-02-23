<div class="sidebar clear">
			<div class="samesidebar clear">
				<h2>Categories</h2>
					<ul>

					<?php 

                $query = "SELECT * FROM tbl_category";
                $category = $db->select($query);
                if ($category) {
                    while ($result = $category->fetch_assoc()) {
                        ?>

						<li><a href="posts.php?category=<?php echo $result['id']; ?>"><?php echo $result['name'] ?></a></li>
					<?php
                    }
                } else {
                    ?>
				<li>No Category Created.</li>
			<?php
                } ?>					
					</ul>
			</div>
			
			<div class="samesidebar clear">
				<h2>Latest articles</h2>

				<?php 
            $query = "SELECT * FROM tbl_post LIMIT 5";
            $post = $db->select($query);
            if ($post) {
                while ($result = $post->fetch_assoc()) {
                    ?>


					<div class="popular clear">
						<h3><a href="post.php?id=<?php echo $result['id']; ?>"><?php echo $result['tittle']; ?></a></h3>
						<a href="post.php?id=<?php echo $result['id']; ?>"><img src="admin/<?php echo $result['image']; ?>" alt="post image"/></a>
						 <?php echo $fm->textShorten($result['body'], 500); ?> 	
					</div>
					<?php
                }
            } else {
                header("Location:404.php");
            } ?>
					
	
			</div>
			
		</div>

		<style>
/* Sidebar h2 as responsive dark blue button */
.sidebar .samesidebar h2 {
    display: inline-block;         /* Button look */
    background-color: #003366;     /* Dark blue */
    color: white;                  /* White text */
    padding: 10px 15px;            /* Vertical + horizontal padding */
    min-width: 150px;              /* Minimum width */
    max-width: 100%;               /* Flexible up to container width */
    border-radius: 5px;            /* Rounded corners */
    margin-bottom: 15px;           /* Space below */
    font-size: 18px;               /* Text size */
    text-align: center;            /* Center the text */
    box-sizing: border-box;        /* Padding included in width */
    word-wrap: break-word;         /* Wrap text if too long */
}
		</style>