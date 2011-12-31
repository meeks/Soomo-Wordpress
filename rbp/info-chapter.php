<?php $theme = $_GET["theme"]; ?>
<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Western Governor's University</title>
  
  <!-- META -->
  <meta name="description" content="" />
  <meta name="author" content="Rockbeatspaper" />
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />

  <!-- CSS -->
  <link rel="stylesheet" href="./css/base.css" />
  <link rel="stylesheet" href="./css/style.css" />
  <?php if (isset($theme)) { echo '<link rel="stylesheet" href="./css/themes/' . $theme . '/theme.css" />'; } ?>

  <!-- MODERNIZR -->
  <script src="/js/libs/modernizr-1.7.min.js"></script>

</head>

<body>
  
  <div id="meta-bar-wrapper" class="png-bg">
    <header id="meta-bar" class="container">
      <div id="user">
        <div id="user-button">
          <a href="#">Hermione Granger <span class="arrow">&#9660;</span></a>
        </div> <!-- /#user-button -->
      </div> <!-- /#user -->
      <div id="support">
        <div id="support-button">
          <a href="#">Soomo Publishing Support <span class="arrow">&#9660;</span></a>
        </div> <!-- /#support-button -->
        <div id="support-menu" style="display:none;">
          <ul>
            <li><a href="#">Email</a></li>
            <li><a href="#">Instant Message</a></li>
            <li class="no-link">Phone - 800.555.1234</li>
            <li><a href="#">FAQ &amp; Knowledge Base</a></li>
          </ul>
        </div>
      </div> <!-- /#settings -->
    </header> <!-- /#meta-bar -->
  </div> <!-- /#meta-bar-wrapper -->
  
  <div id="user-menu" class="container">
    <h3>Jump to another course</h3>
    <ul>
      <li><a href="#" class="current"><em>FNV2</em> Forensics and Network Intrusion</a></li>
      <li><a href="#"><em>ABV1</em> Operating Systems and Other Courses with Extraordinarily Long Titles</a></li>
      <li><a href="#"><em>FXT2</em> Disaster Preparation</a></li>
      <li><a href="#"><em>FNV2</em> Forensics and Network Intrusion</a></li>
      <li><a href="#" class="sign-out">Sign Out</a></li>
    </ul>
  </div> <!-- /#user-menu -->
  
  <div id="utility-bar">
    <a href="#" id="utility-analytics"><span>Course Analytics</span></a>
    <a href="#" id="utility-contact"><span>Contact Mentor</span></a>
    <a href="#" id="utility-print"><span>Print Course</span></a>
  </div> <!-- /#utility-bar -->
  
  <section id="page" class="container">
    <header id="breadcrumbs">
      <nav>
        <ul class="tabs">
          <li><a href="#" title="Breadcrumb Level One">Breadcrumb Level One</a><span>~</span></li>
          <li>Level Two</li>
        </ul>
      </nav>
    </header>
    <section id="content" class="info-chapter">
      <header id="content-title">
        <h1>Course Introduction</h1>
      </header> <!-- /#content-title -->
      
      <section id="content-sidebar">
        <div class="subnav">
          <h2>Jump to</h2>
          <ul>
            <li><a href="#" title="">Overview</a></li>
            <li><a href="#" title="">Outcomes and Evaluation</a></li>
            <li><a href="#" title="">Competencies</a></li>
            <li><a href="#" title="">The Microsoft 70-680 Assessment</a></li>
            <li><a href="#" title="">The Microsoft 70-680 Assessment with a really long title that wraps</a></li>
          </ul>
        </div> <!-- /.subnav -->
        <aside class="note">
          <h2>Heading - Optional</h2>
          <h3>Sub Heading - Optional</h3>
          <p>This is the note text. It can include <a href="#">links</a> and words and really longer words and lists:</p>
          <ul>
            <li>Item One</li>
            <li>Item Two</li>
          </ul>
        </aside> <!-- /.note -->
        <img src="./img/placeholder-image.jpg" width="340" alt="" />
        <div class="caption">You'll often want to caption photos. This is a .caption class</div> <!-- /.caption -->
        <ol>
          <li>This is a list that is well ordered.</li>
          <li>It starts with one and goes to two.</li>
          <li>Then it has a third item.</li>
          <li>Followed by the fourth, and—in this case—last item.</li>
  			</ol>
  			<ul>
          <li>Un-ordered lists are just as simple.</li>
          <li>The only difference being that the items are marks by bullets instead of numbers.</li>
          <li>Don’t forget that lists can have list titles.</li>
          <li>Finally we’ve reached the last un-ordered item.</li>
  			</ul>
      </section> <!-- /#content-sidebar -->
      
      <section id="content-main">
        <h1><span class="kern">T</span>ype-a-file Gives Your Web <span class="kern">T</span>ypography a Head Start</h1>
        <div class="kicker">
  				<p>Below you’ll find some text marked up with the core elements of Type-a-file. View the source code to find out how to use them on your own site. This element, for example is called a “kicker.” It’s paragraph text that introduces the rest of the text. It’s useful for outlining your topic &amp; looks killer. Just create a div with class=“kicker” and throw some paragraphs into it. Blammo!</p>
  			</div>
        <h2>The Typographic Basics</h2>
        <img src="./img/placeholder-image.jpg" alt="" />
        <div class="caption">You'll often want to caption photos. This is a .caption class</div>
        <p><a href="#">Paragraphs</a> are the core building block of typography online. You want to make sure you’ve got a good line-height and horizontal width—aka measure—for good readability. If you stack your lines too close together, or too far apart, lines become harder to read. Like a staircase where the steps are too shallow or too steep. The standard line-height online is something between 1.5 and 2.0 ems.<a href="#ems" class="superscript">1</a> If your lines stretch too far across the page reading can feel like a tedious marathon. The standard single-column width online is about 70-90 characters.</p>
        <p>If you look at the <a href="#">source code</a> you’ll notice how the .sidenote to the right was written before this paragraph, which it is supposed to directly relate to. You’ll probably want to set up your asides in the same manner.</p>
        <p>These are the simple beginnings of Type-a-file. We’ve put in a lot of work to make good typography easier for you. Colors & structure we leave to you, but typographically, we got you covered. Download the file and follow the instructions for installing and setting it up. Now we’ll get into some of the fancier elements we’ve built into Type-a-file</p>
        <p><span class="run-in">Sometimes you want an opening phrase to pop.</span> You could just put it in bold tags, but wouldn’t you rather use semantic markup?<a href="#semantics" class="superscript">2</a> We’ve created a class called .run-in so that you can! Best practices claim you’ll usually want to keep those run-ins to one line.</p>
        <p>Typically you want a nice, steady vertical rhythm to your page. Of course, some folks don’t <span class="pullquote">Speaking of intelligently deviating…</span>think that it’s actually necessary on the web to stick to a baseline grid, but it can be a great guide from which you can intelligently deviate. Speaking of intelligently deviating, there are some key elements that make great deviations from the monotony of paragraphs: the “quotes.” These include blockquotes and a special Type-a-file class named “pullquote.” The latter is above, the former below:</p>
        <blockquote><p>Headings, subheads, block quotations, footnotes, illustrations, captions and other intrusions into the text create syncopations and variations against the base rhythm of regularly leaded lines. These variations can and should add life to the page, but the main text should also return after each variation precisely on beat and in phase.</p></blockquote>
        <cite>Robert Bringhurst</cite>
        <h2>Delineate, Demonstrate, Define</h2>
        <p>This Type-a-file would of course be incomplete without specifications for lists, codes &amp; definitions. It’s fairly common to indent both blockquotes and list elements, but seriously consider left aligning your text for these items and outdenting their bullets &amp; other visual demarcations. It can present a cleaner appearance while also drawing focused attention to information points.</p>
        <ol>
          <li>This is a list that is well ordered.</li>
          <li>It starts with one and goes to two.</li>
          <li>Then it has a third item.</li>
          <li>Followed by the fourth, and—in this case—last item.</li>
  			</ol>
  			<ul>
          <li>Un-ordered lists are just as simple.</li>
          <li>The only difference being that the items are marks by bullets instead of numbers.</li>
          <li>Don’t forget that lists can have list titles.</li>
          <li>Finally we’ve reached the last un-ordered item.</li>
  			</ul>
  			
        <ul class="assignments">
          <li>
            <div class="cell">
              <a href="#" class="visited-and-partially-completed">
                <div style="height: 67%;">&nbsp;</div>
              </a>
              <div class="tooltip">
                <p><em>8 of 16</em> questions answered (50%)</p>
                <span></span>
              </div> <!-- /.tooltip -->
            </div> <!-- /.cell -->
            <a href="#">Assignment Title</a>
          </li>
          <li>
            <div class="cell">
              <a href="#" class="visited-and-partially-completed">
                <div style="height: 67%;">&nbsp;</div>
              </a>
              <div class="tooltip">
                <p><em>8 of 16</em> questions answered (50%)</p>
                <span></span>
              </div> <!-- /.tooltip -->
            </div> <!-- /.cell -->
            <a href="#">Assignment Title</a>
          </li>
          <li>
            <div class="cell">
              <a href="#" class="visited-and-partially-completed">
                <div style="height: 67%;">&nbsp;</div>
              </a>
              <div class="tooltip">
                <p><em>8 of 16</em> questions answered (50%)</p>
                <span></span>
              </div> <!-- /.tooltip -->
            </div> <!-- /.cell -->
            <a href="#">Assignment Title</a>
          </li>
        </ul> <!-- /.assignments -->
        
  			<p>If you’re a blogger geek, sooner or later you’ll want to tell everybody about some ripping <abbr>css</abbr> coding you concocted by posting it on your blog-o-tubes. So we’ve got you covered.</p>
