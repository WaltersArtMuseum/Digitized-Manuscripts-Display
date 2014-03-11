<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
$write_to_dbs = true; // for testing

if (isset($_GET['go']) && $_GET['go']='go') { // let's do it!
	print 'Start...';
	//exit();
	// open database
	$dbh=new PDO("mysql:dbname=walters;host=localhost;charset=utf8", "walters", "sql4secret");
	
	// WARNING -- this will remove all current data (excektp keywords) so that you can republish it all
	if ($write_to_dbs) {
		$stmt = $dbh->prepare('TRUNCATE folios');
		$stmt->execute();
		$stmt = $dbh->prepare('TRUNCATE manuscripts');
		$stmt->execute();
		$stmt = $dbh->prepare('TRUNCATE manuscripts_keywords');
		$stmt->execute();
	}
	
	// let's get the current keywords
	$stmt = $dbh->prepare('SELECT * FROM keywords');
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$row_keyword_id = $row['keyword_id']; // 1
		$row_category = $row['category']; // Book type
		$row_keyword = $row['keyword']; // Antiphonary
		$keywords_from_db[$row_keyword] = array('id'=>$row_keyword_id, 'category'=>$row_category);
	}
	
	// open file
	$file = file_get_contents('http://www.thedigitalwalters.org/Data/WaltersManuscripts/ManuscriptDescriptions/');
	
	// run regular expression to find links
	$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
	preg_match_all("/$regexp/siU", $file, $matches);
	
	$xml_file_array = array();
	foreach ($matches[2] as $this_file) {
		if (substr($this_file, -4) == '.xml') {
			$xml_file_array[] = $this_file;
		}
	}
	
	//print_r($xml_file_array);
	
	for ($i=0; $i<count($xml_file_array); $i++) {
		//print '<li>' . $i;
		//$manuscript_xml_html = file_get_contents('http://www.thedigitalwalters.org/Data/WaltersManuscripts/ManuscriptDescriptions/' . $xml_file_array[$i]);
		//$manuscript_xml_html = str_replace('Original Binding', 'Original binding', $manuscript_xml_html);
		//$manuscript_xml = simplexml_load_string($manuscript_xml_html);
		$manuscript_xml = simplexml_load_file('http://www.thedigitalwalters.org/Data/WaltersManuscripts/ManuscriptDescriptions/' . $xml_file_array[$i]);
		//print_r($manuscript_xml); exit();
		$manu_title = $manuscript_xml->teiHeader->fileDesc->titleStmt->title[0];
		$manu_sections = array();
		// grab sections, for use later, so we'll just put in an array
		for ($section_i = 0; $section_i<count($manuscript_xml->teiHeader->fileDesc->titleStmt->title); $section_i++) {
			$manu_sections[] .= $manuscript_xml->teiHeader->fileDesc->titleStmt->title[$section_i];
		}
		/* // for finding any missing keywords
		foreach ($manuscript_xml->teiHeader->encodingDesc->classDecl->taxonomy->category as $something) {
			if (isset($keywords_from_db[(string)$something->catDesc])) {
				print "\nIn array: " . (string)$something->catDesc;
			} else {
				print "\nMissing: " . (string)$something->catDesc;
			}
		}
		exit();
		*/
		// grab keywords for this item
		$manu_keywords = array();
		foreach ($manuscript_xml->teiHeader->profileDesc->textClass->keywords->list->item as $this_keyword) {
			$this_keyword_text = (string)$this_keyword;
			//print $this_keyword_text;
			//print_r ($keywords_from_db[$this_keyword_text]);
			$manu_keywords[] = array('keyword'=>(string)$this_keyword, 'id'=>$keywords_from_db[$this_keyword_text]['id'], 'category'=>$keywords_from_db[$this_keyword_text]['category']);
		}
		//print_r($manu_keywords);
		//exit();
		$manu_abstract = $manuscript_xml->teiHeader->fileDesc->notesStmt->note;
		$manu_language = $manuscript_xml->teiHeader->fileDesc->sourceDesc->msDesc->msContents->textLang;
		$manu_accession_number = $manuscript_xml->teiHeader->fileDesc->sourceDesc->msDesc->msIdentifier->idno;
		// take out parts of title that don't go there.
		$manu_title = substr($manu_title, strpos($manu_title, ',')+2);
		//print $manu_title;
		//exit();
		//$manu_title = str_replace('Walters Ms. ', '', $manu_title);
		//$manu_title = str_replace($manu_accession_number . ',', '', $manu_title);
		$manu_media_type  = $manuscript_xml->teiHeader->fileDesc->sourceDesc->msDesc->physDesc->objectDesc['form'][0];
		$manu_material = $manuscript_xml->teiHeader->fileDesc->sourceDesc->msDesc->physDesc->objectDesc->supportDesc['material'][0];
		//print '<li>' . $manuscript_xml->teiHeader->fileDesc->sourceDesc->msDesc->physDesc->decoDesc->decoNote;
		//$page_i = 0;
		$manu_not_before = $manuscript_xml->teiHeader->fileDesc->sourceDesc->msDesc->history->origin['notBefore'];
		$manu_not_after = $manuscript_xml->teiHeader->fileDesc->sourceDesc->msDesc->history->origin['notAfter'];
		$manu_orig_date = $manuscript_xml->teiHeader->fileDesc->sourceDesc->msDesc->history->origin->origDate;
		$manu_orig_place = $manuscript_xml->teiHeader->fileDesc->sourceDesc->msDesc->history->origin->origPlace;
		$page_notes = array();
		foreach ($manuscript_xml->teiHeader->fileDesc->sourceDesc->msDesc->physDesc->decoDesc->decoNote as $this_page) {
			//print '<br />' . $page_i;
			$part = $this_page['n'][0];
			$page_title = $this_page->title;
			if (substr($part, 0, 5) !='item ') {
				//print "<li>page_notes[part:" . $part . '] -- title' . $page_title;
				$page_notes[] = array('part'=>$part, 'page_title'=>$page_title);
			}
			//$page_i++;
		}
		//print count($page_notes);
		//print '<li>---' . count($pages);
		//print '<li>';// . $manuscript_xml->facsimile->surface;
		$page_images = array();
		$manuscripts_table_thumb_url = '';
		foreach ($manuscript_xml->facsimile->surface as $this_part_image) {
			$part = $this_part_image['n'];
			$sap_url = $this_part_image->graphic[2]['url'];
			$sap_width = $this_part_image->graphic[2]['width'];
			$sap_height =  $this_part_image->graphic[2]['height'];
			$thumb_url = $this_part_image->graphic[3]['url'];
			$thumb_width = $this_part_image->graphic[3]['width'];
			$thumb_height =  $this_part_image->graphic[3]['height'];
			if (!$manuscripts_table_thumb_url) $manuscripts_table_thumb_url = $thumb_url;
			$page_images[] = array('part'=>$part, 'sap_url'=>$sap_url, 'sap_width'=>$sap_width, 'sap_height'=>$sap_height, 'thumb_url'=>$thumb_url, 'thumb_width'=>$thumb_width, 'thumb_height'=>$thumb_height);
			//print_r($page_images);
		}
		//print_r ($manuscript_xml->facsimile);
	
		$sql = "INSERT INTO manuscripts (accession_number, title, abstract, language, media_type, material, not_before, not_after, orig_date, orig_place, thumb_image) VALUES (
				:manu_accession_number,
				:manu_title,
				:manu_abstract,
				:manu_language,
				:manu_media_type,
				:manu_material,
				:manu_not_before,
				:manu_not_after,
				:manu_orig_date,
				:manu_orig_place,
				:manu_thumb_url
			);";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':manu_accession_number', $manu_accession_number);
		$stmt->bindParam(':manu_title', $manu_title);
		$stmt->bindParam(':manu_abstract', $manu_abstract);
		$stmt->bindParam(':manu_language', $manu_language);
		$stmt->bindParam(':manu_media_type', $manu_media_type);
		$stmt->bindParam(':manu_material', $manu_material);
		$stmt->bindParam(':manu_not_before', $manu_not_before);
		$stmt->bindParam(':manu_not_after', $manu_not_after);
		$stmt->bindParam(':manu_orig_date', $manu_orig_date);
		$stmt->bindParam(':manu_orig_place', $manu_orig_place);
		$stmt->bindParam(':manu_thumb_url', $manuscripts_table_thumb_url);
		if ($write_to_dbs) {
			$stmt->execute();
			$manuscript_id_inserted = $dbh->lastInsertId();
		} else {
			$manuscript_id_inserted = 1;
		}
		print "\n<li>Inserted #" . $manuscript_id_inserted;
		//print $insert_id;
		foreach ($page_images as $this_page_image) {
			//print_r ($this_page_image);
			$page_description = '';
			foreach ($page_notes as $this_page) {
				//print_r ($this_page);
				//print "\n" . $this_page['part'] . '==' . $this_page_image['part'];
				if ((string)$this_page['part']==(string)$this_page_image['part']) $page_description = (string)$this_page['page_title'];
				//$this_page_image['part'];
			}
			//'sap_url'=>$sap_url, 'sap_width'=>$sap_width, 'sap_height'=>$sap_height, 'thumb_url'=>$thumb_url, 'thumb_width'=>$thumb_width, 'thumb_height'
			if ($write_to_dbs) {
				$sql ="INSERT INTO folios (manuscript_id, part, description, sap_url, sap_width, sap_height, thumb_url, thumb_width, thumb_height) values (:manuscript_id, :part, :description, :sap_url, :sap_width, :sap_height, :thumb_url, :thumb_width, :thumb_height)";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':manuscript_id', $manuscript_id_inserted);
				$stmt->bindParam(':part', $this_page_image['part']);
				$stmt->bindParam(':description', $page_description);
				$stmt->bindParam(':sap_url', $this_page_image['sap_url']);
				$stmt->bindParam(':sap_width', $this_page_image['sap_width']);
				$stmt->bindParam(':sap_height', $this_page_image['sap_height']);
				$stmt->bindParam(':thumb_url', $this_page_image['thumb_url']);
				$stmt->bindParam(':thumb_width', $this_page_image['thumb_width']);
				$stmt->bindParam(':thumb_height', $this_page_image['thumb_height']);
			$stmt->execute();
			}
		}
		// add keywords
		foreach ($manu_keywords as $this_keyword) {
			//print_r($this_keyword);
			if ($write_to_dbs) {
				$sql ="INSERT INTO manuscripts_keywords (manuscript_id, keyword_id, keyword, category) values (:manuscript_id, :keyword_id, :keyword, :category)";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':manuscript_id', $manuscript_id_inserted);
				$stmt->bindParam(':keyword_id', $this_keyword['id']);
				$stmt->bindParam(':keyword', $this_keyword['keyword']);
				$stmt->bindParam(':category', $this_keyword['category']);
				//$dbh=new PDO("mysql:dbname=walters;host=localhost;charset=utf8", "walters", "sql4secret");
				$stmt->execute();
			}
		}
	
		//print $sql;
		//print "\n\n";
		//print_r($manuscript_xml); exit();
		//print "<br /><br />";
	
		//exit();
		//if ($i > 3) break;
	}
	
	//http://www.thedigitalwalters.org/Data/WaltersManuscripts/ManuscriptDescriptions/
	//print_r($matches[2]);
	
} else {
	?>
	<form>
	This will rebuild the manuscripts database from <a href='http://www.thedigitalwalters.org/Data/WaltersManuscripts/ManuscriptDescriptions/'>http://www.thedigitalwalters.org/Data/WaltersManuscripts/ManuscriptDescriptions/</a>
	It will take many minutes, please wait until this is complete.
	<input type="submit" name="go" value="go">
	</form>
	<?
}
?>