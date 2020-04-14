limitText.js
=====================
**jquery.limitText.js v0.0.1**

&copy; Copyright 2015 Phillip Molaro (https://github.com/pmolaro)

**Licensed under MIT** (https://github.com/twbs/bootstrap/blob/master/LICENSE)

## Overview
LimitText is a simple jQuery plugin that adds a text counter message to a TextArea element, or other similar form input.  By default the plugin dispays the number of characters the user can type in the field.  As the user types, the number counts down to show them how many characters are left.  Once they reach a threshold (ex. 10 characters remaining), the text will change color to warn them that they are getting close to the limit. The plugin handles both typing and pasting text.


## Dependencies
This is a jQuery plugin, so you need jQuery included in your project. Import jQuery onto your web page:
```HTML
<!-- jQuery -->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
```


## Installation
1. Copy the jquery.limitText.js file into your web project.

   _For these examples, it's assumed your JavaScript is inside of a /js directory._
2. Import the minified plugin code on the page you wish to use it on:
```HTML
<script src="js/jquery.limitText.min.js"></script>
```

## Usage
Assuming you already have a form with a TextArea field, add the following markup:
1. Directly under the TextArea element, add a new div with an id for reference. This is where your counter text will be displayed.
2. I prefer to have my counter text to the right side of the text area.  To do that just add a class or style to align the div to the right.  If you're using Bootstrap, use the class "text-right". This is optional.
3. In your TextArea element add a data attribute called "data-status-message", to reference the div you added
```HTML
 <textarea id="myTextArea" cols="120" rows="30" data-status-message="#counter"></textarea>
 <div id="counter" class="text-right"></div>
```

Keep in mind, if you have multiple text areas, and want to add limitText to each of them, then each message div must have a unique Id value, and each data-status-message attribute must reference the specific values accordingly.

4. Finally, at the bottom of your page, you need to initialize the the plugin.
```Javascript
 <script type="text/javascript">
     $(document).ready(function () {
        $('#myTextArea').limitText();
     });
 </script>
```

In the example, above I have initialized the one limitText plugin for the one text area.  If you use the plugin multiple times, initialize each instance, or you could initialize it for all TextAreas.

Loading the plugin per textarea allows you to pass in custom options for each field.  For example, one text area may allow the default 200 characters, while another only allows 50 characters.
```Javascript
 <script type="text/javascript">
     $(document).ready(function () {
        $('#myTextArea').limitText();
        $('#myOtherTextArea').limitText(limit=50);
     });
 </script>
```


If all of your TextArea fields use the plugin and have the same limits, styles, etc, you can init them all with a single line.  Note, this is less performant, unless you use it on every textarea element.
```Javascript
 <script type="text/javascript">
     $(document).ready(function () {
        $('textarea').limitText();
     });
 </script>
```

## Options
The limitText plugin has several customization options to help meet your needs:

1. **`limit`** (_integer_) - The allowed character count for the textarea field - Default: 200

2. **`warningLimit`** (_integer_) - The remaining character count to trigger the warning class change - Default: 10

3. **`statusMessage`** (_string_) - A jQuery id selector to an existing status container DOM element. If left empty, a default will be added after the element - Default: `''`

4. **`counterClass`** (_string_) - Class to apply to the status text area. Replaced by the warningClass when the warningLimit is reached. - Default: '`text-primary`' (Bootstrap helper class)

5. **`warningClass`** (_string_) - Class applied to status area when warningLimit is reached. Replaces the counterClass on warning. - Default: '`text-danger`' (Bootstrap helper class)

6. **`containerElement`** (_string_) - DOM element to be inserted if statusMessage is undefined - Default: '`<div>`'

7. **`containerClass`** (_string_) - Class applied to the status container. - Default: '`limit-text-status`' (no style definition included)