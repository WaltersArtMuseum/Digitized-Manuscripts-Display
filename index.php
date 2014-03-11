<?
error_reporting(E_ALL);
ini_set('display_errors', 1);

// open database
$dbh=new PDO("mysql:dbname=walters;host=localhost;charset=utf8", "walters", "sql4secret");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <!--[if IE 8]>
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <![endif]-->
    <meta name="keywords" content="" />
    <meta name="description" content="With more than 900 illuminated manuscripts, 1,250 of the first printed books (ca. 1455 - 1500), and an important collection of post-1500 deluxe editions, this extraordinary collection chronicles the art of the book over more than 1,000 years. The collection is from all over the world, and from ancient to modern times. It features deluxe Gospel books from Armenia, Ethiopia, Byzantium, and Ottonian Germany, French and Flemish books of hours, as well as masterpieces of Safavid, Mughal and Ottoman manuscript illumination. It also includes important first printed editions of ancient texts by great thinkers such as Aristotle and Euclid, diaries written by Napoleon and intricate bindings crafted by Tiffany. The early printed book collection highlights the experimental nature of the first attempts at printing. Some of these books have been illuminated by hand, and many are unique objects.&amp;nbsp;" />
    
    <title>The Digital Walters</title>
    
    <link rel="shortcut icon" href="http://art.thewalters.org/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="http://art.thewalters.org/css/app.css" type="text/css" media="all" />
    <link rel="stylesheet" href="http://art.thewalters.org/css/print.css" type="text/css" media="print" />
    
    <link rel="alternate" type="application/rss+xml" title="Artwork of the Day RSS Feed" href="http://art.thewalters.org/feed/" />
    
    <script src="http://art.thewalters.org/js/app.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>
    
    <!--[if IE]>
    <script src="http://art.thewalters.org/js/html5.js"></script>
    <![endif]-->
    <!--[if IE 6]>
    <link rel="stylesheet" href="http://art.thewalters.org/css/ie6.css" type="text/css" media="all" />
    <script src="http://www.fastspot.com/_ie/c.js"></script>
    <![endif]-->
    
    <noscript>
      <link rel="stylesheet" href="http://art.thewalters.org/css/no-script.css" type="text/css" media="all" />
    </noscript>
    <link rel="stylesheet" href="/html/custom.css" type="text/css" media="screen" />
  </head>
  <body>
    <header id="tray">
      <div class="shadow">
	<div class="bar dark">
	  <div class="container">
	    <a href="http://www.thewalters.org/" class="logo left no_select" target="_blank">The Walters Art Museum</a>
	    <div class="jumper right">
	      <div class="browse_options left user fb_show" style="display: none;">
		<a href="http://art.thewalters.org/browse/?type=community&filter=me" class="button browse my no_select">My Collections</a>
		<nav>
		  <div class="contain">
		    <a href="http://art.thewalters.org/user/edit/">Collection Editor</a>
		  </div>
		</nav>
	      </div>
	      <div class="browse_options left">
		<a href="http://art.thewalters.org/browse/" class="button browse no_select">Browse Collection</a>
		<nav>
		  <div class="contain">
		    <a href="http://art.thewalters.org/browse/?type=category">Categories</a>
		    <a href="http://art.thewalters.org/browse/?type=creator">Creators</a>
		    <a href="http://art.thewalters.org/browse/?type=date">Dates</a>
		    <a href="http://art.thewalters.org/browse/?type=medium">Medium</a>
		    <a href="http://art.thewalters.org/browse/?type=location">Museum Locations</a>
		    <a href="http://art.thewalters.org/browse/?type=places">Places</a>
		    <a href="http://art.thewalters.org/browse/?type=community">Community</a>
		    <a href="http://art.thewalters.org/browse/?type=tags">Tags</a>
		  </div>
		</nav>
	      </div>
	      <form action="http://art.thewalters.org/search/" method="get" class="left">
		<a href="http://art.thewalters.org/search/" class="no_select">Advanced Search</a>
		<input type="text" autocomplete="off" id="search_term" name="query" class="text" />
		<input type="hidden" name="type" value="search" />
		<input type="hidden" name="all_fields" value="true" />
		<input type="submit" value="Search" class="button" />
	      </form>
	    </div>
	  </div>
	</div>
	<div class="bar light contain no_select">
	  <div class="container">
	    <nav>
	      <a href="http://art.thewalters.org/" class="home">Works of Art</a>
	      <a href="http://thewalters.org/about/">About</a>
	      <a href="http://thewalters.org/visit/">Visit</a>
	      <a href="http://thewalters.org/exhibitions/">Exhibitions</a>
	      <a href="http://thewalters.org/eventscalendar/">Events</a>
	      <a href="http://thewalters.org/giving/">Giving</a>
	      <a href="http://thewalters.org/store/">Store</a>
	      <a href="http://thewalters.org/research/">Research</a>
	      <a href="http://thewalters.org/news/">Press</a>
	    </nav>
	  </div>
	</div>
      </div>
    </header>
    <div id="wrapper" class="container">
      <div id="content" class="container browse">
	<header class="no_select">
	  <a href="http://art.thewalters.org/browse/?type=category" class="breadcrumb">&lsaquo; The Walters Art Museum</a>
	  <br class="clear" />
	  <h1>The Digital Walters</h1>
	</header>
	<hr />
	<section class="intro contain">
	  <div class="description left contain thin" style="width: 990px;">




	<h3>Find manuscripts:</h3>

	<form>

	<label for="search">Search terms <input id="search" name="search"></label><input type="button" value="Search" onclick="findManuscriptsAndFolios()"> &nbsp; Search by <input type="checkbox" checked="checked">Manuscripts <input type="checkbox" checked="checked">Folios (within manuscripts) 
	<div style="margin-bottom: 15px;"></div>

