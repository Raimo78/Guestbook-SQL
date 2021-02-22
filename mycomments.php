<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="Free App">
<meta name="keywords" content="HTML, CSS, PHP, SQL, Drawio, JavaScript">
<meta name="author" content="Raimo Jämsén">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guestbook System Comments App</title>
<link rel="stylesheet" type="text/css" href="CSS/comments.css">
<link rel="stylesheet" type="text/css" href="CSS/likeme.css">
<script src="jquery-3.5.1.min.js"></script>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>

</head>

<body>

<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<script>
var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 3000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}
</script>

<div class="about-section">
  <h1>Guestbook System Comments App</h1>
  <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="mycomments.php">Home</a>
  <a href="contactme.html">Contact</a>
</div>

<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>

<div style="display:none;" id="myDiv" class="animate-bottom">
  <h2>Welcome to my Website</h2>
  <p>To enjoy..</p>
</div>

</div>

<h2 style="text-align:center">Our Team</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="images/opiskelijaraimo.jpg" alt="Raimo Jämsén" style="width:100%">
      <div class="container">
        <h2>Raimo Jämsén <p class="title">Datanomi student</p><p>The developer of this application.</p><p>diskos78@gmail.com</p><p><button class="button">Contact</button></p></h2>
      </div>
    </div>
  </div>

	<div class="demo-container">
		<form action=" " id="frmComment" method="post">
			<div class="row">
				<label> Name: </label> <span id="name-info"></span><input class="form-field" id="name"
					type="text" name="user"> 
			</div>
			<div class="row">
				<label for="mesg"> Message : <span id="message-info"></span></label>
        <textarea class="form-field" id="message" name="message" rows="4"></textarea>

      </div>

			<div class="row">
				<label for="date"> Date : <span id="date-info"></span></label>
        <input type="text" name="date" class="form-control" value="<?php echo $date = date('m/d/Y h:i:s a', time());?>"/>
        <input placeholder="aika" class="textbox-n" type="text" onfocus="(this.type='date')" id="aika">
			</div>
			<div class="row">
				<input type="hidden" name="add" value="post" />
				<button type="submit" name="submit" id="submit" class="btn-add-comment">Add Comment</button>
				<img src="LoaderIcon.gif" id="loader" />
			</div>
		</form>

<?php

include_once 'connect.php';

$sql_sel = "SELECT * FROM tbl_user_comments ORDER BY id DESC";
$result = $conn->query($sql_sel);
$count = $result->num_rows;

    if($count > 0) {

?>
        <div id="comment-count">
        <span id="count-number"><?php echo $count;?></span> Comment(s)
        </div>

<?php } ?>
		<div id="response">
<?php

while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
{
?>
			<div id="comment-<?php echo $row["id"];?>" class="comment-row">
				<div class="comment-user"><?php echo $row["username"];?></div>
				<div class="comment-msg" id="msgdiv-<?php echo $row["id"];?>"><?php echo $row["message"];?></div>
        
      <?php 
     
      echo date("M,d,Y h:i:s A") . "\n"; 
     
      ?> 

				<div class="delete" name="delete"
					id="delete-<?php echo $row["id"];?>"
					onclick="deletecomment(<?php echo $row["id"];?>)">Delete</div>

        <div class="edit" name="edit"
					id="edit-<?php echo $row["id"];?>"
					onclick="editcomment(<?php echo $row["id"];?>)">Edit</div>
      </div>

      <div class="message-box" id="message_<?php echo $comments[$k]["id"];?>
        ">
      <div>

<?php 

}

?>
		</div>
	</div>

<?php 

?>
		</div>
	</div>

<h1 style="color:blue;">Likes the comments or you don't like it!</h1>

        <div class="comment-form-container">
            <form id="frm-comment">
                <div class="input-row">
                    <input type="hidden" name="comment_id" id="commentId"
                           placeholder="Name" /> <input class="input-field"
                           type="text" name="name" id="name" placeholder="Name" />
                </div>
                <div class="input-row">
                <p class="emoji-picker-container">
						<textarea class="input-field" data-emojiable="true"
							data-emoji-input="unicode" type="text" name="comment"
							id="comment" placeholder="Add a Comment"></textarea></p>
                </div>
                <div id="comments-wrapper">
				<div class="comment clearfix">
            <img src="ehdokas3.jpg" alt="Raimo" class="responsive" width="600" height="400"> 
						<div class="comment-details">
							<span class="comment-name">Raimo Jämsén</span>
							<span class="comment-date">Feb 18, 2021</span>
							<p>This is the first reply to this post on this website.</p>
							<a class="reply-btn" href="mycomments.php" >reply</a>
						</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		
	</div>
</div>
<div>
<input type="button" class="btn-submit" id="submitButton"
value="Send" /><div id="comment-message">Comments Added Successfully!</div>
        </div>
        </div>
        </form>

        </div>
        <div id="output"></div>
    </div>

<div class="footer">
   <p>Welcome to my homepage!</p>
   <p>By Raimo Jämsén Data2019C</p>
</div>

<script type="text/javascript"></script>
<script src="js/deletemycomments.js"></script>
<script src="js/editmycomments.js"></script>
<script src="js/likeme.js"></script>

</body>
</html>