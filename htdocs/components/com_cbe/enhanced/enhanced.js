<script language="javascript" type="text/javascript">
<!--
function gb(text)
{
	var txtarea = document.gbentry.gbentry;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos)
	{
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	}
	else
	{
		txtarea.value  += text;
		txtarea.focus();
	}
}
function limitText(limitField, limitCount, limitNum)
{
	if (limitField.value.length > limitNum)
	{
		limitField.value = limitField.value.substring(0, limitNum);
	}
	else
	{
		limitCount.value = limitNum - limitField.value.length;
	}
}
function emoticon(text)
{
	var txtarea = document.post.comment;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos)
	{
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	}
	else
	{
		txtarea.value  += text;
		txtarea.focus();
	}
}
function messenger(text)
{
	var txtarea = document.compose.compose;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos)
	{
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	}
	else
	{
		txtarea.value  += text;
		txtarea.focus();
	}
}
function messenger_reply(text)
{
	var txtarea = document.reply.compose;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos)
	{
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	}
	else
	{
		txtarea.value  += text;
		txtarea.focus();
	}
}
function storeCaret(textEl)
{
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}
-->
</script>