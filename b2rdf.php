<?php /* RDF 1.0 generator, original version by garym@teledyn.com */
$blog=1; // enter your blog's ID
header("Content-type: text/xml");
include ("blog.header.php");
add_filter('the_content', 'trim');
if (!isset($rss_language)) { $rss_language = 'en'; }
?><?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?".">\n"; ?>
<!-- generator="b2/<?php echo $b2_version ?>" -->
<rdf:RDF
	xmlns="http://purl.org/rss/1.0/"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:admin="http://webns.net/mvcb/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
>

<channel rdf:about="<?php bloginfo_rss("url") ?>">

	<title><?php bloginfo_rss('name') ?></title>
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss('description') ?></description>
	<dc:language><?php echo $rss_language ?></dc:language>
	<dc:date><?php echo gmdate('Y-m-d\TH:i:s'); ?></dc:date>
	<dc:creator><?php echo $admin_email ?></dc:creator>
	<admin:generatorAgent rdf:resource="http://cafelog.com/?v=<?php echo $b2_version ?>"/>
	<admin:errorReportsTo rdf:resource="mailto:<?php echo $admin_email ?>"/>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<sy:updateBase>2000-01-01T12:00+00:00</sy:updateBase>

	<items>
		<rdf:Seq>
		<?php $items_count = 0; while($row = mysql_fetch_object($result)) { start_b2(); ?>
			<rdf:li rdf:resource="<?php permalink_single_rss() ?>"/>
		<?php $b2_items[] = $row; $items_count++; if (($items_count == $posts_per_rss) && empty($m)) { break; } } ?>
		</rdf:Seq>
	</items>
</channel>

<?php foreach($b2_items as $row) { start_b2(); ?>
<item rdf:about="<?php permalink_single_rss() ?>">
	<title><?php the_title_rss() ?></title>
	<link><?php permalink_single_rss() ?></link>
	<dc:date><?php the_time('Y-m-d\TH:i:s'); ?></dc:date>
	<dc:creator><?php the_author() ?> (mailto:<?php the_author_email() ?>)</dc:creator>
	<dc:subject><?php the_category_rss() ?></dc:subject>
	<description><?php the_content_rss('', 0, '', $rss_excerpt_length, 2) ?></description>
	<content:encoded><![CDATA[<?php the_content('', 0, '') ?>]]></content:encoded>
</item>
<?php } ?>

</rdf:RDF>