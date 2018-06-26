<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <title>Git web switcher</title>
  </head>
  <body>
	  <div class="container">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
			  <a class="nav-link active" id="checkout-tab" data-toggle="tab" href="#checkout" role="tab" aria-controls="checkout" aria-selected="true">Checkout branch</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link " id="pull-tab" data-toggle="tab" href="#pull" role="tab" aria-controls="checkout" aria-selected="true">Pull</a>
			</li>
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="checkout" role="tabpanel" aria-labelledby="checkout-tab">
				<? if(isset($checkoutError)):?>
				<div class="alert alert-danger" role="alert"><?= $checkoutError ?></div>
				<?endif?>
				
				<div class="alert <? if(isset($status) && strpos($status, 'clean')):?>alert-success<?else:?>alert-danger<?endif?>" role="alert">
					<pre><?= $status ?></pre>
				</div>
				
				<? if(isset($msgInfo)):?>
				<div class="alert alert-info" role="alert"><?= '<pre>'.implode("</pre><br/><br/><pre>", $msgInfo).'</pre>' ?></div>
				<?endif?>
				
				<form method="POST">
					<input type="hidden" name="action" value="checkout">
					<div class="form-group">
					<label for="selBranch">Select branch</label>
					<?php if (!empty($branches)) { ?>
					<select class="form-control" id="selBranch" name="branch" required>
						<?php foreach ($branches as $row) { ?>
							<option <? if($row[0] == '*'):?>selected<?else:?>value="<?= trim($row, '* ') ?>"<?endif?>><?= $row ?></option>
						<?php } ?>
						</select>
					<?php } else { ?>
						<h2 class="no-records-found"><u>No branches found</u></h2>
					<?php } ?>
					</div>
					<?php if (!empty($branches)) { ?>
					<div class="form-group form-check">
						<input name="clean" value="1" type="checkbox" class="form-check-input" id="inp-clean">
						<label for="inp-clean">Clean directory before checkout?</label>
					</div>
					<button type="submit" class="btn btn-primary">Do checkout</button>
					<?php } ?>
				</form>
			</div>
			<div class="tab-pane fade" id="pull" role="tabpanel" aria-labelledby="pull-tab">
				<form method="POST">
					<input type="hidden" name="action" value="pull">
					<div class="form-group form-check">
						<input name="clean" value="1" type="checkbox" class="form-check-input" id="inp-clean-pull">
						<label for="inp-clean-pull">Clean directory before Pull?</label>
					</div>
					<button type="submit" class="btn btn-primary">Do Pull</button>
				</form>
			</div>
		</div>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>