var input = null;
var inputPrefix = null;
var consoleWrapper = null;
var processingRequestText = null;
var terminalResult = null;

var charInputMode = false;

function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function focusConsole() {
    input.focus();
    scrollConsoleDown();
}

function scrollConsoleDown() {
    consoleWrapper.mCustomScrollbar('scrollTo', 'bottom', {
        scrollInertia: 0
    });
}

function scrollConsoleUp() {
    consoleWrapper.mCustomScrollbar('scrollTo', 'top', {
        scrollInertia: 0
    });
}

function updateConsoleScroll() {
    consoleWrapper.mCustomScrollbar('update');
}

function generateInputCopyText() {
    return "<span class='command-prefix'>" + inputPrefix[0].innerHTML + "</span>"
        + "<span>" + escapeHtml(getInputValue()) + "</span><br>"
}

function resultClear() {
    terminalResult[0].innerHTML = '';
    updateConsoleScroll();
    scrollConsoleDown();
}

function resultCopyInput() {
    terminalResult[0].innerHTML += generateInputCopyText();
    updateConsoleScroll();
    scrollConsoleDown();
}

function resultAddEntry(html) {
    terminalResult[0].innerHTML += generateInputCopyText();
    terminalResult[0].innerHTML += html;
    updateConsoleScroll();
    scrollConsoleDown();
}

function resultAddHtml(html) {
    terminalResult[0].innerHTML += html;
    updateConsoleScroll();
    scrollConsoleDown();
}

function startProcessing() {
    processingRequestText.show();
    scrollConsoleDown();
}

function stopProcessing() {
    processingRequestText.hide();
}

function showInput() {
    inputPrefix.show();
    input.show();
    enableInput();
}

function hideInput() {
    disableInput();
    input.hide();
    inputPrefix.hide();
}

function enableInput() {
    input[0].disabled = false;
    focusConsole();
}

function disableInput() {
    input[0].disabled = true;
}

function setInputValue(value) {
    input.val(value);
}

function getInputValue() {
    return input[0].value;
}

function setInputPrefix(inputPrefixHtml) {
    inputPrefix[0].innerHTML = inputPrefixHtml;
}

function updateBodyScroll() {
    var element = $('body')[0];
    element.scrollTop = element.scrollHeight;
}

function getErrorText(statusText) {
    return statusText === 'parsererror'
        ? "<p>Došlo k problému <b>se serverem</b>. Pokud problém přetrvává, <b>oznamte to</b> pověřené osobě.</p>"
        : "<p>Došlo k problému <b>s připojením k serveru</b>. Opakujte akci později.</p>";
}



(function ($) {
    $(window).on('load', function () {
        input = $('#input');
        inputPrefix = $('#input-prefix');
        consoleWrapper = $('#console-wrapper');
        processingRequestText = $('#processing-request');
        terminalResult = $('#terminal-result');

        updateBodyScroll();
        focusConsole();
    });
})(jQuery);
setInterval(updateBodyScroll, 500);
$(document).delegate('#input', 'keydown', handleKeyDown);
$(document).delegate('#input', 'keypress', handleKeyPress);
$(document).keypress(handleEnter);


function handleKeyPress(e) {
    if (charInputMode) processCommand();
}

function handleKeyDown(e) {
    var TAB_KEY = 9;
    var UP_KEY = 38;
    var DOWN_KEY = 40;
    var keyCode = e.keyCode || e.which;

    switch (keyCode) {
        case TAB_KEY:
            e.preventDefault();
            processTabKey();
            break;
        case UP_KEY:
            e.preventDefault();
            processUpDownKey(-1);
            break;
        case DOWN_KEY:
            e.preventDefault();
            processUpDownKey(1);
            break;
    }
}

function handleEnter(e) {
    var ENTER_KEY = 13;
    var keyCode = e.keyCode || e.which;

    if (keyCode == ENTER_KEY) {
        if (input.is(':focus')) {
            processCommand();
        }
    }
}