<pre><code>#header h1 a {
display: block; 
width: 300px; 
height: 80px; 
}</code></pre>
        <p>Then, since you’re an uber-geek-dufus-man-child who’s fascinated by proving to the world you have sooooo much knowledge to share, you’ll probably want to post some definitions or definition-like information where a title element is closely linked with a description of some kind. We got ya.</p>
        <dl>
   				<dt>Type-a-file</dt>
   				<dd>A really awesome way to get your site up to typographic snuff. It uses traditional semantic HTML tags along with some additional semantic classes named after commonly occurring elements in print design to create a solid typographic toolkit for your website, whoever you are.</dd>
   				<dt>CSS</dt>
   				<dd>CSS stands for Cascading Style Sheet. This is a document format which provides a set of style rules which can then be incorporated in an XHTML or HTML document. It is a means to separate web content from formatting and presentation information. CSS is also a Brazilian rock band from São Paulo. The band was labeled as part of the explosion of the New Rave scene. Their songs are in both English and Portuguese. CSS is an abbreviation for Cansei de Ser Sexy , literally “tired of being sexy” in Portuguese.</dd>
  			</dl>
  			<p>You see how that works? You need something done typographically, Type-a-file does it. That simple. Now what are you waiting for? Find a flavor that suits your mood and go to town. Download the zip file. All the directions and files you’ll need will be squished inside. Oh, and when you’ve become a master <abbr>css</abbr>er and start making your own flavors of Type-a-file, come back and share them with the Type-a-file community!</p>
  			<small>This is just a <code>small</code> element. It’s really useful when you want to add a small note or bit of text to something that’s perhaps less important or a clarification of something. Another option in an arsenal of options.</small>
  			<ol class="footnote">
    			<li id="ems"><span class="run-in">All about ems:</span> An em is a unit of measurement in the field of typography. This unit defines the proportion of the letter width and height with respect to the point size of the current font. Originally the unit was derived from the width of the capital “M” in the currently used typeface. This unit is not defined in terms of any specific typeface, and thus is the same for all fonts at a given point size. So, 1 em in a 16 point typeface is 16 points</li>
    			<li id="semantics"><span class="run-in">Semantic Web:</span>  A group of methods and technologies to allow machines to understand the meaning—or “semantics”—of information on the World Wide Web. The term was coined by World Wide Web Consortium (W3C) director Tim Berners-Lee. According to the original vision, the availability of machine-readable metadata would enable automated agents and other software to access the Web more intelligently. The agents would be able to perform tasks automatically and locate related information on behalf of the user.</li>
    		</ol>
      </section> <!-- /#content-main -->
      
    </section> <!-- /#content -->
  </section> <!-- /#page -->
  
  <footer class="container">
    <small>Course of Study &copy; 2011 Western Governor's University</small>
  </footer>

  <!-- JS at the bottom for fast page loading -->
  
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
  <script>window.jQuery || document.write("<script src='/js/libs/jquery-1.4.2.min.js'>\x3C/script>")</script>
  <script src="/js/libs/browser_selector.js"></script>
  <script src="/js/libs/jquery.tools.min.js"></script>
  <script src="/js/plugins.js"></script>
  <script src="/js/scripts.js"></script>
  
</body>
</html>