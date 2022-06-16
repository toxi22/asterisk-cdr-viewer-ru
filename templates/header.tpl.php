<head>
	<title>Asterisk Call Detail Records</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<link rel="stylesheet" href="style/screen.css" type="text/css" media="screen" />
	<link rel="shortcut icon" href="templates/images/favicon.ico" />
	<script language='JavaScript'>
		function NewDate( cur_date ) {
			var curr = new Date; // get current date
			var first;
			var last;

			if ( cur_date == 'tw' ) {
				first = curr.getDate() - curr.getDay()+1;
				last = new Date(curr.setDate(first+6));
				first = new Date(curr.setDate(first));
			} else if ( cur_date == 'pw' ) {
				first = curr.getDate() - 7 - curr.getDay() + 1;
				last = new Date(curr.setDate(first+6));
				first = new Date(curr.setDate(first));
			} else if ( cur_date == '3w' ) {
				first = curr.getDate() - 14 - curr.getDay() + 1;
				last = new Date(curr.setDate(first+20));
				first = new Date(curr.setDate(first));
			} else if ( cur_date == 'td' ) {
				first = curr.getDate();
				last = new Date(curr.setDate(first));
				first = new Date(curr.setDate(first));
			} else if ( cur_date == 'pd' ) {
				first = curr.getDate()-1;
				last = new Date(curr.setDate(first));
				first = new Date(curr.setDate(first));
			} else if ( cur_date == '3d' ) {
				first = curr.getDate()-2;
				last = new Date(curr.setDate(first+2));
				first = new Date(curr.setDate(first));
			} else if ( cur_date == 'tm' ) {
				last = new Date(curr.getFullYear(), curr.getMonth() + 1, 0);
				first = new Date(curr.getFullYear(), curr.getMonth(), 1);
			} else if ( cur_date == 'pm' ) {
				last = new Date(curr.getFullYear(), curr.getMonth(), 0);
				first = new Date(curr.getFullYear(), curr.getMonth()-1, 1);
			} else if ( cur_date == '3m' ) {
				last = new Date(curr.getFullYear(), curr.getMonth()+1, 0);
				first = new Date(curr.getFullYear(), curr.getMonth()-2, 1);
			}

			if ( typeof(first) !== 'undefined' ) {
				document.getElementById("startmonth").selectedIndex = first.getMonth();
				document.getElementById("startday").value = first.getDate();

				var selector = document.getElementById('startyear');
				for ( i = selector.options.length-1; i>=0; i-- ) {
					if ( selector.options[i].value == first.getFullYear() ) {
						selector.selectedIndex=i;
						break;
					}
				}
				document.getElementById("endmonth").selectedIndex = last.getMonth();
				document.getElementById("endday").value = last.getDate();

				selector = document.getElementById('endyear');
				for ( i = selector.options.length-1; i>=0; i-- ) {
					if ( selector.options[i].value == last.getFullYear() ) {
						selector.selectedIndex=i;
						break;
					}
				}
			}
		}
	</script>

<script type="text/javascript">
function audioPreview(e,cnc) {
 var uri = e.attributes.getNamedItem('data-uri').value;
 var audioElement;
 // 1 if not exists audio control, then create it:
 if (!(audioElement = document.getElementById('au_preview'))) {
  audioElement = document.createElement('audio');
  audioElement.id = 'au_preview';
  audioElement.controls = true;
  audioElement.style.display = 'none';
  document.body.appendChild(audioElement);
 }
 else {
  // 2 need to stop and hide if playing:
  var prevIcon = audioElement.parentNode.previousSibling;
  prevIcon.src = '/html/asterisk-cdr-viewer/templates/images/play.png';
  prevIcon.onclick = function(){ return audioPreview(prevIcon,false);};
 }

 if (('undefined'===typeof cnc)||(!cnc)) {
  //1. to show
  e.nextSibling.appendChild(audioElement);
  audioElement.src = uri;
  audioElement.style.display = 'block';
  audioElement.play();
  e.onclick = function(){ return audioPreview(e,true); };
  e.src = '/html/asterisk-cdr-viewer/templates/images/stop.png';
 }
 else {
  //2. to hide
  audioElement.pause();
  audioElement.style.display = 'none';
  e.onclick = function(){ return audioPreview(e,false); };
  e.src = '/html/asterisk-cdr-viewer/templates/images/play.png';
 }
}
	</script>