var processing = false;

function processUpDownKey(offset) {
    if (processing || charInputMode) return;
    processing = true;

    disableInput();
    var command = getInputValue();
    startProcessing();

    var onCompleted = function () {
        backupContent();
        stopProcessing();
        enableInput();
        processing = false;
    };

    $.ajax({
        async: true,
        method: 'GET',
        url: 'proceed/upDownKey.php',
        data: { input: command, offset: offset },
        dataType: 'json',
        success: function(output, textStatus, jqXHR) {
            setInputValue(output.changedInput);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            resultAddEntry(getErrorText(textStatus));
        },
        complete: function (jqXHR, status) {
            onCompleted();
        }
    });

}

function processTabKey() {
    if (processing || charInputMode) return;
    processing = true;

    disableInput();
    var command = getInputValue();
    startProcessing();

    var onCompleted = function () {
        backupContent();
        stopProcessing();
        enableInput();
        processing = false;
    };

    $.ajax({
        async: true,
        method: 'GET',
        url: 'proceed/tabKey.php',
        data: { input: command },
        dataType: 'json',
        success: function(output, textStatus, jqXHR) {
            if (output.hasResult) resultAddEntry(output.result);
            setInputValue(output.changedInput);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            resultAddEntry(getErrorText(textStatus));
        },
        complete: function (jqXHR, status) {
            onCompleted();
        }
    });
}

function processCommand() {
    if (processing) return;
    processing = true;

    disableInput();
    var command = getInputValue();
    startProcessing();

    var copyInput = input.is(':visible');
    hideInput();
    if (copyInput) resultCopyInput();

    $.ajax({
        async: true,
        method: 'GET',
        url: 'proceed/command.php',
        data: {
            input: command
        },
        dataType: 'json',
        success: function(output, textStatus, jqXHR) {
            if (output.clear) resultClear();
            resultAddHtml(output.result);

            setInputPrefix(output.inputPrefix);
            setInputValue('');

            if (output.backupContent) backupContent();

            stopProcessing();
            switch (output.inputType) {
                case 'none':
                    scrollConsoleDown();
                    break;
                case 'char':
                    charInputMode = true;
                    showInput();
                    break;
                case 'line':
                default:
                    charInputMode = false;
                    showInput();
                    break;
            }
            if (output.clear) scrollConsoleUp();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            resultAddHtml(getErrorText(textStatus));

            setInputValue('');
            stopProcessing();
            showInput();
        },
        complete: function (jqXHR, status) {
            processing = false;
        }
    });
}

function processEditConfirm() {
    disableLastEdit();
    var fileEditText = $('div.file-edit-text:last');
    setInputValue('1' + fileEditText[0].innerHTML);
    fileEditText[0].innerHTML = '<span style="color: lightgreen">Save changes request was sent</span>';
    fileEditText[0].style.minHeight = '10px';
    processCommand();
}

function processEditCancel() {
    disableLastEdit();
    setInputValue('0');
    var fileEditText = $('div.file-edit-text:last');
    fileEditText[0].innerHTML = '<span style="color: lightcoral">Changes was cancelled</span>';
    fileEditText[0].style.minHeight = '10px';
    processCommand();
}

function disableLastEdit() {
    $('div.file-edit-text:last')[0].setAttribute('contentEditable', 'false');
    var buttonConfirm = $('button.file-edit-button-confirm:last');
    buttonConfirm[0].disabled = true;
    buttonConfirm[0].style.color = 'grey';
    var buttonCancel = $('button.file-edit-button-cancel:last');
    buttonCancel[0].disabled = true;
    buttonCancel[0].style.color = 'grey';
}

function backupContent() {
    var content = terminalResult[0].innerHTML;
    $.ajax({
        async: true,
        method: 'POST',
        url: 'proceed/backupContent.php',
        data: { content: content }
    })
}
