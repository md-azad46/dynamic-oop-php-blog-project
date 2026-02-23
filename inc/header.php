<?php include 'config/config.php';?>
<?php include 'lib/Database.php';?>
<?php include 'helpers/Format.php';?>

<?php
$db = new Database();
$fm = new Format();
?>

<!DOCTYPE html>
<html>
<head>	
	<?php include 'scripts/meta.php'; ?>
	<?php include 'scripts/css.php'; ?>
	<?php include 'scripts/js.php'; ?>
</head>

<body>
	<div class="headersection templete clear">
		<a href="index.php">
			<div class="logo">
				<?php
				$query = "SELECT * FROM title_slogan WHERE id ='1'";
				$blog_title = $db->select($query);
				if ($blog_title) {
				    while ($result = $blog_title->fetch_assoc()) {
				        ?>
				<img src="admin/<?php echo $result['logo']; ?>" alt="Logo"/>
				<h2><?php echo $result['title']; ?></h2>
				<p><?php echo $result['slogan']; ?></p>
				<?php
				    }
				} ?>
			</div>
		</a>

		<div class="social clear">
			<div class="icon clear">
				<?php
				$query = "SELECT * FROM tbl_social WHERE id ='1'";
				$social_media = $db->select($query);
				if ($social_media) {
				    while ($result = $social_media->fetch_assoc()) {
				        ?>
				<a href="<?php echo $result['fb']; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
				<a href="<?php echo $result['tw']; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
				<a href="<?php echo $result['ln']; ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
				<a href="<?php echo $result['gp']; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
				<?php
				    }
				} ?>
			</div>

			<div class="searchbtn clear">
			    <form action="search.php" method="get" class="custom-search-form">
			        <input type="text" name="search" placeholder="Search keyword..." class="custom-search-input"/>
			        <input type="submit" name="submit" value="Search" class="custom-search-btn"/>
			    </form>
			</div>
		</div>
	</div>

<div class="navsection templete">
	<?php 
	$path = $_SERVER['SCRIPT_FILENAME'];
	$currentpage = basename($path, '.php');
	?>
	<ul>
		<li><a <?php if ($currentpage == 'index') echo 'id="active"'; ?> href="index.php">Home</a></li>
		<?php
		$query = "SELECT * FROM tbl_page";
		$pages = $db->select($query);
		if ($pages) {
		    while ($result = $pages->fetch_assoc()) {
		        ?>
		<li><a <?php if (isset($_GET['pageid']) && $_GET['pageid'] == $result['id']) echo 'id="active"'; ?> href="page.php?pageid=<?php echo $result['id']; ?>"><?php echo $result['name']; ?></a></li>
		<?php
		    }
		}
		?>
		<li><a <?php if ($currentpage == 'contact') echo 'id="active"'; ?> href="contact.php">Contact</a></li>
	</ul>
</div>

<!-- ===== Custom CSS ===== -->
<style>
/* --- Search Bar --- */
.custom-search-form {
    display: flex;
    align-items: center;
    gap: 5px;
}

.custom-search-input {
    background-color: white !important;
    color: black !important;
    border: 1px solid #ccc;
    padding: 6px 10px;
    border-radius: 4px;
    flex: 1;
    font-size: 14px;
    outline: none;
    transition: 0.3s;
}

.custom-search-input::placeholder {
    color: #888 !important;
}

.custom-search-input:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76,175,80,0.3);
}

/* --- Search Button --- */
.custom-search-btn {
    background-color: #007BFF !important; /* default blue */
    color: white !important;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
}

.custom-search-btn:hover {
    background-color: #0056b3 !important; /* darker blue on hover */
}

.custom-search-btn:active {
    background-color: #28a745 !important; /* green on click */
}

/* --- Social Buttons (Blue like search button) --- */
.social .icon a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #007BFF !important; /* default blue */
    color: white !important; /* icon color */
    width: 35px;
    height: 35px;
    border-radius: 50%;
    font-size: 16px;
    margin-right: 5px;
    text-align: center;
    transition: 0.3s;
}

.social .icon a:hover {
    background-color: #0056b3 !important; /* darker blue */
}

.social .icon a:active {
    background-color: #28a745 !important; /* green on click */
}

/* --- Navbar Links --- */
.navsection ul li a {
    text-decoration: none;
    transition: 0.3s;
}

.navsection ul li a:hover {
    color: #0056b3; /* optional hover, no theme override */
}

.navsection ul li a#active {
    color: #28a745; /* active page */
    font-weight: bold;
}/* ===== Navbar Container ===== */
.navsection.templete {
    background-color: #003366 !important; /* Dark Blue background */
    padding: 4px 0;                       /* Compact height */
    max-width: 1200px;                    /* Limit navbar width */
    margin: 0 auto;                       /* Center navbar */
}

/* ===== Navbar Links ===== */
.navsection ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    gap: 5px;  /* Space between links */
}

.navsection ul li {
    display: inline-block;
}

.navsection ul li a {
    color: white !important;       /* Text white */
    padding: 4px 10px;             /* Slim buttons */
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    transition: 0.3s;
}

/* ===== Hover effect ===== */
.navsection ul li a:hover {
    background-color: #0056b3 !important; /* Lighter blue */
}

/* ===== Active page ===== */
.navsection ul li a#active {
    background-color: #28a745 !important; /* Green */
    color: white !important;
}
</style>