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
  <script src="./js/libs/modernizr-1.7.min.js"></script>

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
    <section id="content" class="assignment">
      <header id="content-title">
        <h1>Course Introduction</h1>
        <p id="last-saved">Last saved 35 minutes ago.</p>
      </header> <!-- /#content-title -->
      
      <section id="content-sidebar" class="reversed">
        <div class="subnav">
          <h2>H2 inside div class="subnav"</h2>
          <ul>
            <li><a href="#" title="">This is an unordered list</a></li>
            <li><a href="#" title="">It is also inside the div class="subav"</a></li>
            <li><a href="#" title="">Third list item</a></li>
            <li><a href="#" title="">And the fourth</a></li>
            <li><a href="#" title="">And one with a really long title that could quite possibly wrap</a></li>
          </ul>
        </div> <!-- /.subnav -->
        <h3>Frames of Reference for Teaching</h3>
        <p><em>Objective:</em> In this topic, you will reflect on factors you would consider when evaluating curriculum and instruction.</p>
        <h3>Read &amp; Reflect</h3>
        <p><em>Teaching Strategies</em>, by Orlich, et al. <a href="http://www.cengage.com/custom/static_content/WGU/CurrEval1/data/teachingstratchap01.swf" target="new">Chapter 1: Frames of Reference for Teaching</a></p>
        <h3>Review</h3>
        <p><em>Power Point: Overview of the major points presented in the text.</em> <a href="http://www.cengage.com/custom/static_content/WGU/CurrEval1/data/orlich_01_2008.ppt" target="new">(download PPT)</a></p>
        <p><em>Glossary: List of terms and definitions</em> <a href="http://www.wadsworth.com/cgi-wadsworth/course_products_wp.pl?fid=M35&amp;product_isbn_issn=0547212933&amp;chapter_number=1&amp;resource_id=10&amp;altname=Glossary" target="new">(open list)</a></p>
        <p><em>Flashcards: For self-review of key terms and ideas.</em> <a href="http://www.wadsworth.com/cgi-wadsworth/course_products_wp.pl?fid=M41&amp;product_isbn_issn=0547212933&amp;chapter_number=1&amp;resource_id=6&amp;altname=Glossary" target="new">(launch flashcard app)</a></p>
        <h3>Apply</h3>
        <p>Take the tutorial quiz for chapter 1 to receive feedback on your understanding of course concepts. Review your results and refer to those content areas needing additional reflection.</p>
        <p><em>Self-Quiz: Test your mastery of the major concepts.</em> <a href="http://webquiz.ilrn.com/ilrn/quiz-public?name=ohts09q/ohts09q_chp01" target="new">(take quiz)</a></p>
        <aside class="note">
          <h2>H2 Heading - Optional</h2>
          <h3>H3 Sub Heading - Optional</h3>
          <p>This entire box is an <strong>aside</strong> with a class of "note"</p>
          <p>This is a paragraph. It can include <a href="#">links</a> and words and really longer words and lists:</p>
          <ul>
            <li>Item One</li>
            <li>Item Two</li>
          </ul>
        </aside> <!-- /.note -->
        <img src="./img/placeholder-image.jpg" width="340" alt="" />
        <div class="caption">You'll often want to caption photos. This is a div with a .caption class</div> <!-- /.caption -->
        <ol>
          <li>This is a list that is well ordered.</li>
          <li><a href="#">It starts with one and goes to two.</a></li>
          <li>Then it has a third item.</li>
          <li>Followed by the fourth, and—in this case—last item.</li>
  			</ol>
  			<ul>
          <li>Un-ordered lists are just as simple.</li>
          <li>The only difference being that the items are marks by bullets instead of numbers.</li>
          <li><a href="#">Don’t forget that lists can have list titles.</a></li>
          <li>Finally we’ve reached the last un-ordered item.</li>
  			</ul>
      </section> <!-- /#content-sidebar -->
      
      <section id="content-main" class="reversed">
        <form action="/assignment/317718/quiz_responses" id="quiz-form" method="post"> 
        <input id="course_id" name="course_id" type="hidden" value="4429" />
          <h1>H1 - use as primary title for content area</h1>
          <h2>H2 - use to separate defined sections of content</h2>
          <h3>H3 - workhouse heading - use for most other needs</h3>
          <h3>Another H3...</h3>
          <p>With a paragraph that immediately follows an H3</p>
          <div class="question-answer">
            <p class="question">This is a paragraph with a class of "question"</p>
      			<textarea class="answer">This is a textarea with a class of "answer"</textarea>
      			<button type="submit" class="button save">Save Answer</button>
            <button type="submit" class="button save inactive">Inactive Button</button>
          </div> <!-- /.question-answer -->     
    			<div class="question-answer">
            <p class="question">The question and the answer are wrapped in a div with a class of "question-answer"</p>
      			<textarea class="answer"></textarea>
      			<button type="submit" class="button save">Save Answer</button>
            <button type="submit" class="button save inactive">Inactive Button</button>
          </div> <!-- /.question-answer -->
          <div class="question-answer">
            <p class="question">Discuss the impact of political mandates on public education.</p>
      			<textarea class="answer"></textarea>
      			<button type="submit" class="button save">Save Answer</button>
            <button type="submit" class="button save inactive">Inactive Button</button>
          </div> <!-- /.question-answer -->
          <div class="question-answer">
            <p class="question">Discuss the impact of political mandates on public education.</p>
      			<textarea class="answer"></textarea>
      			<button type="submit" class="button save">Save Answer</button>
            <button type="submit" class="button save inactive">Inactive Button</button>
          </div> <!-- /.question-answer -->
        </form>
      </section> <!-- /#content-main -->
      
      <section id="content-footer">
        <a href="#" class="button next">Next Assignment</a>
      </section> <!-- /#content-footer -->
      
    </section> <!-- /#content -->
  </section> <!-- /#page -->
  
  <footer class="container">
    <small>Course of Study &copy; 2011 Western Governor's University</small>
  </footer>

  <!-- JS at the bottom for fast page loading -->
  
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
  <script>window.jQuery || document.write("<script src='./js/libs/jquery-1.4.2.min.js'>\x3C/script>")</script>
  <script src="./js/libs/browser_selector.js"></script>
  <script src="./js/plugins.js"></script>
  <script src="./js/scripts.js"></script>
  
</body>
</html>