<?
// open database
$dbh=new PDO("mysql:dbname=walters;host=localhost;charset=utf8", "walters", "sql4secret");

$get_list = $_GET['get_list'];

$sql_keywords = '';
foreach (explode(',', $get_list) as $item) {
	if (is_numeric($item)) {
		$sql_keywords .= 'keywords.keyword_id=' . (int)$item . ' OR ';
	} else {
		$sql_keywords .= "keywords.category='" . $item . "' OR ";
	}
}
$sql_keywords = substr($sql_keywords, 0, -3);
//print($sql_keywords);
//exit();

//mail ('m@diedrick.com', 'whatsup with Walters?', "Post:\n\n" . serialize($_POST) . "\n\nGet:\n\n" . serialize($_GET));

if (isset($_GET['search_term']) && $_GET['search_term'] && !$_GET['get_list']) {
	$stmt = $dbh->prepare('SELECT * FROM manuscripts, manuscripts_keywords, keywords WHERE 
		manuscripts.manuscript_id=manuscripts_keywords.manuscript_id AND
		manuscripts_keywords.keyword_id = keywords.keyword_id AND
		(abstract like :search OR title like :search_title)
		GROUP BY manuscripts.manuscript_id');
	$search_term = '%' . trim($_GET['search_term']) . '%';
	$stmt->bindParam(':search', $search_term);
	$stmt->bindParam(':search_title', $search_term);
} elseif (isset($_GET['search_term']) && $_GET['search_term'] && $_GET['get_list']) {
	$stmt = $dbh->prepare('SELECT * FROM manuscripts, manuscripts_keywords, keywords WHERE 
		manuscripts.manuscript_id=manuscripts_keywords.manuscript_id AND
		manuscripts_keywords.keyword_id = keywords.keyword_id AND
		(abstract like :search OR title like :search_title) AND
		(' . $sql_keywords . ') LIMIT 0, 12');
	$search_term = '%' . trim($_GET['search_term']) . '%';
	$stmt->bindParam(':search', $search_term);
	$stmt->bindParam(':search_title', $search_term);
} else {
	$stmt = $dbh->prepare('SELECT * FROM manuscripts, manuscripts_keywords, keywords WHERE 
		manuscripts.manuscript_id=manuscripts_keywords.manuscript_id AND
		manuscripts_keywords.keyword_id = keywords.keyword_id AND
		(' . $sql_keywords . ') LIMIT 0, 12');
}
//$stmt->bindParam(':cms_admin_id', $get_id);
$stmt->execute();
$row_count = $stmt->rowCount();
$output_json = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	/*foreach ($row as $field=>$value) {
		print '<br />';
		print '    $row_' . $field . ' = $row[\'' . $field . '\']; // ' . $value;
	}*/

	$row_manuscript_id = $row['manuscript_id']; // 8
	$row_accession_number = $row['accession_number']; // W.144
	$row_title = $row['title']; // Walters Ms. W.144, Les livres du gouvernement des roys et des princes
	$row_abstract = $row['abstract']; // This early fourteenth-century English manuscript is an example of Henri de Gauchy’s French translation of De regimine principum, a text that is an important witness to the flowering of the “mirror for princes” genre at the courts of the Capetian kings of France. Giles of Rome first composed De regimine principum for Philip the Fair of France around 1277, and it was soon translated into several vernacular languages. Henri de Gauchy’s was the most prolifically copied of the French translations, and remains extant in thirty-one copies, six of which are of English origin. W.144 is one of a cluster of illuminated manuscripts of a political nature produced during the last years of the reign of King Edward II and the minority of Edward III, a tumultuous period in English history during which concerns about good government came to the fore. Although the manuscript contains no evidence of ownership prior to 1463, the quality of the illumination in W.144 suggests that this book was originally destined for a king or member of the nobility. The text is divided into three books intended to instruct princes on their ethical, economic, and political responsibilities: the conduct of the individual ruler; the rule of the family and household; and, the governance of the kingdom. Scenes of princes and scholars conversing, as wells as princes instructing their queens and children, are among the ten miniatures and historiated initials. Stylistically, the book is a member of the Queen Mary Psalter group (London, British Library Royal 2 B VII), although aspects of its illumination also relate it to other important groups of manuscripts produced in early fourteenth-century England.
	$row_language = $row['language']; // The primary language in this manuscript is French, Old (842-ca.1400).
	$row_media_type = $row['media_type']; // book
	$row_material = $row['material']; // parchment
	$row_not_before = $row['not_before']; // 1300
	$row_not_after = $row['not_after']; // 1330
	$row_orig_date = $row['orig_date']; // First third of the 14th century CE
	$row_orig_place = $row['orig_place']; // London (?), England
	$row_thumb_image = $row['thumb_image']; // London (?), England
	$row_thumb_image = 'http://www.thedigitalwalters.org/Data/WaltersManuscripts/' . str_replace('.', '', $row_accession_number) . '/data/' . $row_accession_number . '/' . $row_thumb_image;
	$row_id = $row['id']; // 108
	$row_keyword_id = $row['keyword_id']; // 7
	$row_keyword = $row['keyword']; // Document
	$row_category = $row['category']; // Book type
	$row_category_type = $row['category_type']; // 
	$row_abstract = implode(' ', array_slice(explode(' ', $row_abstract), 0, 12));

	$output_json[] = array('acc'=>$row_accession_number, 'id'=>$row_manuscript_id, 'thumb_image'=>$row_thumb_image, 'title'=>$row_title, 'abstract'=>$row_abstract, 'date'=>$row_orig_date, 'place'=>$row_orig_place);
}
//print_r ($stmt->errorInfo());
$stmt = null;

header('Content-Type: application/json');
print json_encode($output_json);
?>