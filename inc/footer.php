</div>

	<div class="footersection templete clear">
	  <div class="footermenu clear">
         <h2 style="margin-bottom:20px;">My Blog</h2>
		<ul>
            
  <li><a href="index.php">Home</a></li>
  <li><a href="#">About</a></li>
  <li><a href="contact.php">Contact Us</a></li>
  <li><a href="#">Privacy</a></li>
</ul>
	  </div>
	  <?php 
                    $query = "SELECT * FROM tbl_footer WHERE id ='1'";
                    $footernote = $db->select($query);
                    if ($footernote) {
                        while ($result = $footernote->fetch_assoc()) {
                            ?>
	  <p>&copy; <?php echo $result['note'] ?> 2025- <?php echo date('Y'); ?></p>
	  <?php
                        }
                    } ?>
	</div>
	<div class="fixedicon clear">
		<?php 
                    $query = "SELECT * FROM tbl_social WHERE id ='1'";
                    $social_media = $db->select($query);
                    if ($social_media) {
                        while ($result = $social_media->fetch_assoc()) {
                            ?>
		<a href="<?php echo $result['fb']; ?>" target="_blank"><img src="images/fb.png" alt="Facebook"/></a>
		<a href="<?php echo $result['tw']; ?>" target="_blank"><img src="images/tw.png" alt="Twitter"/></a>
		<a href="<?php echo $result['ln']; ?>" target="_blank"><img src="images/in.png" alt="LinkedIn"/></a>
		<a href="<?php echo $result['gp']; ?>" target="_blank"><img src="images/gl.png" alt="GooglePlus"/></a>
		<?php
                        }
                    } ?>
	</div>
<script type="text/javascript" src="js/scrolltop.js"></script>
</body>
</html>


<style>
	
.footersection {
    background-color: #222;
    padding: 20px 0;
    color: white;
}

.footersection .footermenu ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center;  /* Links centered */
    gap: 20px;
}

.footersection .footermenu ul li a {
    color: white;           /* Color আগের মতো থাকবে */
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
}

.footersection .footermenu ul li a:hover {
    color: #007BFF;         /* Hover effect আগের মতো থাকবে */
}


</style>