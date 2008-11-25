=== Plugin Name ===
Contributors: miloandrew
Donate link: http://blog.miloco.com/moviewidget/donate
Tags: movie collector, widget, movie catalog 
Requires at least: 2.3
Tested up to: 2.6.2
Stable tag: 0.7

A sidebar widget for displaying random movies from your Collectorz MovieCollector exported xml file.

== Description ==

I use [MovieCollector](http://www.collectorz.com/movie/?a=miloco/ "MovieCollector") from Collectorz to catalog my DVD Collection. I really wanted to randomly display parts of my collection on my blog, but I couldn’t find anything ready made out on the Net so I danced a bit with PHP and put together this Wordpress widget.  It was made for Wordpress 2.3 and above.

The widget’s display has been designed very simply to fit in with most blogs.

== Installation ==

# Unzip and copy the `moviecollector` folder to your wordpress `/wp-content/plugins/` directory.
# Using the Wordpress Administration panels, activate the MovieCollector Display Widget.
# Add the widget to your blog by adding it to a dynamic sidebar (from a widget ready theme) using the Design >> Widgets option on the admin panel.

= Configuration =

Configuration is fairly straightforward. There are a few odd things however, so its best to read this section fully, or pay special attention to the inline help on the Widget control page.

The configuration options are as follows: 

* **Widget Title**: No magic here. Just the displayed title of the widget.

* **Base Filepath**: Used to turn the thumbnail file spec embedded in the Movie Collector XML from something like this: `E:\Program Files\Collectorz.com\Movie Collector\Data\ Thumbnails\fabd5884547c9e232d60d9d2b441a486.jpg` Into a web ready URL, like: `http://blog.miloco.com/movies/Thumbnails/ fabd5884547c9e232d60d9d2b441a486.jpg` Move Collector embeds the full filespec of each DVD cover image. Unfortunately, this won't help us put them on your blog. You'll need to copy your Movie Collector Images and Thumbnail directories to a spot on your webhost where they can be served up via a URL. This configuration option is simply the filespec that your movie images are stored in on your computer. This is only used as a point of reference - the Widget takes this value and strips it out of the returned XML values on runtime. The plugin never directly accesses *any* file on your PC, nor does it report this value to the public.

* **Second Filepath:** An optional value that allows you to specify a second file spec where your images may have been stored. Why this value? Well, my collection images were split between two hard drives. Some images were on my `D:` drive, others were on `E:`. Since I needed to be able to split up my own collection, this logic was added to the widget as well. :) If all of your images are in the same directory, you can just leave this blank.

* **Hosting URL**: This is simply the base URL for the web directory where you are storing your movie thumbnail images.

* **XML Location:** This is the location of the exported XML file. The file location should be relative to your active Wordpress theme. Doing so provides swift parsing of the XML file, but comes with that negative point of if you ever change themes, you'll need to copy the XML file as well.Why didn't I use a more universal configuration? Well, using an universal absolute file spec is hard because of the nature of webhosting, and I didn't want to provide a URL, as that would slow down the parsing tremendously (XML would be streamed off of the server, through HTTP and then back to PHP). If I can figure out a better way, I'll update the Widget.

*   **Buy Verbage:** Allows you to customize the wording of the "buy" link that is below the displayed movie cover.

**Additional Configuration (Optional):**

There is a CSS file in the "moviecollector" plugin directory with values for changing the style of the Widget title, as well as the Buy link.

== Frequently Asked Questions ==

= My thumbnails aren't showing up =

Did you make sure to upload them to a directory on your website?  Did you configure the widget to pull them from that directory?

== Screenshots ==

1. Widget Configuration Screen with Inline Help
2. Example of a stylized widget.

== Need Help? ==

If you need help with this Widget, browse over to the [plugin home page] (http://blog.miloco.com/moviewidget "Movie Widget") and leave a comment there.  I’ll do my best to answer any questions that you have.

== Donation ==

If you like the plugin, consider cruising by the [plugin home page] (http://blog.miloco.com/moviewidget "Movie Widget") and dropping a buck or two to say thanks and help with future versions.