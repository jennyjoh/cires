<?php /* Template Name: CustomCiras */ ?>

<?php
//Set up variables
$server = '#';
$user = '#';
$pw = '#';
$db = '#';


//create connection
$conn = new mysqli($server, $user, $pw, $db);
// check connection
if ($conn ->connect_error){
    die("Connection failed:" . $conn->connect_error);
}

mysqli_set_charset($conn,"utf8");

//echo "Connected successfully";


?>

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>

			<?php astra_primary_content_top(); ?>
		

		<?php astra_content_page_loop(); ?>
		

		<?php astra_primary_content_bottom(); ?>
		<div class="trash-body">
		   
		   
		   
        <h2 id="anchor" class="trash-heading">
			Vælg din kommune
		</h2>
			
        <form class="municipality-select-form" action="#anchor" method="GET">
	<select onchange="this.form.submit()" id="Municipality_dropdown" name="Municipality_dropdown">
    <option>---</option>
  <?php  //get data from database
$querystring = "SELECT ID, name FROM Municipality ORDER BY name";
$result = $conn -> query($querystring);
		
if($result->num_rows>0) {
    //output data of each row
    while($row = $result->fetch_assoc()){
        $selectedString = '';
        if ($row['ID'] == $_GET['Municipality_dropdown']){ 
			$selectedString = 'selected' ;
		}

        echo '<option '.$selectedString.' value="'. $row['ID'].'">'.$row['name'].'</option>';
    }
} else {
    echo "0 results";
}

$conn ->close();

?>
    </select>
</form>


<div class="trash-container">
		
	

<!-- Her kalder jeg affaldstypen op -->

<?php $conn = new mysqli($server, $user, $pw, $db);
// check connection
if ($conn ->connect_error){
    die("Connection failed:" . $conn->connect_error);
}
			
mysqli_set_charset($conn,"utf8");

//echo "Connected successfully";

//get data from database
$sql = "SELECT Trash_types.name, Trash_types.imagefilepath, Trash_types.description
FROM Municipality_Trash_types, Trash_types
WHERE Municipality_Trash_types.mt_municipalityid  = ".$_GET['Municipality_dropdown']."
   AND Municipality_Trash_types.mt_trashtypeid = Trash_types.ID
   ORDER BY Trash_types.name";
$result = $conn -> query($sql);
if($result->num_rows>0) {
    //output data of each row
    while($row = $result->fetch_assoc()){
        echo "<div class='trash-element'>" . $row['ID'] . "<h2 class='trash-headline'>" . $row['name']. "</h2>" ."<br/>"
        ."<img class='myImg' alt='".$row['description']."' src='". get_theme_file_uri() ."/theme_images/" . $row['imagefilepath']
        . "'/>"
		//. "<br/>"."<div class='trash-description'>".$row['description']."</div>"
        . "<br/>" . "</div>";
    }
} else {
    echo "0 resultater";
}

?> 
		</div>
			
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<h3 class="trash-h3">Tryk på billedet for at læse mere om de enkelte fraktioner</h3>

<!-- Her prover jeg at faa affaldstypen kaldt op -->	
		
		</div>
       
		<!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php
get_footer();