<div style="width: 165px; float: left;">
	<div style="width: 110px; float: left;">Culture(s):</div>
	<div style="width: 50px; float: right;"><input type="checkbox" id="culture_all" value="culture" onchange="checkAll('culture')"><label for="culture_all">All</label></div>
	<br style="clear: both;" />
	<div style="width: 150px; height: 150px; overflow-y: scroll; border: 1px solid green; background-color: #f7f5f0;">
		<?paintBox('Culture');?>
	</div>
</div>

<div style="width: 165px; float: left;">
	<div style="width: 110px; float: left;">Geography(s):</div>
	<div style="width: 50px; float: right;"><input type="checkbox" id="geography_all" value="geography" onchange="checkAll('geography')"><label for="geography_all">All</label></div>
	<br style="clear: both;" />
	<div style="width: 150px; height: 150px; overflow-y: scroll; border: 1px solid green; background-color: #f7f5f0">
		<?paintBox('Geography');?>
	</div>
</div>

<div style="width: 165px; float: left;">
	<div style="width: 110px; float: left;">Book Type(s):</div>
	<div style="width: 50px; float: right;"><input type="checkbox" id="book_type_all" value="book_type" onchange="checkAll('book_type')"><label for="book_type_all">All</label></div>
	<br style="clear: both;" />
	<div style="width: 150px; height: 150px; overflow-y: scroll; border: 1px solid green; background-color: #f7f5f0;">
		<?paintBox('Book Type');?>
	</div>
</div>

<div style="width: 165px; float: left;">
	<div style="width: 110px; float: left;">Subject(s):</div>
	<div style="width: 50px; float: right;"><input type="checkbox" id="subject_all" value="subject" onchange="checkAll('subject')"><label for="subject_all">All</label></div>
	<br style="clear: both;" />
	<div style="width: 150px; height: 150px; overflow-y: scroll; border: 1px solid green; background-color: #f7f5f0;">
		<?paintBox('Subject');?>
	</div>
</div>

<div style="width: 165px; float: left;">
	<div style="width: 110px; float: left;">Descr. Term(s):</div>
	<div style="width: 50px; float: right;"><input type="checkbox" id="descriptive_all" value="descriptive" onchange="checkAll('descriptive')"><label for="descriptive_all">All</label></div>
	<br style="clear: both;" />
	<div style="width: 150px; height: 150px; overflow-y: scroll; border: 1px solid green; background-color: #f7f5f0;">
		<?paintBox('Descriptive');?>
	</div>
</div>

<div style="width: 165px; float: left;">
	<div style="width: 110px; float: left;">Date(s):</div>
	<div style="width: 50px; float: right;"><input type="checkbox" id="century_all" value="century" onchange="checkAll('century')"><label for="century_all">All</label></div>
	<br style="clear: both;" />
	<div style="width: 150px; height: 150px; overflow-y: scroll; border: 1px solid green; background-color: #f7f5f0;">
		<?paintBox('Century');?>
		<input type="checkbox" id="check_specific_dates_checkbox" onchange="check_specific_dates()">Specific Dates
		<div id="specific_dates" style="display: none;">
			<label for="year-start">Year start <input id="year-start" name="years"></label>
			<label for="year-start">Year end <input id="year-end" name="years"></label>
		</div>
	</div>
</div>

