    
    saveSelection = function(containerEl) {
        if (window.getSelection && document.createRange) {
            var range = window.getSelection().getRangeAt(0);
            var preSelectionRange = range.cloneRange();
            preSelectionRange.selectNodeContents(containerEl);
            preSelectionRange.setEnd(range.startContainer, range.startOffset);
            var start = preSelectionRange.toString().length;

            return {
                start: start,
                end: start + range.toString().length,
                content: range.toString()
            };
        } else if (document.selection) { // if IE
            var selectedTextRange = document.selection.createRange();
            var preSelectionTextRange = document.body.createTextRange();
            preSelectionTextRange.moveToElementText(containerEl);
            preSelectionTextRange.setEndPoint("EndToStart", selectedTextRange);
            var start = preSelectionTextRange.text.length;

            return {
                start: start,
                end: start + selectedTextRange.text.length,
                content: selectedTextRange.text
            }
        }
    };

    restoreSelection = function(containerEl, savedSel) {

        if (window.getSelection && document.createRange) {
            var charIndex = 0, range = document.createRange();
            range.setStart(containerEl, 0);
            range.collapse(true);
            var nodeStack = [containerEl], node, foundStart = false, stop = false;

            while (!stop && (node = nodeStack.pop())) {
                if (node.nodeType == 3) {
                    var nextCharIndex = charIndex + node.length;
                    if (!foundStart && savedSel.start >= charIndex && savedSel.start <= nextCharIndex) {
                        range.setStart(node, savedSel.start - charIndex);
                        foundStart = true;
                    }
                    if (foundStart && savedSel.end >= charIndex && savedSel.end <= nextCharIndex) {
                        range.setEnd(node, savedSel.end - charIndex);
                        stop = true;
                    }
                    charIndex = nextCharIndex;
                } else {
                    var i = node.childNodes.length;
                    while (i--) {
                        nodeStack.push(node.childNodes[i]);
                    }
                }
            }

            var sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        } else if (document.selection) { // if IE
            var textRange = document.body.createTextRange();
            textRange.moveToElementText(containerEl);
            textRange.collapse(true);
            textRange.moveEnd("character", savedSel.end);
            textRange.moveStart("character", savedSel.start);
            textRange.select();            
        }
    };


    function execCommandOnElement(el, commandName, value, range) {
        if (typeof value == "undefined") {
            value = null;
        }

        if (typeof window.getSelection != "undefined") {

            // Temporarily enable designMode so that
            // document.execCommand() will work
            document.designMode = "on";

                restoreSelection(el, range);


            // Execute the command
            document.execCommand(commandName, false, value);

            // Disable designMode
            document.designMode = "off";

                restoreSelection(el, range);
                return range;
        } else if (typeof document.body.createTextRange != "undefined") {
            // IE case
            var textRange = document.body.createTextRange();
            textRange.moveToElementText(el);
            textRange.execCommand(commandName, false, value);
            return saveSelection(el);
        }
    }


wordWid = function(a, options) {

    wordWid._before = null;
    wordWid._after = null;
    
    wordWid.setwordinto = function(sel)
    {
        return sel.content = wordWid.textarea.val().substring(sel.start, sel.end);
    }

    wordWid.getword = function(start, end)
    {
        return wordWid.textarea.val().substring(start, end);
    }

    wordWid.add = function(sel)
    {
        execCommandOnElement(wordWid.containerDiv[0], 'createLink', sel.id, sel);
    }

    settings = $.extend({
            width : "400px",
            height : "200px"
        }, options);

    return $(a).each(function() {
        
        wordWid.textarea = $(this).hide();
        // create a container div on the fly

        wordWid.containerDiv = $("<div/>",{
           contenteditable: true,
           class: 'wordWid',
           css : {
               width : settings.width,
               height : settings.height,
               border : "1px solid #ccc"
           },
           keydown: function(event) 
           {
                if ( (event.keyCode < 37 || event.keyCode > 40) && event.keyCode != 16 && wordWid._before == null) // if not arrows
                {
                    wordWid._before = saveSelection(wordWid.containerDiv[0]);
                }
           },
           keyup: function(event)
           {
                if ( (event.keyCode < 37 || event.keyCode > 40) && event.keyCode != 16 && wordWid._before != null ) // if not arrows
                {
                    wordWid._after = saveSelection(wordWid.containerDiv[0]);                    
                    wordWid.textarea.val(wordWid.containerDiv.text());
                    settings.movingWords(wordWid._before, wordWid._after);                        

                    wordWid._before = null;
                }
           }
       }).html(wordWid.textarea.val());
       $(this).after(wordWid.containerDiv); 

        wordWid.containerDiv.click( function() {
            if (event.target.nodeName == 'A')
                settings.loadWord($(event.target).attr('href'));
        });

        function selectWord()
        {
            var sel = saveSelection(wordWid.containerDiv[0]);
            if (sel.content.trim().length > 0 && !settings.exist(sel))
            {
                if (settings.wordButton(sel)) // check for collitions, if valid add to words
                    execCommandOnElement(wordWid.containerDiv[0], 'createLink', sel.id, sel);
            }
        } 

       if (settings.wordButton)
       {
            var button = $("<input />",{
                type : "button",
                value : "Agregar Palabra",
                click : selectWord
            });
            wordWid.containerDiv.after(button);
       }

    });
}


