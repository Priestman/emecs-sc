var validator=function(m){return{tests:{},samples:{},check:function(h){var k=m.document,h=h.elements,n=h.length,b=!1,a=null,e=null,c=b=b=null,i=[],d={},j=null,l=0,f,g;this.samples={};f=0;a:for(;f<n;f+=1){a=h[f];if("undefined"===typeof a.className||"undefined"===typeof a.value)continue a;e=a.value;b=-1!==a.className.indexOf("require");c=k.getElementById(a.name+"_error");c||(c=k.createElement("SPAN"),c.id=a.name+"_error",c.className="error",a.parentNode.insertBefore(c,a.nextSibling));if(1>e.length&&!b){c.innerHTML="";continue a}i=a.className.split(" ");l=i.length;g=0;b:for(;g<l;g+=1){b=i[g];if(!this.tests.hasOwnProperty(b))continue b;if(e.match(this.tests[b].condition))d[a.name]=!1,c.innerHTML="";else{d[a.name]=!0;c.innerHTML=this.tests[b].failText;break b}}b=a.className.match(/\bconfirm-?\d{0,}\b/i);null!==b&&("undefined"===typeof this.samples[b]?this.samples[b]=e:this.samples[b]!==e?(d[a.name+"_samples"]=!0,c.innerHTML="\u0425"):(d[a.name+"_samples"]=!1,c.innerHTML=""))}for(j in d)if(d.hasOwnProperty(j)&&!0===d[j])return!1;return!0}}}(this);