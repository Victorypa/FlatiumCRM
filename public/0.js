webpackJsonp([0],{347:function(t,e,r){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=r(15),a=function(t){if(t.vml){var e,r=String,a=parseFloat,n=Math,o=n.round,s=n.max,l=n.min,c=n.sqrt,p=n.abs,h=/[, ]+/,f=t.eve,d=Array.prototype.shift,u=t._g.doc.createElement("div"),g={M:"m",L:"l",C:"c",Z:"x",m:"t",l:"r",c:"v",z:"x"},v=/([clmz]),?([^clmz]*)/gi,m=/-?[^,\s-]+/g,_={path:1,rect:1,image:1},w={circle:1,ellipse:1},b=function(e){var i=/[ahqstv]/gi,a=t._pathToAbsolute;if(r(e).match(i)&&(a=t._path2curve),i=/[clmz]/g,a==t._pathToAbsolute&&!r(e).match(i)){var n=r(e).replace(v,function(t,e,r){var i=[],a="m"==e.toLowerCase(),n=g[e];return r.replace(m,function(t){a&&2==i.length&&(n+=i+g["m"==e?"l":"L"],i=[]),i.push(o(21600*t))}),n+i});return n||"m0,0"}var s,l,c=a(e);n=[];for(var p=0,h=c.length;p<h;p++){s=c[p],"z"==(l=c[p][0].toLowerCase())&&(l="x");for(var f=1,d=s.length;f<d;f++)l+=o(21600*s[f])+(f==d-1?"":",");n.push(l)}return n.length?n.join(" "):"m0,0"},k=function(e,r,i){var a=t.matrix();return a.rotate(-e,.5,.5),{dx:a.x(r,i),dy:a.y(r,i)}},T=function(t,e,r,i,a,n){var o=t._,s=t.matrix,l=o.fillpos,c=t.node,h=c.style,f=1,d="",u=21600/e,y=21600/r;if(h.visibility="hidden",e&&r){if(c.coordsize=p(u)+" "+p(y),h.rotation=n*(0>e*r?-1:1),n){var g=k(n,i,a);i=g.dx,a=g.dy}if(0>e&&(d+="x"),0>r&&(d+=" y")&&(f=-1),h.flip=d,c.coordorigin=i*-u+" "+a*-y,l||o.fillsize){var v=c.getElementsByTagName("fill");(v=v&&v[0])&&(c.removeChild(v),l&&(g=k(n,s.x(l[0],l[1]),s.y(l[0],l[1])),v.position=g.dx*f+" "+g.dy*f),o.fillsize&&(v.size=o.fillsize[0]*p(e)+" "+o.fillsize[1]*p(r)),c.appendChild(v))}h.visibility="visible"}};u.innerHTML='<v:shape adj="1"/>',(e=u.firstChild).style.behavior="url(#default#VML)",e&&"object"==typeof e.adj||(t.type=""),u=null,t._url="",t.toString=function(){return"Your browser doesn’t support SVG. Falling down to VML.\nYou are running Raphaël "+this.version};var S,R=function(t,e){for(var r in e)f("raphael.attr."+r+"."+t.id,t,e[r],r),t.ca[r]&&t.attr(r,e[r])},C=["font","line-height","font-family","font-weight","font-style","font-size"],B=function(t){for(var e,r,i,a={},n=C.length;t.paper&&t.paper.canvas;){for(i=t.attrs,e=!0,r=0;r<n;r++)a[C[r]]||(a[C[r]]=i[C[r]],e=!1);if(e)break;t=t.parent}return a},z=t._setFillAndStroke=function(e,i){if(e.paper.canvas){e.attrs=e.attrs||{};var n,c=e.node,p=e.attrs,f=c.style,d=_[e.type]&&(i.x!=p.x||i.y!=p.y||i.width!=p.width||i.height!=p.height||i.cx!=p.cx||i.cy!=p.cy||i.rx!=p.rx||i.ry!=p.ry||i.r!=p.r),u=w[e.type]&&(p.cx!=i.cx||p.cy!=i.cy||p.r!=i.r||p.rx!=i.rx||p.ry!=i.ry),y="group"===e.type,g=e;for(var v in n=g.oriOp||(g.oriOp={}),i){if(""===i[v]){c.removeAttribute(v),delete p[v],delete i[v];continue}i.hasOwnProperty(v)&&(p[v]=i[v])}if(d&&(p.path=t._getPath[e.type](e),e._.dirty=1),i.href&&(c.href=i.href),i.title&&(c.title=i.title),i.target&&(c.target=i.target),i.cursor&&(f.cursor=i.cursor),"blur"in i&&e.blur(i.blur),(i.path&&"path"==e.type||d)&&(c.path=b(~r(p.path).toLowerCase().indexOf("r")?t._pathToAbsolute(p.path):p.path),"image"==e.type&&(e._.fillpos=[p.x,p.y],e._.fillsize=[p.width,p.height],T(e,1,1,0,0,0))),"transform"in i&&e.transform(i.transform),"rotation"in i){var x=i.rotation;t.is(x,"array")?e.rotate.apply(e,x):e.rotate(x)}if("visibility"in i&&("hidden"===i.visibility?e.hide():e.show()),u){var m=+p.cx,k=+p.cy,R=+p.rx||+p.r||0,C=+p.ry||+p.r||0;c.path=t.format("ar{0},{1},{2},{3},{4},{1},{4},{1}x",o(21600*(m-R)),o(21600*(k-C)),o(21600*(m+R)),o(21600*(k+C)),o(21600*m))}if("clip-rect"in i){var z=r(i["clip-rect"]).split(h);if(4==z.length){z[0]=+z[0],z[1]=+z[1],z[2]=+z[2]+z[0],z[3]=+z[3]+z[1];var N,j=y?c:c.clipRect||t._g.doc.createElement("div"),O=j.style;y?(e.clip=z.slice(),N=e.matrix.offset(),N=[a(N[0]),a(N[1])],z[0]-=N[0],z[1]-=N[1],z[2]-=N[0],z[3]-=N[1],O.width="1px",O.height="1px"):!c.clipRect&&(O.top="0",O.left="0",O.width=e.paper.width+"px",O.height=e.paper.height+"px",c.parentNode.insertBefore(j,c),j.appendChild(c),j.raphael=!0,j.raphaelid=c.raphaelid,c.clipRect=j),O.position="absolute",O.clip=t.format("rect({1}px {2}px {3}px {0}px)",z)}i["clip-rect"]||(y&&e.clip?(c.style.clip="rect(0px 10800px 10800px 0px)",delete e.clip):c.clipRect&&(c.clipRect.style.clip="rect(0px 10800px 10800px 0px)"))}if("shape-rendering"in i&&(c.style.antialias="crisp"!==i["shape-rendering"]),e.textpath||y){var E=y?c.style:e.textpath.style;i.font&&(E.font=i.font),i["font-family"]&&(E.fontFamily='"'+i["font-family"].split(",")[0].replace(/^['"]+|['"]+$/g,"")+'"'),i["font-size"]&&(E.fontSize=i["font-size"]),i["font-weight"]&&(E.fontWeight=i["font-weight"]),i["font-style"]&&(E.fontStyle=i["font-style"])}if("arrow-start"in i&&t.addArrow&&t.addArrow(g,i["arrow-start"]),"arrow-end"in i&&t.addArrow&&t.addArrow(g,i["arrow-end"],1),null!=i.opacity||null!=i["stroke-width"]||null!=i.fill||null!=i.src||null!=i.stroke||null!=i["stroke-width"]||null!=i["stroke-opacity"]||null!=i["fill-opacity"]||null!=i["stroke-dasharray"]||null!=i["stroke-miterlimit"]||null!=i["stroke-linejoin"]||null!=i["stroke-linecap"]){var A,H=c.getElementsByTagName("fill"),M=-1;if((H=H&&H[0])||(H=S("fill")),"image"==e.type&&i.src&&(function(t,e){var r=e.src;t._.group,t.node,t._.RefImg||(t._.RefImg=new Image),void 0===e.src||(t._.RefImg.src=r)}(e,i),H.src=i.src),i.fill&&(H.on=!0),(null==H.on||"none"==i.fill||null===i.fill)&&(H.on=!1),H.on&&i.fill)if(r(i.fill).match(t._ISURL)){A=i.fill.split(t._ISURL),H.parentNode==c&&c.removeChild(H),H.rotate=!0,H.src=A[1],H.type="tile";var P=e.getBBox(1);H.position=P.x+" "+P.y,e._.fillpos=[P.x,P.y],t._preload(A[1],function(){e._.fillsize=[this.offsetWidth,this.offsetHeight]})}else{var W=t.getRGB(i.fill);H.color=W.hex,H.src="",H.type="solid",W.error&&(g.type in{circle:1,ellipse:1}||"r"!=r(i.fill).charAt())&&L(g,i.fill,H)?(p.fill="none",p.gradient=i.fill,H.rotate=!1):"opacity"in W&&!("fill-opacity"in i)&&(n.nonGradOpacity=M=W.opacity)}if(-1!==M||"fill-opacity"in i||"opacity"in i){var F=((+p["fill-opacity"]+1||2)-1)*((+p.opacity+1||2)-1);F=l(s(F,0),1),n.opacity=F,void 0===n.opacity1?H.opacity=F*(void 0===n.nonGradOpacity?1:n.nonGradOpacity):(H.opacity=n.opacity1*F,H["o:opacity2"]=n.opacity2*F),H.src&&(H.color="none")}n.opacity=void 0,c.appendChild(H);var I=c.getElementsByTagName("stroke")&&c.getElementsByTagName("stroke")[0],G=!1;I||(G=I=S("stroke")),(i.stroke&&"none"!=i.stroke||i["stroke-width"]||null!=i["stroke-opacity"]||i["stroke-dasharray"]||i["stroke-miterlimit"]||i["stroke-linejoin"]||i["stroke-linecap"])&&(I.on=!0),("none"==i.stroke||null===i.stroke||null==I.on||0==i.stroke||0==i["stroke-width"])&&(I.on=!1);var V=t.getRGB("stroke"in i?i.stroke:p.stroke);I.on&&i.stroke&&(I.color=V.hex),F=((+p["stroke-opacity"]+1||2)-1)*((+p.opacity+1||2)-1)*((+V.opacity+1||2)-1);var Y=.75*(a(i["stroke-width"])||1);if(F=l(s(F,0),1),null==i["stroke-width"]&&(Y=p["stroke-width"]),i["stroke-width"]&&(I.weight=Y),Y&&1>Y&&(F*=Y)&&(I.weight=1),I.opacity="none"===p.stroke?0:F,i["stroke-linejoin"]&&(I.joinstyle=i["stroke-linejoin"])||G&&(G.joinstyle="miter"),I.miterlimit=i["stroke-miterlimit"]||8,i["stroke-linecap"]&&(I.endcap="butt"==i["stroke-linecap"]?"flat":"square"==i["stroke-linecap"]?"square":"round"),i["stroke-dasharray"]){var q={"-":"shortdash",".":"shortdot","-.":"shortdashdot","-..":"shortdashdotdot",". ":"dot","- ":"dash","--":"longdash","- .":"dashdot","--.":"longdashdot","--..":"longdashdotdot"};I.dashstyle=q.hasOwnProperty(i["stroke-dasharray"])?q[i["stroke-dasharray"]]:i["stroke-dasharray"].join&&i["stroke-dasharray"].join(" ")||""}G&&c.appendChild(I)}if("text"==g.type){g.paper.canvas.style.display="";var X=g.paper.span,D=B(g),U=D.font&&D.font.match(/\d+(?:\.\d*)?(?=px)/),$=D["line-height"]&&(D["line-height"]+"").match(/\d+(?:\.\d*)?(?=px)/);f=X.style,D.font&&(f.font=D.font),D["font-family"]&&(f.fontFamily=D["font-family"]),D["font-weight"]&&(f.fontWeight=D["font-weight"]),D["font-style"]&&(f.fontStyle=D["font-style"]),U=a(D["font-size"]||U&&U[0])||10,f.fontSize=100*U+"px",$=a(D["line-height"]||$&&$[0]||1.2*U)||12,f.lineHeight=100*$+"px",t.is(i.text,"array")&&(i.text=g.textpath.string=i.text.join("\n").replace(/<br\s*?\/?>/gi,"\n")),g.textpath.string&&(X.innerHTML=r(g.textpath.string).replace(/</g,"&#60;").replace(/&/g,"&#38;").replace(/\n/g,"<br>"));var J=X.getBoundingClientRect();switch(g.W=p.w=(J.right-J.left)/100,g.H=p.h=(J.bottom-J.top)/100,g.X=p.x,g.Y=p.y,p["vertical-align"]){case"top":g.bby=g.H/2;break;case"bottom":g.bby=-g.H/2;break;default:g.bby=0}("x"in i||"y"in i||void 0!==g.bby)&&(g.path.v=t.format("m{0},{1}l{2},{1}",o(21600*p.x),o(21600*(p.y+(g.bby||0))),o(21600*p.x)+1));for(var Z=["x","y","text","font","font-family","font-weight","font-style","font-size","line-height"],K=0,Q=Z.length;K<Q;K++)if(Z[K]in i){g._.dirty=1;break}switch(p["text-anchor"]){case"start":g.textpath.style["v-text-align"]="left",g.bbx=g.W/2;break;case"end":g.textpath.style["v-text-align"]="right",g.bbx=-g.W/2;break;default:g.textpath.style["v-text-align"]="center",g.bbx=0}g.textpath.style["v-text-kern"]=!0}}},N=t._updateFollowers=function(){var t,e,r,a=Object(i.d)(arguments),n=d.call(a),o=d.call(a);for(t=0,e=n.followers.length;t<e;t++)(r=n.followers[t].el)[o].apply(r,a)},L=function(e,i,n){e.attrs=e.attrs||{};e.attrs;var o,s=Math.pow,l=e.oriOp,p="linear",h=".5 .5";if(e.attrs.gradient=i,i=(i=r(i).replace(t._radial_gradient,function(t,e){p="radial";(e=e&&e.split(",")||[])[0],e[1],e[2];var r=e[3],i=e[4];e[5];return r&&i&&(r=a(r),i=a(i),.25<s(r-.5,2)+s(i-.5,2)&&(i=c(.25-s(r-.5,2))*(2*(.5<i)-1)+.5),h=r+" "+i),""})).split(/\s*\-\s*/),"linear"==p){var f=i.shift();if(f=-a(f),isNaN(f))return null}var d=t._parseDots(i);if(!d)return null;if(e=e.shape||e.node,d.length){n.parentNode==e&&e.removeChild(n),n.on=!0,n.method="none",n.color=d[0].color,n.color2=d[d.length-1].color;for(var u=[],y=1,g=void 0===d[0].opacity?1:d[0].opacity,v=0,x=d.length;v<x;v++)d[v].offset&&u.push(d[v].offset+" "+d[v].color),void 0!==d[v].opacity&&(y=d[v].opacity);n.colors=u.length?u.join():"0% "+n.color,l.opacity1=y,l.opacity2=g,o=void 0===l.opacity?1:l.opacity,n.opacity=y*o,n["o:opacity2"]=g*o,"radial"==p?(n.type="gradientTitle",n.focus="100%",n.focussize="0 0",n.focusposition=h,n.angle=0):(n.type="gradient",n.angle=(270-f)%360),e.appendChild(n)}return 1},j=function(e,r,i){var a,n=this,o=i||r;o.canvas&&o.canvas.appendChild(e),(a=S("skew")).on=!0,e.appendChild(a),n.skew=a,n.node=n[0]=e,e.raphael=!0,e.raphaelid=n.id=t._oid++,n.X=0,n.Y=0,n.attrs=n.attrs||{},n.followers=n.followers||[],n.paper=r,n.ca=n.customAttributes=n.customAttributes||new r._CustomAttributes,n.matrix=t.matrix(),n._={transform:[],sx:1,sy:1,dx:0,dy:0,deg:0,dirty:1,dirtyT:1},n.parent=o,o.bottom||(o.bottom=n),n.prev=o.top,o.top&&(o.top.next=n),o.top=n,n.next=null},O=t.el;j.prototype=O,O.constructor=j,O.transform=function(e){if(null==e)return this._.transform;var i,a=this.paper._viewBoxShift,n=a?"s"+[a.scale,a.scale]+"-1-1t"+[a.dx,a.dy]:"";a&&(i=e=r(e).replace(/\.{3}|\u2026/g,this._.transform||"")),t._extractTransform(this,n+e);var o,s=this.matrix.clone(),l=this.skew,c=this.node,p=~r(this.attrs.fill).indexOf("-"),h=!r(this.attrs.fill).indexOf("url(");if(s.translate(-.5,-.5),h||p||"image"==this.type)if(l.matrix="1 0 0 1",l.offset="0 0",o=s.split(),p&&o.noRotation||!o.isSimple){c.style.filter=s.toFilter();var f=this.getBBox(),d=this.getBBox(1),u=f.x2&&d.x2?"x2":"x",y=f.y2&&d.y2?"y2":"y",g=f[u]-d[u],v=f[y]-d[y];c.coordorigin=-21600*g+" "+-21600*v,T(this,1,1,g,v,0)}else c.style.filter="",T(this,o.scalex,o.scaley,o.dx,o.dy,o.rotate);else c.style.filter="",l.matrix=r(s),l.offset=s.offset();return i&&(this._.transform=i),this},O.rotate=function(t,e,i){var n=this;if(n.removed)return n;if(N(n,"rotate",t,e,i),null!=t){if((t=r(t).split(h)).length-1&&(e=a(t[1]),i=a(t[2])),t=a(t[0]),null==i&&(e=i),null==e||null==i){var o=n.getBBox(1);e=o.x+o.width/2,i=o.y+o.height/2}return n._.dirtyT=1,n.transform(n._.transform.concat([["r",t,e,i]])),n}},O.translate=function(t,e){var i=this;return i.removed?i:(N(i,"translate",t,e),(t=r(t).split(h)).length-1&&(e=a(t[1])),t=a(t[0])||0,e=+e||0,i._.bbox&&(i._.bbox.x+=t,i._.bbox.y+=e),i.transform(i._.transform.concat([["t",t,e]])),i)},O.scale=function(t,e,i,n){var o=this;if(o.removed)return o;if(N(o,"scale",t,e,i,n),(t=r(t).split(h)).length-1&&(e=a(t[1]),i=a(t[2]),n=a(t[3]),isNaN(i)&&(i=null),isNaN(n)&&(n=null)),t=a(t[0]),null==e&&(e=t),null==n&&(i=n),null==i||null==n)var s=o.getBBox(1);return i=null==i?s.x+s.width/2:i,n=null==n?s.y+s.height/2:n,o.transform(o._.transform.concat([["s",t,e,i,n]])),o._.dirtyT=1,o},O.hide=function(t){var e=this;return N(e,"hide",t),e.removed||(e.node.style.display="none"),e},O.show=function(t){var e=this;return N(e,"show",t),e.removed||(e.node.style.display=""),e},O._getBBox=function(){var t=this;return t.removed?{}:{x:t.X+(t.bbx||0)-t.W/2,y:t.Y+(t.bby||0)-t.H/2,width:t.W,height:t.H}},O.remove=function(){if(!this.removed&&this.parent.canvas){var e=this,r=t._engine.getNode(e),i=e.paper,a=e.shape;for(i.__set__&&i.__set__.exclude(e),f.unbind("raphael.*.*."+e.id),a&&a.parentNode.removeChild(a),r.parentNode&&r.parentNode.removeChild(r);n=e.followers.pop();)n.el.remove();for(;n=e.bottom;)n.remove();if(e._drag&&e.undrag(),e.events)for(;n=e.events.pop();)n.unbind();for(var n in e.removeData(),delete i._elementsById[e.id],t._tear(e,e.parent),e)e[n]="function"==typeof e[n]?t._removedFactory(n):null;e.removed=!0}},O.attr=function(e,r){if(this.removed)return this;if(null==e){var i={};for(var a in this.attrs)this.attrs.hasOwnProperty(a)&&(i[a]=this.attrs[a]);return i.gradient&&"none"==i.fill&&(i.fill=i.gradient)&&delete i.gradient,i.transform=this._.transform,i.visibility="none"===this.node.style.display?"hidden":"visible",i}if(null==r&&t.is(e,"string")){if("fill"==e&&"none"==this.attrs.fill&&this.attrs.gradient)return this.attrs.gradient;if("visibility"==e)return"none"===this.node.style.display?"hidden":"visible";for(var n=e.split(h),o={},s=0,l=n.length;s<l;s++)o[e=n[s]]=e in this.attrs?this.attrs[e]:t.is(this.ca[e],"function")?this.ca[e].def:t._availableAttrs[e];return l-1?o:o[n[0]]}if(this.attrs&&null==r&&t.is(e,"array")){for(o={},s=0,l=e.length;s<l;s++)o[e[s]]=this.attr(e[s]);return o}var c;if(null!=r&&((c={})[e]=r),null==r&&t.is(e,"object")&&(c=e),!t.stopPartialEventPropagation)for(var p in c)f("raphael.attr."+p+"."+this.id,this,c[p],p);if(c){var d,u={};for(p in this.ca)if(this.ca[p]&&c.hasOwnProperty(p)&&t.is(this.ca[p],"function")&&!this.ca["_invoked"+p]){this.ca["_invoked"+p]=!0;var y=this.ca[p].apply(this,[].concat(c[p]));for(var g in delete this.ca["_invoked"+p],y)y.hasOwnProperty(g)&&(c[g]=y[g]);this.attrs[p]=c[p],!1===y&&(u[p]=c[p],delete c[p])}"text"in c&&"text"==this.type&&(t.is(c.text,"array")&&(c.text=c.text.join("\n")),this.textpath.string=c.text.replace(/<br\s*?\/?>/gi,"\n")),z(this,c);for(s=0,l=this.followers.length;s<l;s++)(d=this.followers[s]).cb&&!d.cb.call(d.el,c,this)||d.el.attr(c);for(var g in u)c[g]=u[g]}return this},O.on=function(e,r,i){var a,n=this,o=r;if(n.removed)return n;switch(n._actualListners||(n._actualListners=[]),n._derivedListeners||(n._derivedListeners=[]),e){case"fc-dragstart":return n.drag(null,r),n;case"fc-dragmove":return n.drag(r),n;case"fc-dragend":return n.drag(null,null,r),n;case"fc-dbclick":return n.dbclick(r,i),n;case"fc-click":return n.fcclick(r,i),n}return e=e.replace(/fc-/,""),n._&&n._.RefImg&&("load"===e||"error"===e)?(node=n._.RefImg,o=function(e,r){return function(i){a={},t.makeSelectiveCopy(a,i),a.target=n._.RefImg,e.removed||r.call(e,a)}}(n,r)):node=n.node,node.attachEvent?o===r&&(o=function(t){r.call(i||n,t)}):o=function(){var e=t._g.win.event;e.target=e.srcElement,r(e)},n._actualListners.push(r),n._derivedListeners.push(o),node.attachEvent?node.attachEvent("on"+e,o):node["on"+e]=o,n},O.off=function(t,e){var r,i=this;return i.removed?i:"fc-dragstart"===t?(i.undragstart(e),i):"fc-dragmove"===t?(i.undragmove(e),i):"fc-dragend"===t?(i.undragend(e),i):"fc-dbclick"===t?(i.undbclick(e),i):"fc-click"===t?(i.fcunclick(e),i):(t=t.replace(/fc-/,""),-1!==(r=i._actualListners.indexOf(e))&&(e=i._derivedListeners[r],i._actualListners.splice(r,1),i._derivedListeners.splice(r,1)),i.node.attachEvent?i.node.detachEvent("on"+t,e):i.node["on"+t]=null,i)},t._engine.getNode=function(t){var e=t.node||t[0].node;return e.clipRect||e},t._engine.getLastNode=function(t){var e=t.node||t[t.length-1].node;return e.clipRect||e},t._engine.group=function(e,r,i){var a,n=t._g.doc.createElement("div"),o=e._HTMLClassName,s=new j(n,e,i);return n.style.cssText="position:absolute;left:0;top:0;width:1px;height:1px",s._id=r||"",r&&(a=n.className="raphael-group-"+s.id+"-"+r),o&&(n.className=a?a+" "+o:o),(i||e).canvas.appendChild(n),s.type="group",s.canvas=s.node,s.transform=t._engine.group.transform,s.top=null,s.bottom=null,s},t._engine.group.transform=function(e){if(null==e)return this._.transform;var i,n,o,s,l=this,c=l.node.style,p=l.clip,h=l.paper._viewBoxShift,f=h?"s"+[h.scale,h.scale]+"-1-1t"+[h.dx,h.dy]:"";return h&&(e=r(e).replace(/\.{3}|\u2026/g,l._.transform||"")),t._extractTransform(l,f+e),n=(i=l.matrix).offset(),o=a(n[0])||0,s=a(n[1])||0,c.left=o+"px",c.top=s+"px",c.zoom=(l._.tzoom=i.get(0))+"",p&&(c.clip=t.format("rect({1}px {2}px {3}px {0}px)",[p[0]-o,p[1]-s,p[2]-o,p[3]-s])),l},t._engine.path=function(t,e,r){var i=S("shape");i.style.cssText="position:absolute;left:0;top:0;width:1px;height:1px",i.coordsize="21600 21600",i.coordorigin=t.coordorigin;var a=new j(i,t,r);return a.type=e.type||"path",a.path=[],a.Path="",e.type&&delete e.type,z(a,e),R(a,e),a},t._engine.rect=function(e,r,i){var a=t._rectPath(r.x,r.y,r.w,r.h,r.r);r.path=a,r.type="rect";var n=e.path(r,i),o=n.attrs;return n.X=o.x,n.Y=o.y,n.W=o.width,n.H=o.height,o.path=a,n},t._engine.ellipse=function(t,e,r){e.type="ellipse";var i=t.path(e,r),a=i.attrs;return i.X=a.x-a.rx,i.Y=a.y-a.ry,i.W=2*a.rx,i.H=2*a.ry,i},t._engine.circle=function(t,e,r){e.type="circle";var i=t.path(e,r),a=i.attrs;return i.X=a.x-a.r,i.Y=a.y-a.r,i.W=i.H=2*a.r,i},t._engine.image=function(e,r,i){r.w||(r.w=r.width),r.h||(r.h=r.height);var a=t._rectPath(r.x,r.y,r.w,r.h);r.path=a,r.type="image",r.stroke="none";var n=e.path(r,i),o=n.attrs,s=n.node,l=s.getElementsByTagName("fill")[0];return n._.RefImg||(n._.RefImg=new Image),o.src=r.src,n.X=o.x=r.x,n.Y=o.y=r.y,n.W=o.width=r.w,n.H=o.height=r.h,l.parentNode==s&&s.removeChild(l),l.rotate=!0,l.src=o.src,l.type="tile",n._.fillpos=[o.x,o.y],n._.fillsize=[o.w,o.h],s.appendChild(l),T(n,1,1,0,0,0),n},t._engine.text=function(e,i,a,n){var s=S("shape"),l=S("path"),c=S("textpath");x=i.x||0,y=i.y||0,text=i.text,l.v=t.format("m{0},{1}l{2},{1}",o(21600*i.x),o(21600*i.y),o(21600*i.x)+1),l.textpathok=!0,c.string=r(i.text).replace(/<br\s*?\/?>/gi,"\n"),c.on=!0,s.style.cssText="position:absolute;left:0;top:0;width:1px;height:1px",s.coordsize="21600 21600",s.coordorigin="0 0";var p=new j(s,e,a);return p.shape=s,p.path=l,p.textpath=c,p.type="text",p.attrs.text=r(i.text||""),p.attrs.x=i.x,p.attrs.y=i.y,p.attrs.w=1,p.attrs.h=1,n&&p.css&&p.css(n,void 0,!0),z(p,i),R(p,i),s.appendChild(c),s.appendChild(l),p},t._engine.setSize=function(e,r){var i=this.canvas.style;return this.width=e,this.height=r,e==+e&&(e+="px"),r==+r&&(r+="px"),e&&(i.width=e),r&&(i.height=r),i.clip="rect(0 "+i.width+" "+i.height+" 0)",this._viewBox&&t._engine.setViewBox.apply(this,this._viewBox),this},t._engine.setViewBox=function(t,e,r,i,a){f("raphael.setViewBox",this,this._viewBox,[t,e,r,i,a]);var n,o,l=this.width,c=this.height,p=1/s(r/l,i/c);return a&&(o=l/r,r*(n=c/i)<l&&(t-=(l-r*n)/2/n),i*o<c&&(e-=(c-i*o)/2/o)),this._viewBox=[t,e,r,i,!!a],this._viewBoxShift={dx:-t,dy:-e,scale:p},this.forEach(function(t){t.transform("...")}),this},t._engine.initWin=function(e){var i=e.document;i.createStyleSheet().addRule(".rvml","behavior:url(#default#VML)");try{i.namespaces.rvml||i.namespaces.add("rvml","urn:schemas-microsoft-com:vml"),S=t._createNode=function(t,e){var a,n=i.createElement("<rvml:"+t+' class="rvml">');for(a in e)n[a]=r(e[a]);return n}}catch(e){S=t._createNode=function(t,e){var a,n=i.createElement("<"+t+' xmlns="urn:schemas-microsoft.com:vml" class="rvml">');for(a in e)n[a]=r(e[a]);return n}}},t._engine.initWin(t._g.win),t._engine.create=function(){var e=t._getContainer.apply(0,arguments),r=e.container,i=e.height,a=e.width,n=e.x,o=e.y;if(!r)throw new Error("VML container not found.");var s=new t._Paper,l=s.canvas=t._g.doc.createElement("div"),c=l.style;return n=n||0,o=o||0,a=a||512,i=i||342,s.width=a,s.height=i,a==+a&&(a+="px"),i==+i&&(i+="px"),s.coordsize="21600000 21600000",s.coordorigin="0 0",l.id="raphael-paper-"+s.id,s.span=t._g.doc.createElement("span"),s.span.style.cssText="position:absolute;left:-9999em;top:-9999em;padding:0;margin:0;line-height:1;",l.appendChild(s.span),c.cssText=t.format("top:0;left:0;width:{0};height:{1};display:inline-block;cursor:default;position:relative;clip:rect(0 {0} {1} 0);overflow:hidden",a,i),1==r?(t._g.doc.body.appendChild(l),c.left=n+"px",c.top=o+"px",c.position="absolute"):r.firstChild?r.insertBefore(l,r.firstChild):r.appendChild(l),s.renderfix=function(){},s},t.prototype.clear=function(){var e;for(f("raphael.clear",this);e=this.bottom;)e.remove();this.canvas.innerHTML="",this.span=t._g.doc.createElement("span"),this.span.style.cssText="position:absolute;left:-9999em;top:-9999em;padding:0;margin:0;line-height:1;display:inline;",this.canvas.appendChild(this.span),this.bottom=this.top=null},t.prototype.remove=function(){for(f("raphael.remove",this);e=this.bottom;)e.remove();for(var e in this.canvas.parentNode.removeChild(this.canvas),this)this[e]="function"==typeof this[e]?t._removedFactory(e):null;return!0},t.prototype.setHTMLClassName=function(t){this._HTMLClassName=t}}},n=r(1),o={extension:function(t){let e=t.getDep("redraphael","plugin");a(e),function(t){let e,r=t._availableAttrs,i="",a=" ",o="_",s="; ",l='"',c="text",p="text-anchor",h="middle",f="font-size",d="stroke-opacity",u="linear",y="radial",g='" id = "',v=/^matrix\(|\)$/g,x=/\,/g,m=/\n|<br\s*?\/?>/gi,_=/[^\d\.]/gi,w=/[\%\(\)\s,\xb0#]/g,b=/group/gi,k=/&/g,T=/"/g,S=/'/g,R=/</g,C=/>/g,B=0,z="userSpaceOnUse",N=Math,L=parseFloat,j=N.max,O=N.abs,E=N.pow,A=String,H=/[, ]+/,M={blur:function(){},transform:function(){},src:function(){var t=arguments[1],e=t.attrs.src;t.attrSTR+=' xlink:href="'+e+l},path:function(){var e=arguments[1],r=e.attrs.path;r=t._pathToAbsolute(r||i),e.attrSTR+=' d="'+(r.toString&&r.toString()||i).replace(x,a)+l},gradient:function(r,a,n){var s,l,c,p,h,f,d,v,x,m,_=r.attrs.gradient,b=u,k=_,T=.5,S=.5,R=i,C=i,B=i;if(!n[k=k.replace(w,o)]){if(_=(_=A(_).replace(t._radial_gradient,function(t,e){var r,i,a,n,o,s,l,c;return e=e&&e.split(",")||[],b=y,r=e[0],i=e[1],n=e[2],o=e[3],s=e[4],m=e[5],c=r&&i,n&&(x=/\%/.test(n)?n:L(n)),m===z?(c&&(T=r,S=i),o&&s&&(d=o,v=s,!c&&(T=d,S=v)),""):(c&&(T=L(r),a=2*(.5<(S=L(i)))-1,.25<(l=E(T-.5,2))+E(S-.5,2)&&.25>l&&(S=N.sqrt(.25-l)*a+.5)&&.5!==S&&(S=S.toFixed(5)-1e-5*a)),o&&s&&(d=L(o),a=2*(.5<(v=L(s)))-1,.25<(l=E(d-.5,2))+E(v-.5,2)&&.25>l&&(v=N.sqrt(.25-l)*a+.5)&&.5!==v&&(v=v.toFixed(5)-1e-5*a),!c&&(T=d,S=v)),"")})).split(/\s*\-\s*/),b==u){if(s=_.shift(),s=-L(s),isNaN(s))return null;l=[0,0,N.cos(t.rad(s)),N.sin(t.rad(s))],c=1/(j(O(l[2]),O(l[3]))||1),l[2]*=c,l[3]*=c,0>l[2]&&(l[0]=-l[2],l[2]=0),0>l[3]&&(l[1]=-l[3],l[3]=0)}if(!(p=t._parseDots(_)))return null;for(b==y?(R='<radialGradient fx = "'+T+'" fy = "'+S+'" cy = "'+v+'" cx = "'+d+'" r = "'+x+'" gradientUnits = "'+m+g+k+'">',C="</radialGradient>"):(R='<linearGradient x1 = "'+l[0]+'" y1 = "'+l[1]+'" x2 = "'+l[2]+'" y2 = "'+l[3]+'" gradientTransform ="matrix('+r.matrix.invert()+")"+g+k+'">',C="</linearGradient>"),h=0,f=p.length;h<f;h++)B+='<stop offset="'+(p[h].offset?p[h].offset:h?"100%":"0%")+'" stop-color="'+(p[h].color||"#fff")+'" stop-opacity="'+(p[h].opacity===e?1:p[h].opacity)+'" />';n[k]=!0,n.str+=R+B+C}a.attrSTR+=" fill=\"url('#"+k+"')\""},fill:function(e,r){var i,a,n=r.attrs,o=n.fill;e.attrs.gradient||(a=(i=t.color(o)).opacity,e.type===c?r.styleSTR+="fill:"+i+s+d+":0"+s:(r.attrSTR+=' fill="'+i+l,!n["fill-opacity"]&&(a||0===a)&&(r.attrSTR+=' fill-opacity="'+a+l)))},stroke:function(e,r){var i,a,n=r.attrs,o=n.stroke;a=(i=t.color(o)).opacity,e.type!==c&&(r.attrSTR+=' stroke="'+i+l,!n[d]&&(a||0===a)&&(r.attrSTR+=' stroke-opacity="'+a+l))},"clip-rect":function(t,e,r){var a=e.attrs,n=A(a["clip-rect"]),s=n.split(H),c=n.replace(w,o)+o+o+B++;4===s.length&&(!r[c]&&(r[c]=!0,r.str+='<clipPath id="'+c+'"><rect x="'+s[0]+'" y="'+s[1]+'" width="'+s[2]+'" height="'+s[3]+'" transform="matrix('+t.matrix.invert().toMatrixString().replace(v,i)+')"/></clipPath>'),e.attrSTR+=' clip-path="url(#'+c+")"+l)},cursor:function(){var t=arguments[1],e=t.attrs.cursor;e&&(t.styleSTR+="cursor:"+e+s)},font:function(){var t=arguments[1],e=t.attrs.font;t.styleSTR+="font:"+e.replace(/\"/gi,a)+s},"font-size":function(){var t=arguments[1],e=t.attrs,r=Object(n._38)(e[f],"10");r&&r.replace&&(r=r.replace(_,i)),t.styleSTR+="font-size:"+r+"px; "},"font-weight":function(){var t=arguments[1],e=t.attrs["font-weight"];t.styleSTR+="font-weight:"+e+s},"font-family":function(){var t=arguments[1],e=t.attrs["font-family"];t.styleSTR+="font-family:"+e+s},"line-height":n._51,"clip-path":n._51,visibility:n._51,"vertical-align":n._51,"text-anchor":function(t,e){var r=e.attrs[p]||h;t.type===c&&(e.attrSTR+=' text-anchor="'+r+l)},title:n._51,text:function(){var t,e,r,a,o,s,c,p,d=arguments[1],u=d.attrs,y=u.text,g=Object(n._38)(u[f],u.font,"10"),v=Object(n._38)(u["line-height"]);for(g&&g.replace&&(g=g.replace(_,i)),g=Object(n._40)(g),v&&v.replace&&(v=v.replace(_,i)),v=Object(n._40)(v,g&&1.2*g),t=g?.85*g:.75*v,e=u.x,r=Object(n._38)(u["vertical-align"],h).toLowerCase(),s=(a=A(y).split(m)).length,o=0,c="top"===r?t:"bottom"===r?t-v*s:t-v*s*.5;o<s;o++)d.textSTR+="<tspan ",p=(a[o]||i).replace(k,"&amp;").replace(T,"&quot;").replace(S,"&#39;").replace(R,"&lt;").replace(C,"&gt;"),d.textSTR+=o?'dy="'+v+'" x="'+e+'" ':'dy="'+c+l,d.textSTR+=">"+p+"</tspan>"}},P=function(t,n){var o,h,f,d=i,u={attrSTR:i,styleSTR:i,textSTR:i,attrs:t.attr()},y=t.isShadow,g=i,x=i,m=u.attrs;if("none"===t.node.style.display||y)t.next&&(d+=P(t.next,n));else{for(o in m)"gradient"!==o&&(r[o]!==e||M[o])&&m[o]!==e&&(M[o]?M[o](t,u,n):u.attrSTR+=a+o+'="'+m[o]+l);for(h in t.attrs.gradient&&M.gradient(t,u,n),"rect"===t.type&&m.r&&(u.attrSTR+=' rx="'+m.r+l+a+'ry="'+m.r+l),t.styles)u.styleSTR+=h+":"+t.styles[h]+s;"image"===t.type&&(u.attrSTR+=' preserveAspectRatio="none"'),t.type!==c||m[p]||M[p](t,u),t.bottom&&(g=P(t.bottom,n)),t.next&&(x=P(t.next,n)),(f=t.type).match(b)&&(f="g"),d+="<"+f+' transform="matrix('+t.matrix.toMatrixString().replace(v,i)+')" style="'+u.styleSTR+l+u.attrSTR+">"+u.textSTR+g+"</"+f+">"+x}return d};t.vml&&(t.fn.toSVG=function(t){var e=this,r=i,a={str:i},n=i;return r='<svg style="overflow: hidden; position: relative;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="'+e.width+'" version="1.1" height="'+e.height+'">',e.bottom&&(n=P(e.bottom,a)),r+="<defs>"+a.str+"</defs>"+n+"</svg>",t||(r=r.replace(/<image[^\>]*\>[^\>]*\>/gi,function(t){return t.match(/href=\"data\:image/i)?t:""})),r})}(e)},name:"redraphaelVml",type:"plugin",requiresFusionCharts:!0};e.default=o}});