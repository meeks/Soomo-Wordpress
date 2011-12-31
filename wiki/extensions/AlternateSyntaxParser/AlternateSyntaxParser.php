<?php //{{MediaWikiExtension}}<source lang="php">
/*
 * AlternateSyntaxParser.php - Conditionally replaces wikitext processing with a alternate syntaxes.
 * @author Jim R. Wilson
 * @version 0.1
 * @copyright Copyright (C) 2007 Jim R. Wilson
 * @license The MIT License - http://www.opensource.org/licenses/mit-license.php 
 * -----------------------------------------------------------------------
 * Description:
 *     This is a MediaWiki (http://www.mediawiki.org/) extension which conditionally replaces
 *     the wikitext parsing engine in MediaWiki with an alternate syntax parser of your
 *     choice.  Several alternate light markup languages are supported out-of-the-box, 
 *     and the extension is itself extensible to work with other syntaxes.
 * Requirements:
 *     Mediawiki 1.6.x, 1.9.x, 1.10.x or higher
 *     PHP 4.x, 5.x or higher
 *     PHP Markdown or PHP Markdown Extra library:
 *         http://www.michelf.com/projects/php-markdown/
 * Installation:
 *     1. Create a folder in your $IP/extensions directory called AlternateSyntaxParser.
 *         Note: $IP is your MediaWiki install dir.
 *     2. Drop this script (AlternateSyntaxParser.php) into $IP/extensions/AlternateSyntaxParser
 *     3. Enable the extension by adding this line to your LocalSettings.php:
 *         require_once('extensions/MarkdownSyntax.php');
 *     4. Download required libraries for chosen alternate syntaxes below
 *         Note: If you don't configure this, it won't do anything!
 * To support Markdown Syntax:
 *     1. Download Michel Fortin's PHP Markdown or PHP Markdown Extra library:
 *         http://www.michelf.com/projects/php-markdown/
 *     2. Extract the file 'markdown.php' from the downloaded archive.
 *     3. Drop markdown.php into $IP/extensions/AlternateSyntaxParser/
 * To support Textile Syntax:
 *     1. Download Jim Riggs' TextilePHP library:
 *         http://jimandlissa.com/project/textilephp
 *     2. Extract the file 'Textile.php' from the downloaded archive.
 *     3. Drop Textile.php into $IP/extensions/AlternateSyntaxParser/
 * Usage:
 *     To use an alternate syntax in a page, put the following at the top of the page:
 *         #MARKUP language
 *     Where 'language' is the markup language - examples include 'markdown' and 'textile'.
 *     Alternatively, you may specify a site-wide default alternate language by setting
 *     the $wgAlternateSyntaxParserLanguage variable in your LocalSettings.php.  For
 *     examlpe, to make Markdown the default parsing syntax, you'd add:
 *         $wgAlternateSyntaxParserLanguage = 'markdown';
 * Version Notes:
 *     version 0.1:
 *         Initial release.
 * -----------------------------------------------------------------------
 * Copyright (c) 2007 Jim R. Wilson
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy 
 * of this software and associated documentation files (the "Software"), to deal 
 * in the Software without restriction, including without limitation the rights to 
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of 
 * the Software, and to permit persons to whom the Software is furnished to do 
 * so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all 
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, 
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES 
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING 
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR 
 * OTHER DEALINGS IN THE SOFTWARE. 
 * -----------------------------------------------------------------------
 */
 
