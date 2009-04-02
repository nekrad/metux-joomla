var numero = 1;

c= function (tag) {
   return document.createElement(tag);
}
d = function (id) {
   return document.getElementById(id);
}
e = function (evt) {
   return (!evt) ? event : evt;
}
f = function (evt) {
   return evt.srcElement ?  evt.srcElement : evt.target;
}

addField = function () {
   if(aflimitatt!='')if ( numero > aflimitatt-1 ) return false;
   container = d('attfiles');

   span = c('SPAN');
   span.className = 'attfile';
   span.id = 'file' + (++numero);

   field = c('INPUT');
   field.name = 'attfile[]';
   field.type = 'file';

   a = c('A');
   a.name = span.id;
   a.href = 'javascript:void(0);';
   a.onclick = removeField;
   a.innerHTML = delbutton;

   span.appendChild(field);
   span.appendChild(a);
   container.appendChild(span);
}
removeField = function (evt) {
   lnk = f(e(evt));
   span = d(lnk.name);
   span.parentNode.removeChild(span);
}