</head>
<body>
	<table id="header">
		<tr>
			<td id="header_logo" rowspan="2" align="left"><a href="/" title="Home"><img src="templates/images/asterisk.gif" alt="Asterisk CDR Viewer" /></a></td>
			<td id="header_title">Asterisk CDR Viewer</td>
			<td align='right'>
				Пожертвование<br />
				<a href="https://www.liqpay.ua/ru/checkout/romanpavlovsky" target="_blank"><img src="data:image/svg+xml,%3Csvg width='117' height='24' viewBox='0 0 117 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%237AB72B' fill-rule='evenodd'%3E%3Cpath d='M94.86 1.934l8.068 9.346-8.068 9.348 2.238 1.931 9.734-11.279L97.098.001z'/%3E%3Cpath d='M104.672 1.934l8.068 9.346-8.068 9.348 2.237 1.931 9.735-11.279L106.91.001zM10.086 19.931c0 .2-.01.367-.03.502-.02.135-.052.25-.097.345a.512.512 0 0 1-.165.21.397.397 0 0 1-.233.067H.976c-.23 0-.447-.077-.653-.232-.205-.155-.307-.427-.307-.817V2.054c0-.08.02-.15.06-.21.04-.06.11-.107.21-.142.1-.035.235-.065.405-.09.17-.025.375-.037.615-.037.25 0 .458.012.623.037.165.025.298.055.398.09.1.035.17.082.21.142.04.06.06.13.06.21v16.769h6.964c.09 0 .167.022.233.067.064.045.12.11.165.195.045.084.077.197.097.337.02.14.03.31.03.51zM15.519 20.666c0 .08-.02.15-.06.21a.404.404 0 0 1-.21.142c-.1.035-.233.064-.398.09a4.35 4.35 0 0 1-.623.037c-.24 0-.446-.013-.615-.037a2.308 2.308 0 0 1-.405-.09.401.401 0 0 1-.21-.143.367.367 0 0 1-.06-.21V2.055c0-.08.022-.15.067-.21a.451.451 0 0 1 .225-.142c.105-.035.24-.065.405-.09.165-.025.362-.037.593-.037.25 0 .458.012.623.037.165.025.297.055.398.09.1.035.17.082.21.142.04.06.06.13.06.21v18.612zM39.337 22.763c0 .23-.012.422-.037.577a1.061 1.061 0 0 1-.112.36.426.426 0 0 1-.166.172.403.403 0 0 1-.18.045c-.2 0-.523-.082-.968-.247a12.21 12.21 0 0 1-1.538-.719c-.58-.315-1.2-.697-1.861-1.147-.66-.45-1.3-.974-1.921-1.573-.49.3-1.11.56-1.861.779-.75.22-1.621.33-2.612.33-1.46 0-2.724-.215-3.79-.645-1.065-.429-1.945-1.058-2.64-1.888-.696-.829-1.214-1.86-1.554-3.094-.34-1.234-.51-2.65-.51-4.248 0-1.539.185-2.93.555-4.173.37-1.244.925-2.303 1.666-3.177.74-.874 1.666-1.549 2.776-2.023 1.111-.475 2.406-.712 3.887-.712 1.39 0 2.614.215 3.67.644a6.911 6.911 0 0 1 2.656 1.88c.716.825 1.254 1.842 1.614 3.05.36 1.21.54 2.598.54 4.166 0 .81-.048 1.584-.143 2.323-.095.74-.245 1.439-.45 2.098a9.75 9.75 0 0 1-.772 1.828 7.613 7.613 0 0 1-1.096 1.514c.73.599 1.37 1.066 1.92 1.4.55.336 1.006.588 1.366.758.36.17.64.292.84.366.2.075.35.16.451.255.1.095.17.23.21.405.04.174.06.407.06.696zM34.235 11.3c0-1.1-.098-2.118-.293-3.057-.195-.94-.52-1.756-.976-2.45a4.705 4.705 0 0 0-1.823-1.626c-.76-.39-1.701-.585-2.822-.585-1.12 0-2.061.208-2.821.622a5.208 5.208 0 0 0-1.854 1.679c-.475.704-.816 1.52-1.02 2.45a13.67 13.67 0 0 0-.309 2.952c0 1.14.095 2.186.286 3.14.19.954.51 1.78.96 2.48.45.7 1.053 1.242 1.808 1.626.756.384 1.704.577 2.844.577 1.131 0 2.082-.21 2.852-.63.77-.419 1.39-.986 1.861-1.7.47-.714.805-1.544 1.006-2.488.2-.945.3-1.941.3-2.99zM53.295 7.344c0 .97-.16 1.843-.48 2.622a5.536 5.536 0 0 1-1.373 1.993c-.595.55-1.326.974-2.192 1.274-.865.3-1.898.45-3.099.45h-2.206v6.983c0 .08-.022.15-.068.21a.449.449 0 0 1-.21.142 2.073 2.073 0 0 1-.39.09 4.35 4.35 0 0 1-.622.037c-.25 0-.458-.013-.623-.037a2.315 2.315 0 0 1-.398-.09.401.401 0 0 1-.21-.143.367.367 0 0 1-.06-.21V2.774c0-.4.104-.684.314-.854.21-.17.445-.255.706-.255h4.157c.42 0 .823.018 1.208.053.386.035.84.11 1.366.224.525.116 1.06.33 1.606.645a5.084 5.084 0 0 1 1.388 1.161c.38.46.673.992.878 1.596a6.2 6.2 0 0 1 .308 2zm-2.716.21c0-.79-.148-1.449-.443-1.979-.295-.53-.66-.924-1.096-1.184a3.69 3.69 0 0 0-1.35-.494 9.172 9.172 0 0 0-1.36-.105h-2.385v7.777h2.326c.78 0 1.428-.1 1.944-.3a3.64 3.64 0 0 0 1.298-.831c.35-.354.615-.78.796-1.274a4.68 4.68 0 0 0 .27-1.61zM71.785 20.141c.08.22.122.397.127.532.005.135-.032.238-.112.308s-.213.114-.398.135c-.185.02-.433.03-.743.03s-.557-.008-.743-.023a1.679 1.679 0 0 1-.42-.075.444.444 0 0 1-.21-.142 1.156 1.156 0 0 1-.127-.224l-1.666-4.72h-8.075l-1.59 4.66a.777.777 0 0 1-.121.232.58.58 0 0 1-.218.165c-.095.044-.23.077-.405.097-.175.02-.403.03-.682.03-.29 0-.528-.013-.713-.037-.185-.025-.315-.073-.39-.143-.075-.07-.11-.172-.105-.307.005-.135.047-.312.127-.532l6.514-18.012c.04-.11.092-.2.157-.27a.649.649 0 0 1 .285-.165 2.16 2.16 0 0 1 .48-.082c.195-.015.443-.023.743-.023.32 0 .586.008.796.023.21.015.38.042.51.082s.23.097.3.172a.81.81 0 0 1 .165.278l6.514 18.011zm-8.36-15.9h-.015l-3.346 9.666h6.753l-3.392-9.665zM81.21 13.518v7.147c0 .08-.02.15-.06.21a.4.4 0 0 1-.209.142c-.1.036-.234.065-.403.09-.169.025-.373.038-.611.038-.25 0-.455-.013-.62-.038a2.516 2.516 0 0 1-.403-.09.402.402 0 0 1-.216-.142.369.369 0 0 1-.06-.21v-7.147l-5.493-10.94c-.11-.23-.178-.41-.202-.54-.026-.129 0-.229.075-.299.075-.07.21-.114.405-.135.195-.02.457-.03.788-.03.3 0 .542.01.728.03.185.02.332.048.443.083.11.035.192.085.247.15.055.065.108.147.158.247l2.686 5.574c.25.53.498 1.084.747 1.664.248.58.502 1.164.761 1.753h.03c.229-.57.465-1.136.709-1.7.243-.565.49-1.122.74-1.672L84.15 2.1c.03-.1.073-.185.128-.255a.497.497 0 0 1 .225-.157c.095-.035.227-.062.398-.083.17-.02.385-.03.645-.03.36 0 .643.013.848.038.205.025.347.072.428.142.08.07.107.17.082.3-.024.13-.092.304-.202.524l-5.493 10.94z'/%3E%3C/g%3E%3C/svg%3E" align="center"/></a>
			</td>
		</tr>
		<tr>
		<td id="header_subtitle">&nbsp;</td>
			<td align='right'>
			<?php
			if ( strlen(getenv('REMOTE_USER')) ) {
				echo "<a href='/html/asterisk-cdr-viewer/index.php?action=logout'>logout: ". getenv('REMOTE_USER') ."</a>";
			}
			?>
		</td>
		</tr>
		</table>
