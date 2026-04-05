// ejemplo:  document.getElementById("code_field").value = "<Script Language='Javascript'>\ndocument.write(unescape('"+escapeTxt(code)+"'));</Script\>";


var encN=1;

function decodeTxt(s){
	var s1=unescape(s.substr(0,s.length-1));
	var t='';
	for(i=0;i<s1.length;i++)t+=String.fromCharCode(s1.charCodeAt(i)-s.substr(s.length-1,1));
	return unescape(t);
}

function encodeTxt(s){
	s=escape(s);
	var ta=new Array();
	for(i=0;i<s.length;i++)ta[i]=s.charCodeAt(i)+encN;
	return ""+escape(eval("String.fromCharCode("+ta+")"))+encN;
}

function escapeTxt(os){
	var ns='';
	var t;
	var chr='';
	var cc='';
	var tn='';
	for(i=0;i<256;i++){
		tn=i.toString(16);
		if(tn.length<2)tn="0"+tn;
		cc+=tn;
		chr+=unescape('%'+tn);
	}
	cc=cc.toUpperCase();
	os.replace(String.fromCharCode(13)+'',"%13");
	for(q=0;q<os.length;q++){
		t=os.substr(q,1);
		for(i=0;i<chr.length;i++){
			if(t==chr.substr(i,1)){
				t=t.replace(chr.substr(i,1),"%"+cc.substr(i*2,2));
				i=chr.length;
			}
		}
		ns+=t;
	}
	return ns;
}

function unescapeTxt(s){
return unescape(s);
}
function wF(s){
document.write(decodeTxt(s));
}