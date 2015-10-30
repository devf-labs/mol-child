function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function insertMegaLink() {
	
	var tagtext;
	
	var styleid = document.getElementById('style_shortcode').value;	
	
		if (styleid != 0) {
			tagtext = "["+ styleid + "]Insert your content here.[/" + styleid + "] ";
		}
		
		if (styleid != 0 && styleid == 'button' ) {
			tagtext = "["+ styleid + " url=\"#\" window=\"true\" style=\"e.g. orange, blue, green, yellow, red, pink, purple, gray\" size=\"e.g. small, medium, large\"]Button Text[/" + styleid + "]";
		}
		
		if (styleid != 0 && styleid == 'accordion' ) {
			tagtext="["+ styleid + " collapsible=\"false\" framed=\"false\" type=\"2\"]<br>" + "[section title=\"Accordion Title 1\"]Insert your text here.[/section]<br>" + "[section title=\"Accordion Title 2\"]Insert your text here.[/section]<br>" + "[section title=\"Accordion Title 3\"]Insert your text here.[/section]<br>" + "[/" + styleid + "]";
		}
		
		if (styleid != 0 && styleid == 'tabgroup') {
			tagtext="["+ styleid + "]<br>" + "[tab title=\"Tab 1\"]Insert your text here.[/tab]<br>" + "[tab title=\"Tab 2\"]Insert your text here.[/tab]<br>" + "[tab title=\"Tab 3\"]Insert your text here.[/tab]<br>" + "[/" + styleid + "]";
		}
		
		if (styleid != 0 && styleid == 'dropcap' ) {
			tagtext = "["+ styleid + "]A[/" + styleid + "]";
		}
		
		if (styleid != 0 && styleid == 'highlight' ) {
			tagtext = "["+ styleid + " background=\"#F6F67A\" color=\"#111111\"]Insert your text here.[/" + styleid + "]";
		}
		
		if (styleid != 0 && styleid == 'hr' ) {
			tagtext = "["+ styleid + "]";
		}
		
		if (styleid != 0 && styleid == 'map' ) {
			tagtext = "["+ styleid + " width=\"100%\" height=\"380\" zoom=\"10\" type=\"e.g. ROADMAP, HYBRID, TERRAIN\"]<br>" + "[marker address=\"Insert your address here\"]Insert your text here[/marker]<br>" + "[/" + styleid + "]";
		}
		
		if ( styleid == 0 ) {
			tinyMCEPopup.close();
		}
		
		if (styleid != 0 && styleid == 'person') {
			tagtext="["+ styleid + " name=\"Insert person's name here\" image=\"Insert image URL here\" title=\"Insert person's title here\" facebook=\"\" twitter=\"\" linkedin=\"\" dribbble=\"\" behance=\"\" evernote=\"\" digg=\"\" lastfm=\"\" forrst=\"\" flickr=\"\" google_plus=\"\" github=\"\" instagram=\"\" skype=\"\" myspace=\"\" vimeo=\"\"]" + "Insert your text here" + "[/" + styleid + "]";
		}
		
		if (styleid != 0 && styleid == 'recent_posts') {
			tagtext="["+ styleid + " number=\"2\"]";
		}


	if(window.tinyMCE) {
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}