<?
function paintBox($this_keyword_category) {
	global $dbh;
	// let's get the current keywords
	$this_keyword_html = strtolower(str_replace(' ', '_', $this_keyword_category));
	//print '<input type="checkbox" id="group_' . strtolower(str_replace(' ', '_', $this_keyword_category)) . '_all" value="All"><label for="group_' . strtolower(str_replace(' ', '_', $this_keyword_category)) . '_all">All</label><br />';
	$stmt = $dbh->prepare('SELECT * FROM keywords WHERE category=:category ORDER BY category_type DESC, keyword');
	$stmt->bindParam(':category', $this_keyword_category);
	$stmt->execute();
	$current_category_type = '';
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$row_keyword_id = $row['keyword_id']; // 1
		$row_category = $row['category']; // Book type
		$row_category_type = $row['category_type']; // Book type
		$row_keyword = $row['keyword']; // Antiphonary
		$keywords_from_db[$row_keyword] = array('id'=>$row_keyword_id, 'category'=>$row_category);
		if ($row_category_type != $current_category_type) {
			$current_category_type = $row_category_type;
			print "\n" . '		<div style="padding-top: 5px; font-style: italic;">' . $current_category_type . '</div>';
		}
		print "\n" . '		<input type="checkbox" class="inputs_' . $this_keyword_html . '" id="group_' . $this_keyword_html . "_" . $row_keyword_id . '" value="' . trim($row_keyword_id) . '" onchange="checkTerms(\'' . $this_keyword_html . '\')"><label for="group_' . $this_keyword_html . "_" . $row_keyword_id . '">' . trim($row_keyword) . '</label><br />';
	}
} //end function paintBox($this_keyword_category) {
?>

<script type="text/javascript">
$( document ).ready(function() {
	//	console.log( "document ready" );
	//$('#specific_dates').show();
});
function checkTerms(which) {
	//alert (which);
	$('#'+which+'_all').attr("checked", false);
	findManuscriptsAndFolios();
}
function checkAll(which) {
	//alert ('.inputs_'+which);
	$('.inputs_'+which).attr("checked", false);
	findManuscriptsAndFolios();
}
function check_specific_dates() {
	if ($('#check_specific_dates_checkbox').is(":checked")) {
		$('#specific_dates').show();
	} else {
		$('#specific_dates').hide();
	}
}
function gotowork(acc) {
	acc = acc.replace('.', '');
	window.location.href = "http://www.thedigitalwalters.org/Data/WaltersManuscripts/"+acc;
}
function findManuscriptsAndFolios() {
	sList = '';
	$('input[type=checkbox]:checked').each(function () {
	    if ($(this).val()!='on') sList += $(this).val() + ',';
	});
	sSearch = $('#search').val();
	//console.log (sList);
//jQuery.each( $('.inputs_culture').isChecked, function( i, val ) {
//	console.log (val);
	//$( "#" + i ).append( document.createTextNode( " - " + val ) );
//});
	$.ajax({
		type: "GET",
		url: "find.php",
		dataType: "Json",
		data: { get_list: sList, search_term: sSearch }
	})
	.done(function( data ) {
		htmlOutput = '';
		if (data) {
			for (var x = 0; x < data.length; x++) {
				//console.log (data[x].id);
				//console.log (data[x].thumb_image);
				htmlOutput += '<div class="results_pane"><img src="' + data[x].thumb_image + '" /><span class="restults_title">' + data[x].title + '</span> <b>'+data[x].acc+'</b><br />'+data[x].abstract+'<br /><i>'+data[x].place+'</i><br /><b>'+data[x].date+'</b><br /><input type="submit" value="Go to project" onclick="gotowork(\''+data[x].acc+'\')" /></div>';
			}
		}
		$("#results_bank").html(htmlOutput);
		//alert( "Got: " + msg );
	});
}
</script>

</form>

<br style="clear: both;" />
<br /><br />

<div id="results_bank">Choose some options above...</div>

<style>
.results_pane {float: left; overflow: hidden; width: 306px; height: 191px; margin-right: 12px; margin-bottom: 12px;  border: 1px solid green; line-height: 16px; padding: 4px; color: #666; font-size: 12px;}
.results_pane img {float: left; margin-right: 5px; }
.results_pane .restults_title {font-family: "WaltersGothicRegular", sans-serif; color: #9F907D; font-size: 16px; font-weight: normal; text-transform: uppercase;}
</style>
</div>

</section>
</div>

&nbsp;<br />
&nbsp;<br />
&nbsp;<br />


</div>
<div id="loading"></div>
<div id="object_preview">
  <div class="inner"></div>
</div>
</body>
</html>
