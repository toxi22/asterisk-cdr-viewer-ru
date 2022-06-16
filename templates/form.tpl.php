<div id="main">
<table class="cdr">
<tr>
<td>

<form method="post" enctype="application/x-www-form-urlencoded" action="?">
<fieldset>
<legend class="title">Поиск информации по звонкам</legend>
<table width="100%">
<tr>
<th>Сортировать по</th>
<th>Условия поиска</th>
<th>&nbsp;</th>
</tr>
<tr>
<td><input <?php if (empty($_REQUEST['order']) || $_REQUEST['order'] == 'calldate') { echo 'checked="checked"'; } ?> type="radio" name="order" value="calldate" />&nbsp;Дата звонка:</td>
<td>От:
<input type="text" name="startday" id="startday" size="2" maxlength="2" value="<?php if (isset($_REQUEST['startday'])) { echo htmlspecialchars($_REQUEST['startday']); } else { echo '01'; } ?>" />
<select name="startmonth" id="startmonth">
<?php
$months = array('01' => 'Январь', '02' => 'Февраль', '03' => 'Март', '04' => 'Апрель', '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август', '09' => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь');
foreach ($months as $i => $month) {
	if ((is_blank($_REQUEST['startmonth']) && date('m') == $i) || (isset($_REQUEST['startmonth']) && $_REQUEST['startmonth'] == $i)) {
		echo "        <option value=\"$i\" selected=\"selected\">$month</option>\n";
	} else {
		echo "        <option value=\"$i\">$month</option>\n";
	}
}
?>
</select>
<select name="startyear" id="startyear">
<?php
for ( $i = 2000; $i <= date('Y'); $i++) {
	if ((empty($_REQUEST['startyear']) && date('Y') == $i) || (isset($_REQUEST['startyear']) && $_REQUEST['startyear'] == $i)) {
		echo "        <option value=\"$i\" selected=\"selected\">$i</option>\n";
	} else {
		echo "        <option value=\"$i\">$i</option>\n";
	}
}
?>
</select>
<input type="text" name="starthour" id="starthour" size="2" maxlength="2" value="<?php if (isset($_REQUEST['starthour'])) { echo htmlspecialchars($_REQUEST['starthour']); } else { echo '00'; } ?>" />
:
<input type="text" name="startmin" id="startmin" size="2" maxlength="2" value="<?php if (isset($_REQUEST['startmin'])) { echo htmlspecialchars($_REQUEST['startmin']); } else { echo '00'; } ?>" />
До:
<input type="text" name="endday" id="endday" size="2" maxlength="2" value="<?php if (isset($_REQUEST['endday'])) { echo htmlspecialchars($_REQUEST['endday']); } else { echo '31'; } ?>" />
<select name="endmonth" id="endmonth">
<?php
foreach ($months as $i => $month) {
	if ((is_blank($_REQUEST['endmonth']) && date('m') == $i) || (isset($_REQUEST['endmonth']) && $_REQUEST['endmonth'] == $i)) {
		echo "        <option value=\"$i\" selected=\"selected\">$month</option>\n";
	} else {
		echo "        <option value=\"$i\">$month</option>\n";
	}
}
?>
</select>
<select name="endyear" id="endyear">
<?php
for ( $i = 2000; $i <= date('Y'); $i++) {
	if ((empty($_REQUEST['endyear']) && date('Y') == $i) || (isset($_REQUEST['endyear']) && $_REQUEST['endyear'] == $i)) {
		echo "        <option value=\"$i\" selected=\"selected\">$i</option>\n";
	} else {
		echo "        <option value=\"$i\">$i</option>\n";
	}
}
?>
</select>
<input type="text" name="endhour" id="endhour" size="2" maxlength="2" value="<?php if (isset($_REQUEST['endhour'])) { echo htmlspecialchars($_REQUEST['endhour']); } else { echo '23'; } ?>" />
:
<input type="text" name="endmin" id="endmin" size="2" maxlength="2" value="<?php if (isset($_REQUEST['endmin'])) { echo htmlspecialchars($_REQUEST['endmin']); } else { echo '59'; } ?>" />
&nbsp;
&nbsp;
&nbsp;
<select name='ranges' onchange="NewDate(this.value);">
	<option value=''>Быстрый выбор</option>
	<option value='td'>За сегодня</option>
	<option value='pd'>За вчера</option>
	<option value='3d'>За последние 3 дня</option>
	<option value='tw'>Текущая неделя</option>
	<option value='pw'>Предыдущая неделя</option>
	<option value='3w'>Последние 3 недели</option>
	<option value='tm'>Текущий месяц</option>
	<option value='pm'>Предыдущий месяц</option>
	<option value='3m'>Последние 3 месяца</option>
</select>
</td>
<td rowspan="13" valign='top' align='right'>
<fieldset>
<legend class="title">Доп. опции</legend>
<table>
<tr>
<td>Тип отчета : </td>
<td>
<input <?php if ( (empty($_REQUEST['need_html']) && empty($_REQUEST['need_chart']) && empty($_REQUEST['need_chart_cc']) && empty($_REQUEST['need_minutes_report']) && empty($_REQUEST['need_asr_report']) && empty($_REQUEST['need_csv'])) || ( ! empty($_REQUEST['need_html']) &&  $_REQUEST['need_html'] == 'true' ) ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_html" id="need_html" value="true" /> : <label for="need_html">Поиск по CDR<br />(подробный отчет по звонкам.<br /><font color=red>Потребуется время для создания отчета.<br />Наберитесь терпения, если указан<br />очень большой период :)</font>)</label><br />
<?php
if ( strlen($callrate_csv_file) > 0 ) {
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="use_callrates" value="true"';
	if ( ! empty($_REQUEST['use_callrates']) &&  $_REQUEST['use_callrates'] == 'true' ) { echo 'checked="checked"'; }
	echo ' /> с длительностью звонков<br/>';
}
if ( isset($cdr_suppress_download_links) and $cdr_suppress_download_links ) {
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="show_download_file" value="true"';
	if ( ! empty($_REQUEST['show_download_links']) &&  $_REQUEST['show_download_links'] == 'true' ) { echo 'checked="checked"'; }
	echo ' /> показать ссылку на скачивание<br/>';
}
?>
<!--// <input <?php if ( ! empty($_REQUEST['need_csv']) && $_REQUEST['need_csv'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_csv" value="true" /> : Сгенерировать CSV-файл (Excel)<br/> //-->
<input <?php if ( (empty($_REQUEST['need_html']) && empty($_REQUEST['need_chart']) && empty($_REQUEST['need_chart_cc']) && empty($_REQUEST['need_minutes_report']) && empty($_REQUEST['need_asr_report']) && empty($_REQUEST['need_csv'])) || ( ! empty($_REQUEST['need_html']) &&  $_REQUEST['need_html'] == 'true' ) ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_csv" id="need_csv" value="true" /> : <label for="need_csv">Сгенерировать CSV-файл (Excel)<br />(Анализ звонков с помощью Excel)</label><br/>
<input <?php if ( ! empty($_REQUEST['need_chart']) && $_REQUEST['need_chart'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_chart" id="need_chart" value="true" /> : <label for="need_chart">Отчет по звонкам ввиде графика</label><br />
<input <?php if ( ! empty($_REQUEST['need_chart_cc']) && $_REQUEST['need_chart_cc'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_chart_cc" id="need_chart_cc" value="true" /> : <label for="need_chart_cc">Одновременные вызовы<br />(Обычно указывает на то, кто совершил<br />более 1 вызова одновременно)</label><br />
<input <?php if ( ! empty($_REQUEST['need_minutes_report']) && $_REQUEST['need_minutes_report'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_minutes_report" id="need_minutes_report" value="true" /> : <label for="need_minutes_report">Отчет по минутам/кол. звонков</label><br />
<input <?php if ( ! empty($_REQUEST['need_asr_report']) && $_REQUEST['need_asr_report'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_asr_report" id="need_asr_report" value="true" /> : <label for="need_asr_report">Качество звонков <a href="https://ru.wikipedia.org/wiki/Answer_Seizure_Ratio" target="_blank">ASR</a>/<a href="https://ru.wikipedia.org/wiki/ACD" target="_blank">ACD</a><br />(Отчет позволяет оценить количество и<br />скорость ответов звонков операторами)</label><br />
<hr>
</td>
</tr>
<!--//<?php
if ( count($plugins) > 0 ) {
	echo '<tr><td label for="Plugins">Плагины : </td><td><hr>';
	foreach ( $plugins as &$p_key ) {
		echo '<input type="checkbox" name="need_'.$p_key.'" value="true" ';
		if ( ! empty($_REQUEST['need_'.$p_key]) && $_REQUEST['need_'.$p_key] == 'true' ) {
			echo 'checked="checked"';
		}
		echo ' /> : '. $p_key .'<br />';
	}
	echo '</td></tr>';
}
?>//-->
<tr>
<td><label for="Result limit">Выводить по: </label></td>
<td>
<input value="<?php
if (isset($_REQUEST['limit']) ) {
	echo htmlspecialchars($_REQUEST['limit']);
} else {
	echo $db_result_limit;
} ?>" name="limit" size="6" /> строк результата на страницу
</td>
</tr>
</table>
</fieldset>
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'channel') { echo 'checked="checked"'; } ?> type="radio" name="order" value="channel" />&nbsp;<label for="channel">Направление (технич.):</label></td>
<td><input type="text" name="channel" id="channel" value="<?php if (isset($_REQUEST['channel'])) { echo htmlspecialchars($_REQUEST['channel']); } ?>" />
<input <?php if ( isset($_REQUEST['channel_neg'] ) && $_REQUEST['channel_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="channel_neg" id="channel_neg_true" value="true" /> <label for="channel_neg_true">не совпадает</label>
<input <?php if (empty($_REQUEST['channel_mod']) || $_REQUEST['channel_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="channel_mod" id="channel_mod_begins_with" value="begins_with" />: <label for="channel_mod_begins_with">Начинается с,</label>
<input <?php if (isset($_REQUEST['channel_mod']) && $_REQUEST['channel_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="channel_mod" id="channel_mod_contains" value="contains" />: <label for="channel_mod_contains">Содержит,</label>
<input <?php if (isset($_REQUEST['channel_mod']) && $_REQUEST['channel_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="channel_mod" id="channel_mod_ends_with" value="ends_with" />: <label for="channel_mod_ends_with">Заканчивается на,</label>
<input <?php if (isset($_REQUEST['channel_mod']) && $_REQUEST['channel_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="channel_mod" id="channel_mod_exact" value="exact" />: <label for="channel_mod_exact">Точное совпадение</label>
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'src') { echo 'checked="checked"'; } ?> type="radio" name="order" value="src" />&nbsp;<label for="src">Кто звонил:</label></td>
<td><input type="text" name="src" id="src" value="<?php if (isset($_REQUEST['src'])) { echo htmlspecialchars($_REQUEST['src']); } ?>" />
<input <?php if ( isset($_REQUEST['src_neg'] ) && $_REQUEST['src_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="src_neg" id="src_neg_true" value="true" /> <label for="src_neg_true">не совпадает</label>
<input <?php if (empty($_REQUEST['src_mod']) || $_REQUEST['src_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="src_mod" id="src_mod_begins_with" value="begins_with" />: <label for="src_mod_begins_with">Начинается с,</label>
<input <?php if (isset($_REQUEST['src_mod']) && $_REQUEST['src_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="src_mod" id="src_mod_contains" value="src_mod_contains" />: <label for="src_mod_contains">Содержит,</label>
<input <?php if (isset($_REQUEST['src_mod']) && $_REQUEST['src_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="src_mod" id="src_mod_ends_with" value="ends_with" />: <label for="src_mod_ends_with">Заканчивается на,</label>
<input <?php if (isset($_REQUEST['src_mod']) && $_REQUEST['src_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="src_mod" id="src_mod_exact" value="exact" />: <label for="src_mod_exact">Точное совпадение</label>
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'clid') { echo 'checked="checked"'; } ?> type="radio" name="order" value="clid" />&nbsp;<label for="clid">Номер звонящего</label></td>
<td><input type="text" name="clid" id="clid" value="<?php if (isset($_REQUEST['clid'])) { echo htmlspecialchars($_REQUEST['clid']); } ?>" />
<input <?php if ( isset($_REQUEST['clid_neg'] ) && $_REQUEST['clid_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="clid_neg" id="clid_neg_true" value="true" /> <label for="clid_neg_true">не совпадает</label>
<input <?php if (empty($_REQUEST['clid_mod']) || $_REQUEST['clid_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="clid_mod" id="clid_mod_begins_with" value="begins_with" />: <label for="clid_mod_begins_with">Начинается с,</label>
<input <?php if (isset($_REQUEST['clid_mod']) && $_REQUEST['clid_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="clid_mod" id="clid_mod_contains" value="contains" />: <label for="clid_mod_contains">Содержит,</label>
<input <?php if (isset($_REQUEST['clid_mod']) && $_REQUEST['clid_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="clid_mod" id="clid_mod_ends_with" value="ends_with" />: <label for="clid_mod_ends_with">Заканчивается на,</label>
<input <?php if (isset($_REQUEST['clid_mod']) && $_REQUEST['clid_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="clid_mod" id="clid_mod_exact" value="exact" />: <label for="clid_mod_exact">Точное совпадение</label>
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'dst') { echo 'checked="checked"'; } ?> type="radio" name="order" value="dst" />&nbsp;<label for="dst">Куда звонил:</label></td>
<td><input type="text" name="dst" id="dst" value="<?php if (isset($_REQUEST['dst'])) { echo htmlspecialchars($_REQUEST['dst']); } ?>" />
<input <?php if ( isset($_REQUEST['dst_neg'] ) &&  $_REQUEST['dst_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="dst_neg" id="dst_neg_true" value="true" /> <label for="dst_neg_true">не совпадает</label>
<input <?php if (empty($_REQUEST['dst_mod']) || $_REQUEST['dst_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="dst_mod" id="dst_mod_begins_with" value="begins_with" />: <label for="dst_mod_begins_with">Начинается с,</label>
<input <?php if (isset($_REQUEST['dst_mod']) && $_REQUEST['dst_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="dst_mod" id="dst_mod_contains" value="contains" />: <label for="dst_mod_contains">Содержит,</label>
<input <?php if (isset($_REQUEST['dst_mod']) && $_REQUEST['dst_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="dst_mod" id="dst_mod_ends_with" value="ends_with" />: <label for="dst_mod_ends_with">Заканчивается на,</label>
<input <?php if (isset($_REQUEST['dst_mod']) && $_REQUEST['dst_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="dst_mod" id="dst_mod_exact" value="exact" />: <label for="dst_mod_exact">Точное совпадение</label>
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'did') { echo 'checked="checked"'; } ?> type="radio" name="order" value="did" />&nbsp;<label for="did">Вход. номер (если есть):</label></td>
<td><input type="text" name="did" id="did" value="<?php if (isset($_REQUEST['did'])) { echo htmlspecialchars($_REQUEST['did']); } ?>" />
<input <?php if ( isset($_REQUEST['did_neg'] ) && $_REQUEST['did_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="did_neg" id="did_neg_true" value="true" /> <label for="did_neg_true">не совпадает</label>
<input <?php if (empty($_REQUEST['did_mod']) || $_REQUEST['did_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="did_mod" id="did_mod_begins_with" value="begins_with" />: <label for="did_mod_begins_with">Начинается с,</label>
<input <?php if (isset($_REQUEST['did_mod']) && $_REQUEST['did_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="did_mod" id="did_mod_contains" value="contains" />: <label for="did_mod_contains">Содержит,</label>
<input <?php if (isset($_REQUEST['did_mod']) && $_REQUEST['did_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="did_mod" id="did_mod_ends_with" value="ends_with" />: <label for="did_mod_ends_with">Заканчивается на,</label>
<input <?php if (isset($_REQUEST['did_mod']) && $_REQUEST['did_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="did_mod" id="did_mod_exact" value="exact" />: <label for="did_mod_exact">Точное совпадение</label>
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'dstchannel') { echo 'checked="checked"'; } ?> type="radio" name="order" value="dstchannel" />&nbsp;<label for="dstchannel">Канал назначения:</label></td>
<td><input type="text" name="dstchannel" id="dstchannel" value="<?php if (isset($_REQUEST['dstchannel'])) { echo htmlspecialchars($_REQUEST['dstchannel']); } ?>" />
<input <?php if ( isset($_REQUEST['dstchannel_neg'] ) && $_REQUEST['dstchannel_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="dstchannel_neg" id="dstchannel_neg_true" value="true" /> <label for="dstchannel_neg_true">не совпадает</label>
<input <?php if (empty($_REQUEST['dstchannel_mod']) || $_REQUEST['dstchannel_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="dstchannel_mod" id="dstchannel_mod_begins_with" value="begins_with" />: <label for="dstchannel_mod_begins_with">Начинается с,</label>
<input <?php if (isset($_REQUEST['dstchannel_mod']) && $_REQUEST['dstchannel_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="dstchannel_mod" id="dstchannel_mod_contains" value="contains" />: <label for="dstchannel_mod_contains">Содержит,</label>
<input <?php if (isset($_REQUEST['dstchannel_mod']) && $_REQUEST['dstchannel_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="dstchannel_mod" id="dstchannel_mod_ends_with" value="ends_with" />: <label for="dstchannel_mod_ends_with">Заканчивается на,</label>
<input <?php if (isset($_REQUEST['dstchannel_mod']) && $_REQUEST['dstchannel_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="dstchannel_mod" id="dstchannel_mod_exact" value="exact" />: <label for="dstchannel_mod_exact">Точное совпадение</label>
</td>
</tr>
<!--// <tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'userfield') { echo 'checked="checked"'; } ?> type="radio" name="order" value="userfield" />&nbsp;<label for="userfield">Польз. поле:</label></td>
<td><input type="text" name="userfield" id="userfield" value="<?php if (isset($_REQUEST['userfield'])) { echo htmlspecialchars($_REQUEST['userfield']); } ?>" />
<input <?php if (  isset($_REQUEST['userfield_neg'] ) && $_REQUEST['userfield_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="userfield_neg" id="userfield_neg_true" value="true" /> <label for="userfield_neg_true">не совпадает</label>
<input <?php if (empty($_REQUEST['userfield_mod']) || $_REQUEST['userfield_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="userfield_mod" id="userfield_mod_begins_with" value="begins_with" />: <label for="userfield_mod_begins_with">Начинается с,</label>
<input <?php if (isset($_REQUEST['userfield_mod']) && $_REQUEST['userfield_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="userfield_mod" id="userfield_mod_contains" value="contains" />: <label for="userfield_mod_contains">Содержит,</label>
<input <?php if (isset($_REQUEST['userfield_mod']) && $_REQUEST['userfield_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="userfield_mod" id="userfield_mod_ends_with" value="ends_with" />: <label for="userfield_mod_ends_with">Заканчивается на,</label>
<input <?php if (isset($_REQUEST['userfield_mod']) && $_REQUEST['userfield_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="userfield_mod" id="userfield_mod_exact" value="exact" />: <label for="userfield_mod_exact">Точное совпадение</label>
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'accountcode') { echo 'checked="checked"'; } ?> type="radio" name="order" value="accountcode" />&nbsp;<label for="userfield">ID аккаунта:</label></td>
<td><input type="text" name="accountcode" id="accountcode" value="<?php if (isset($_REQUEST['accountcode'])) { echo htmlspecialchars($_REQUEST['accountcode']); } ?>" />
<input <?php if ( isset($_REQUEST['accountcode_neg'] ) &&  $_REQUEST['accountcode_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="accountcode_neg" id="accountcode_neg_true" value="true" /> <label for="accountcode_neg_true">не совпадает</label>
<input <?php if (empty($_REQUEST['accountcode_mod']) || $_REQUEST['accountcode_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="accountcode_mod" id="accountcode_mod_begins_with" value="begins_with" />: <label for="accountcode_mod_begins_with">Начинается с,</label>
<input <?php if (isset($_REQUEST['accountcode_mod']) && $_REQUEST['accountcode_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="accountcode_mod" id="accountcode_mod_contains" value="contains" />: <label for="accountcode_mod_contains">Содержит,</label>
<input <?php if (isset($_REQUEST['accountcode_mod']) && $_REQUEST['accountcode_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="accountcode_mod" id="accountcode_mod_ends_with" value="ends_with" />: <label for="accountcode_mod_ends_with">Заканчивается на,</label>
<input <?php if (isset($_REQUEST['accountcode_mod']) && $_REQUEST['accountcode_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="accountcode_mod" id="accountcode_mod_exact" value="exact" />: <label for="accountcode_mod_exact">Точное совпадение</label>
</td>
</tr> //-->
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'duration') { echo 'checked="checked"'; } ?> type="radio" name="order" value="duration" />&nbsp;<label>Длительность звонка:</label></td>
<td>Между:
<input type="text" name="dur_min" value="<?php if (isset($_REQUEST['dur_min'])) { echo htmlspecialchars($_REQUEST['dur_min']); } ?>" size="3" maxlength="5" />
и:
<input type="text" name="dur_max" value="<?php if (isset($_REQUEST['dur_max'])) { echo htmlspecialchars($_REQUEST['dur_max']); } ?>" size="3" maxlength="5" />
секунд
</td>
</tr>

<?php
if ( isset($display_column['billsec']) and $display_column['billsec'] == 1 ) {
?>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'billsec') { echo 'checked="checked"'; } ?> type="radio" name="order" value="billsec" />&nbsp;<label>Длительность разговора:</label></td>
<td>Между:
<input type="text" name="bill_min" value="<?php if (isset($_REQUEST['bill_min'])) { echo htmlspecialchars($_REQUEST['bill_min']); } ?>" size="3" maxlength="5" />
и:
<input type="text" name="bill_max" value="<?php if (isset($_REQUEST['bill_max'])) { echo htmlspecialchars($_REQUEST['bill_max']); } ?>" size="3" maxlength="5" />
секунд
</td>
</tr>
<?php
};?>

<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'disposition') { echo 'checked="checked"'; } ?> type="radio" name="order" value="disposition" />&nbsp;<label for="disposition">Состояние вызова:</label></td>
<td nowrap=""nowrap>
<input <?php if ( isset($_REQUEST['disposition_neg'] ) && $_REQUEST['disposition_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="disposition_neg" id="disposition_neg" value="true" /> <label for="disposition_neg">не равно</label>
<select name="disposition" id="disposition">
<option <?php if (empty($_REQUEST['disposition']) || $_REQUEST['disposition'] == 'all') { echo 'selected="selected"'; } ?> value="all">Все состояния</option>
<option <?php if (isset($_REQUEST['disposition']) && $_REQUEST['disposition'] == 'ANSWERED') { echo 'selected="selected"'; } ?> value="ANSWERED">Отвеченные</option>
<option <?php if (isset($_REQUEST['disposition']) && $_REQUEST['disposition'] == 'BUSY') { echo 'selected="selected"'; } ?> value="BUSY">Занято</option>
<option <?php if (isset($_REQUEST['disposition']) && $_REQUEST['disposition'] == 'FAILED') { echo 'selected="selected"'; } ?> value="FAILED">Ошибка</option>
<option <?php if (isset($_REQUEST['disposition']) && $_REQUEST['disposition'] == 'NO ANSWER') { echo 'selected="selected"'; } ?> value="NO ANSWER">Без ответа</option>
</select>
</td>
</tr>
<tr>
<td>
<select name="sort" id="sort">
<option <?php if (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'ASC') { echo 'selected="selected"'; } ?> value="ASC">По возрастанию</option>
<option <?php if (empty($_REQUEST['sort']) || $_REQUEST['sort'] == 'DESC') { echo 'selected="selected"'; } ?> value="DESC">По убыванию</option>
</select>
</td>
<td><table width="100%"><tr><td>
<label for="group">Группировать по:</label>
<select name="group" id="group">
<optgroup label="Инофрмация об аккаунте">
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'accountcode') { echo 'selected="selected"'; } ?> value="accountcode">ID аккаунта</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'userfield') { echo 'selected="selected"'; } ?> value="userfield">Польз. полю</option>
</optgroup>
<optgroup label="Дата/Время">
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'minutes1') { echo 'selected="selected"'; } ?> value="minutes1">Минутам</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'minutes10') { echo 'selected="selected"'; } ?> value="minutes10">10 минут</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'hour') { echo 'selected="selected"'; } ?> value="hour">Часу</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'hour_of_day') { echo 'selected="selected"'; } ?> value="hour_of_day">Часам за день</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'day_of_week') { echo 'selected="selected"'; } ?> value="day_of_week">Дням за неделю</option>
<option <?php if (empty($_REQUEST['group']) || $_REQUEST['group'] == 'day') { echo 'selected="selected"'; } ?> value="day">Дням</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'week') { echo 'selected="selected"'; } ?> value="week">Неделе ( Пн-Вс )</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'month') { echo 'selected="selected"'; } ?> value="month">Месям</option>
</optgroup>
<optgroup label="Номер телефона">
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'clid') { echo 'selected="selected"'; } ?> value="clid">ID звонящего</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'src') { echo 'selected="selected"'; } ?> value="src">Номеру вызывающего</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'dst') { echo 'selected="selected"'; } ?> value="dst">Номеру вызываемого</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'did') { echo 'selected="selected"'; } ?> value="did">Входящему номеру</option>
</optgroup>
<optgroup label="Техническая информация">
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'disposition') { echo 'selected="selected"'; } ?> value="disposition">Статусу звонка</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'disposition_by_day') { echo 'selected="selected"'; } ?> value="disposition_by_day">Статусу звонка, по дням</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'disposition_by_hour') { echo 'selected="selected"'; } ?> value="disposition_by_hour">Статусу звонка, по часам</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'dcontext') { echo 'selected="selected"'; } ?> value="dcontext">Контексту назначения</option>
</optgroup>
</select></td><td align="left" width="40%">
</td></td></table>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" value="Поиск" />
<input <?php if (empty($_REQUEST['search_mode']) || $_REQUEST['search_mode'] == 'all') { echo 'checked="checked"'; } ?> type="radio" name="search_mode" id="search_mode_all" value="all" />: <label for="search_mode_all">учитывать все условия</label>
<input <?php if (isset($_REQUEST['search_mode']) && $_REQUEST['search_mode'] == 'any') { echo 'checked="checked"'; } ?> type="radio" name="search_mode" id="search_mode_any" value="any" />: <label for="search_mode_any">для любого условия</label>
</td>
</tr>
</table>
</fieldset>
</form>
</td>
</tr>
</table>
<a id="CDR"></a>