# Confirm MediaWiki environment
if (defined('MEDIAWIKI')) {
 
# Credits
$wgExtensionCredits['parserhook'][] = array(
    'name'=>'AlternateSyntaxParser',
    'author'=>'Jim R. Wilson - wilson.jim.r&lt;at&gt;gmail.com',
    'url'=>'http://jimbojw.com/wiki/index.php?title=AlternateSyntaxParser',
    'description'=>'Conditionally replaces wikitext processing with a alternate syntaxes',
    'version'=>'0.1'
);

/**
 * Wrapper class for encapsulating AlternateSyntaxParser methods
 */
class AlternateSyntaxParser {

    /**
     * Setup for AlternateSyntaxParser extension.
     */
    function setup( ) {
    	# Add system messages
    	global $wgMessageCache;
        $wgMessageCache->addMessage(
            'alternatesyntax-unrecognized-language',
            'AlternateSyntaxParser does not recognize the language "<tt>$1</tt>"'
        );
    }

    /**
     * Hides all incoming text to the parser for later processing.
     * @param Parser $parser Instance of Parser performing the parse.
     * @param String $text Text to be processed.
     * @return Boolean false if processing suceeded, true otherwise
     */
    function swapOutText( &$parser, &$text ) {
    
        # Short-circuit if we're not processing main article text
        if (
            !$parser->mRevisionId &&
            !$this->mEditPreviewFlag
        ) return true;

        # Determine the markup language in use.
        # Note: This will either be specified in the text iteslf in the form
        #   "#MARKUP whatever", or will be pulled from the global language setting.        
        if (preg_match('/^#MARKUP\s+([a-zA-Z0-9_]+)/', $text, $matches)) {
            $parser->mMarkupLanguage = $matches[1];
            $text = substr($text, strlen($matches[0]));
        } else {
            global $wgAlternateSyntaxParserLanguage;
            if (!$wgAlternateSyntaxParserLanguage) return true;
            $parser->mMarkupLanguage = $wgAlternateSyntaxParserLanguage;
        }

        # An alternate syntax is in use - swap out text
        $parser->mSwappedOutText = $text;
        $text = '';
        return false;
    }

    /**
     * Displays alternatively processed text.
     * @param Parser $parser Instance of Parser performing the parse.
     * @param String $text Text to be processed.
     * @return Boolean false if processing suceeded, true otherwise
     */
    function swapInText( &$parser, &$text ) {
    
        # Short-circuit if extension has not been configured or there's nothing to process
        if (
            !isset($parser->mMarkupLanguage) ||
            !isset($parser->mSwappedOutText)
        ) return true;
        
        # Perform processing based on selected language
        switch (strtolower($parser->mMarkupLanguage)) {
            case 'markdown':
                require_once('markdown.php');
                $text = Markdown($parser->mSwappedOutText);
                break;
            case 'textile':
                require_once('Textile.php');
                $textile = new Textile();
                $text = $textile->process($parser->mSwappedOutText);
                break;
            default:
                if (wfRunHooks( 'AlternateSyntaxParser', array( 
                    &$parser, &$text, $parser->mMarkupLanguage
                ) )) {
                    $text = '<div class="errorbox">'.wfMsgForContent(
                        'alternatesyntax-unrecognized-language',
                        htmlspecialchars($parser->mMarkupLanguage)
                    ).'</div>';
                }
                break;
        }
        unset($parser->mSwappedOutText);
        return false;
    }

    /**
     * Flags when an edit preview is taking place.
     * Usage: $wgHooks['EditPage::showEditForm:initial'][] = 'wfAlternateSyntaxFlagEditPreview';
     * @param EditPage $editpage Instance of EditPage performing a preview.
     * @return Boolean Always true.
     */
    function flagEditPreview( &$editpage ) {
        $this->mEditPreviewFlag = true;
        return true;
    }

    /**
     * Unsets edit preview flag
     * @param EditPage $editpage Instance of EditPage performing a preview.
     * @param OutputPage $out Instance of OutputPage during render ($wgOut).
     * @return Boolean Always true.
     */
    function unflagEditPreview( &$editpage, &$out ) {
        if (isset($this->mEditPreviewFlag)) unset($this->mEditPreviewFlag);
        return true;
    }

}

# Create global instance and wire it up!
$wgAlternateSyntaxParser = new AlternateSyntaxParser();
$wgExtensionFunctions[] = array($wgAlternateSyntaxParser, 'setup');
if (version_compare($wgVersion, '1.6', '>')) {

    # Standard hook mechanism for more recent MW versions
    $wgHooks['ParserBeforeStrip'][] = array($wgAlternateSyntaxParser, 'swapOutText');
    $wgHooks['ParserBeforeTidy'][] = array($wgAlternateSyntaxParser, 'swapInText');
    $wgHooks['EditPage::showEditForm:initial'][] = array($wgAlternateSyntaxParser, 'flagEditPreview');
    $wgHooks['EditPage::showEditForm:fields'][] = array($wgAlternateSyntaxParser, 'unflagEditPreview');

} else {

    # Hack solution to resolve 1.6 array parameter nullification for hook args
    function wfAlternateSyntaxParserSwapOutText( &$parser, &$text ) {
        global $wgAlternateSyntaxParser;
        return $wgAlternateSyntaxParser->swapOutText( $parser, $text );
    }
    function wfAlternateSyntaxParserSwapInText( &$parser, &$text ) {
        global $wgAlternateSyntaxParser;
        return $wgAlternateSyntaxParser->swapInText( $parser, $text );
    }
    function wfAlternateSyntaxParserFlagEditPreview( &$editpage ) {
        global $wgAlternateSyntaxParser;
        return $wgAlternateSyntaxParser->flagEditPreview( $editpage );
    }
    function wfAlternateSyntaxParserUnflagEditPreview( &$editpage, &$out ) {
        global $wgAlternateSyntaxParser;
        return $wgAlternateSyntaxParser->flagEditPreview( $editpage, $out );
    }
    $wgHooks['ParserBeforeStrip'][] = 'wfAlternateSyntaxParserSwapOutText';
    $wgHooks['ParserBeforeTidy'][] = 'wfAlternateSyntaxParserSwapInText';
    $wgHooks['EditPage::showEditForm:initial'][] = 'wfAlternateSyntaxParserFlagEditPreview';
    $wgHooks['EditPage::showEditForm:fields'][] = 'wfAlternateSyntaxParserUnflagEditPreview';
}

} # End MW Environment wrapper
//</source>
?>