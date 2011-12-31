<!--Begin Sidebar Tabbed Menu-->
<ul class="idTabs">
<li><a href="#recententries">Recent Entries</a></li>
<li><a href="#recentcomments2">Recent Comments</a></li>
<li><a href="#mostcomments">About Us</a></li>
</ul>
<div id="recententries" class="sidebar-box">
<ul >
<?php get_archives('postbypost', "$artsee_tab_entries;"); ?>
</ul>
</div>
<div id="recentcomments2" class="sidebar-box">
<?php include (TEMPLATEPATH . '/simple_recent_comments.php'); /* recent comments plugin by: www.g-loaded.eu */ ?>
<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments("$artsee_tab_comments;", 85, '', ''); } ?>
</div>
<div id="mostcomments" class="sidebar-box">
<?php echo $artsee_about; ?>
</div>
<!--End Sidebar Tabbed Menu-->