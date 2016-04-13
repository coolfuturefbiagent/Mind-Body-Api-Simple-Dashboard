
	<?php include("tem/header.html");?>

<form>
  <div class="form-group" method="post" action="userlogin.php">
    <label for="exampleInputEmail1">Source Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Source Name">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputFile">File input</label>
    <input type="file" id="exampleInputFile">
    <p class="help-block">Example block-level help text here.</p>
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Check me out
    </label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

	<?php include("tem/footer.html");?>