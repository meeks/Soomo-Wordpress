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
  <?php if (isset($theme)) { echo '<link rel="stylesheet" href="./css/themes/' . $theme . './theme.css" />'; } ?>

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
        <img src="/img/placeholder-image.jpg" width="340" alt="" />
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
      
      <section id="content-main" class="reversed">
        <form action="/assignment/317718/quiz_responses" id="quiz-form" method="post"> 
        <input id="course_id" name="course_id" type="hidden" value="4429" />
          <h1><span class="kern">F</span>rames of Reference for <span class="kern">T</span>eaching</h1>
          <h2 class="blurb">While reading Chapter 1, respond to the following reflection questions:</h2>
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
  <script>window.jQuery || document.write("<script src='/js/libs/jquery-1.4.2.min.js'>\x3C/script>")</script>
  <script src="/js/libs/browser_selector.js"></script>
  <script src="/js/plugins.js"></script>
  <script src="/js/scripts.js"></script>
  
</body>
</html>