<?php 
/* 
Plugin Name: MovieCollector Display Widget
Plugin URI: http://blog.miloco.com/moviewidget
Description: A sidebar widget for displaying random movies from your Collectorz MovieCollector exported xml file.  Born from Kaf's MyWidget example.
Author: Andy Milo
Version: 0.5
Author URI: http://blog.miloco.com 

    This widget is released under the GNU General Public License (GPL) 
    http://www.gnu.org/licenses/gpl.txt 

    This is a WordPress plugin (http://wordpress.org) and widget 
    (http://automattic.com/code/widgets/). 
*/ 


// We're putting the plugin's functions in one big function we then 
// call at 'plugins_loaded' (add_action() at bottom) to ensure the 
// required Sidebar Widget functions are available. 
function widget_moviewidget_init() { 

    // Check to see required Widget API functions are defined... 
    if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') ) 
        return; // ...and if not, exit gracefully from the script. 

    // This function prints the sidebar widget--the cool stuff! 
    function widget_moviewidget($args) { 

        // $args is an array of strings which help your widget 
        // conform to the active theme: before_widget, before_title, 
        // after_widget, and after_title are the array keys. 
        extract($args); 

        // Collect our widget's options, or define their defaults. 
        $options = get_option('widget_moviewidget'); 
        $title = empty($options['title']) ? 'My Movie Collection' : $options['title']; 
		$baseurl = empty($options['baseurl']) ? "E:\Program Files\Collectorz.com\Movie Collector\Data" : $options['baseurl'];		// url for old location
		$baseurl1 = empty($options['baseurl1']) ? "D:/My Documents/Movie Collector" : $options ['baseurl1'];						// url for new location
		$hostedurl = empty($options['hostedurl']) ? "http://blog.miloco.com/movies" : $options ['hostedurl'];						// my hosting url
		$xmllocation = empty($options['xmllocation']) ? "/xml/milo.xml" : $options ['xmllocation'];									// xml location from template directory
		$buyverbage = empty($options['buyverbage']) ? "Snag this for yourself..." : $options ['buyverbage'];						// xml location from template directory

/* The Actual Meat of the Plugin - I.E What it displays */
//		echo "<style type=\"text/css\"> .MovieWidgetTitle {font-size:small;color:#cc0000;font-weight:bold;}</style>";				// CHANGE THIS FOR WIDGET STYLES
		echo "<STYLE type=\"text/css\">";
		echo (include (TEMPLATEPATH.'/../../plugins/moviecollector/moviewidget.css'));
		echo "</STYLE>";
        echo $before_widget; 
//        echo $before_title . '<h5>' . $title . '</h5>' . $after_title; 
 		echo "<div id='MovieWidget'>";
        echo $before_title . "<div class='MovieWidgetTitle'>" . $title . "</div>" . $after_title; 
		display_movie();
		echo "</div>";
        echo $after_widget; 
/* done MILOA */
    } 

    // This is the function that outputs the form to let users edit 
    // the widget's title and so on. It's an optional feature, but 
    // we'll use it because we can! 
    function widget_moviewidget_control() { 

        // Collect our widget's options. 
        $options = $newoptions = get_option('widget_moviewidget'); 

        // This is for handing the control form submission. 
        if ( $_POST['moviewidget-submit'] ) { 
            // Clean up control form submission options 
            $newoptions['title'] = strip_tags(stripslashes($_POST['moviewidget-title'])); 
// NEW
            $newoptions['baseurl'] = strip_tags(stripslashes($_POST['moviewidget-baseurl'])); 
            $newoptions['baseurl1'] = strip_tags(stripslashes($_POST['moviewidget-baseurl1'])); 
            $newoptions['hostedurl'] = strip_tags(stripslashes($_POST['moviewidget-hostedurl']));
			$newoptions['xmllocation'] = strip_tags(stripslashes($_POST['moviewidget-xmllocation']));
			$newoptions['buyverbage'] = strip_tags(stripslashes($_POST['moviewidget-buyverbage']));
// END NEW
        } 

        // If original widget options do not match control form 
        // submission options, update them. 
        if ( $options != $newoptions ) { 
            $options = $newoptions; 
            update_option('widget_moviewidget', $options); 
        } 

        // Format options as valid HTML. Hey, why not. 
        $title = htmlspecialchars($options['title'], ENT_QUOTES); 
// NEW
		$baseurl = htmlspecialchars($options['baseurl'], ENT_QUOTES);
		$baseurl1 = htmlspecialchars($options['baseurl1'], ENT_QUOTES);
		$hostedurl = htmlspecialchars($options['hostedurl'], ENT_QUOTES);
		$xmllocation = htmlspecialchars($options['xmllocation'], ENT_QUOTES);
		$buyverbage = htmlspecialchars($options['buyverbage'], ENT_QUOTES);
// END NEW

// The HTML below is the control form for editing options. 
?>
<style type="text/css">
.WidgetOptionLabel {
	line-height:35px;
	display:block;
	font-weight:bold;
	color:#990000;
}
.WidgetHelpLabel {
	font-size:x-small;
	font-style:italic;
	color:#333333;
}
</style>
  <label for="moviewidget-title" class="WidgetOptionLabel">Widget Title:
  <input type="text" size="50" id="moviewidget-title" name="moviewidget-title" value="<?php echo $title; ?>" />
  </label>
  <label class="WidgetHelpLabel">Title of the widget.</label>
  <!-- new -->
  <label for="moviewidget-baseurl" class="WidgetOptionLabel">Base Filepath:
  <input type="text" size="50" id="moviewidget-baseurl" name="moviewidget-baseurl" value="<?php echo $baseurl; ?>" />
  </label>
  <label class="WidgetHelpLabel">Enter the local filepath of your MovieCollector data.<br />
  (e.g. C:\Program Files\Collectorz.com\Movie Collector\Data )<br />
  This is only needed to strip the filepath from the XML data so that we can replace it with the hosted URL.  Of course, the plugin does NOT transfer or access your local files. </label>
  <label for="moviewidget-baseurl1" class="WidgetOptionLabel">Second Filepath (opt):
  <input type="text" size="50" id="moviewidget-baseurl1" name="moviewidget-baseurl1" value="<?php echo $baseurl1; ?>" />
  </label>
  <label class="WidgetHelpLabel">Optional: Enter a second local filepath where images may have been stored<br />
  (e.g. C:\My Documents\Movie Collector\ )</label>
  <label for="moviewidget-hostedurl" class="WidgetOptionLabel">Hosting URL:
  <input type="text" size="50" id="moviewidget-hostedurl" name="moviewidget-hostedurl" value="<?php echo $hostedurl; ?>" />
  </label>
  <label class="WidgetHelpLabel">Enter the URL where your Images and Thumbnail files are hosted<br />
  (e.g. http://blog.miloco.com/movies )</label>
  <label for="moviewidget-xmllocation" class="WidgetOptionLabel">XML location:
  <input type="text" size="50" id="moviewidget-xmllocation" name="moviewidget-xmllocation" value="<?php echo $xmllocation; ?>" />
  </label>
  <label class="WidgetHelpLabel">Enter the location of your hosted XML file in relative form from your active wordpress theme.<br />
  (e.g. /xml/milo.xml )</label>
  <label for="moviewidget-buyverbage" class="WidgetOptionLabel">Buy Verbage:
  <input type="text" size="50" id="moviewidget-buyverbage" name="moviewidget-buyverbage" value="<?php echo $buyverbage; ?>" />
  </label>
  <label class="WidgetHelpLabel">Words to use for the 'buy' link. <br />
  (e.g. Buy Now! or Buy This Movie. )</label>
  <!-- end NEW -->
  <input type="hidden" name="moviewidget-submit" id="moviewidget-submit" value="1" />
<?php 
    // end of widget_moviewidget_control() 
    } 

    // This registers the widget. About time. 
    register_sidebar_widget('Movie Collection', 'widget_moviewidget'); 

    // This registers the (optional!) widget control form. 
    register_widget_control('Movie Collection', 'widget_moviewidget_control', '550','500'); 
} 


// MILOA Functions

function display_movie() {

    $options = get_option('widget_moviewidget');
	$xmllocation = htmlspecialchars($options['xmllocation'], ENT_QUOTES);
	$buyverbage = htmlspecialchars($options['buyverbage'], ENT_QUOTES);
	$baseurl = htmlspecialchars($options['baseurl'], ENT_QUOTES);
	$baseurl1 = htmlspecialchars($options['baseurl1'], ENT_QUOTES);
	$hostedurl = htmlspecialchars($options['hostedurl'], ENT_QUOTES);
	$xmlfile = TEMPLATEPATH . $xmllocation ;										// find the xml file
	$xml = simplexml_load_file($xmlfile);  										// load the XML file with simplexml 
	$count = 0;
	foreach($xml->xpath("/movieinfo/movielist/movie") as $foo) {
	$moviecount++ ;  															// get a count of all movies.
	}
	
	srand ((double) microtime( )*1000000);
	$random_number = rand(1,$moviecount);  										// Create a random number between 1 and # of movies
	
	$querystring = '/movieinfo/movielist/movie[index='. $random_number . ']'; 	// query string for movie
	$querystringlink = "/movieinfo/movielist/movie[index=". $random_number . "]/links/link[description='Amazon US']";  // query string for amazon link
	
	foreach ($xml->xpath($querystring) as $movie) { 							// find the movie with this index.
		$thumb = $movie->thumbfilepath;											// get the thumnail file
		$thumburl= $hostedurl . (str_replace($baseurl1, "", (str_replace("\\", "/", (str_replace($baseurl, "", $thumb))))));	// removing file specs
		if ($thumburl <> "") {													// check to make sure we have a picture
			$linkurl = "";
			foreach ($xml->xpath($querystringlink) as $link ) {					// check to see if there is an amazon link
				$linkurl = str_replace("collectorzcom-20", "ansbl02-20", ($link->url));									// add my affiliate
				}
			if ($linkurl == "") { $linkurl = "http://www.amazon.com/s?ie=UTF8&index=blended&tag=ansbl02-20&keywords=" . $movie->title; }	// alt keyword search
			echo "<a target='_blank' href=\"" . $linkurl . "\">";				// make the html
			echo "<img src=\"" . $thumburl . " \">";
			echo "</a>";
			echo "<br /><div class='MovieBuyVerbage'><a target='_blank' href=\"" . $linkurl . "\">" . $buyverbage . "</a></div>";
		} 
		else { echo 'Oops! Try again...'; }										// didn't find a thumbnail or film
	}
}
// DONE MILOA FUNCTIONS

// Delays plugin execution until Dynamic Sidebar has loaded first. 
add_action('plugins_loaded', 'widget_moviewidget_init'); 
?>
